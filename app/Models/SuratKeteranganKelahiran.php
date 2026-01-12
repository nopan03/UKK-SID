<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganKelahiran extends Model
{
    protected $table = 'surat_keterangan_kelahiran';
    
    // IZINKAN SEMUA KOLOM DIISI
    protected $guarded = [];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}