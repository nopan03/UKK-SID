<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganPindah extends Model
{
    protected $table = 'surat_keterangan_pindah'; // Sesuaikan nama tabel
    protected $guarded = ['id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}