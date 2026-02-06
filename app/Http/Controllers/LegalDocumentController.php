<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LegalDocument;
use App\Models\Folder;
use App\Models\Document;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LegalDocumentController extends Controller
{
    public function index()
    {
        $folders = LegalDocument::orderBy('name')->get();

        // Calculate real stats
        $totalFiles = Document::count();

        // Recent files (last 7 days)
        $recentFiles = Document::where('created_at', '>=', now()->subDays(7))->count();

        // Calculate total storage used
        $totalStorageBytes = 0;
        $documents = Document::all();
        foreach ($documents as $doc) {
            $fullPath = storage_path('app/public/' . $doc->file_path);
            if (file_exists($fullPath)) {
                $totalStorageBytes += filesize($fullPath);
            }
        }

        // Format storage size
        if ($totalStorageBytes >= 1073741824) {
            $totalStorage = number_format($totalStorageBytes / 1073741824, 2) . ' GB';
        } elseif ($totalStorageBytes >= 1048576) {
            $totalStorage = number_format($totalStorageBytes / 1048576, 2) . ' MB';
        } elseif ($totalStorageBytes >= 1024) {
            $totalStorage = number_format($totalStorageBytes / 1024, 2) . ' KB';
        } else {
            $totalStorage = $totalStorageBytes . ' B';
        }

        return view('legal-documents', compact('folders', 'totalFiles', 'recentFiles', 'totalStorage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:legal_documents,name',
        ]);

        LegalDocument::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Folder added successfully!');
    }

    public function destroy(LegalDocument $legalDocument)
    {
        $legalDocument->delete();
        return redirect()->back()->with('success', 'Folder deleted successfully!');
    }

    public function getDocuments($folder)
    {
        try {
            $decodedFolder = urldecode($folder);

            // Cari folder di folders table (yang di-reference oleh documents.folder_id)
            $folderModel = Folder::where('name', $decodedFolder)->first();

            if (!$folderModel) {
                // Fallback: cek di legal_documents table
                $legalDoc = LegalDocument::where('name', $decodedFolder)->first();
                if (!$legalDoc) {
                    return response()->json([]);
                }
                // Sync: buat di folders table juga
                $folderModel = Folder::firstOrCreate(['name' => $decodedFolder]);
            }

            // Ambil files dari database
            $files = Document::where('folder_id', $folderModel->id)
                ->get()
                ->map(function ($doc) {
                    return [
                        'file_name' => $doc->file_name,
                        'url' => asset('storage/' . $doc->file_path),
                        'size' => $this->formatFileSize($doc->file_path),
                    ];
                });

            return response()->json($files);
        } catch (\Throwable $e) {
            Log::error('getDocuments error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function formatFileSize($filePath)
    {
        $fullPath = storage_path('app/public/' . $filePath);
        if (file_exists($fullPath)) {
            $bytes = filesize($fullPath);
            return round($bytes / 1024, 2) . ' KB';
        }
        return 'N/A';
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $folderName = trim($request->name);

        // Buat folder fisik
        $path = storage_path("app/public/legal-documents/{$folderName}");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // Simpan ke legal_documents
        $legalDoc = LegalDocument::firstOrCreate(['name' => $folderName]);

        // Sync ke folders table (untuk FK constraint di documents table)
        $folder = Folder::firstOrCreate(['name' => $folderName]);

        return response()->json([
            'success' => true,
            'folder' => $legalDoc
        ]);
    }

    public function deleteFile(Request $request, $folder)
    {
        $filename = $request->input('filename');

        if (!$filename) {
            return response()->json(['message' => 'Filename is required'], 400);
        }

        $decodedFolder = urldecode($folder);

        // Cari di folders table (yang di-reference oleh documents.folder_id)
        $folderModel = Folder::where('name', $decodedFolder)->first();

        // Fallback: coba variasi nama
        if (!$folderModel) {
            $folderModel = Folder::where('name', str_replace('_', ' ', $decodedFolder))->first();
        }
        if (!$folderModel) {
            $folderModel = Folder::where('name', str_replace('_', '&', $decodedFolder))->first();
        }
        if (!$folderModel) {
            $folderModel = Folder::where('name', str_replace('_and_', ' & ', $decodedFolder))->first();
        }

        if (!$folderModel) {
            return response()->json(['message' => 'Folder not found'], 404);
        }

        // Cari dokumen di DB
        $doc = Document::where('folder_id', $folderModel->id)
            ->where('file_name', $filename)
            ->first();

        if (!$doc) {
            return response()->json(['message' => 'File not found in database'], 404);
        }

        // Hapus file dari storage
        $filePath = 'public/' . $doc->file_path;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // Hapus record dari DB
        $doc->delete();

        return response()->json(['message' => 'File deleted successfully']);
    }

    public function storeDocument(Request $request, $folder)
    {
        try {
            // Decode folder dari URL
            $decodedFolder = urldecode($folder);

            Log::info('Upload attempt', [
                'raw_folder' => $folder,
                'decoded_folder' => $decodedFolder
            ]);

            $request->validate([
                'file' => 'required|file|max:50240',
            ]);

            $file = $request->file('file');

            // ✅ JANGAN sanitize folder name untuk storage
            // Pakai nama folder ASLI dari database
            $path = $file->storeAs(
                "legal-documents/{$decodedFolder}",
                $file->getClientOriginalName(),
                'public'
            );

            if (!$path) {
                throw new \Exception("Gagal menyimpan file ke storage");
            }

            // Cari folder di database dengan nama asli
            $legalDoc = LegalDocument::where('name', $decodedFolder)->first();

            if (!$legalDoc) {
                // Jika folder tidak ada di database, buat dulu
                $legalDoc = LegalDocument::create(['name' => $decodedFolder]);

                // Buat folder fisik juga
                $physicalPath = storage_path("app/public/legal-documents/{$decodedFolder}");
                if (!File::exists($physicalPath)) {
                    File::makeDirectory($physicalPath, 0755, true);
                }
            }

            // Sync ke folders table (FK constraint di documents table references folders.id)
            $folder = Folder::firstOrCreate(['name' => $decodedFolder]);

            // Simpan metadata file menggunakan folders.id (bukan legal_documents.id)
            Document::create([
                'folder_id' => $folder->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully.',
                'file' => [
                    'name' => $file->getClientOriginalName(),
                    'path' => asset('storage/' . $path),
                    'type' => $file->getClientOriginalExtension(),
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'error' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Upload error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file. Please try again.',
            ], 500);
        }
    }

    public function previewFile($folder, $filename)
    {
        $path = storage_path("app/public/legal-documents/$folder/$filename");

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        $mimeType = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }
    
    public function renameFolder(Request $request)
    {
        $request->validate([
            'old_name' => 'required|string',
            'new_name' => 'required|string|max:255',
        ]);

        $oldName = $request->old_name;
        $newName = $request->new_name;

        try {
            // Update legal_documents table
            $legalDoc = LegalDocument::where('name', $oldName)->firstOrFail();
            $legalDoc->name = $newName;
            $legalDoc->save();

            // Update folders table
            $folder = Folder::where('name', $oldName)->first();
            if ($folder) {
                $folder->name = $newName;
                $folder->save();

                // Update file paths in documents table
                Document::where('folder_id', $folder->id)->get()->each(function ($doc) use ($oldName, $newName) {
                    $doc->file_path = str_replace("legal-documents/{$oldName}/", "legal-documents/{$newName}/", $doc->file_path);
                    $doc->save();
                });
            }

            // Rename physical folder
            $oldPath = storage_path("app/public/legal-documents/{$oldName}");
            $newPath = storage_path("app/public/legal-documents/{$newName}");

            if (File::exists($oldPath)) {
                File::move($oldPath, $newPath);
            }

            return response()->json(['success' => true, 'message' => 'Folder renamed successfully']);
        } catch (\Exception $e) {
            Log::error('Rename folder error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $folderName = $request->name;

        try {
            // Delete from legal_documents table
            $legalDoc = LegalDocument::where('name', $folderName)->firstOrFail();
            $legalDoc->delete();

            // Delete from folders table + cascade documents
            $folder = Folder::where('name', $folderName)->first();
            if ($folder) {
                Document::where('folder_id', $folder->id)->delete();
                $folder->delete();
            }

            // Delete physical folder
            $folderPath = storage_path("app/public/legal-documents/{$folderName}");
            if (File::exists($folderPath)) {
                File::deleteDirectory($folderPath);
            }

            return response()->json(['success' => true, 'message' => 'Folder deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Delete folder error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
