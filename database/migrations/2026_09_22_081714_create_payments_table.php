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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bill_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('collector_id')->constrained('users'); // Society collector/admin
            
            $table->decimal('amount', 12, 2);
            $table->string('payment_method', 30)->comment('Cash, bKash, Bank Transfer, Nagad');
            $table->string('transaction_id', 100)->nullable();
            $table->date('payment_date');
            $table->string('receipt_no', 30)->unique();
            $table->text('remarks')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
