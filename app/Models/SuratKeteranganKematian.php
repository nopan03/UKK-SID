<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganKematian extends Model
{
    protected $table = 'surat_keterangan_kematian';
    protected $guarded = ['id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}