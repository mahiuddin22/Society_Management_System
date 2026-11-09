<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plot_and_units', function (Blueprint $table) {
            $table->text('missing_flat_note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('plot_and_units', function (Blueprint $table) {
            $table->dropColumn('missing_flat_note');
        });
    }
};
