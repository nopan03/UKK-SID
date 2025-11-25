<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganTidakMampu extends Model
{
    // Nama tabel di database (Sesuai migration tadi)
    protected $table = 'surat_keterangan_tidak_mampu';
    
    protected $guarded = ['id'];

    // Relasi Balik ke Induk
    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}