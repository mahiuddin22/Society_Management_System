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
        Schema::create('sector_collenctions', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique()->nullable();
            $table->integer('road_id')->nullable();
            $table->string('holding_no')->nullable();
            $table->integer('plot_and_unit_id')->nullable();
            $table->integer('member_id')->nullable();
            $table->string('flat_no')->nullable();
            $table->string('number')->nullable();
            $table->string('email')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->tinyInteger('payment_status')->default(0);
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sector_collenctions');
    }
};
