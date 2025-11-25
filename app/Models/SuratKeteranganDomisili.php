<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganDomisili extends Model
{
    protected $table = 'surat_keterangan_domisili';
    protected $guarded = ['id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}