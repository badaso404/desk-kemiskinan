<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('masyarakats', function (Blueprint $table) {
            $table->id();
            
            // Step 1: Identitas
            $table->string('nik', 16)->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('telepon');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->text('alamat');

            // Step 2: Kondisi Pekerjaan
            $table->string('status_pekerjaan');
            $table->string('lama_menganggur')->nullable();
            $table->string('alasan_tidak_bekerja')->nullable();
            $table->string('pengalaman_terakhir')->nullable();
            $table->string('lama_pengalaman')->nullable();
            $table->string('tipe_pekerjaan_dicari')->nullable();

            // Step 3: Kondisi Ekonomi
            $table->string('status_dtks')->nullable();
            $table->string('pendapatan_bulanan')->nullable();
            $table->integer('jumlah_tanggungan')->nullable()->default(0);
            $table->string('status_rumah')->nullable();
            $table->json('bantuan')->nullable();

            // Step 4: Pendidikan & Kemampuan
            $table->string('pendidikan_terakhir');
            $table->string('jurusan')->nullable();
            $table->text('keahlian');
            $table->json('sertifikat')->nullable();
            $table->string('minat_pelatihan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masyarakats');
    }
};