<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MasyarakatTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'nama',
            'nik',
            'jenis_kelamin',
            'tanggal_lahir',
            'telepon',
            'kecamatan',
            'kelurahan',
            'alamat',
            'pendidikan_terakhir',
            'status_pekerjaan',
            'keahlian_minat',
        ];
    }

    public function array(): array
    {
        // Baris contoh — hapus sebelum diisi data asli
        return [
            [
                'Ahmad Contoh',
                '3173010101990001',
                'Laki-laki',
                '1999-01-01',
                '081234567890',
                'Cengkareng',
                'Kapuk',
                'Jl. Contoh No. 10, RT 01/RW 02',
                'SMA/SMK',
                'Belum / Tidak Bekerja',
                'Otomotif, Mengemudi',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:K1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF12395B');

        $widths = [
            'A' => 22, 'B' => 20, 'C' => 14, 'D' => 14, 'E' => 16,
            'F' => 22, 'G' => 22, 'H' => 32, 'I' => 18, 'J' => 22, 'K' => 26,
        ];
        foreach ($widths as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }

        return [];
    }
}