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
        Schema::create('bulksms', function (Blueprint $table) {
            $table->id();
            $table->enum('sms_type',['custom','draft'])->nullable();
            $table->integer('draft_id')->nullable();
            $table->enum('language',['english','bangla'])->nullable();
            $table->string('custom_sms')->nullable();
            $table->enum('sending_method',['send_now','scheduled_message'])->nullable();
            $table->datetime('schedule_time')->nullable();
            $table->enum('status',['pending','sent'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulksms');
    }
};
