<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeProfile;
use App\Models\EmployeeFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeDocumentController extends Controller
{
    public function index()
    {
        $employees = EmployeeProfile::withCount('files')->orderBy('employee_name')->get();

        $totalEmployees = $employees->count();
        $totalFiles = EmployeeFile::count();
        $activeEmployees = $employees->where('status', 'active')->count();

        $expiringDocs = EmployeeFile::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->count();

        $documentTypes = [
            'KTP', 'NPWP', 'BPJS Kesehatan', 'BPJS Ketenagakerjaan',
            'Kartu Keluarga', 'Ijazah', 'Sertifikat', 'Surat Lamaran',
            'CV / Resume', 'Pas Foto', 'Surat Keterangan Sehat',
            'SKCK', 'Surat Referensi', 'Slip Gaji', 'SPT Pajak', 'Lainnya',
        ];

        return view('employee-documents', compact(
            'employees', 'totalEmployees', 'totalFiles',
            'activeEmployees', 'expiringDocs', 'documentTypes'
        ));
    }

    public function storeEmployee(Request $request)
    {
        try {
            $validated = $request->validate([
                'employee_name' => 'required|string|max:255',
                'employee_id_number' => 'nullable|string|max:50',
                'position' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:30',
                'join_date' => 'nullable|date',
            ]);

            $employee = EmployeeProfile::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Karyawan berhasil ditambahkan!',
                'employee' => $employee,
            ]);
        } catch (\Throwable $e) {
            Log::error('Store employee error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan karyawan.',
            ], 500);
        }
    }

    public function updateEmployee(Request $request, $id)
    {
        try {
            $employee = EmployeeProfile::findOrFail($id);

            $validated = $request->validate([
                'employee_name' => 'required|string|max:255',
                'employee_id_number' => 'nullable|string|max:50',
                'position' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:30',
                'join_date' => 'nullable|date',
                'status' => 'nullable|in:active,inactive,resigned',
            ]);

            $employee->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil diperbarui!',
            ]);
        } catch (\Throwable $e) {
            Log::error('Update employee error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data.'], 500);
        }
    }

    public function destroyEmployee($id)
    {
        try {
            $employee = EmployeeProfile::findOrFail($id);

            // Delete all files from storage
            foreach ($employee->files as $file) {
                Storage::disk('public')->delete($file->file_path);
            }

            $employee->delete(); // cascade deletes files records

            return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus!']);
        } catch (\Throwable $e) {
            Log::error('Delete employee error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus karyawan.'], 500);
        }
    }

    public function getFiles($employeeId)
    {
        try {
            $employee = EmployeeProfile::findOrFail($employeeId);
            $files = $employee->files()->orderBy('document_type')->get()->map(function ($f) {
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
            Log::error('Get files error: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    // Allowed file extensions for employee documents
    private const ALLOWED_EXTENSIONS = [
        'pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp',
        'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
        'txt', 'csv', 'zip', 'rar',
    ];

    public function uploadFile(Request $request, $employeeId)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240|mimes:' . implode(',', self::ALLOWED_EXTENSIONS),
                'document_type' => 'required|string|max:100',
                'notes' => 'nullable|string|max:500',
                'expiry_date' => 'nullable|date',
            ]);

            $employee = EmployeeProfile::findOrFail($employeeId);
            $file = $request->file('file');

            // Sanitize folder name from employee name
            $safeFolderName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $employee->employee_name);

            // Sanitize filename: keep original name but add unique suffix to prevent overwrite
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
            $extension = strtolower($file->getClientOriginalExtension());
            $uniqueName = $safeFileName . '_' . Str::random(8) . '.' . $extension;

            $path = $file->storeAs(
                "employee-documents/{$safeFolderName}",
                $uniqueName,
                'public'
            );

            $doc = EmployeeFile::create([
                'employee_profile_id' => $employee->id,
                'document_type' => $request->document_type,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_extension' => $extension,
                'notes' => $request->notes,
                'expiry_date' => $request->expiry_date,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload!',
                'file' => $doc,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal: ' . implode(', ', array_map(fn($e) => $e[0], $e->errors())), 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            Log::error('Upload file error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengupload dokumen.'], 500);
        }
    }

    public function deleteFile($fileId)
    {
        try {
            $file = EmployeeFile::findOrFail($fileId);
            Storage::disk('public')->delete($file->file_path);
            $file->delete();

            return response()->json(['success' => true, 'message' => 'Dokumen berhasil dihapus!']);
        } catch (\Throwable $e) {
            Log::error('Delete file error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus dokumen.'], 500);
        }
    }

    public function previewFile($fileId)
    {
        $file = EmployeeFile::findOrFail($fileId);
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
