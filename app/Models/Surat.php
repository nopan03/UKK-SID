<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table  = 'surat';
    // semua kolom boleh di–mass assign kecuali id
    protected $guarded = ['id'];
    
    protected $casts = [
        'is_read' => 'boolean', // Agar dibaca sebagai true/false, bukan 1/0
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // Pemohon
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Detail masing-masing jenis surat
    public function detailTidakMampu()
    {
        return $this->hasOne(SuratKeteranganTidakMampu::class, 'surat_id');
    }

    public function detailDomisili()
    {
        return $this->hasOne(SuratKeteranganDomisili::class, 'surat_id');
    }

    public function detailKelahiran()
    {
        return $this->hasOne(SuratKeteranganKelahiran::class, 'surat_id');
    }

    public function detailKematian()
    {
        return $this->hasOne(SuratKeteranganKematian::class, 'surat_id');
    }

    public function detailNikah()
    {
        return $this->hasOne(SuratPengantarNikah::class, 'surat_id');
    }

    public function detailPindah()
    {
        return $this->hasOne(SuratKeteranganPindah::class, 'surat_id');
    }

    public function detailTanah()
    {
        return $this->hasOne(SuratPengajuanTanah::class, 'surat_id');
    }

    public function detailUsaha()
    {
        return $this->hasOne(SuratKeteranganUsaha::class, 'surat_id');
    }
    
    public function detailSkck()
    {
        return $this->hasOne(SuratPengantarSkck::class, 'surat_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR: keterangan
    |--------------------------------------------------------------------------
    | Dipakai di Blade cukup dengan $surat->keterangan
    | - Jika ada data keperluan di tabel detail -> pakai itu
    | - Kalau tidak ada -> pakai kolom "keterangan" di tabel surat (fallback)
    */
    public function getKeteranganAttribute()
    {
        // nilai asli dari kolom "keterangan" di tabel surat
        $default = $this->attributes['keterangan'] ?? null;

        switch ($this->jenis_surat) {
            case 'Surat Pengantar SKCK':
                return optional($this->detailSkck)->keperluan ?? $default;

            case 'Surat Keterangan Tidak Mampu':
                return optional($this->detailTidakMampu)->keperluan ?? $default;

            // contoh jika nanti mau diambil dari tabel lain:
            // case 'Surat Keterangan Domisili':
            //     return optional($this->detailDomisili)->alamat ?? $default;

            // case 'Surat Pengajuan Tanah':
            //     return optional($this->detailTanah)->keperluan ?? $default;

            default:
                // untuk semua jenis surat lain, minimal tampilkan kolom "keterangan"
                return $default;
        }
    }
}