<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // 1. Role harus dibuat paling pertama agar ID-nya tersedia
            RoleSeeder::class, // (Pastikan pakai huruf R besar)

            // 2. User (termasuk Admin, Camat, Lurah) dibuat setelah Role
            UserSeeder::class,

            // 3. Masukkan data dummy aplikasi (Dashboard akan kembali terisi)
            PemberdayaanSeeder::class,
            AuditTrailSeeder::class,
            
            // Catatan: AdminSeeder kita hapus/tidak dipanggil karena 
            // akun admin sudah dibuat di dalam UserSeeder.
        ]);
    }
}