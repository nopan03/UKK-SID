<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganDesa extends Model
{
    use HasFactory;

    // 1. Pastikan nama tabel benar
    protected $table = 'keuangan_desa';

    // 2. Pastikan nama kolom SESUAI dengan gambar phpMyAdmin Anda
    protected $fillable = [
        'user_id',
        'jenis',      // enum('pemasukan', 'pengeluaran')
        'kategori',
        'jumlah',     // PENTING: Namanya 'jumlah', bukan 'nominal'
        'keterangan',
        'tanggal',
    ];

    // Relasi ke User (Admin yang input)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}