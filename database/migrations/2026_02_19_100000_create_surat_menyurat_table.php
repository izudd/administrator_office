<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_menyurat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->enum('jenis_surat', ['masuk', 'keluar', 'internal', 'sk']);
            $table->string('perihal');
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima')->nullable(); // untuk surat masuk
            $table->string('pengirim')->nullable();       // untuk surat masuk
            $table->string('penerima')->nullable();       // untuk surat keluar
            $table->string('instansi')->nullable();       // asal/tujuan instansi
            $table->enum('status', ['draft', 'terkirim', 'diterima', 'dibalas', 'diarsipkan'])->default('draft');
            $table->text('keterangan')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_extension')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_menyurat');
    }
};
