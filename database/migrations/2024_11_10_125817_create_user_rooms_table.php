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
        Schema::create('user_rooms', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('user_id', 100)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('room_id', 10)->nullable();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('set null');
            $table->datetime('rent_period')->nullable();
            $table->string('payment_id', 10)->nullable();
            $table->foreign('payment_id')->references('id')->on('rooms')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rooms');
    }
};
