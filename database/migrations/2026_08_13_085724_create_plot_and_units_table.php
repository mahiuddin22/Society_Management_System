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
            $table->string('road')->nullable();
            $table->string('holding_no')->nullable();
            $table->string('building_type')->nullable();
            $table->integer('total_flat')->default(0);
            $table->integer('occupied_flat')->default(0);
            $table->string('collection_type')->nullable();
            $table->string('contact_person')->nullable();
            $table->decimal('collection_rate', 10, 2)->default(0);
            $table->decimal('collection_amount', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
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
