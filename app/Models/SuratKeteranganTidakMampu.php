<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini (opsional tapi bagus)
use Illuminate\Database\Eloquent\Model;

class SuratKeteranganTidakMampu extends Model
{
    use HasFactory;

    // Nama tabel sudah benar
    protected $table = 'surat_keterangan_tidak_mampu';

    // ---------------------------------------------------------
    // PERBAIKAN UTAMA DI SINI
    // ---------------------------------------------------------
    
    // HAPUS atau KOMENTARI bagian $fillable yang membatasi ini:
    /*
    protected $fillable = [
        'surat_id',
        'keperluan'
    ];
    */

    // GANTI DENGAN INI:
    // Artinya: "Tidak ada kolom yang dijaga, silakan isi semua kolom yang dikirim Controller"
    protected $guarded = []; 

    // CATATAN SOAL TIMESTAMPS:
    // Di screenshot database Anda ada kolom 'created_at' & 'updated_at'.
    // Kalau Anda mau kolom itu terisi otomatis, HAPUS baris 'public $timestamps = false;'
    // Tapi kalau mau dibiarkan NULL, biarkan kode di bawah ini aktif:
    // public $timestamps = false; 
}