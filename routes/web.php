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

// --- 2. IMPORT CONTROLLER WARGA (YANG BARU DIPINDAH) ---
// Perhatikan namespace-nya sekarang ada tambahan "\Warga"
use App\Http\Controllers\Warga\PendudukController;
use App\Http\Controllers\Warga\ApbdesController;
use App\Http\Controllers\Warga\SuratController;      // ✅ Updated path
use App\Http\Controllers\Warga\KeluhanController;    // ✅ Updated path
use App\Http\Controllers\Warga\ProfileController;    // ✅ Updated path


/* --- 1. ROUTE PUBLIK --- */
Route::get('/', function () {
    $beritaTerbaru = Berita::orderBy('tanggal', 'desc')->take(3)->get();
    return view('welcome', ['beritas' => $beritaTerbaru]);
});

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
Route::post('/lapor-keluhan-simpan', [KeluhanController::class, 'store'])->name('keluhan.store');

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

        // Route Keluhan Admin
        Route::resource('keluhan', AdminKeluhanController::class);

        // Route Log Aktivitas
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');
    });

/* --- 4. ROUTE WARGA (BUTUH LOGIN) --- */
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/riwayat-surat', function () {
        $suratSaya = Surat::where('user_id', Auth::id())->latest()->get();
        return view('warga.riwayat', compact('suratSaya'));
    })->name('warga.riwayat');

    // Route Surat Warga (Sekarang menggunakan controller di folder Warga)
    Route::get('/surat/buat/{jenis}', [SuratController::class, 'create'])->name('surat.create');
    Route::post('/surat/simpan', [SuratController::class, 'store'])->name('surat.store');
    Route::get('/surat/detail/{id}', [SuratController::class, 'show'])->name('surat.show');

    // Route Profile (Sekarang menggunakan controller di folder Warga)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';