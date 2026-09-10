<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'bidang',
        'narahubung',
        'telepon',
        'alamat',
    ];

    /**
     * Program yang diselenggarakan mitra ini.
     */
    public function program(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    /**
     * Total kursi yang masih kosong dari program yang belum selesai.
     */
    public function getSisaKuotaAttribute(): int
    {
        return $this->program
            ->where('status', '!=', 'Selesai')
            ->sum(fn ($program) => $program->sisa_kuota);
    }
}
