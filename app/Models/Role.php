<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Mengizinkan mass-assignment untuk kolom name
    protected $fillable = ['name'];

    // Relasi balik ke user (opsional tapi disarankan)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}