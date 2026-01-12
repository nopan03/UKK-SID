<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganUsaha extends Model
{
    protected $table = 'surat_keterangan_usaha';
    
    // IZINKAN SEMUA KOLOM DIISI
    protected $guarded = [];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}