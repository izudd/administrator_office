<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('management_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('title')->nullable(); // Gelar: Drs., SE., Ak., M.Ak., CPA
            $table->enum('position', ['managing_partner', 'partner', 'manager', 'senior_auditor'])->default('partner');
            $table->string('nip')->nullable(); // Nomor Induk Pegawai
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('ap_number')->nullable(); // Nomor Register Akuntan Publik
            $table->date('ap_expiry')->nullable(); // Masa berlaku izin AP
            $table->string('cpa_number')->nullable(); // Nomor Sertifikat CPA
            $table->date('join_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'retired'])->default('active');
            $table->timestamps();
        });

        Schema::create('management_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_profile_id')->constrained('management_profiles')->onDelete('cascade');
            $table->string('document_type');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_extension')->nullable();
            $table->text('notes')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('management_files');
        Schema::dropIfExists('management_profiles');
    }
};
