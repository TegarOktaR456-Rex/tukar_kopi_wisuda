<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    // Relasi ke tabel User (untuk mengambil nama pelayan dari akun user-nya)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}