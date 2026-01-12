<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPengajuanTanah extends Model
{
    // PERBAIKAN: Nama tabel harus surat_pengajuan_tanah
    protected $table = 'surat_pengajuan_tanah'; 
    
    // IZINKAN SEMUA KOLOM DIISI
    protected $guarded = [];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}