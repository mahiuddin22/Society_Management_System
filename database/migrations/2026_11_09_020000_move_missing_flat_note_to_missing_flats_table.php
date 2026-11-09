<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missing_flats', function (Blueprint $table) {
            $table->text('note')->nullable();
        });

        if (Schema::hasColumn('plot_and_units', 'missing_flat_note')) {
            DB::table('plot_and_units')
                ->whereNotNull('missing_flat_note')
                ->where('missing_flat_note', '<>', '')
                ->orderBy('id')
                ->chunkById(100, function ($plots) {
                    foreach ($plots as $plot) {
                        DB::table('missing_flats')
                            ->where('plot_and_unit_id', $plot->id)
                            ->update(['note' => $plot->missing_flat_note]);
                    }
                });

            Schema::table('plot_and_units', function (Blueprint $table) {
                $table->dropColumn('missing_flat_note');
            });
        }
    }

    public function down(): void
    {
        Schema::table('plot_and_units', function (Blueprint $table) {
            $table->text('missing_flat_note')->nullable();
        });

        DB::table('missing_flats')
            ->select('plot_and_unit_id', 'note')
            ->whereNotNull('note')
            ->where('note', '<>', '')
            ->orderBy('id')
            ->get()
            ->unique('plot_and_unit_id')
            ->each(function ($flat) {
                DB::table('plot_and_units')
                    ->where('id', $flat->plot_and_unit_id)
                    ->update(['missing_flat_note' => $flat->note]);
            });

        Schema::table('missing_flats', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
};
