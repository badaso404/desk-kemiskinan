<?php

namespace Database\Seeders;

use App\Models\AuditTrail;
use Illuminate\Database\Seeder;

class AuditTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'user_name' => 'Simulasi',
                'action' => 'login',
                'module' => 'auth',
                'description' => 'User login ke panel admin',
                'metadata' => ['ip' => '192.168.1.12'],
                'created_at' => now()->subMinutes(8),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'logout',
                'module' => 'auth',
                'description' => 'User logout dari panel admin',
                'metadata' => ['ip' => '192.168.1.12'],
                'created_at' => now()->subMinutes(16),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'create_masyarakat',
                'module' => 'masyarakat',
                'description' => 'Kasus baru JKB-2026-0015 - handa risky',
                'metadata' => ['kasus' => 'JKB-2026-0015'],
                'created_at' => now()->subHours(1),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'update_masyarakat',
                'module' => 'masyarakat',
                'description' => 'Pelapor baru: nada risky',
                'metadata' => ['pelapor' => 'nada risky'],
                'created_at' => now()->subHours(2),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'update_masyarakat',
                'module' => 'masyarakat',
                'description' => 'Input Desil 10 untuk kasus JKB-2026-0015',
                'metadata' => ['nilai' => 10],
                'created_at' => now()->subHours(3),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'update_masyarakat',
                'module' => 'masyarakat',
                'description' => 'Update Desil untuk kasus JKB-2026-0014',
                'metadata' => ['nilai' => 1],
                'created_at' => now()->subHours(4),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'create_program',
                'module' => 'program',
                'description' => 'Program baru "Pelatihan Komputer" dibuat',
                'metadata' => ['program' => 'Pelatihan Komputer'],
                'created_at' => now()->subHours(5),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'update_program',
                'module' => 'program',
                'description' => 'Program "Pelatihan Komputer" diperbarui',
                'metadata' => ['program' => 'Pelatihan Komputer'],
                'created_at' => now()->subHours(6),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'create_penempatan',
                'module' => 'penempatan',
                'description' => 'Rekomendasi program Beasiswa Anak Miskin (skor 72%) untuk kasus JKB-2026-0014',
                'metadata' => ['skor' => '72%'],
                'created_at' => now()->subHours(7),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'update_penempatan',
                'module' => 'penempatan',
                'description' => 'Sistem menghasilkan rekomendasi program baru',
                'metadata' => ['jumlah' => 3],
                'created_at' => now()->subHours(9),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'update_penempatan',
                'module' => 'penempatan',
                'description' => 'Keputusan program disetujui untuk ditindaklanjuti',
                'metadata' => ['status' => 'approved'],
                'created_at' => now()->subHours(10),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'status_change',
                'module' => 'penempatan',
                'description' => 'Status penempatan berubah menjadi diterima',
                'metadata' => ['status' => 'diterima'],
                'created_at' => now()->subHours(11),
            ],
            [
                'user_name' => 'Simulasi',
                'action' => 'permission_change',
                'module' => 'user',
                'description' => 'Hak akses user administrator diperbarui',
                'metadata' => ['role' => 'admin'],
                'created_at' => now()->subHours(12),
            ],
        ];

        foreach ($events as $event) {
            AuditTrail::create([
                'user_id' => null,
                'user_name' => $event['user_name'],
                'action' => $event['action'],
                'module' => $event['module'],
                'description' => $event['description'],
                'model_type' => null,
                'model_id' => null,
                'metadata' => $event['metadata'],
                'created_at' => $event['created_at'],
                'updated_at' => $event['created_at'],
            ]);
        }
    }
}
