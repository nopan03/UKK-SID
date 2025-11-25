<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Berita;
use App\Models\Surat; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\SuratController as AdminSuratController;
use App\Http\Controllers\KeluhanController;

/* --- 1. ROUTE PUBLIK --- */
Route::get('/', function () {
    $beritaTerbaru = Berita::orderBy('tanggal', 'desc')->take(3)->get();
    return view('welcome', ['beritas' => $beritaTerbaru]);
});

// Profil Desa
Route::get('/sejarah-desa', function () { return view('warga.profil-desa.sejarah'); })->name('sejarah');
Route::get('/visi-misi', function () { return view('warga.profil-desa.visimisi'); })->name('visimisi');
Route::get('/struktur-organisasi', function () { return view('warga.profil-desa.struktur-organisasi'); })->name('struktur');

// Infografis
Route::get('/infografis-penduduk', function () { return view('warga.infografis.penduduk'); })->name('infografis.penduduk');

// Layanan Surat
Route::get('/administrasi-surat', function () { return view('warga.surat.index'); })->name('surat.index');

//Layanan Keluhan
Route::get('/lapor-keluhan', [KeluhanController::class, 'create'])->name('keluhan.create');
Route::post('/lapor-keluhan-simpan', [KeluhanController::class, 'store'])->name('keluhan.store');

/* --- 2. LOGIKA REDIRECT --- */
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('warga.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

/* --- 3. ROUTE ADMIN --- */
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('warga', WargaController::class)->parameter('warga', 'penduduk');
    Route::resource('berita', BeritaController::class)->parameter('berita', 'berita');
    Route::resource('keuangan', KeuanganController::class);
    // Verifikasi Surat
    Route::resource('surat', AdminSuratController::class);
});

/* --- 4. ROUTE WARGA --- */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/warga/dashboard', function () {
        $suratSaya = Surat::where('user_id', Auth::id())->latest()->get();
        return view('warga.dashboard', compact('suratSaya'));
    })->name('warga.dashboard');

    Route::get('/surat/buat/{jenis}', [SuratController::class, 'create'])->name('surat.create');
    Route::post('/surat/simpan', [SuratController::class, 'store'])->name('surat.store');
    Route::get('/surat/detail/{id}', [SuratController::class, 'show'])->name('surat.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';