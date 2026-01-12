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
        $validatedData = $request->validate([
            'judul'    => 'required|string|max:255|unique:berita,judul',
            'kategori' => 'required|string|max:100',
            'tanggal'  => 'required|date',
            'isi'      => 'required|string',
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // 2. Upload Gambar (Jika ada)
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita-images', 'public');
            $validatedData['gambar'] = $path;
        }

        $validatedData['slug']    = Str::slug($request->judul, '-');
        $validatedData['user_id'] = auth()->id();
        
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
        $validatedData = $request->validate([
            'judul'    => ['required', 'string', 'max:255', Rule::unique('berita')->ignore($berita->id)],
            'kategori' => 'required|string|max:100',
            'tanggal'  => 'required|date',
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