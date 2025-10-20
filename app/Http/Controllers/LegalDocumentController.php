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
        return view('legal-documents', compact('folders'));
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
        $decodedFolder = urldecode($folder);
        $path = storage_path("app/public/legal-documents/{$decodedFolder}");

        if (!is_dir($path)) {
            return response()->json([]);
        }

        $files = collect(File::files($path))->map(function ($file) use ($decodedFolder) {
            return [
                'file_name' => $file->getFilename(),
                'url' => asset('storage/legal-documents/' . $decodedFolder . '/' . $file->getFilename()),
                'size' => round($file->getSize() / 1024, 2) . ' KB',
            ];
        });

        return response()->json($files);
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

        // ✅ Simpan ke legal_documents (bukan folders)
        $folder = LegalDocument::firstOrCreate(['name' => $folderName]);

        return response()->json([
            'success' => true,
            'folder' => $folder
        ]);
    }

    public function deleteFile(Request $request, $folder)
    {
        $filename = $request->input('filename');

        if (!$filename) {
            return response()->json(['message' => 'Filename is required'], 400);
        }

        // Decode folder dari URL
        $decodedFolder = urldecode($folder);

        // ✅ Reverse sanitize: ubah underscore kembali ke karakter asli
        // Coba cari dengan nama yang di-decode dulu
        $folderModel = LegalDocument::where('name', $decodedFolder)->first();

        // Jika tidak ketemu, coba cari dengan berbagai variasi
        if (!$folderModel) {
            // Coba ganti underscore dengan spasi
            $folderWithSpace = str_replace('_', ' ', $decodedFolder);
            $folderModel = LegalDocument::where('name', $folderWithSpace)->first();
        }

        if (!$folderModel) {
            // Coba ganti underscore dengan &
            $folderWithAmpersand = str_replace('_', '&', $decodedFolder);
            $folderModel = LegalDocument::where('name', $folderWithAmpersand)->first();
        }

        if (!$folderModel) {
            // Coba ganti "and" dengan &
            $folderWithAmpersand2 = str_replace('_and_', ' & ', $decodedFolder);
            $folderModel = LegalDocument::where('name', $folderWithAmpersand2)->first();
        }

        if (!$folderModel) {
            Log::error('Folder not found', [
                'decoded' => $decodedFolder,
                'raw' => $folder,
                'available_folders' => LegalDocument::pluck('name')->toArray()
            ]);
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
                'file' => 'required|file|max:10240',
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
            $folderModel = LegalDocument::where('name', $decodedFolder)->first();

            if (!$folderModel) {
                // Jika folder tidak ada di database, buat dulu
                $folderModel = LegalDocument::create(['name' => $decodedFolder]);

                // Buat folder fisik juga
                $physicalPath = storage_path("app/public/legal-documents/{$decodedFolder}");
                if (!File::exists($physicalPath)) {
                    File::makeDirectory($physicalPath, 0755, true);
                }
            }

            // Simpan metadata file
            Document::create([
                'folder_id' => $folderModel->id,
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
                'message' => 'Upload gagal: ' . $e->getMessage(),
                'error' => $e->getMessage(),
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
}
