<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPengantarNikah extends Model
{
    protected $table = 'surat_pengantar_nikah';
    
    // IZINKAN SEMUA KOLOM DIISI
    protected $guarded = [];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}