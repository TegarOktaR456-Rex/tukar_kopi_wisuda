<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penukaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelayan_id',
        'tamu_id',
        'waktu_penukaran',
    ];

    // Relasi ke tabel Pelayan
    public function pelayan()
    {
        return $this->belongsTo(Pelayan::class, 'pelayan_id');
    }

    // Relasi ke tabel Tamu
    public function tamu()
    {
        return $this->belongsTo(Tamu::class, 'tamu_id');
    }
}