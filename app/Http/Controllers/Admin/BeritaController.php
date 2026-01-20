<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $semua_berita = Berita::with('user')->latest()->paginate(10);
        return view('admin.berita.index', ['beritas' => $semua_berita]);
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    // Simpan berita yang baru di buat
    public function store(Request $request)
    {
        // 1. Validasi
        // 🔥 Perubahan: 'tanggal' dihapus dari validasi karena kita akan isi otomatis
        $validatedData = $request->validate([
            'judul'    => 'required|string|max:255|unique:berita,judul',
            'kategori' => 'required|string|max:100',
            // 'tanggal' => 'required|date', <--- INI DIHAPUS
            'isi'      => 'required|string',
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // 2. Upload Gambar (Jika ada)
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita-images', 'public');
            $validatedData['gambar'] = $path;
        }

        // 3. Set Data Otomatis
        $validatedData['slug']    = Str::slug($request->judul, '-');
        $validatedData['user_id'] = auth()->id();
        
        // 🔥 Perubahan: Paksa tanggal menjadi HARI INI
        $validatedData['tanggal'] = date('Y-m-d'); 
        
        Berita::create($validatedData);
        LogAktivitas::catat("Memublikasikan berita desa baru: {$request->judul}");

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(Berita $berita)
    {
        return view('admin.berita.show', ['berita' => $berita]);
    }

    
    // Edit Berita
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', ['berita' => $berita]);
    }

    // Update Berita
    public function update(Request $request, Berita $berita)
    {
        // 🔥 Perubahan: 'tanggal' dihapus dari validasi update juga
        // Agar tanggal asli tidak berubah meskipun diedit
        $validatedData = $request->validate([
            'judul'    => ['required', 'string', 'max:255', Rule::unique('berita')->ignore($berita->id)],
            'kategori' => 'required|string|max:100',
            // 'tanggal' => 'required|date', <--- INI DIHAPUS
            'isi'      => 'required|string',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            
            $path = $request->file('gambar')->store('berita-images', 'public');
            $validatedData['gambar'] = $path;
        }

        $validatedData['slug'] = Str::slug($request->judul, '-');
        
        // Update data (Kolom 'tanggal' di database tidak akan disentuh, jadi tetap aman)
        $berita->update($validatedData);
        
        LogAktivitas::catat("Menyunting/Edit berita desa: {$berita->judul}");

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // Hapus berita 
    public function destroy(Berita $berita)
    {
        $judulLama = $berita->judul; // Simpan judul untuk log

        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        
        $berita->delete();
        LogAktivitas::catat("Menghapus berita desa: {$judulLama}");
        
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}