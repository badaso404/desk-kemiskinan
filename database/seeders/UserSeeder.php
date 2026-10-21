<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin2026'),
            'role_id' => 1, // ID untuk 'admin'
            'role' => 'admin',

        ]);

        // 2. Akun Kecamatan
        User::create([
            'name' => 'Camat Sukamaju',
            'email' => 'kecamatan@gmail.com',
            'password' => Hash::make('admin2026'),
            'role_id' => 2, // ID untuk 'kecamatan'
            'role' => 'kecamatan',
        ]);

        // 3. Akun Kelurahan
        User::create([
            'name' => 'Lurah Sukamaju',
            'email' => 'kelurahan@gmail.com',
            'password' => Hash::make('admin2026'),
            'role_id' => 3, // ID untuk 'kelurahan'
            'role' => 'kelurahan',
        ]);

        // 3. Akun Pimpinan Kesra
        User::create([
            'name' => 'Apa ajalah',
            'email' => 'kesra@gmail.com',
            'password' => Hash::make('admin2026'),
            'role_id' => 4, // ID untuk 'kelurahan'
            'role' => 'pimpinan_kesra',
        ]);

        // 4. Akun Walikota
        User::create([
            'name' => 'Bapak Walikota',
            'email' => 'walikota@gmail.com',
            'password' => Hash::make('admin2026'),
            'role_id' => 5, // ID untuk 'walikota'
            'role' => 'walikota',
        ]);
    }
}