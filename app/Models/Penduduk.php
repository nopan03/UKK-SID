<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    /**
     * Memberitahu Laravel bahwa Model ini harus terhubung ke tabel 'biodata'.
     */
    protected $table = 'biodata';

    /**
     * The attributes that are mass assignable.
     * Daftar kolom yang "diizinkan" untuk diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'status_hidup',
        'pendidikan',
        // Daftarkan semua kolom lain dari tabel biodata yang ingin Anda bisa isi melalui form
    ];
}