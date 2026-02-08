<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManagementProfile;
use App\Models\ManagementFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ManagementDocumentController extends Controller
{
    public function index()
    {
        $profiles = ManagementProfile::withCount('files')->orderBy('full_name')->get();

        $totalProfiles = $profiles->count();
        $totalFiles = ManagementFile::count();
        $activeProfiles = $profiles->where('status', 'active')->count();

        $expiringDocs = ManagementFile::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->count();

        // Check AP expiring soon
        $apExpiring = ManagementProfile::whereNotNull('ap_expiry')
            ->where('ap_expiry', '<=', now()->addDays(90))
            ->where('ap_expiry', '>=', now())
            ->count();

        $documentTypes = [
            'Izin Akuntan Publik (AP)', 'Sertifikat CPA', 'KTP', 'NPWP',
            'Sertifikat PPL/SKP', 'SK Pengangkatan', 'Surat Kuasa',
            'Ijazah', 'Sertifikat Profesi', 'BPJS Kesehatan',
            'BPJS Ketenagakerjaan', 'Pas Foto', 'Lainnya',
        ];

        return view('management-documents', compact(
            'profiles', 'totalProfiles', 'totalFiles',
            'activeProfiles', 'expiringDocs', 'apExpiring', 'documentTypes'
        ));
    }

    public function storeProfile(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'title' => 'nullable|string|max:100',
                'position' => 'required|in:managing_partner,partner,manager,senior_auditor',
                'nip' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:30',
                'ap_number' => 'nullable|string|max:100',
                'ap_expiry' => 'nullable|date',
                'cpa_number' => 'nullable|string|max:100',
                'join_date' => 'nullable|date',
            ]);

            $profile = ManagementProfile::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data pimpinan berhasil ditambahkan!',
                'profile' => $profile,
            ]);
        } catch (\Throwable $e) {
            Log::error('Store management profile error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data pimpinan.',
            ], 500);
        }
    }

    public function updateProfile(Request $request, $id)
    {
        try {
            $profile = ManagementProfile::findOrFail($id);

            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'title' => 'nullable|string|max:100',
                'position' => 'required|in:managing_partner,partner,manager,senior_auditor',
                'nip' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:30',
                'ap_number' => 'nullable|string|max:100',
                'ap_expiry' => 'nullable|date',
                'cpa_number' => 'nullable|string|max:100',
                'join_date' => 'nullable|date',
                'status' => 'nullable|in:active,inactive,retired',
            ]);

            $profile->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data pimpinan berhasil diperbarui!',
            ]);
        } catch (\Throwable $e) {
            Log::error('Update management profile error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data.'], 500);
        }
    }

    public function destroyProfile($id)
    {
        try {
            $profile = ManagementProfile::findOrFail($id);

            foreach ($profile->files as $file) {
                Storage::delete('public/' . $file->file_path);
            }

            $profile->delete();

            return response()->json(['success' => true, 'message' => 'Data pimpinan berhasil dihapus!']);
        } catch (\Throwable $e) {
            Log::error('Delete management profile error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data.'], 500);
        }
    }

    public function getFiles($profileId)
    {
        try {
            $profile = ManagementProfile::findOrFail($profileId);
            $files = $profile->files()->orderBy('document_type')->get()->map(function ($f) {
                return [
                    'id' => $f->id,
                    'document_type' => $f->document_type,
                    'file_name' => $f->file_name,
                    'url' => asset('storage/' . $f->file_path),
                    'file_extension' => $f->file_extension,
                    'notes' => $f->notes,
                    'expiry_date' => $f->expiry_date ? $f->expiry_date->format('Y-m-d') : null,
                    'created_at' => $f->created_at->format('d M Y'),
                ];
            });

            return response()->json($files);
        } catch (\Throwable $e) {
            Log::error('Get management files error: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function uploadFile(Request $request, $profileId)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240',
                'document_type' => 'required|string|max:100',
                'notes' => 'nullable|string|max:500',
                'expiry_date' => 'nullable|date',
            ]);

            $profile = ManagementProfile::findOrFail($profileId);
            $file = $request->file('file');

            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $profile->full_name);
            $path = $file->storeAs(
                "management-documents/{$safeName}",
                $file->getClientOriginalName(),
                'public'
            );

            $doc = ManagementFile::create([
                'management_profile_id' => $profile->id,
                'document_type' => $request->document_type,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_extension' => $file->getClientOriginalExtension(),
                'notes' => $request->notes,
                'expiry_date' => $request->expiry_date,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload!',
                'file' => $doc,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            Log::error('Upload management file error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengupload dokumen.'], 500);
        }
    }

    public function deleteFile($fileId)
    {
        try {
            $file = ManagementFile::findOrFail($fileId);
            Storage::delete('public/' . $file->file_path);
            $file->delete();

            return response()->json(['success' => true, 'message' => 'Dokumen berhasil dihapus!']);
        } catch (\Throwable $e) {
            Log::error('Delete management file error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus dokumen.'], 500);
        }
    }

    public function previewFile($fileId)
    {
        $file = ManagementFile::findOrFail($fileId);
        $path = storage_path('app/public/' . $file->file_path);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }
}
