<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penempatan extends Model
{
    // Melindungi field id agar tidak mass-assignable, sisanya boleh
    protected $fillable = [
        'masyarakat_id',
        'program_id',
        'tanggal_penempatan',
        'status',
    ];

    /**
     * Relasi ke tabel masyarakat
     */
    public function masyarakat(): BelongsTo
    {
        return $this->belongsTo(Masyarakat::class);
    }

    /**
     * Relasi ke tabel program
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}