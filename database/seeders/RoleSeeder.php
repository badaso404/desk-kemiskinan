<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',           // Akan mendapat ID: 1
            'kecamatan',       // Akan mendapat ID: 2
            'kelurahan',  // Akan mendapat ID: 3
            'pimpinan_kesra',      // Akan mendapat ID: 4
            'walikota'         // Akan mendapat ID: 5
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}