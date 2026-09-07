<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Membuat akun admin. Aplikasi ini hanya punya satu peran, yaitu admin.
     *
     * Kredensial diambil dari .env bila tersedia:
     *   ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@gmail.com')],
            [
                'name' => env('ADMIN_NAME', 'Admin'),
                'password' => env('ADMIN_PASSWORD', 'admin2026'),
            ]
        );
    }
}
