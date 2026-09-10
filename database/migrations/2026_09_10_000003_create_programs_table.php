<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ['Pelatihan', 'Seminar', 'Bimbingan Teknis', 'Workshop'])->default('Pelatihan');
            $table->string('kategori');
            $table->foreignId('mitra_id')->nullable()->constrained('mitras')->nullOnDelete();
            $table->string('penyelenggara');
            $table->string('lokasi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->unsignedInteger('kuota')->default(0);
            $table->unsignedInteger('peserta')->default(0);
            $table->enum('status', ['Pendaftaran', 'Berjalan', 'Selesai'])->default('Pendaftaran');
            // Keahlian/minat yang disasar program ini, dipisah koma.
            // Dipakai modul Rekomendasi untuk mencocokkan warga dengan program.
            $table->text('kriteria')->nullable();
            // Keahlian yang diperoleh peserta setelah lulus, dipisah koma.
            $table->text('keahlian_dihasilkan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
