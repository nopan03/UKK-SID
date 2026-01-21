<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// 🔥 IMPORT UTAMA 🔥
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpGantiPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir profil user.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi profil user (Nama, Email Readonly).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email = $request->user()->getOriginal('email');
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * ==========================================================
     * FITUR BARU: GANTI PASSWORD DENGAN VALIDASI LAMA & OTP
     * ==========================================================
     */

    /**
     * TAHAP 1: Validasi Input, Cek Password Lama, Kirim OTP
     */
    public function initiatePasswordUpdate(Request $request)
    {
        // 1. Validasi Input (Password Lama, Baru, Konfirmasi)
        $request->validate([
            'current_password' => ['required', 'current_password'], // Laravel otomatis cek password lama user
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Generate OTP
        $otp = rand(100000, 999999);
        $userId = $request->user()->id;

        // 3. Simpan OTP & Password Baru (Hash) ke Cache selama 5 menit
        // Kita simpan password barunya di server dulu, belum disimpan ke database
        $dataCache = [
            'otp' => $otp,
            'new_password_hash' => Hash::make($request->password)
        ];
        
        Cache::put('password_change_' . $userId, $dataCache, 300); // 300 detik = 5 menit

        // 4. Kirim Email
        try {
            Mail::to($request->user()->email)->send(new OtpGantiPassword($otp));
            
            // 5. Kembali ke halaman dengan status 'otp_sent' agar form OTP muncul
            return back()->with('otp_sent', true)->with('status', '✅ Password lama benar. Kode OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Coba lagi.');
        }
    }

    /**
     * TAHAP 2: Verifikasi OTP & Simpan Password Baru Permanen
     */
    public function finalizePasswordUpdate(Request $request)
    {
        // 1. Validasi Input OTP
        $request->validate([
            'otp_code' => 'required|numeric',
        ]);

        $userId = $request->user()->id;
        $cachedData = Cache::get('password_change_' . $userId);

        // 2. Cek Validitas OTP (Ada di cache & sama dengan inputan)
        if (!$cachedData || $cachedData['otp'] != $request->otp_code) {
            // Jika salah, form OTP tetap terbuka (otp_sent=true)
            return back()->with('otp_sent', true)->withErrors(['otp_code' => 'Kode OTP salah atau sudah kadaluarsa. Silakan ulangi proses dari awal.']);
        }

        // 3. Update Password User dengan Hash yang sudah disimpan di cache
        $request->user()->update([
            'password' => $cachedData['new_password_hash']
        ]);

        // 4. Bersihkan Cache (Hapus data sementara)
        Cache::forget('password_change_' . $userId);

        return back()->with('status', 'password-updated'); // Trigger alert sukses hijau
    }

    /**
     * KHUSUS LUPA PASSWORD (SAAT SUDAH LOGIN)
     * Mengirim link reset password standar Laravel ke email tanpa logout
     */
    public function requestPasswordReset(Request $request)
    {
        $status = \Illuminate\Support\Facades\Password::broker()->sendResetLink(
            ['email' => $request->user()->email]
        );

        return $status == \Illuminate\Support\Facades\Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }
}