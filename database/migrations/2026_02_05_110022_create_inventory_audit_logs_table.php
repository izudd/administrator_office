<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->string('asset_name');
            $table->string('action'); // CREATE, UPDATE, DELETE, LOAN, RETURN
            $table->string('operation_code'); // For audit compliance
            $table->string('table_name')->default('inventory_assets');
            $table->string('user_name');
            $table->string('user_role'); // Admin, Staff, Auditor
            $table->json('previous_snapshot')->nullable();
            $table->json('new_snapshot')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('inventory_assets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_audit_logs');
    }
};
