<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('id_number')->unique();

            $table->enum('gender', ['male', 'female']);
            $table->string('position')->nullable(); // Untuk jabatan guru/staf

            $table->enum('role', ['teacher', 'student', 'staff']);

            $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
