<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WargaController extends Controller
{
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
            'nik' => 'required|string|digits:16|unique:biodata,nik',
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

        return redirect()->route('admin.dashboard')->with('success', 'Data warga berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail data seorang warga.
     */
    public function show(Penduduk $penduduk)
    {
        return view('admin.warga.show', ['warga' => $penduduk]);
    }

    /**
     * Menampilkan form untuk mengedit data warga.
     */
    public function edit(Penduduk $penduduk)
    {
        return view('admin.warga.edit', ['warga' => $penduduk]);
    }

    /**
     * Memperbarui data warga di database.
     */
    public function update(Request $request, Penduduk $penduduk)
    {
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

        return redirect()->route('admin.dashboard')->with('success', 'Data warga berhasil diperbarui!');
    }

    /**
     * Menghapus data warga dari database.
     */
    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Data warga berhasil dihapus!');
    }
}