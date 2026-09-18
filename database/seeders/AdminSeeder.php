<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar pengguna untuk semua role
        $users = [
            [
                'name'  => env('ADMIN_NAME', 'Administrator'),
                'email' => env('ADMIN_EMAIL', 'admin@gmail.com'),
                'role'  => 'admin',
            ],
            [
                'name'  => 'Kecamatan',
                'email' => 'kecamatan@gmail.com',
                'role'  => 'kecamatan',
            ],
            [
                'name'  => 'Pimpinan Kesra',
                'email' => 'kesra@gmail.com',
                'role'  => 'pimpinan_kesra',
            ],
            [
                'name'  => 'Kelurahan',
                'email' => 'kelurahan@gmail.com',
                'role'  => 'kelurahan',
            ],
            [
                'name'  => 'Walikota',
                'email' => 'walikota@gmail.com',
                'role'  => 'walikota',
            ],
        ];

        $defaultPassword = env('ADMIN_PASSWORD', 'admin2026');

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name'     => $userData['name'],
                    'password' => Hash::make($defaultPassword),
                    'role'     => $userData['role'],
                ]
            );
        }
    }
}