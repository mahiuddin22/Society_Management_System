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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plot_and_unit_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            
            // Billing Period
            $table->date('billing_month')->comment("'2026-10-01' (Always store first of month)");
            $table->date('due_date')->comment('2026-10-15');
            
            // Financial Snapshot at Time of Generation
            $table->decimal('rate', 10, 2);
            $table->unsignedSmallInteger('billing_units')->default(1);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('amount', 12, 2)->comment('(rate * billing_units) - discount');      
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->comment('amount - paid_amount');

            // Status
            $table->enum('status', ['Unpaid', 'Partial', 'Paid'])->default('Unpaid');
            $table->string('invoice_no', 30)->unique()->comment('INV-202610-UTR03...');
            
            $table->timestamps();

            // Prevent duplicate bills for the same property in the same month
            $table->unique(['plot_and_unit_id', 'billing_month']);
            $table->index(['billing_month', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
