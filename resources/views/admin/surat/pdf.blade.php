<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $surat->jenis_surat }} - {{ $surat->id }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 25px 45px;
        }

        table {
            border-collapse: collapse;
        }

        /* ==== KOP SURAT ==== */
        .kop-table { width: 100%; }
        .kop-logo { width: 80px; }
        .kop-logo img { width: 75px; height: auto; }

        .kop-text { text-align: center; line-height: 1.2; }
        .kop-text h1, .kop-text h2, .kop-text h3, .kop-text p { margin: 0; }

        .kop-text .pemerintah { font-size: 12pt; font-weight: bold; }
        .kop-text .kecamatan  { font-size: 13pt; font-weight: bold; }
        .kop-text .desa       { font-size: 16pt; font-weight: bold; }
        .kop-text .alamat     { font-size: 10pt; margin-top: 4px; }

        .garis-kop-1 {
            border-top: 2px solid #000;
            margin-top: 4px;
        }
        .garis-kop-2 {
            border-top: 1px solid #000;
            margin-top: 1px;
            margin-bottom: 18px;
        }

        /* ==== JUDUL & NOMOR ==== */
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .subjudul {
            text-align: center;
            margin-bottom: 18px;
        }

        /* ==== ISI SURAT ==== */
        .konten { text-align: justify; }

        .tabel-data {
            margin-left: 40px;
            margin-bottom: 18px;
        }
        .tabel-data td {
            padding: 1px 0;
            vertical-align: top;
        }
        .tabel-data td.label { width: 180px; }

        .ttd-kanan {
            width: 40%;
            float: right;
            text-align: center;
            margin-top: 40px;
        }
        .clear { clear: both; }
    </style>
</head>
<body>

@php
    $user    = $surat->user;
    $biodata = $user->biodata ?? null;

    // 1) nomor dari controller (paling utama)
    $nomorSurat = $noSurat ?? null;

    // 2) kalau controller belum kirim, cari di tabel detail (nomor_surat / nomor_sk_tm)
    if (!$nomorSurat && isset($detail)) {
        $fields = ['nomor_surat', 'nomor_sk_tm'];
        foreach ($fields as $field) {
            if (isset($detail->$field) && $detail->$field !== null && $detail->$field !== '') {
                $nomorSurat = $detail->$field;
                break;
            }
        }
    }
@endphp

{{-- ===================== KOP SURAT DENGAN LOGO ===================== --}}
<table class="kop-table">
    <tr>
        <td class="kop-logo" align="center">
            <img src="{{ public_path('img/SDA1.png') }}" alt="Logo Desa">
        </td>
        <td class="kop-text">
            <div class="pemerintah">PEMERINTAH DESA SURUH</div>
            <div class="kecamatan">KECAMATAN SUKODONO</div>
            <div class="alamat">Jl. Raya Suruh No. 1, Kode Pos 61258</div>
        </td>
        <td class="kop-logo"></td> {{-- kosong untuk keseimbangan --}}
    </tr>
</table>
<div class="garis-kop-1"></div>
<div class="garis-kop-2"></div>

<div class="judul">{{ strtoupper($surat->jenis_surat) }}</div>
<div class="subjudul">
    Nomor : {{ $nomorSurat ?? '-' }}
</div>

<div class="konten">

    {{-- ========================================================= --}}
    {{-- 1. SURAT KETERANGAN DOMISILI                             --}}
    {{-- ========================================================= --}}
    @if($surat->jenis_surat === 'Surat Keterangan Domisili')

        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono,
            Kabupaten Sidoarjo, dengan ini menerangkan bahwa:
        </p>

        <table class="tabel-data">
            <tr>
                <td class="label">Nama Lengkap</td><td>:</td>
                <td>{{ $biodata->nama_lengkap ?? $user->name }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td><td>:</td>
                <td>{{ $biodata->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tempat, Tgl Lahir</td><td>:</td>
                <td>
                    {{ $biodata->tempat_lahir ?? '-' }},
                    {{ $biodata->tanggal_lahir ?? '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td><td>:</td>
                <td>{{ $biodata->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Agama</td><td>:</td>
                <td>{{ $biodata->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td><td>:</td>
                <td>{{ $biodata->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Perkawinan</td><td>:</td>
                <td>{{ $biodata->status_perkawinan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Warga Negara</td><td>:</td>
                <td>{{ $biodata->kewarganegaraan ?? 'Indonesia' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Domisili</td><td>:</td>
                <td>{{ $biodata->alamat ?? '-' }}</td>
            </tr>
        </table>

        <p>
            Benar nama tersebut di atas adalah warga kami yang berdomisili di
            {{ $biodata->alamat ?? 'Desa Suruh, Kecamatan Sukodono, Kabupaten Sidoarjo' }}
            sejak tahun {{ $detail->tahun_mulai_domisili ?? '-' }} hingga saat ini.
        </p>

        <p>
            Surat keterangan ini dibuat untuk keperluan
            {{ $detail->keperluan ?? $surat->keterangan ?? '-' }}.
            Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dipergunakan
            sebagaimana mestinya.
        </p>

    {{-- ========================================================= --}}
    {{-- 2. SURAT KETERANGAN TIDAK MAMPU                          --}}
    {{-- ========================================================= --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Tidak Mampu')

        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono,
            Kabupaten Sidoarjo, dengan ini menerangkan bahwa:
        </p>

        <table class="tabel-data">
            <tr><td class="label">Nama Lengkap</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr>
                <td class="label">Tempat, Tgl Lahir</td><td>:</td>
                <td>{{ $biodata->tempat_lahir ?? '-' }}, {{ $biodata->tanggal_lahir ?? '-' }}</td>
            </tr>
            <tr><td class="label">Jenis Kelamin</td><td>:</td><td>{{ $biodata->jenis_kelamin ?? '-' }}</td></tr>
            <tr><td class="label">Agama</td><td>:</td><td>{{ $biodata->agama ?? '-' }}</td></tr>
            <tr><td class="label">Pekerjaan</td><td>:</td><td>{{ $biodata->pekerjaan ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>

        <p>
            Benar yang bersangkutan merupakan warga Desa Suruh dan berdasarkan data
            yang ada pada Pemerintah Desa serta keterangan RT/RW setempat,
            termasuk dalam kategori <strong>keluarga tidak mampu / prasejahtera</strong>.
        </p>

        <p>
            Surat keterangan ini dibuat untuk keperluan:
            <strong>{{ $detail->keperluan ?? $surat->keterangan ?? '-' }}</strong>.
        </p>

        <p>
            Demikian surat keterangan ini dibuat dengan sebenar-benarnya,
            agar dapat dipergunakan sebagaimana mestinya.
        </p>

    {{-- ========================================================= --}}
    {{-- 3. SURAT KETERANGAN USAHA                                --}}
    {{-- ========================================================= --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Usaha')

        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono,
            Kabupaten Sidoarjo, menerangkan dengan sebenar-benarnya bahwa:
        </p>

        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr>
                <td class="label">Tempat, Tgl Lahir</td><td>:</td>
                <td>{{ $biodata->tempat_lahir ?? '-' }}, {{ $biodata->tanggal_lahir ?? '-' }}</td>
            </tr>
            <tr><td class="label">Jenis Kelamin</td><td>:</td><td>{{ $biodata->jenis_kelamin ?? '-' }}</td></tr>
            <tr><td class="label">Agama</td><td>:</td><td>{{ $biodata->agama ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>

        <p>
            Benar yang bersangkutan mempunyai usaha dengan keterangan sebagai berikut:
        </p>

        <table class="tabel-data">
            <tr><td class="label">Nama Usaha</td><td>:</td><td>{{ $detail->nama_usaha ?? '-' }}</td></tr>
            <tr><td class="label">Jenis Usaha</td><td>:</td><td>{{ $detail->jenis_usaha ?? '-' }}</td></tr>
            <tr><td class="label">Alamat Usaha</td><td>:</td><td>{{ $detail->alamat_usaha ?? '-' }}</td></tr>
            <tr><td class="label">Lama Usaha</td><td>:</td><td>{{ $detail->lama_usaha ?? '-' }}</td></tr>
        </table>

        <p>
            Surat keterangan usaha ini dibuat untuk keperluan
            {{ $detail->keperluan ?? $surat->keterangan ?? '-' }}.
            Demikian surat ini dibuat agar dipergunakan sebagaimana mestinya.
        </p>

    {{-- ========================================================= --}}
    {{-- 4. SURAT KETERANGAN PINDAH                               --}}
    {{-- ========================================================= --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Pindah')

        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono,
            Kabupaten Sidoarjo, menerangkan bahwa:
        </p>

        <table class="tabel-data">
            <tr><td class="label">Nama Kepala Keluarga</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Alamat Asal</td><td>:</td><td>{{ $detail->alamat_asal ?? $biodata->alamat ?? '-' }}</td></tr>
            <tr><td class="label">Alamat Tujuan</td><td>:</td><td>{{ $detail->alamat_tujuan ?? '-' }}</td></tr>
            <tr><td class="label">Alasan Pindah</td><td>:</td><td>{{ $detail->alasan_pindah ?? $surat->keterangan ?? '-' }}</td></tr>
            <tr><td class="label">Jumlah Anggota Keluarga</td><td>:</td><td>{{ $detail->jumlah_anggota ?? '-' }} orang</td></tr>
        </table>

        <p>
            Surat keterangan ini dibuat sebagai pengantar proses kepindahan penduduk
            dari Desa Suruh ke alamat tujuan tersebut di atas.
            Demikian surat keterangan pindah ini dibuat dengan sebenar-benarnya
            untuk dipergunakan sebagaimana mestinya.
        </p>

    {{-- ========================================================= --}}
    {{-- 5. SURAT KETERANGAN KELAHIRAN                            --}}
    {{-- ========================================================= --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Kelahiran')

        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono,
            Kabupaten Sidoarjo, menerangkan dengan sebenar-benarnya bahwa:
        </p>

        <p>Telah lahir seorang anak dengan data sebagai berikut:</p>

        <table class="tabel-data">
            <tr><td class="label">Nama Bayi</td><td>:</td><td>{{ $detail->nama_bayi ?? '-' }}</td></tr>
            <tr><td class="label">Jenis Kelamin</td><td>:</td><td>{{ $detail->jenis_kelamin_bayi ?? '-' }}</td></tr>
            <tr><td class="label">Tempat Lahir</td><td>:</td><td>{{ $detail->tempat_lahir_bayi ?? '-' }}</td></tr>
            <tr><td class="label">Tanggal Lahir</td><td>:</td><td>{{ $detail->tanggal_lahir_bayi ?? '-' }}</td></tr>
            <tr><td class="label">Jam Lahir</td><td>:</td><td>{{ $detail->jam_lahir_bayi ?? '-' }}</td></tr>
        </table>

        <p>Dengan identitas orang tua sebagai berikut:</p>

        <table class="tabel-data">
            <tr><td class="label">Nama Ayah</td><td>:</td><td>{{ $detail->nama_ayah ?? '-' }}</td></tr>
            <tr><td class="label">Nama Ibu</td><td>:</td><td>{{ $detail->nama_ibu ?? '-' }}</td></tr>
            <tr><td class="label">Alamat Orang Tua</td><td>:</td><td>{{ $detail->alamat_orangtua ?? $biodata->alamat ?? '-' }}</td></tr>
        </table>

        <p>
            Surat keterangan ini dibuat untuk keperluan pengurusan Akta Kelahiran
            dan administrasi lainnya yang berkaitan.
        </p>

    {{-- ========================================================= --}}
    {{-- 6. SURAT KETERANGAN KEMATIAN                             --}}
    {{-- ========================================================= --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Kematian')

        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono,
            Kabupaten Sidoarjo, menerangkan bahwa:
        </p>

        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $biodata->nama_lengkap ?? '-' }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>

        <p>Telah meninggal dunia dengan keterangan sebagai berikut:</p>

        <table class="tabel-data">
            <tr><td class="label">Hari / Tanggal</td><td>:</td><td>{{ $detail->hari_wafat ?? '-' }}, {{ $detail->tanggal_wafat ?? '-' }}</td></tr>
            <tr><td class="label">Jam</td><td>:</td><td>{{ $detail->jam_wafat ?? '-' }} WIB</td></tr>
            <tr><td class="label">Tempat Meninggal</td><td>:</td><td>{{ $detail->tempat_wafat ?? '-' }}</td></tr>
            <tr><td class="label">Penyebab Kematian</td><td>:</td><td>{{ $detail->penyebab_wafat ?? '-' }}</td></tr>
        </table>

        <p>
            Surat keterangan ini dibuat untuk keperluan pengurusan Akta Kematian
            dan administrasi lain yang diperlukan.
        </p>

    {{-- ========================================================= --}}
    {{-- 7. SURAT PENGAJUAN TANAH                                 --}}
    {{-- ========================================================= --}}
    @elseif($surat->jenis_surat === 'Surat Pengajuan Tanah')

        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono,
            Kabupaten Sidoarjo, menerangkan bahwa:
        </p>

        <table class="tabel-data">
            <tr><td class="label">Nama Pemohon</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>

        <p>Benar yang bersangkutan mengajukan permohonan tanah dengan data:</p>

        <table class="tabel-data">
            <tr><td class="label">Letak / Lokasi Tanah</td><td>:</td><td>{{ $detail->lokasi_tanah ?? '-' }}</td></tr>
            <tr><td class="label">Luas Tanah</td><td>:</td><td>{{ $detail->luas_tanah ?? '-' }} m²</td></tr>
            <tr><td class="label">Status Tanah</td><td>:</td><td>{{ $detail->status_tanah ?? '-' }}</td></tr>
            <tr><td class="label">Peruntukan</td><td>:</td><td>{{ $detail->peruntukan_tanah ?? $surat->keterangan ?? '-' }}</td></tr>
        </table>

        <p>
            Surat ini dibuat sebagai pengantar pengurusan administrasi pertanahan
            pada instansi terkait. Demikian surat pengajuan tanah ini dibuat
            untuk dipergunakan sebagaimana mestinya.
        </p>

    {{-- ========================================================= --}}
    {{-- 8. SURAT PENGANTAR NIKAH                                 --}}
    {{-- ========================================================= --}}
    @elseif($surat->jenis_surat === 'Surat Pengantar Nikah')

        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono,
            Kabupaten Sidoarjo, menerangkan bahwa:
        </p>

        <p><strong>Calon Suami</strong></p>
        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $detail->nama_pria ?? '-' }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $detail->nik_pria ?? '-' }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>:</td>
                <td>{{ $detail->tempat_lahir_pria ?? '-' }}, {{ $detail->tanggal_lahir_pria ?? '-' }}</td>
            </tr>
            <tr><td class="label">Agama</td><td>:</td><td>{{ $detail->agama_pria ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $detail->alamat_pria ?? '-' }}</td></tr>
            <tr><td class="label">Status Perkawinan</td><td>:</td><td>{{ $detail->status_perkawinan_pria ?? '-' }}</td></tr>
        </table>

        <p><strong>Calon Istri</strong></p>
        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $detail->nama_wanita ?? '-' }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $detail->nik_wanita ?? '-' }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>:</td>
                <td>{{ $detail->tempat_lahir_wanita ?? '-' }}, {{ $detail->tanggal_lahir_wanita ?? '-' }}</td>
            </tr>
            <tr><td class="label">Agama</td><td>:</td><td>{{ $detail->agama_wanita ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $detail->alamat_wanita ?? '-' }}</td></tr>
            <tr><td class="label">Status Perkawinan</td><td>:</td><td>{{ $detail->status_perkawinan_wanita ?? '-' }}</td></tr>
        </table>

        <p>
            Bermaksud akan melangsungkan pernikahan pada:
        </p>

        <table class="tabel-data">
            <tr><td class="label">Hari / Tanggal</td><td>:</td><td>{{ $detail->hari_nikah ?? '-' }}, {{ $detail->tanggal_nikah ?? '-' }}</td></tr>
            <tr><td class="label">Tempat Nikah</td><td>:</td><td>{{ $detail->lokasi_nikah ?? '-' }}</td></tr>
        </table>

        <p>
            Surat pengantar ini dibuat untuk keperluan pengurusan administrasi
            pernikahan di Kantor Urusan Agama Kecamatan Sukodono.
        </p>

    {{-- ========================================================= --}}
    {{-- 9. SURAT PENGANTAR SKCK                                  --}}
    {{-- ========================================================= --}}
    @elseif($surat->jenis_surat === 'Surat Pengantar SKCK')

        <p>
            Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono,
            Kabupaten Sidoarjo, menerangkan bahwa:
        </p>

        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr>
                <td class="label">Tempat, Tgl Lahir</td><td>:</td>
                <td>{{ $biodata->tempat_lahir ?? '-' }}, {{ $biodata->tanggal_lahir ?? '-' }}</td>
            </tr>
            <tr><td class="label">Jenis Kelamin</td><td>:</td><td>{{ $biodata->jenis_kelamin ?? '-' }}</td></tr>
            <tr><td class="label">Agama</td><td>:</td><td>{{ $biodata->agama ?? '-' }}</td></tr>
            <tr><td class="label">Pekerjaan</td><td>:</td><td>{{ $biodata->pekerjaan ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>

        <p>
            Berdasarkan catatan administrasi desa, yang bersangkutan adalah warga
            Desa Suruh dan <strong>berkelakuan baik serta tidak pernah tersangkut
            perkara pidana</strong>.
        </p>

        <p>
            Surat pengantar ini dibuat untuk keperluan pengajuan
            <strong>Surat Keterangan Catatan Kepolisian (SKCK)</strong>
            di Polsek/Polres setempat.
        </p>

        <p>Demikian surat pengantar ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>

    {{-- ========================================================= --}}
    {{-- FALLBACK                                                 --}}
    {{-- ========================================================= --}}
    @else

        <p>
            Yang bertanda tangan di bawah ini menerangkan bahwa:
        </p>

        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>

        <p>
            Surat ini dibuat untuk keperluan: {{ $surat->keterangan ?? '-' }}.
        </p>

    @endif

</div>

<div class="ttd-kanan">
    Suruh, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
    Kepala Desa Suruh
    <br><br>

    {{-- QR CODE TANDA TANGAN --}}
    @if(!empty($qrBase64))
        <img src="data:image/svg+xml;base64,{{ $qrBase64 }}"
             style="width:90px; height:90px; margin-bottom:5px;">
        <br>
    @endif

    <strong>Suwono</strong>
</div>

<div class="clear"></div>

</body>
</html>
