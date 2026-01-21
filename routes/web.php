<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Berita;
use App\Models\Surat; 

// --- 1. IMPORT CONTROLLER ADMIN ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\SuratController as AdminSuratController;
use App\Http\Controllers\Admin\KeluhanController as AdminKeluhanController;
use App\Http\Controllers\Admin\LogAktivitasController;

// --- 2. IMPORT CONTROLLER WARGA ---
use App\Http\Controllers\Warga\PendudukController;
use App\Http\Controllers\Warga\ApbdesController;
use App\Http\Controllers\Warga\SuratController;      
use App\Http\Controllers\Warga\KeluhanController;
use App\Http\Controllers\Warga\ProfileController;

// --- 3. IMPORT CONTROLLER OTP ---
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\ForgotPasswordOtpController;


/* --- 1. ROUTE PUBLIK --- */
Route::get('/', function () 
{
    // 1. Jika User SUDAH LOGIN & Role-nya ADMIN
    if (Auth::check() && Auth::user()->role === 'admin') {
        // Langsung lempar kembali ke Dashboard Admin
        return redirect()->route('admin.dashboard');
    }

    // 2. Jika Belum Login (Tamu), Tampilkan Landing Page seperti biasa
    $beritaTerbaru = Berita::orderBy('tanggal', 'desc')->take(3)->get();
    return view('welcome', ['beritas' => $beritaTerbaru]);
});

// Route berita baca selengkapnya (Hanya yang sudah login)
Route::get('/berita/{id}', function ($id) {
    $berita = Berita::findOrFail($id); 
    return view('landing.berita-detail', compact('berita'));
})->middleware('auth')->name('berita.detail');


// Route Validasi Surat (PUBLIK - Bisa Scan Tanpa Login)
Route::get('/validasi-surat/{id}', [SuratController::class, 'validasi'])->name('surat.validasi');

// Profil Desa
Route::get('/sejarah-desa', function () {
    return view('warga.profil-desa.sejarah');
})->name('sejarah');

Route::get('/visi-misi', function () {
    return view('warga.profil-desa.visimisi');
})->name('visimisi');

Route::get('/struktur-organisasi', function () {
    return view('warga.profil-desa.struktur-organisasi');
})->name('struktur');

Route::get('/peta-desa', function () {
    return view('warga.profil-desa.peta-desa');
})->name('peta-desa');

// Infografis (PUBLIK)
Route::get('/infografis-penduduk', [PendudukController::class, 'index'])
    ->name('infografis.penduduk');

// Infografis APBDes (PUBLIK)
Route::get('/infografis-apbdes', [ApbdesController::class, 'index'])
    ->name('infografis.apbdes');

// Layanan Surat (Halaman Pilihan Surat)
Route::get('/administrasi-surat', function () {
    return view('warga.surat.index');
})->name('surat.index');

// Layanan Keluhan (Untuk Warga Mengisi)
Route::get('/lapor-keluhan', [KeluhanController::class, 'create'])->name('keluhan.create');
Route::post('/lapor-keluhan-simpan', [KeluhanController::class, 'store'])
    ->middleware('throttle:3,1') 
    ->name('keluhan.store');

/* --- 2. LOGIKA REDIRECT --- */
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect('/'); 
    }
})->middleware(['auth', 'verified'])->name('dashboard');

/* --- 3. ROUTE ADMIN --- */
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Resource Controller
        Route::resource('warga', WargaController::class)->parameter('warga', 'penduduk');
        Route::resource('berita', BeritaController::class)->parameter('berita', 'berita');
        Route::resource('keuangan', KeuanganController::class);
        Route::resource('surat', AdminSuratController::class);

        // ➜ ROUTE KHUSUS UNTUK MENAMPILKAN / UNDUH PDF SURAT
        Route::get('/surat/{surat}/pdf', [AdminSuratController::class, 'cetakPdf'])
            ->name('surat.pdf');

        Route::post('/surat/{id}/kirim-email', [AdminSuratController::class, 'kirimEmail'])
            ->name('surat.kirim-email');

        // Route Keluhan Admin
        Route::resource('keluhan', AdminKeluhanController::class);

        // Route Log Aktivitas
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');
    });

/* --- 4. ROUTE WARGA (BUTUH LOGIN & SUDAH VERIFIKASI) --- */
Route::middleware(['auth', 'verified'])->group(function () {
    
    //Route Riwayat Surat Warga
    Route::get('/riwayat-surat', [SuratController::class, 'index'])->name('warga.riwayat');

    // Route Surat Warga
    Route::get('/surat/buat/{jenis}', [SuratController::class, 'create'])->name('surat.create');
    Route::post('/surat/simpan', [SuratController::class, 'store'])->name('surat.store');
    Route::get('/surat/detail/{id}', [SuratController::class, 'show'])->name('surat.show');

    // Route Profile (Standard)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔥 FITUR BARU: GANTI PASSWORD (VALIDASI LAMA + OTP) 🔥
    
    // 1. Validasi Password Lama & Baru -> Kirim OTP
    Route::post('/profile/password/initiate', [ProfileController::class, 'initiatePasswordUpdate'])
        ->name('profile.password.initiate');

    // 2. Finalisasi Ganti Password dengan OTP
    Route::put('/profile/password/confirm', [ProfileController::class, 'finalizePasswordUpdate'])
        ->name('profile.password.confirm');
        
    // 3. Link Lupa Password (Khusus User Login yang lupa password lamanya)
    Route::post('/profile/forgot-password-logged-in', [ProfileController::class, 'requestPasswordReset'])
        ->name('profile.forgot.logged_in');
});


/* --- 5. ROUTE OTP (BUTUH LOGIN, TAPI TIDAK BUTUH VERIFIED) --- */
Route::middleware('auth')->group(function () {
    Route::get('/verify-otp', [OtpController::class, 'show'])->name('otp.verify');
    Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.check');
    Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');
});

// =========================================================================
// REQUIRE AUTH
// =========================================================================
require __DIR__.'/auth.php'; 


// === ROUTE KHUSUS LUPA PASSWORD DENGAN OTP (GUEST) ===
Route::middleware('guest')->group(function () {
    
    // Halaman Input Email
    Route::get('forgot-password', [ForgotPasswordOtpController::class, 'showLinkRequestForm'])
        ->name('password.request');

    // Proses Kirim OTP
    Route::post('forgot-password', [ForgotPasswordOtpController::class, 'sendOtp'])
        ->name('password.email'); 

    // Halaman Input OTP + Password Baru
    Route::get('reset-password-otp', [ForgotPasswordOtpController::class, 'showResetForm'])
        ->name('password.reset.otp.form');

    // Proses Simpan Password Baru
    Route::post('reset-password-otp', [ForgotPasswordOtpController::class, 'updatePassword'])
        ->name('password.update.otp');
});