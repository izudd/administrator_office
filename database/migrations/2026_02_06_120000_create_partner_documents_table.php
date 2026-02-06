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
        // Partner categories (like folders)
        Schema::create('partner_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('color')->default('#10b981'); // For UI display
            $table->timestamps();
        });

        // Partner documents
        Schema::create('partner_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('partner_categories')->onDelete('cascade');
            $table->string('partner_name'); // Company/partner name
            $table->string('document_type'); // Agreement, NDA, Contract, Invoice, etc.
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->date('document_date')->nullable(); // Date on document
            $table->date('expiry_date')->nullable(); // For contracts with expiry
            $table->enum('status', ['draft', 'active', 'expired', 'archived'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_documents');
        Schema::dropIfExists('partner_categories');
    }
};
