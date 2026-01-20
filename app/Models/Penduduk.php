<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    // --- KUNCI RAHASIANYA DISINI ---
    // Walaupun nama modelnya 'Penduduk', kita paksa dia connect ke tabel 'biodata'
    protected $table = 'biodata'; 

    protected $guarded = ['id'];

    // Tetap kita kasih pengaman biar NIK dianggap string (bukan angka)
    protected $casts = [
        'nik' => 'string',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->hasOne(User::class, 'nik', 'nik');
    }
}