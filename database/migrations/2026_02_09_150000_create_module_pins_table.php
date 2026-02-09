<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_pins', function (Blueprint $table) {
            $table->id();
            $table->string('module_key')->unique(); // e.g. 'legal-documents', 'inventory'
            $table->string('module_name');           // e.g. 'Legal Documents', 'Inventory'
            $table->string('pin_code');              // hashed 6-digit PIN
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });

        // Seed default PINs (000000) for all modules
        $modules = [
            ['module_key' => 'legal-documents', 'module_name' => 'Legal Documents'],
            ['module_key' => 'employee-legal', 'module_name' => 'Kontrak Karyawan'],
            ['module_key' => 'employee-documents', 'module_name' => 'Legal Karyawan'],
            ['module_key' => 'management-documents', 'module_name' => 'Legal Management'],
            ['module_key' => 'partner-documents', 'module_name' => 'Partner Docs'],
            ['module_key' => 'inventory', 'module_name' => 'Inventory'],
        ];

        foreach ($modules as $module) {
            DB::table('module_pins')->insert([
                'module_key' => $module['module_key'],
                'module_name' => $module['module_name'],
                'pin_code' => Hash::make('000000'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('module_pins');
    }
};
