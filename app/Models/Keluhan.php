<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    protected $table = 'keluhan';

    protected $fillable = [
        'user_id',      // Sesuai gambar DB
        'judul',        // Sesuai gambar DB
        'isi',          // Sesuai gambar DB
        'foto_bukti',   // Sesuai gambar DB
        'status',       // Sesuai gambar DB
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}