<?php

namespace App\Console\Commands;

use App\Exports\MasyarakatDummyExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class GenerateMasyarakatDummy extends Command
{
    protected $signature = 'masyarakat:generate-dummy
                            {--per-kecamatan=50 : Jumlah data per kecamatan}
                            {--output=dummy-masyarakat.xlsx : Nama file output (di storage/app)}';

    protected $description = 'Generate file Excel berisi data dummy masyarakat untuk testing import';

    public function handle(): int
    {
        $perKecamatan = (int) $this->option('per-kecamatan');
        $output       = $this->option('output');

        $jumlahKecamatan = 8;
        $total           = $perKecamatan * $jumlahKecamatan;

        $this->newLine();
        $this->info('  Memulai generate data dummy...');
        $this->line("  • Kecamatan        : {$jumlahKecamatan} (Jakarta Barat)");
        $this->line("  • Per kecamatan    : {$perKecamatan}");
        $this->line("  • Total baris      : {$total}");
        $this->newLine();

        try {
            Excel::store(new MasyarakatDummyExport($perKecamatan), $output, 'local');
        } catch (\Throwable $e) {
            $this->error('  ❌ Gagal generate: ' . $e->getMessage());
            return self::FAILURE;
        }

        $path = storage_path('app/' . $output);

        $this->info('  ✅ File berhasil dibuat!');
        $this->line("  📁 Lokasi : {$path}");
        $this->newLine();
        $this->comment('  Copy file tersebut lalu upload via menu Import Excel untuk testing.');
        $this->newLine();

        return self::SUCCESS;
    }
}