<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganDomisili extends Model
{
    protected $table = 'surat_keterangan_domisili';
    
    // IZINKAN SEMUA KOLOM DIISI
    protected $guarded = [];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}