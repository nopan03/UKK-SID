<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; // Penting untuk menghapus file

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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $imageName = time().'.'.$request->gambar->extension();  
            $request->gambar->storeAs('public/berita-images', $imageName);
            $validatedData['gambar'] = $imageName;
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if($berita->gambar) {
                Storage::delete('public/berita-images/' . $berita->gambar);
            }
            $imageName = time().'.'.$request->gambar->extension();  
            $request->gambar->storeAs('public/berita-images', $imageName);
            $validatedData['gambar'] = $imageName;
        }

        $validatedData['slug'] = Str::slug($request->judul, '-');
        
        $berita->update($validatedData);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Berita $berita)
    {
        if($berita->gambar) {
            Storage::delete('public/berita-images/' . $berita->gambar);
        }
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}