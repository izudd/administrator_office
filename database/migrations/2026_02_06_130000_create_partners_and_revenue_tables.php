<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Partners table - comprehensive partner management
        Schema::create('partners', function (Blueprint $table) {
            $table->id();

            // Company Information
            $table->string('company_name');
            $table->string('company_type')->default('PT'); // PT, CV, Perorangan, etc.
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('Indonesia');
            $table->string('npwp')->nullable(); // Tax ID

            // Partnership Details
            $table->enum('partnership_model', ['equity', 'revenue_share', 'subscription', 'project_based'])->default('project_based');
            $table->enum('status', ['active', 'inactive', 'pending', 'suspended', 'terminated'])->default('pending');
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->decimal('equity_percentage', 5, 2)->default(0);
            $table->decimal('revenue_share_percentage', 5, 2)->default(0);
            $table->decimal('monthly_fee', 15, 2)->default(0);

            // Contact Person
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_position')->nullable();

            // Notes & Metadata
            $table->text('notes')->nullable();
            $table->json('custom_fields')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // Revenue Transactions
        Schema::create('revenue_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partners')->onDelete('cascade');

            $table->enum('type', ['subscription_fee', 'revenue_share', 'one_time_payment', 'refund', 'credit', 'adjustment'])->default('one_time_payment');
            $table->decimal('amount', 15, 2);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2);
            $table->string('currency', 3)->default('IDR');

            // Revenue Share Details
            $table->decimal('revenue_share_percentage', 5, 2)->nullable();
            $table->decimal('base_revenue', 15, 2)->nullable();

            // Period
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();

            // Payment
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'cancelled'])->default('pending');
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('invoice_number')->nullable();

            $table->string('description')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });

        // Add partner_id to partner_documents (optional link)
        Schema::table('partner_documents', function (Blueprint $table) {
            $table->foreignId('partner_id')->nullable()->after('category_id')->constrained('partners')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('partner_documents', function (Blueprint $table) {
            $table->dropForeign(['partner_id']);
            $table->dropColumn('partner_id');
        });
        Schema::dropIfExists('revenue_transactions');
        Schema::dropIfExists('partners');
    }
};
