<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail; // 🔥 PENTING: Jangan lupa import ini

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
        $cekPenduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$cekPenduduk) {
            // Jika NIK tidak ditemukan di tabel Penduduk
            return back()->withErrors(['nik' => 'NIK Anda belum terdaftar di Data Desa. Silakan hubungi Admin Desa.'])->withInput();
        }

        // ============================================================
        // 🔥 FITUR BARU: GENERATE OTP
        // ============================================================
        $otpCode = rand(100000, 999999);

        // 3. SIMPAN USER BARU + KODE OTP
        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga', // Default role
            'otp' => $otpCode, // Simpan kode OTP ke database
        ]);

        // 4. KIRIM EMAIL OTP
        try {
            $pesan = "Halo $user->name,\n\nTerima kasih telah mendaftar.\nKode verifikasi (OTP) Anda adalah:\n\n$otpCode\n\nMasukkan kode ini di website untuk mengaktifkan akun.";
            
            Mail::raw($pesan, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode Verifikasi OTP - Desa Suruh');
            });
        } catch (\Exception $e) {
            // Opsional: Biarkan kosong atau log error jika email gagal (agar user tetap terbuat)
        }

        // 5. TRIGGER EVENT (Opsional, bawaan Laravel)
        event(new Registered($user));

        // 6. LOGIN OTOMATIS & LEMPAR KE HALAMAN INPUT OTP
        // Kita tidak redirect ke Login, tapi langsung Login-kan user
        // Namun karena belum verified, middleware akan menahan dia di halaman OTP nanti.
        Auth::login($user);

        return redirect()->route('otp.verify');
    }
}