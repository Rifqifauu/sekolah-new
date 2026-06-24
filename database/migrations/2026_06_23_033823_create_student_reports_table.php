<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId("student_id")->constrained("people")->cascadeOnDelete();
            $table->foreignId("teacher_id")->constrained("people")->cascadeOnDelete();
            $table->text("notes")->nullable(); // Diubah ke text agar bisa menampung laporan panjang
            $table->enum("status", ["pending", "approved", "rejected"])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_reports');
    }
};
