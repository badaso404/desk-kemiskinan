<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'bantuan' => 'array',
        'sertifikat' => 'array',
        'tanggal_lahir' => 'date',
    ];
}