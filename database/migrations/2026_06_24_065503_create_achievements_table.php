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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Contoh: Juara 1 Robotik Nasional
            $table->string('category'); // Contoh: Akademik, Olahraga & Seni
            $table->string('level'); // Contoh: Nasional, Provinsi
            $table->string('rank'); // Contoh: Juara 1, Medali Emas
            $table->year('year');
            $table->string('image')->nullable(); // Dibuat nullable jika foto tidak wajib
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
