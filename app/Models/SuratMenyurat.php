<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMenyurat extends Model
{
    use HasFactory;

    protected $table = 'surat_menyurat';

    protected $fillable = [
        'nomor_surat',
        'jenis_surat',
        'perihal',
        'tanggal_surat',
        'tanggal_diterima',
        'pengirim',
        'penerima',
        'instansi',
        'status',
        'keterangan',
        'file_name',
        'file_path',
        'file_extension',
    ];

    protected $casts = [
        'tanggal_surat'    => 'date',
        'tanggal_diterima' => 'date',
    ];

    public static function generateNomor(string $jenis): string
    {
        $prefix = match ($jenis) {
            'masuk'    => 'SM',
            'keluar'   => 'SK',
            'internal' => 'SI',
            'sk'       => 'SKP',
            default    => 'S',
        };

        $year  = now()->format('Y');
        $month = now()->format('m');

        $count = self::where('jenis_surat', $jenis)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 1;

        return sprintf('%s/%03d/%s/%s', $prefix, $count, $month, $year);
    }
}
