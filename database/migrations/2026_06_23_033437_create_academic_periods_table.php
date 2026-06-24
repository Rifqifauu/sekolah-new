<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_periods', function (Blueprint $table) {
            $table->id();
            $table->string('year'); // Contoh: '2024/2025'
            $table->enum('semester', ['odd', 'even'])->comment('odd = Ganjil, even = Genap');
            $table->boolean('is_active')->default(false); // Hanya boleh ada 1 yang true di aplikasi nanti
            $table->timestamps();

            // Mencegah duplikasi data, misal 2024/2025 Ganjil diinput dua kali
            $table->unique(['year', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_periods');
    }
};
