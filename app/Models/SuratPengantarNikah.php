<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPengantarNikah extends Model
{
    protected $table = 'surat_pengantar_nikah'; // Sesuaikan nama tabel
    protected $guarded = ['id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}