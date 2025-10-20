<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalDocument;

class LegalDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $folders = [
            'Akta & SK',
            'BPK',
            'Company Profile',
            'CV AP',
            'Izin AP',
            'Izin KAP (Pusat & Cabang)',
            'KTP AP',
            'KTP dan NPWP Partner',
            'NIB',
            'No Anggota IAPI AP',
            'NPWP',
            'OJK',
            'Pajak KAP',
            'Perbahan Susunan Rekan Kemenkeu',
            'Register Negara Akuntan',
            'Rekanan dengan Bank',
            'Rekomendasi IAPI',
            'Sanksi Pembekuan Izin',
            'Sertifikat CA, CPA & CFI',
            'SKDP & Perubahan Alamat',
            'SP2DK',
            'STTD dan PPD',
            'Surat Keterangan Izin AP'
        ];

        foreach ($folders as $f) {
            LegalDocument::firstOrCreate(['name' => $f]);
        }
    }
}
