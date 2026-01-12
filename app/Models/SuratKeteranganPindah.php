<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganPindah extends Model
{
    protected $table = 'surat_keterangan_pindah';
    
    // IZINKAN SEMUA KOLOM DIISI
    protected $guarded = [];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}