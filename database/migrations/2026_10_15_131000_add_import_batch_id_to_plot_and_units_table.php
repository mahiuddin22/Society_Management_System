<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plot_and_units', function (Blueprint $table) {
            $table->uuid('import_batch_id')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('plot_and_units', function (Blueprint $table) {
            $table->dropColumn('import_batch_id');
        });
    }
};
