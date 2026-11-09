<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missing_flats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plot_and_unit_id')->constrained('plot_and_units')->cascadeOnDelete();
            $table->string('flat_number', 30);
            $table->timestamps();
            $table->unique(['plot_and_unit_id', 'flat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missing_flats');
    }
};
