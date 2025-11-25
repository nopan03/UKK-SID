<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratKeteranganDomisili;
use App\Models\SuratKeteranganTidakMampu;
// use App\Models\SuratKeteranganUsaha; // Pastikan model ini ada atau gunakan DB facade
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuratController extends Controller
{
    // 1. Menampilkan Halaman Formulir
    public function create($jenis)
    {
        return view('warga.surat.create', compact('jenis'));
    }

    // 2. Menyimpan Data (Otak Utamanya)
    public function store(Request $request)
    {
        // A. Validasi Umum
        $request->validate([
            'jenis_surat' => 'required',
            'keperluan' => 'required|string',
            // Validasi File (Maks 2MB, Gambar/PDF)
            'file_ktp' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_kk' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_pengantar' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_bukti_usaha' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        // B. Mulai Transaksi
        DB::beginTransaction();

        try {
            // 1. Simpan ke Tabel Induk (SURAT)
            $surat = Surat::create([
                'user_id' => Auth::id(),
                'jenis_surat' => $request->jenis_surat,
                'status' => 'menunggu',
                'keterangan' => $request->keperluan,
            ]);

            // Helper Function Sederhana untuk Upload
            $upload = function ($inputName, $folder) use ($request) {
                if ($request->hasFile($inputName)) {
                    $file = $request->file($inputName);
                    $filename = time() . '_' . $inputName . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/dokumen_warga/' . $folder, $filename);
                    return $filename;
                }
                return null;
            };

            // 2. Simpan ke Tabel Anak (Detail) sesuai Jenis
            switch ($request->jenis_surat) {
                
                case 'sktm':
                    SuratKeteranganTidakMampu::create([
                        'surat_id' => $surat->id,
                        'keperluan' => $request->keperluan,
                        'penghasilan' => $request->penghasilan,
                        'tanggungan' => $request->tanggungan,
                        // Simpan Nama File
                        'file_ktp' => $upload('file_ktp', 'sktm'),
                        'file_kk' => $upload('file_kk', 'sktm'),
                        'file_pengantar' => $upload('file_pengantar', 'sktm'),
                    ]);
                    break;

                case 'sku':
                    // Contoh pakai DB Facade jika Model belum dibuat
                    DB::table('surat_keterangan_usahas')->insert([
                        'surat_id' => $surat->id,
                        'nama_usaha' => $request->nama_usaha,
                        'jenis_usaha' => $request->jenis_usaha,
                        'alamat_usaha' => $request->alamat_usaha,
                        'keperluan' => $request->keperluan,
                        'file_ktp' => $upload('file_ktp', 'sku'),
                        'file_bukti_usaha' => $upload('file_bukti_usaha', 'sku'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'domisili':
                    SuratKeteranganDomisili::create([
                        'surat_id' => $surat->id,
                        'keperluan' => $request->keperluan,
                        'alamat_asal' => $request->alamat_asal,
                        'alamat_domisili' => $request->alamat_domisili,
                        'status_tempat_tinggal' => $request->status_tempat_tinggal,
                        'file_ktp' => $upload('file_ktp', 'domisili'),
                        'file_kk' => $upload('file_kk', 'domisili'),
                    ]);
                    break;

                case 'skck':
                    // Simpan ke tabel surat_pengantar_skcks (Pastikan tabel ada)
                    DB::table('surat_pengantar_skcks')->insert([
                        'surat_id' => $surat->id,
                        'keperluan' => $request->keperluan,
                        'file_ktp' => $upload('file_ktp', 'skck'),
                        'file_kk' => $upload('file_kk', 'skck'),
                        'file_akta' => $upload('file_akta', 'skck'),
                        'file_pengantar' => $upload('file_pengantar', 'skck'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'kelahiran':
                    // Simpan ke tabel surat_keterangan_kelahirans
                    DB::table('surat_keterangan_kelahirans')->insert([
                        'surat_id' => $surat->id,
                        'nama_bayi' => $request->nama_bayi,
                        'tgl_lahir_bayi' => $request->tgl_lahir_bayi,
                        'nama_ayah' => $request->nama_ayah,
                        'nama_ibu' => $request->nama_ibu,
                        'file_ket_lahir' => $upload('file_ket_lahir', 'kelahiran'),
                        'file_kk' => $upload('file_kk', 'kelahiran'),
                        'file_buku_nikah' => $upload('file_buku_nikah', 'kelahiran'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'kematian':
                    // Simpan ke tabel surat_keterangan_kematians
                    DB::table('surat_keterangan_kematians')->insert([
                        'surat_id' => $surat->id,
                        'nama_almarhum' => $request->nama_almarhum,
                        'tgl_meninggal' => $request->tgl_meninggal,
                        'file_ket_kematian' => $upload('file_ket_kematian', 'kematian'),
                        'file_ktp_almarhum' => $upload('file_ktp_almarhum', 'kematian'),
                        'file_kk_almarhum' => $upload('file_kk_almarhum', 'kematian'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                default:
                    // Untuk surat lain yang belum ada tabel khususnya
                    break; 
            }

            // Jika sukses
            DB::commit();
            return redirect()->route('warga.dashboard')->with('success', 'Pengajuan surat dan dokumen berhasil dikirim!');

        } catch (\Exception $e) {
            // Jika gagal
            DB::rollback();
            return back()->with('error', 'Gagal mengirim surat: ' . $e->getMessage());
        }
    }

    // ... fungsi show() ...
}