<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('employee_id_number')->nullable(); // NIK/NIP
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('join_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'resigned'])->default('active');
            $table->timestamps();
        });

        Schema::create('employee_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_profile_id')->constrained('employee_profiles')->onDelete('cascade');
            $table->string('document_type'); // KTP, NPWP, BPJS Kesehatan, etc
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_extension')->nullable();
            $table->text('notes')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_files');
        Schema::dropIfExists('employee_profiles');
    }
};
