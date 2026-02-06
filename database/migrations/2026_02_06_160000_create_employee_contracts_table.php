<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_contracts', function (Blueprint $table) {
            $table->id();
            // Section 1: Identitas Para Pihak
            $table->string('company_name');
            $table->string('company_address')->nullable();
            $table->string('employee_name');
            $table->string('employee_nik')->nullable();
            $table->string('employee_address')->nullable();
            // Section 2: Jenis Perjanjian
            $table->enum('contract_type', ['PKWT', 'PKWTT']);
            $table->string('legal_basis')->default('UU Ketenagakerjaan & UU Cipta Kerja');
            // Section 3: Jabatan
            $table->string('position');
            $table->string('direct_superior')->nullable();
            $table->text('job_description')->nullable();
            // Section 4: Lokasi & Waktu Kerja
            $table->string('work_location')->nullable();
            $table->integer('working_hours')->default(8);
            $table->integer('working_days')->default(5);
            $table->text('overtime_rules')->nullable();
            // Section 5: Masa Kerja
            $table->date('start_date');
            $table->integer('contract_duration')->nullable(); // months, for PKWT
            $table->integer('probation_period')->default(3); // months
            // Section 6: Gaji & Kompensasi
            $table->bigInteger('base_salary')->default(0);
            $table->bigInteger('transport_allowance')->default(0);
            $table->bigInteger('meal_allowance')->default(0);
            $table->bigInteger('other_allowance')->default(0);
            $table->string('payment_method')->default('Transfer Bank');
            $table->integer('payment_date')->nullable(); // day of month
            // Section 7: Hak Karyawan (booleans)
            $table->boolean('right_annual_leave')->default(true);
            $table->boolean('right_sick_leave')->default(true);
            $table->boolean('right_special_leave')->default(true);
            $table->boolean('right_bpjs_health')->default(true);
            $table->boolean('right_bpjs_employment')->default(true);
            $table->boolean('right_thr')->default(true);
            // Section 8: Kewajiban & Kerahasiaan
            $table->text('employee_obligations')->nullable();
            $table->text('nda_ip_policy')->nullable();
            $table->text('prohibitions')->nullable();
            $table->text('termination_terms')->nullable();
            // Status
            $table->enum('status', ['active', 'probation', 'expired', 'terminated'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_contracts');
    }
};
