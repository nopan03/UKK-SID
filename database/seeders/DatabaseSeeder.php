<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Penduduk; // Sudah Benar
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. BUAT AKUN ADMIN (TANPA BIODATA / NIK)
        // ==========================================
        User::create([
            'nik' => null,
            'name' => 'Administrator',
            'email' => 'admin@desa.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // ==========================================
        // 2. BUAT AKUN WARGA (DENGAN BIODATA)
        // ==========================================

        // A. Bikin Biodata Warga
        // 🔥 PERBAIKAN DISINI: Ganti Biodata::create jadi Penduduk::create
        Penduduk::create([
            'nik' => '3500000000000001', 
            // Pastikan nama kolom ini sesuai dengan migration tabel biodata Mas
            // (apakah 'nama' atau 'nama_lengkap'?)
            'nama' => 'Warga Teladan', 
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1995-05-15',
            'jenis_kelamin' => 'L', // Sesuaikan dengan enum di database (L/P atau Laki-laki/Perempuan)
            'agama' => 'Islam',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Wiraswasta',
            'alamat' => 'Dusun Sukamaju RT 01 RW 02',
            'status_hidup' => 'Hidup', // Sesuaikan huruf besar/kecil dengan enum database
        ]);

        // B. Bikin User Warga (Disambung via NIK)
        User::create([
            'nik' => '3500000000000001', 
            'name' => 'Warga Teladan',
            'email' => 'warga@desa.com',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'email_verified_at' => now(),
        ]);
    }
}