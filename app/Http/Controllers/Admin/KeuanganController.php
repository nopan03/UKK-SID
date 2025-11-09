<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeuanganDesa;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen keuangan dengan rekapitulasi.
     */
    public function index()
    {
        $transaksis = KeuanganDesa::with('user')->latest()->paginate(15);
        $total_pemasukan = KeuanganDesa::where('jenis', 'pemasukan')->sum('jumlah');
        $total_pengeluaran = KeuanganDesa::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo_akhir = $total_pemasukan - $total_pengeluaran;

        return view('admin.keuangan.index', compact('transaksis', 'total_pemasukan', 'total_pengeluaran', 'saldo_akhir'));
    }

    /**
     * Menampilkan form untuk membuat transaksi baru.
     */
    public function create()
    {
        return view('admin.keuangan.create');
    }

    /**
     * Menyimpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $validatedData['user_id'] = auth()->id();

        KeuanganDesa::create($validatedData);

        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit transaksi.
     */
    public function edit(KeuanganDesa $keuangan) // Menggunakan Route Model Binding
    {
        return view('admin.keuangan.edit', compact('keuangan'));
    }

    /**
     * Memperbarui transaksi di database.
     */
    public function update(Request $request, KeuanganDesa $keuangan)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $keuangan->update($validatedData);

        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus transaksi dari database.
     */
    public function destroy(KeuanganDesa $keuangan)
    {
        $keuangan->delete();
        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}