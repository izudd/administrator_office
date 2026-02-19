<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMenyurat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuratMenyuratController extends Controller
{
    private const ALLOWED_EXTENSIONS = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];

    public function index()
    {
        $totalMasuk    = SuratMenyurat::where('jenis_surat', 'masuk')->count();
        $totalKeluar   = SuratMenyurat::where('jenis_surat', 'keluar')->count();
        $totalInternal = SuratMenyurat::where('jenis_surat', 'internal')->count();
        $totalSK       = SuratMenyurat::where('jenis_surat', 'sk')->count();

        $suratList = SuratMenyurat::orderByDesc('tanggal_surat')->orderByDesc('created_at')->get();

        return view('surat-menyurat', compact(
            'totalMasuk', 'totalKeluar', 'totalInternal', 'totalSK', 'suratList'
        ));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'jenis_surat'      => 'required|in:masuk,keluar,internal,sk',
                'perihal'          => 'required|string|max:500',
                'tanggal_surat'    => 'required|date',
                'tanggal_diterima' => 'nullable|date',
                'pengirim'         => 'nullable|string|max:255',
                'penerima'         => 'nullable|string|max:255',
                'instansi'         => 'nullable|string|max:255',
                'status'           => 'nullable|in:draft,terkirim,diterima,dibalas,diarsipkan',
                'keterangan'       => 'nullable|string|max:1000',
                'file'             => 'nullable|file|max:10240|mimes:' . implode(',', self::ALLOWED_EXTENSIONS),
            ]);

            $validated['nomor_surat'] = SuratMenyurat::generateNomor($validated['jenis_surat']);
            $validated['status']      = $validated['status'] ?? 'draft';

            if ($request->hasFile('file')) {
                $file         = $request->file('file');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeName     = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
                $extension    = strtolower($file->getClientOriginalExtension());
                $uniqueName   = $safeName . '_' . Str::random(8) . '.' . $extension;

                $path = $file->storeAs('surat-menyurat', $uniqueName, 'public');

                $validated['file_name']      = $file->getClientOriginalName();
                $validated['file_path']      = $path;
                $validated['file_extension'] = $extension;
            }

            $surat = SuratMenyurat::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Surat berhasil ditambahkan!',
                'surat'   => $surat,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', array_map(fn($e) => $e[0], $e->errors())),
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Store surat error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan surat.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $surat = SuratMenyurat::findOrFail($id);

            $validated = $request->validate([
                'jenis_surat'      => 'required|in:masuk,keluar,internal,sk',
                'perihal'          => 'required|string|max:500',
                'tanggal_surat'    => 'required|date',
                'tanggal_diterima' => 'nullable|date',
                'pengirim'         => 'nullable|string|max:255',
                'penerima'         => 'nullable|string|max:255',
                'instansi'         => 'nullable|string|max:255',
                'status'           => 'nullable|in:draft,terkirim,diterima,dibalas,diarsipkan',
                'keterangan'       => 'nullable|string|max:1000',
                'file'             => 'nullable|file|max:10240|mimes:' . implode(',', self::ALLOWED_EXTENSIONS),
            ]);

            if ($request->hasFile('file')) {
                // Delete old file
                if ($surat->file_path) {
                    Storage::disk('public')->delete($surat->file_path);
                }

                $file         = $request->file('file');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeName     = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
                $extension    = strtolower($file->getClientOriginalExtension());
                $uniqueName   = $safeName . '_' . Str::random(8) . '.' . $extension;

                $path = $file->storeAs('surat-menyurat', $uniqueName, 'public');

                $validated['file_name']      = $file->getClientOriginalName();
                $validated['file_path']      = $path;
                $validated['file_extension'] = $extension;
            }

            $surat->update($validated);

            return response()->json(['success' => true, 'message' => 'Surat berhasil diperbarui!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Update surat error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui surat.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $surat = SuratMenyurat::findOrFail($id);

            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }

            $surat->delete();

            return response()->json(['success' => true, 'message' => 'Surat berhasil dihapus!']);
        } catch (\Throwable $e) {
            Log::error('Delete surat error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus surat.'], 500);
        }
    }

    public function preview($id)
    {
        $surat = SuratMenyurat::findOrFail($id);

        if (!$surat->file_path) {
            abort(404, 'Tidak ada file terlampir.');
        }

        $path = storage_path('app/public/' . $surat->file_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($path, [
            'Content-Type'        => mime_content_type($path),
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $surat = SuratMenyurat::findOrFail($id);

            $request->validate([
                'status' => 'required|in:draft,terkirim,diterima,dibalas,diarsipkan',
            ]);

            $surat->update(['status' => $request->status]);

            return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui!']);
        } catch (\Throwable $e) {
            Log::error('Update status surat error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui status.'], 500);
        }
    }
}
