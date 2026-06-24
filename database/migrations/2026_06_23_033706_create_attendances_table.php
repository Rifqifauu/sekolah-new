<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId("student_id")->constrained("people")->cascadeOnDelete();
            $table->foreignId("teacher_id")->constrained("people")->cascadeOnDelete();
            $table->date("date");
            $table->enum('status', ['present', 'absent', 'late', 'permission', 'sick']); // Tambahan status umum
            $table->string("note")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
