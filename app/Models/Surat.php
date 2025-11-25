<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';
    protected $guarded = ['id'];

    // Relasi ke User (Pemohon)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // === RELASI KE DETAIL SURAT (ANAK) ===
    
    public function detailTidakMampu()
    {
        return $this->hasOne(SuratKeteranganTidakMampu::class);
    }

    public function detailDomisili()
    {
        return $this->hasOne(SuratKeteranganDomisili::class);
    }

    public function detailKelahiran()
    {
        return $this->hasOne(SuratKeteranganKelahiran::class);
    }

    public function detailKematian()
    {
        return $this->hasOne(SuratKeteranganKematian::class);
    }

    public function detailNikah()
    {
        return $this->hasOne(SuratPengantarNikah::class);
    }

    public function detailPindah()
    {
        return $this->hasOne(SuratKeteranganPindah::class);
    }

    public function detailTanah()
    {
        return $this->hasOne(SuratPengajuanTanah::class);
    }

    public function detailSkck()
    {
        return $this->hasOne(SuratPengantarSkck::class);
    }
}