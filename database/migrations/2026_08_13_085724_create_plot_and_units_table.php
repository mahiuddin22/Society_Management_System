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

            // Relationships
            $table->foreignId('plot_type_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('road_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Owner / Payer Information
            $table->string('name', 100)->index();
            $table->string('email', 254)->nullable();
            $table->string('phone', 20);
            $table->string('unique_id', 30)->unique();

            // Property Information
            $table->string('holding_no', 20);
            $table->unsignedSmallInteger('total_flat');
            $table->unsignedSmallInteger('occupied_flat');
            $table->string('building_name', 100);
            $table->string('flat_numbers')->nullable()->comment('2A,2B,3A,3C');

            // Collection Information
            $table->enum('collection_type', [
                'Group',
                'Individual',
            ]);

            $table->decimal('collection_rate', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);

            // Status
            $table->enum('status', [
                'Active',
                'Inactive',
                'Hold',
                'Archived',
            ])->default('Active');

            $table->timestamps();

            // Allows multiple records for the same holding
            // while making road + holding searches efficient.
            $table->index(['road_id', 'holding_no']);
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
