<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPengajuanTanah extends Model
{
    protected $table = 'surat_pengajuan_tanah'; // Sesuaikan nama tabel
    protected $guarded = ['id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}