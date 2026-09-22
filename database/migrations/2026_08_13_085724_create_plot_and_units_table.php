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

            $table->string('unique_id', 30)->unique();

            $table->string('name', 100)->index();
            $table->string('email', 254)->nullable();
            $table->string('phone', 20); // form sends name="number" (map in controller)
            $table->string('flat_no', 30)->nullable(); // Contact person's unit

            // Property Information
            $table->string('holding_no', 20);
            $table->string('building_name', 100)->nullable()->comment('Optional for plots/vacant land');
            $table->unsignedSmallInteger('total_flat')->default(0)->nullable();
            $table->unsignedSmallInteger('occupied_flat')->default(0)->nullable();
            $table->string('flat_numbers')->nullable()->comment('Comma-separated flat tags e.g. 2A,2B,3A,3C');

            // Collection Information
            $table->enum('collection_type', [
                'Group',
                'Individual',
            ]);

            $table->decimal('collection_rate', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0); // form sends name="collection_amount"
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
