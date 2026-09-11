<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penempatans', function (Blueprint $table) {
            $table->id();
            // Menghubungkan kandidat (masyarakat) dan posisi (program)
            $table->foreignId('masyarakat_id')->constrained('masyarakats')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            
            $table->date('tanggal_penempatan')->nullable();
            $table->enum('status', ['Seleksi', 'Diterima', 'Bekerja', 'Ditolak'])->default('Seleksi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penempatans');
    }
};