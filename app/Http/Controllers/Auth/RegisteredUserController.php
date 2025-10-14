<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk; // Pastikan nama model ini benar
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
        // 1. Sesuaikan Aturan Validasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'digits:16', 'unique:'.User::class], // NIK harus unik di tabel users
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Validasi tambahan: Cek NIK ke data master penduduk
        $wargaExists = Penduduk::where('nik', $request->nik)->exists();
        if (!$wargaExists) {
            // Jika NIK tidak ada di master data, kembalikan dengan error
            return back()->withErrors(['nik' => 'NIK yang Anda masukkan tidak terdaftar sebagai warga.'])->withInput();
        }

        // 2. Sesuaikan Bagian Pembuatan User
        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Role akan otomatis terisi 'warga' dari nilai default di database.
        ]);

        event(new Registered($user));

        // Setelah registrasi, user TIDAK otomatis login, tapi diarahkan ke halaman login
        // Auth::login($user); // Baris ini kita non-aktifkan sesuai permintaan Anda

        // Arahkan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login dengan NIK dan password Anda.');
    }
}