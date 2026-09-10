<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'kategori',
        'mitra_id',
        'penyelenggara',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota',
        'peserta',
        'status',
        'kriteria',
        'keahlian_dihasilkan',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'kuota' => 'integer',
        'peserta' => 'integer',
    ];

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class);
    }

    public function getSisaKuotaAttribute(): int
    {
        return max(0, $this->kuota - $this->peserta);
    }

    public function getPersenTerisiAttribute(): int
    {
        return $this->kuota > 0 ? (int) round($this->peserta / $this->kuota * 100) : 0;
    }

    /**
     * Kriteria peserta sebagai array yang sudah dirapikan.
     *
     * @return array<int, string>
     */
    public function getDaftarKriteriaAttribute(): array
    {
        return static::pecah($this->kriteria);
    }

    /**
     * @return array<int, string>
     */
    public function getDaftarKeahlianDihasilkanAttribute(): array
    {
        return static::pecah($this->keahlian_dihasilkan);
    }

    /**
     * Memecah teks berpemisah koma menjadi array huruf kecil.
     *
     * @return array<int, string>
     */
    public static function pecah(?string $teks): array
    {
        if (blank($teks)) {
            return [];
        }

        return collect(preg_split('/[,;\/]+/', $teks))
            ->map(fn ($bagian) => trim(mb_strtolower($bagian)))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
