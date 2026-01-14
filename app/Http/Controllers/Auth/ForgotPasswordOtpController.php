<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;

class ForgotPasswordOtpController extends Controller
{
    // 1. TAMPILKAN HALAMAN INPUT EMAIL
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. PROSES KIRIM KODE OTP KE EMAIL
    public function sendOtp(Request $request)
    {
        // Validasi: Email harus ada di tabel users
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Buat Kode OTP 6 Angka
        $otp = rand(100000, 999999);
        
        // Simpan OTP sementara ke database user
        $user->otp = $otp;
        $user->save();

        // Kirim Email (Pastikan .env sudah setting Gmail)
        try {
            Mail::raw("Halo $user->name,\n\nKami menerima permintaan reset password.\nKode OTP Anda adalah:\n\n$otp\n\nMasukkan kode ini di website untuk membuat password baru.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode OTP Reset Password - Desa Suruh');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Pastikan koneksi internet lancar.']);
        }

        // Arahkan user ke halaman Input OTP (Sambil bawa data emailnya)
        return redirect()->route('password.reset.otp.form', ['email' => $request->email])
                         ->with('status', 'Kode OTP telah dikirim ke email Anda!');
    }

    // 3. TAMPILKAN HALAMAN INPUT OTP & PASSWORD BARU
    // 3. TAMPILKAN HALAMAN INPUT OTP & PASSWORD BARU
    public function showResetForm(Request $request)
    {
        // SEBELUMNYA (Kalau pakai file baru):
        // return view('auth.reset-password-otp', ['email' => $request->email]);

        // SEKARANG (Pakai file bawaan yang sudah diedit):
        return view('auth.reset-password', ['email' => $request->email]);
    }

    // 4. PROSES SIMPAN PASSWORD BARU
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Cari user yang Email DAN OTP-nya cocok
        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();

        // Jika tidak ketemu (berarti OTP Salah)
        if (!$user) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau tidak cocok.']);
        }

        // Jika Benar: Ganti Password & Hapus OTP
        $user->password = Hash::make($request->password);
        $user->otp = null; 
        $user->save();

        return redirect()->route('login')->with('status', 'Password berhasil diubah! Silakan login.');
    }
}