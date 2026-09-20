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
        Schema::create('plot_and_units', function (Blueprint $table) {
            $table->id();

            $table->string('unique_id');
            $table->integer('road');
            $table->string('holding_no');
            $table->string('building_type');
            $table->integer('total_flat');
            $table->integer('occupied_flat');
            $table->string('building_name');
            $table->string('collection_type');
            $table->decimal('collection_rate', 10, 2)->default(0);
            $table->decimal('collection_amount', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->date('date');
            $table->tinyInteger('status');
            $table->string('name');
            $table->string('flat_no');
            $table->string('number');
            $table->string('email');
            $table->tinyInteger('payment_status');
            $table->date('payment_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plot_and_units');
    }
};
