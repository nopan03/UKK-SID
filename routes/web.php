<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\BeritaController; // <-- INI YANG PERLU DIPASTIKAN ADA

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk halaman utama (landing page)
Route::get('/', function () {
    return view('welcome');
});

// Rute "penyalur" setelah pengguna berhasil login
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
    
    // Rute untuk dashboard utama admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // --- Rute CRUD untuk Manajemen Warga ---
    Route::get('/warga/create', [WargaController::class, 'create'])->name('warga.create');
    Route::post('/warga', [WargaController::class, 'store'])->name('warga.store');
    Route::get('/warga/{penduduk}', [WargaController::class, 'show'])->name('warga.show');
    Route::get('/warga/{penduduk}/edit', [WargaController::class, 'edit'])->name('warga.edit');
    Route::put('/warga/{penduduk}', [WargaController::class, 'update'])->name('warga.update');
    Route::delete('/warga/{penduduk}', [WargaController::class, 'destroy'])->name('warga.destroy');

    // --- Rute CRUD untuk Manajemen Berita ---
    Route::resource('berita', BeritaController::class)->parameters([
    'berita' => 'berita'
]);


});


// Rute untuk halaman profil pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Memuat semua rute autentikasi dari Breeze
require __DIR__.'/auth.php';