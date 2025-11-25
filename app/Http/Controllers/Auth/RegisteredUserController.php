<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk; // Pastikan Model ini benar (Penduduk atau Biodata)
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'], 
            'nik' => ['required', 'string', 'max:16', 'unique:users,nik'], 
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.unique' => 'Nama lengkap ini sudah memiliki akun.',
            'nik.unique' => 'NIK ini sudah terdaftar sebagai akun pengguna. Silakan login saja.',
            'email.unique' => 'Email ini sudah digunakan.',
        ]);

        // 2. CEK APAKAH NIK ADA DI DATA PENDUDUK (DASHBOARD ADMIN)
        // Logika: Warga tidak bisa daftar jika NIK-nya belum diinput oleh Admin
        $cekPenduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$cekPenduduk) {
            // Jika NIK tidak ditemukan di tabel Penduduk
            return back()->withErrors(['nik' => 'NIK Anda belum terdaftar di Data Desa. Silakan hubungi Admin Desa.'])->withInput();
        }

        // 3. SIMPAN USER BARU KE DATABASE (INI YANG TADI HILANG)
        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga', // Set default role sebagai warga
        ]);

        // 4. TRIGGER EVENT REGISTERED
        event(new Registered($user));

        // 5. ARAHKAN KE LOGIN
       return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login dengan Email dan password Anda.');
    }
}