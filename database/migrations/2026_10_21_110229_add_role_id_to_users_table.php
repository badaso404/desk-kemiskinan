<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->default(1)->after('password')->constrained('roles')->onDelete('cascade');
            }
        });

        // Isi role_id user yang sudah ada berdasarkan kolom enum 'role' yang lama
        $map = [
            'admin' => 1,
            'kecamatan' => 2,
            'kelurahan' => 3,
            'pimpinan_kesra' => 4,
            'walikota' => 5,
        ];

        foreach ($map as $roleName => $roleId) {
            DB::table('users')->where('role', $roleName)->update(['role_id' => $roleId]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role_id')) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            }
        });
    }
};
