<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Administrator', 'email' => 'admin@gmail.com', 'role' => 'admin'],
            ['name' => 'Kecamatan Cengkareng', 'email' => 'kecamatan@gmail.com', 'role' => 'kecamatan'],
            ['name' => 'Pimpinan Kesra', 'email' => 'kesra@gmail.com', 'role' => 'pimpinan_kesra'],
            ['name' => 'Kelurahan Kapuk', 'email' => 'kelurahan@gmail.com', 'role' => 'kelurahan'],
            ['name' => 'Bapak Walikota', 'email' => 'walikota@gmail.com', 'role' => 'walikota'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'),
                'role' => $user['role'],
            ]);
        }
    }
}