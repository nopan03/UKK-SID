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
use Illuminate\Support\Facades\Mail;
// use App\Rules\Recaptcha; // ❌ HAPUS ATAU KOMENTAR INI

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDASI INPUT (Tanpa Recaptcha)
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'nik' => ['required', 'numeric', 'digits:16', 'unique:users,nik'], 
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // ❌ BAGIAN RECAPTCHA SUDAH SAYA BUANG DARI SINI
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama ini sudah dipakai.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK ini sudah terdaftar. Silakan login.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        // 2. LOGIKA PENENTUAN STATUS & ROLE
        $cekPenduduk = Penduduk::where('nik', $request->nik)->first();

        // Default: Anggap dia PENDATANG
        $roleUser = 'pengunjung'; 
        $labelStatus = 'Warga Pendatang'; 

        // Jika Ternyata NIK-nya Ada (Warga Asli)
        if ($cekPenduduk) {
            $roleUser = 'warga';
            $labelStatus = 'Warga Asli'; 
        }

        // 3. GENERATE OTP
        $otpCode = rand(100000, 999999);

        // 4. SIMPAN USER
        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
            // Variabel dinamis dari logika di atas
            'role' => $roleUser,            
            'status_kependudukan' => $labelStatus, 
            
            'otp' => $otpCode,
        ]);

        // 5. KIRIM EMAIL OTP
        try {
            $pesan = "Halo $user->name,\n\nTerima kasih telah mendaftar.\nKode verifikasi (OTP) Anda adalah:\n\n$otpCode\n\nMasukkan kode ini di website untuk mengaktifkan akun.";
            
            Mail::raw($pesan, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode Verifikasi OTP - Desa Suruh');
            });
        } catch (\Exception $e) {
            // Abaikan error email
        }

        // 6. LOGIN & REDIRECT
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('otp.verify');
    }
}