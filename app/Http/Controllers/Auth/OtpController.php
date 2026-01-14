<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
   // 1. TAMPILKAN FORM INPUT KODE
    public function show()
    {
        // Jika user sudah verified, lempar ke dashboard
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        
        // DULU: return view('auth.verify-otp');
        // SEKARANG: Kita pakai file bawaan Laravel saja
        return view('auth.verify-email'); 
    }

    // 2. PROSES CEK KODE
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();

        // Cek apakah kode yang diinput SAMA dengan di database
        if ($request->otp == $user->otp) {
            
            // A. Tandai email sebagai verified (Ada jam & tanggalnya)
            $user->markEmailAsVerified();
            
            // B. Hapus kode OTP agar tidak bisa dipakai ulang (Security)
            $user->otp = null;
            $user->save();

            // C. Redirect ke Dashboard dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'Akun berhasil diverifikasi! Selamat Datang.');
        }

        // Jika Salah: Kembali ke form dengan error
        return back()->withErrors(['otp' => 'Kode OTP salah atau kedaluwarsa. Silakan cek email Anda lagi.']);
    }
    
    // 3. KIRIM ULANG KODE (RESEND)
    public function resend()
    {
        $user = Auth::user();
        $otpCode = rand(100000, 999999);
        
        $user->otp = $otpCode;
        $user->save();
        
        $pesan = "Halo $user->name,\n\nKode verifikasi BARU Anda adalah:\n\n$otpCode";
        
        \Illuminate\Support\Facades\Mail::raw($pesan, function ($message) use ($user) {
            $message->to($user->email)->subject('Kode OTP Baru - Desa Suruh');
        });
        
        return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}