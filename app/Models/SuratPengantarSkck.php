<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPengantarSkck extends Model
{
    protected $table = 'surat_pengantar_skck'; // Sesuaikan nama tabel
    protected $guarded = ['id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}