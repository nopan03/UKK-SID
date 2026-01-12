<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengantarSkck extends Model
{
    use HasFactory;

    protected $table = 'surat_pengantar_skck'; 

    // IZINKAN SEMUA KOLOM DIISI
    protected $guarded = [];

    // Jika tabel ini memang tidak punya created_at/updated_at, biarkan ini false.
    // Tapi jika punya, boleh dihapus baris ini.
    public $timestamps = false; 

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}