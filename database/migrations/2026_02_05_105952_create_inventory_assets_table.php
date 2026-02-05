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
        Schema::create('inventory_assets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // FA-001-KAP
            $table->string('name');
            $table->string('category'); // IT Equipment, Furniture, Vehicles, Infrastructure
            $table->date('acquisition_date');
            $table->decimal('cost', 15, 2)->default(0);
            $table->decimal('depreciation', 15, 2)->default(0);
            $table->decimal('book_value', 15, 2)->default(0);
            $table->string('location')->nullable();
            $table->enum('status', ['Active', 'Disposed', 'Damaged', 'In-Repair', 'Maintenance', 'Loaned'])->default('Active');
            $table->enum('condition', ['Good', 'Damaged'])->default('Good');
            $table->date('last_audit_date')->nullable();
            $table->string('image_url')->nullable();
            $table->string('loaned_to')->nullable();
            $table->boolean('is_deleted')->default(false); // Soft delete
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_assets');
    }
};
