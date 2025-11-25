<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Bikin Akun Admin
        User::create([
            'nik' => '0000000000000001', // NIK Admin (Asal aja)
            'name' => 'Administrator',
            'email' => 'admin@desa.com', // Email Admin
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'admin', // Penting: Role Admin
        ]);

        // Bikin Akun Warga (Buat Tes)
        User::create([
            'nik' => '3515000000000001',
            'name' => 'Warga Contoh',
            'email' => 'warga@desa.com',
            'password' => Hash::make('password'),
            'role' => 'warga',
        ]);
    }
}