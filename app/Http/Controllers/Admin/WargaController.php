<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk; // Pastikan Model ini benar
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WargaController extends Controller
{
    /**
     * MENAMPILKAN DAFTAR WARGA (Fungsi yang tadi hilang)
     */
    public function index()
    {
        // 1. Ambil semua data dari tabel (Model Penduduk)
        // Menggunakan paginate(10) agar kalau datanya ribuan tidak berat (halaman terbagi)
        $warga = Penduduk::paginate(10); 
        
        // 2. Tampilkan ke View index
        // Pastikan Anda punya file: resources/views/admin/warga/index.blade.php
        return view('admin.warga.index', compact('warga'));
    }

    /**
     * Menampilkan form untuk membuat data warga baru.
     */
    public function create()
    {
        return view('admin.warga.create');
    }

    /**
     * Menyimpan data warga baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required|string|digits:16|unique:biodata,nik', // Pastikan nama tabelnya 'biodata' sesuai database
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'agama' => 'required|string',
            'status_perkawinan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_hidup' => 'required|in:hidup,meninggal',
            'pendidikan' => 'nullable|string',
        ]);

        Penduduk::create($validatedData);

        // Redirect ke index (daftar warga), bukan dashboard, agar admin bisa lihat data yang baru masuk
        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail data seorang warga.
     */
    public function show(Penduduk $penduduk) // Pastikan route model binding-nya benar
    {
        return view('admin.warga.show', ['warga' => $penduduk]);
    }

    /**
     * Menampilkan form untuk mengedit data warga.
     */
    public function edit($id)
    {
        // Kadang Route Model Binding bermasalah jika nama param beda, kita cari manual biar aman
        $penduduk = Penduduk::findOrFail($id);
        return view('admin.warga.edit', ['warga' => $penduduk]);
    }

    /**
     * Memperbarui data warga di database.
     */
    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $validatedData = $request->validate([
            'nik' => ['required', 'string', 'digits:16', Rule::unique('biodata')->ignore($penduduk->id)],
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'agama' => 'required|string',
            'status_perkawinan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_hidup' => 'required|in:hidup,meninggal',
        ]);

        $penduduk->update($validatedData);

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil diperbarui!');
    }

    /**
     * Menghapus data warga dari database.
     */
    public function destroy($id)
    {
        // 1. Cari data warga berdasarkan ID
        $penduduk = Penduduk::findOrFail($id);

        // 2. (OPSIONAL) Hapus juga Akun Login (User) milik warga ini jika ada
        if ($penduduk->nik) {
             \App\Models\User::where('nik', $penduduk->nik)->delete();
        }

        // 3. Hapus Data Warga
        $penduduk->delete();

        // 4. Kembali ke halaman tabel (Index), BUKAN ke Dashboard
        return redirect()->route('admin.warga.index')->with('success', 'Data warga dan akun terkait berhasil dihapus!');
    }
}