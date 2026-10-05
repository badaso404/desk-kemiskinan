<?php

namespace App\Imports;

use App\Models\Masyarakat;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class MasyarakatImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public int $successCount = 0;
    public int $errorCount   = 0;

    public function model(array $row)
    {
        $this->successCount++;

        return new Masyarakat([
            'nama'                => trim((string) ($row['nama'] ?? '')),
            'nik'                 => trim((string) ($row['nik'] ?? '')),
            'jenis_kelamin'       => $this->normalizeGender($row['jenis_kelamin'] ?? ''),
            'tanggal_lahir'       => $this->parseDate($row['tanggal_lahir'] ?? null),
            'telepon'             => $this->normalizePhone($row['telepon'] ?? ''),
            'kecamatan'           => trim((string) ($row['kecamatan'] ?? '')),
            'kelurahan'           => trim((string) ($row['kelurahan'] ?? '')),
            'alamat'              => trim((string) ($row['alamat'] ?? '')),
            'pendidikan_terakhir' => trim((string) ($row['pendidikan_terakhir'] ?? '')),
            'status_pekerjaan'    => trim((string) ($row['status_pekerjaan'] ?? '')),
            'status_verifikasi'   => 'Belum Terverifikasi',
            'keahlian'            => trim((string) ($row['keahlian_minat'] ?? '')),
        ]);
    }

    public function rules(): array
    {
        return [
            'nik'                 => 'required|numeric|digits:16|unique:masyarakats,nik',
            'nama'                => 'required|string|max:255',
            'jenis_kelamin'       => 'required|in:Laki-laki,Perempuan,laki-laki,perempuan,L,P',
            'tanggal_lahir'       => 'required',
            'telepon'             => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'kecamatan'           => 'required|string',
            'kelurahan'           => 'required|string',
            'alamat'              => 'required|string',
            'status_pekerjaan'    => 'required|string',
            'pendidikan_terakhir' => 'nullable|string|max:50',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nik.required'          => 'NIK wajib diisi.',
            'nik.numeric'           => 'NIK harus berupa angka.',
            'nik.digits'            => 'NIK harus tepat 16 digit.',
            'nik.unique'            => 'NIK sudah terdaftar di sistem.',
            'nama.required'         => 'Nama wajib diisi.',
            'jenis_kelamin.required'=> 'Jenis kelamin wajib diisi (Laki-laki / Perempuan).',
            'jenis_kelamin.in'      => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'tanggal_lahir.required'=> 'Tanggal lahir wajib diisi.',
            'telepon.required'      => 'Nomor telepon wajib diisi.',
            'telepon.regex'         => 'Format telepon tidak valid (contoh: 08123456789).',
            'kecamatan.required'    => 'Kecamatan wajib diisi.',
            'kelurahan.required'    => 'Kelurahan wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
            'status_pekerjaan.required' => 'Status pekerjaan wajib diisi.',
        ];
    }

    public function onFailure(Failure ...$failures): void
    {
        $this->errorCount += count($failures);
    }

    /**
     * Normalisasi jenis kelamin ke format baku: Laki-laki / Perempuan.
     */
    private function normalizeGender($value): ?string
    {
        $v = strtolower(trim((string) $value));

        return match (true) {
            in_array($v, ['laki-laki', 'laki laki', 'l', 'pria', 'male'])  => 'Laki-laki',
            in_array($v, ['perempuan', 'p', 'wanita', 'female'])            => 'Perempuan',
            default                                                          => null,
        };
    }

    /**
     * Normalisasi nomor telepon ke format 08xxxxxxxxx.
     */
    private function normalizePhone($value): string
    {
        $v = preg_replace('/[\s\-\.]/', '', (string) $value);

        if (str_starts_with($v, '+62')) {
            $v = '0' . substr($v, 3);
        } elseif (str_starts_with($v, '62')) {
            $v = '0' . substr($v, 2);
        }

        return $v;
    }

    /**
     * Parse tanggal dari berbagai format Excel.
     */
    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Throwable $e) {
                return null;
            }
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}