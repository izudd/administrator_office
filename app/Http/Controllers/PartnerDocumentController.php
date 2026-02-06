<?php

namespace App\Http\Controllers;

use App\Models\PartnerCategory;
use App\Models\PartnerDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PartnerDocumentController extends Controller
{
    public function index()
    {
        $categories = PartnerCategory::withCount('documents')->orderBy('name')->get();

        // Stats
        $totalDocuments = PartnerDocument::count();
        $totalPartners = PartnerDocument::distinct('partner_name')->count('partner_name');
        $activeDocuments = PartnerDocument::active()->count();
        $expiringSoon = PartnerDocument::expiringSoon(30)->count();

        // Calculate total storage
        $totalStorageBytes = PartnerDocument::sum('file_size');
        if ($totalStorageBytes >= 1073741824) {
            $totalStorage = number_format($totalStorageBytes / 1073741824, 2) . ' GB';
        } elseif ($totalStorageBytes >= 1048576) {
            $totalStorage = number_format($totalStorageBytes / 1048576, 2) . ' MB';
        } elseif ($totalStorageBytes >= 1024) {
            $totalStorage = number_format($totalStorageBytes / 1024, 2) . ' KB';
        } else {
            $totalStorage = $totalStorageBytes . ' B';
        }

        return view('partner-documents.index', compact(
            'categories',
            'totalDocuments',
            'totalPartners',
            'activeDocuments',
            'expiringSoon',
            'totalStorage'
        ));
    }

    // Category CRUD
    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:20',
        ]);

        $category = PartnerCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#10b981',
        ]);

        // Create physical folder
        $path = storage_path("app/public/partner-documents/{$request->name}");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return response()->json([
            'success' => true,
            'category' => $category,
            'message' => 'Category created successfully'
        ]);
    }

    public function renameCategory(Request $request)
    {
        $request->validate([
            'old_name' => 'required|string',
            'new_name' => 'required|string|max:255',
        ]);

        try {
            $category = PartnerCategory::where('name', $request->old_name)->firstOrFail();
            $oldName = $category->name;
            $category->name = $request->new_name;
            $category->save();

            // Rename physical folder
            $oldPath = storage_path("app/public/partner-documents/{$oldName}");
            $newPath = storage_path("app/public/partner-documents/{$request->new_name}");
            if (File::exists($oldPath)) {
                File::move($oldPath, $newPath);
            }

            // Update file paths
            PartnerDocument::where('category_id', $category->id)->get()->each(function ($doc) use ($oldName, $newName) {
                $doc->file_path = str_replace("partner-documents/{$oldName}/", "partner-documents/{$newName}/", $doc->file_path);
                $doc->save();
            });

            return response()->json(['success' => true, 'message' => 'Category renamed successfully']);
        } catch (\Exception $e) {
            Log::error('Rename category error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $category = PartnerCategory::where('name', $request->name)->firstOrFail();

            // Delete physical folder
            $folderPath = storage_path("app/public/partner-documents/{$request->name}");
            if (File::exists($folderPath)) {
                File::deleteDirectory($folderPath);
            }

            // Delete category (cascades to documents)
            $category->delete();

            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Delete category error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Document operations
    public function getDocuments($categoryId)
    {
        try {
            $category = PartnerCategory::findOrFail($categoryId);
            $documents = $category->documents()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($doc) {
                    return [
                        'id' => $doc->id,
                        'partner_name' => $doc->partner_name,
                        'document_type' => $doc->document_type,
                        'file_name' => $doc->file_name,
                        'file_path' => $doc->file_path,
                        'file_type' => $doc->file_type,
                        'file_size' => $doc->formatted_file_size,
                        'document_date' => $doc->document_date?->format('d M Y'),
                        'expiry_date' => $doc->expiry_date?->format('d M Y'),
                        'status' => $doc->status,
                        'notes' => $doc->notes,
                        'is_expired' => $doc->isExpired(),
                        'is_expiring_soon' => $doc->isExpiringSoon(),
                        'url' => asset('storage/' . $doc->file_path),
                    ];
                });

            return response()->json($documents);
        } catch (\Exception $e) {
            Log::error('Get documents error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function uploadDocument(Request $request, $categoryId)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:51200', // 50MB
                'partner_name' => 'required|string|max:255',
                'document_type' => 'required|string|max:100',
                'document_date' => 'nullable|date',
                'expiry_date' => 'nullable|date',
                'notes' => 'nullable|string',
            ]);

            $category = PartnerCategory::findOrFail($categoryId);
            $file = $request->file('file');

            // Store file
            $path = $file->storeAs(
                "partner-documents/{$category->name}",
                $file->getClientOriginalName(),
                'public'
            );

            // Create record
            $document = PartnerDocument::create([
                'category_id' => $category->id,
                'partner_name' => $request->partner_name,
                'document_type' => $request->document_type,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'document_date' => $request->document_date,
                'expiry_date' => $request->expiry_date,
                'status' => 'active',
                'notes' => $request->notes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully',
                'document' => $document
            ]);
        } catch (\Exception $e) {
            Log::error('Upload document error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteDocument(Request $request, $documentId)
    {
        try {
            $document = PartnerDocument::findOrFail($documentId);

            // Delete file
            $filePath = 'public/' . $document->file_path;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $document->delete();

            return response()->json(['success' => true, 'message' => 'Document deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Delete document error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateDocument(Request $request, $documentId)
    {
        try {
            $request->validate([
                'partner_name' => 'sometimes|string|max:255',
                'document_type' => 'sometimes|string|max:100',
                'document_date' => 'nullable|date',
                'expiry_date' => 'nullable|date',
                'status' => 'sometimes|in:draft,active,expired,archived',
                'notes' => 'nullable|string',
            ]);

            $document = PartnerDocument::findOrFail($documentId);
            $document->update($request->only([
                'partner_name',
                'document_type',
                'document_date',
                'expiry_date',
                'status',
                'notes'
            ]));

            return response()->json(['success' => true, 'message' => 'Document updated successfully']);
        } catch (\Exception $e) {
            Log::error('Update document error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function previewDocument($documentId)
    {
        $document = PartnerDocument::findOrFail($documentId);
        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        $mimeType = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"',
        ]);
    }

    public function downloadDocument($documentId)
    {
        $document = PartnerDocument::findOrFail($documentId);
        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->download($path, $document->file_name);
    }
}
