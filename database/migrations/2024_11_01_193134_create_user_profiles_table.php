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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->string('user_id', 100)->primary();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('nik', 16)->unique();
            $table->string('phone');
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->string('regency_id', 100)->nullable();
            $table->string('nim')->nullable();
            $table->string('university')->nullable();
            $table->string('major')->nullable();
            $table->string('ktp');
            $table->string('family_card')->nullable();
            $table->string('active_student')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
