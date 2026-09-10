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
            $table->string('nama');
            $table->string('nik', 16);
            $table->string('posisi');
            $table->string('pemberi_kerja');
            $table->date('tanggal_penempatan')->nullable();
            $table->string('status'); // Seleksi, Bekerja, Diterima
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penempatans');
    }
};