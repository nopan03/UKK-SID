<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    /**
     * Properti $fillable yang benar dan lengkap.
     */
    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'gambar',
        'kategori',
        'tanggal',
        'user_id',
    ];

    /**
     * Relasi ke User (penulis).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}