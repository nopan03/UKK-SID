<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk; // Model untuk tabel biodata/penduduk
use App\Models\User; // Model untuk tabel users
use App\Models\Surat; // Model untuk tabel surat
use App\Models\LogAktivitas; // Model untuk logging aktivitas
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // <- penting untuk DB::table()

class WargaController extends Controller
{
    /**
     * MENAMPILKAN DAFTAR WARGA
     */
    public function index()
    {
        // paginate(10) supaya kalau data banyak tetap ringan
        $warga = Penduduk::paginate(10);

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
            'nik'               => 'required|string|digits:16|unique:biodata,nik',
            'nama'              => 'required|string|max:255',
            'tempat_lahir'      => 'required|string|max:255',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|in:L,P',
            'alamat'            => 'required|string',
            'agama'             => 'required|string',
            'status_perkawinan' => 'required|string',
            'pekerjaan'         => 'required|string',
            'status_hidup'      => 'required|in:hidup,meninggal',
            'pendidikan'        => 'nullable|string',
        ]);

        $warga = Penduduk::create($validatedData);
        LogAktivitas::catat("Menambahkan data warga baru: {$warga->nama} (NIK: {$warga->nik})");

        return redirect()
            ->route('admin.warga.index')
            ->with('success', 'Data warga berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail data seorang warga.
     * Route model binding: parameter {penduduk} di-route resource.
     */
    public function show(Penduduk $penduduk)
    {
        return view('admin.warga.show', ['warga' => $penduduk]);
    }

    /**
     * Menampilkan form untuk mengedit data warga.
     */
    public function edit($id)
    {
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
            'nik'               => ['required', 'string', 'digits:16', Rule::unique('biodata')->ignore($penduduk->id)],
            'nama'              => 'required|string|max:255',
            'tempat_lahir'      => 'required|string|max:255',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|in:L,P',
            'alamat'            => 'required|string',
            'agama'             => 'required|string',
            'status_perkawinan' => 'required|string',
            'pekerjaan'         => 'required|string',
            'status_hidup'      => 'required|in:hidup,meninggal',
        ]);

        // Simpan data lama untuk perbandingan log (opsional, tapi bagus)
        // $oldName = $penduduk->nama;

        $penduduk->update($validatedData);
        LogAktivitas::catat("Memperbarui data warga: {$penduduk->nama} (NIK: {$penduduk->nik})");

        return redirect()
            ->route('admin.warga.index')
            ->with('success', 'Data warga berhasil diperbarui!');
    }

    /**
     * Menghapus data warga dari database.
     * - HAPUS semua detail surat di tabel-tabel turunan (berdasarkan surat_id).
     * - HAPUS semua surat milik user (apapun statusnya).
     * - HAPUS akun user.
     * - HAPUS data penduduk.
     * - Kirim pesan warning bahwa semua permohonan surat ikut terhapus.
     */
    public function destroy(Request $request, $id)
    {
        // 1. Cari data warga berdasarkan ID
        $penduduk = Penduduk::findOrFail($id);
        
        // Simpan info untuk log sebelum dihapus
        $namaWarga = $penduduk->nama;
        $nikWarga  = $penduduk->nik;

        $totalSuratDihapus = 0;

        // 2. Kalau warga punya NIK, cari akun user yang terkait
        if ($penduduk->nik) {
            $user = User::where('nik', $penduduk->nik)->first();

            if ($user) {
                // 3. Ambil semua ID surat milik user ini
                $suratIds = Surat::where('user_id', $user->id)->pluck('id');

                if ($suratIds->isNotEmpty()) {
                    $totalSuratDihapus = $suratIds->count();

                    // 4. HAPUS DULU semua detail di tabel-tabel turunan
                    //    (berdasarkan kolom surat_id)
                    DB::table('surat_keterangan_tidak_mampu')
                        ->whereIn('surat_id', $suratIds)->delete();

                    DB::table('surat_keterangan_usaha')
                        ->whereIn('surat_id', $suratIds)->delete();

                    DB::table('surat_keterangan_domisilis') // Perhatikan nama tabelnya pakai 's' atau tidak di DB Anda
                        ->whereIn('surat_id', $suratIds)->delete();

                    DB::table('surat_pengantar_skcks')
                        ->whereIn('surat_id', $suratIds)->delete();

                    DB::table('surat_keterangan_kelahiran')
                        ->whereIn('surat_id', $suratIds)->delete();

                    DB::table('surat_keterangan_kematian')
                        ->whereIn('surat_id', $suratIds)->delete();

                    DB::table('surat_keterangan_pindah')
                        ->whereIn('surat_id', $suratIds)->delete();

                    DB::table('surat_pengantar_nikah')
                        ->whereIn('surat_id', $suratIds)->delete();

                    // Perhatikan: dari error MySQL, nama tabelnya `surat_pengajuan_tanah` (tanpa "s")
                    DB::table('surat_pengajuan_tanah')
                        ->whereIn('surat_id', $suratIds)->delete();

                    // 5. Setelah SEMUA child terhapus, baru hapus surat parent-nya
                    Surat::whereIn('id', $suratIds)->delete();
                }

                // 6. Hapus akun user
                $user->delete();
            }
        }

        // 7. Terakhir, HAPUS data warga (penduduk)
        $penduduk->delete();
        LogAktivitas::catat("Menghapus data warga: {$namaWarga} (NIK: {$nikWarga}) beserta akun dan riwayat suratnya.");

        // 8. Redirect dengan pesan sukses + peringatan
        return redirect()
            ->route('admin.warga.index')
            ->with('success', 'Data warga berhasil dihapus.')
            ->with('warning', 'Akun login dan ' . $totalSuratDihapus . ' data permohonan surat (beserta detailnya) milik warga tersebut juga telah dihapus permanen.');
    }
}