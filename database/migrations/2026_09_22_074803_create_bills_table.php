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
            $table->foreignId('plot_and_unit_id')->constrained('plot_and_units')->cascadeOnDelete();
            $table->string('bill_number', 50)->unique();
            $table->string('billing_month', 7); // Format: 'YYYY-MM' (e.g., '2026-09')
            $table->date('due_date');

            // Snapshot attributes at the exact time of billing
            $table->string('plot_type_name', 50);
            $table->unsignedInteger('billing_units')->default(1);
            $table->decimal('rate_snapshot', 10, 2)->default(0.00);
            $table->decimal('discount_snapshot', 10, 2)->default(0.00);
            $table->decimal('gross_amount', 10, 2)->default(0.00);
            $table->decimal('net_amount', 10, 2)->default(0.00);
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            
            // Status: Unpaid, Partial, Paid, Overdue
            $table->enum('status', ['Unpaid', 'Partial', 'Paid', 'Overdue'])->default('Unpaid');
            $table->timestamps();

            // Prevent duplicate bills for the same property in the same month
            $table->unique(['plot_and_unit_id', 'billing_month'], 'uniq_property_month_bill');
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
