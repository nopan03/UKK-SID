<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeuanganDesa;
use App\Models\LogAktivitas; // 🔥 IMPORT MODEL LOG
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
        // 1. Validasi
        // Kita sesuaikan dengan 'name' yang ada di View Mas tadi
        $request->validate([
            'tanggal'    => 'required',             // Wajib ada (makanya view gak boleh disabled)
            'kategori'   => 'required|string',
            'jenis'      => 'required|in:pemasukan,pengeluaran',
            'jumlah'     => 'required|numeric|min:1', // Di View namanya 'jumlah', bukan 'nominal'
            'keterangan' => 'required|string',
        ]);

        // 2. Format Tanggal (Ubah dari 20-01-2026 jadi 2026-01-20 buat Database)
        try {
            $tanggalFix = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d');
        } catch (\Exception $e) {
            $tanggalFix = now()->format('Y-m-d');
        }

        // 3. Simpan Data (Pakai Model yang Benar: KeuanganDesa)
        // 🔥 Perhatikan nama kolom sebelah kiri, itu nama kolom di Database Mas 🔥
        KeuanganDesa::create([
            'tanggal'    => $tanggalFix,
            'kategori'   => $request->kategori,
            'jenis'      => $request->jenis,       // Database kolomnya 'jenis', bukan 'jenis_transaksi'
            'jumlah'     => $request->jumlah,      // Database kolomnya 'jumlah', bukan 'nominal'
            'keterangan' => $request->keterangan,
            'user_id'    => auth()->id(),          // Biar tahu siapa admin yang input
        ]);

        // 4. Catat Log (Opsional, pemanis)
        $rupiah = number_format($request->jumlah, 0, ',', '.');
        LogAktivitas::catat("Menambahkan Keuangan: $request->kategori (Rp $rupiah)");

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Data keuangan berhasil disimpan!');
    }

    /**
     * Menampilkan form untuk mengedit transaksi.
     */
    public function edit(KeuanganDesa $keuangan)
    {
        return view('admin.keuangan.edit', compact('keuangan'));
    }

    /**
     * Memperbarui transaksi di database.
     */
    public function update(Request $request, KeuanganDesa $keuangan)
    {
        $validatedData = $request->validate([
            'tanggal'    => 'required|date',
            'kategori'   => 'required|string|max:255',
            'keterangan' => 'required|string',
            'jenis'      => 'required|in:pemasukan,pengeluaran',
            'jumlah'     => 'required|numeric|min:0',
        ]);

        // Simpan data lama buat perbandingan (Opsional, tapi bagus)
        // $jumlahLama = number_format($keuangan->jumlah, 0, ',', '.');

        $keuangan->update($validatedData);

        $rupiahBaru = number_format($keuangan->jumlah, 0, ',', '.');
        $jenis      = ucfirst($keuangan->jenis);

        LogAktivitas::catat("Mengedit Data Keuangan ($jenis): Menjadi Rp $rupiahBaru - $keuangan->keterangan");

        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus transaksi dari database.
     */
    public function destroy(KeuanganDesa $keuangan)
    {
        // Simpan info penting sebelum dihapus agar bisa dicatat
        $infoLog = ucfirst($keuangan->jenis) . " sebesar Rp " . number_format($keuangan->jumlah, 0, ',', '.') . " ($keuangan->keterangan)";

        $keuangan->delete();
        LogAktivitas::catat("Menghapus Data Keuangan: $infoLog");

        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}