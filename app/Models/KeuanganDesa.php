<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganDesa extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit (praktik yang baik)
    protected $table = 'keuangan_desa';

    // Kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'tanggal',
        'kategori',
        'keterangan',
        'jenis',
        'jumlah',
        'user_id',
    ];

    /**
     * Mendefinisikan relasi ke tabel User.
     * Satu transaksi dimiliki oleh satu User (admin).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}