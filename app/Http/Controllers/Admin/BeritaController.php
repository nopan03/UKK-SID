<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255|unique:berita,judul',
            'kategori' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            // Saat membuat berita baru, gambar seharusnya wajib diisi
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cara standar Laravel untuk menyimpan file.
        // File akan disimpan di storage/app/public/berita-images
        // dan path lengkapnya (folder + nama hash) akan dikembalikan.
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita-images', 'public');
            $validatedData['gambar'] = $path;
        }

        $validatedData['slug'] = Str::slug($request->judul, '-');
        $validatedData['user_id'] = auth()->id();
        
        Berita::create($validatedData);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(Berita $berita)
    {
        return view('admin.berita.show', ['berita' => $berita]);
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', ['berita' => $berita]);
    }

    public function update(Request $request, Berita $berita)
    {
        $validatedData = $request->validate([
            'judul' => ['required', 'string', 'max:255', Rule::unique('berita')->ignore($berita->id)],
            'kategori' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            // Saat update, gambar boleh kosong (nullable)
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama, menggunakan path yang sudah tersimpan di database
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            
            // Simpan gambar baru
            $path = $request->file('gambar')->store('berita-images', 'public');
            $validatedData['gambar'] = $path;
        }

        $validatedData['slug'] = Str::slug($request->judul, '-');
        
        $berita->update($validatedData);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Berita $berita)
    {
        // Hapus gambar dari storage
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        
        // Hapus record dari database
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}