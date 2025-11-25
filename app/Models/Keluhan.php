<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    // 1. KUNCI TABEL: Karena nama tabel Anda 'keluhan' (bukan keluhans)
    protected $table = 'keluhan';

    // 2. IZINKAN KOLOM: Daftar kolom yang boleh diisi data
    protected $fillable = [
        'nama_pelapor',
        'judul_laporan',
        'isi_laporan',
        'foto_bukti',
        'status'
    ];
}