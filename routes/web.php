<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Models\Berita;
use App\Http\Controllers\Admin\KeuanganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', function () {
    // 1. Ambil 3 berita terbaru (berdasarkan tanggal) dari database
    $beritaTerbaru = Berita::orderBy('tanggal', 'desc')->take(3)->get();

    // 2. Kirim data tersebut ke view 'welcome'
    return view('welcome', [
        'beritas' => $beritaTerbaru
    ]);
});

// Penyalur setelah login
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect('/');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// =======================================================
// GRUP RUTE UNTUK SEMUA FITUR ADMIN
// =======================================================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Warga
    Route::resource('warga', WargaController::class)->parameter('warga', 'penduduk');

    // Manajemen Berita
    Route::resource('berita', BeritaController::class)->parameter('berita', 'berita');

    // Manajemen Keuangan
    Route::resource('keuangan', KeuanganController::class);

});

// Rute untuk halaman profil pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Memuat rute autentikasi
require __DIR__.'/auth.php';