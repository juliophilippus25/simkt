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
        Schema::create('apply_residencies', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id', 100);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('verified_by', 100)->nullable();
            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->enum('status', ['pending', 'pending-payment', 'accepted', 'rejected'])->default('pending');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apply_residencies');
    }
};
