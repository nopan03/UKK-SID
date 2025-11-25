<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganKelahiran extends Model
{
    protected $table = 'surat_keterangan_kelahiran';
    protected $guarded = ['id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}