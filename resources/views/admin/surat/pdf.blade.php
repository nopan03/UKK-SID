<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $surat->jenis_surat }} - {{ $surat->id }}</title>
    <style>
        /* Mengatur Margin Halaman PDF lewat CSS @page */
        @page { margin: 2cm 2.5cm; }

        * { box-sizing: border-box; }
        
        /* 🔥 PENGHEMATAN 1: Font 11pt dan Line-Height 1.15 (Biar muat 1 lembar) */
        body { 
            font-family: "Times New Roman", Times, serif; 
            font-size: 11pt; 
            line-height: 1.15; 
            margin: 0; 
        }

        table { border-collapse: collapse; width: 100%; }
        
        /* ==== KOP SURAT ==== */
        .kop-table { width: 100%; margin-bottom: -5px; } /* Sedikit ditarik ke atas */
        .kop-logo { width: 75px; }
        .kop-logo img { width: 70px; height: auto; }
        .kop-text { text-align: center; line-height: 1.1; }
        .kop-text .pemerintah { font-size: 11pt; font-weight: bold; }
        .kop-text .kecamatan  { font-size: 12pt; font-weight: bold; }
        .kop-text .desa       { font-size: 14pt; font-weight: bold; }
        .kop-text .alamat     { font-size: 9pt; margin-top: 2px; font-style: italic; }
        
        .garis-kop-1 { border-top: 2px solid #000; margin-top: 4px; }
        
        /* 🔥 PENGHEMATAN 2: Jarak bawah garis kop dikurangi */
        .garis-kop-2 { border-top: 1px solid #000; margin-top: 1px; margin-bottom: 10px; }

        /* ==== JUDUL & NOMOR ==== */
        .judul { text-align: center; font-weight: bold; font-size: 12pt; text-decoration: underline; text-transform: uppercase; margin-bottom: 2px; }
        
        /* 🔥 PENGHEMATAN 3: Jarak subjudul dikurangi */
        .subjudul { text-align: center; margin-bottom: 10px; font-size: 11pt; }

        /* ==== ISI SURAT ==== */
        .konten { text-align: justify; }
        
        /* 🔥 PENGHEMATAN 4: Padding tabel dinolkan */
        .tabel-data { margin-left: 10px; margin-bottom: 5px; width: 100%; }
        .tabel-data td { padding: 0; vertical-align: top; } 
        .tabel-data td.label { width: 160px; }
        
        /* 🔥 PENGHEMATAN 5: Jarak TTD dikurangi */
        .ttd-kanan { width: 45%; float: right; text-align: center; margin-top: 15px; }
        .clear { clear: both; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>

@php
    $user    = $surat->user;
    $biodata = $user->biodata ?? null;

    // Logika Nomor Surat
    $nomorSurat = $noSurat ?? null;
    if (!$nomorSurat && isset($detail)) {
        $det = is_array($detail) ? (object)$detail : $detail;
        $fields = ['nomor_surat', 'nomor_sk_tm'];
        foreach ($fields as $field) {
            if (isset($det->$field) && $det->$field !== null && $det->$field !== '') {
                $nomorSurat = $det->$field;
                break;
            }
        }
    }
@endphp

{{-- ===================== KOP SURAT ===================== --}}
<table class="kop-table">
    <tr>
        <td class="kop-logo" align="center">
            <img src="{{ public_path('img/SDA1.png') }}" alt="Logo Desa">
        </td>
        <td class="kop-text">
            <div class="pemerintah">PEMERINTAH KABUPATEN SIDOARJO</div>
            <div class="kecamatan">KECAMATAN SUKODONO</div>
            <div class="desa">DESA SURUH</div>
            <div class="alamat">Jl. Raya Suruh No. 1, Kode Pos 61258</div>
        </td>
        <td class="kop-logo"></td>
    </tr>
</table>
<div class="garis-kop-1"></div>
<div class="garis-kop-2"></div>

<div class="judul">{{ strtoupper($surat->jenis_surat) }}</div>
<div class="subjudul">Nomor : {{ $nomorSurat ?? '-' }}</div>

<div class="konten">

    {{-- 1. SURAT KETERANGAN DOMISILI --}}
    @if($surat->jenis_surat === 'Surat Keterangan Domisili')
        <p>Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono, Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama Lengkap</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>:</td><td>{{ $biodata->tempat_lahir ?? '-' }}, {{ $biodata->tanggal_lahir ?? '-' }}</td></tr>
            <tr><td class="label">Jenis Kelamin</td><td>:</td><td>{{ $biodata->jenis_kelamin ?? '-' }}</td></tr>
            <tr><td class="label">Agama</td><td>:</td><td>{{ $biodata->agama ?? '-' }}</td></tr>
            <tr><td class="label">Pekerjaan</td><td>:</td><td>{{ $biodata->pekerjaan ?? '-' }}</td></tr>
            <tr><td class="label">Status Perkawinan</td><td>:</td><td>{{ $biodata->status_perkawinan ?? '-' }}</td></tr>
            <tr><td class="label">Alamat Domisili</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>
        <p>Benar nama tersebut di atas adalah warga kami yang berdomisili di {{ $biodata->alamat }} sejak tahun {{ $detail->tahun_mulai_domisili ?? '-' }} hingga saat ini.</p>
        <p>Surat keterangan ini dibuat untuk keperluan {{ $detail->keperluan ?? $surat->keterangan ?? '-' }}.</p>


    {{-- 2. SURAT KETERANGAN TIDAK MAMPU --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Tidak Mampu')
        <p>Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono, Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama Lengkap</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>:</td><td>{{ $biodata->tempat_lahir ?? '-' }}, {{ $biodata->tanggal_lahir ?? '-' }}</td></tr>
            <tr><td class="label">Jenis Kelamin</td><td>:</td><td>{{ $biodata->jenis_kelamin ?? '-' }}</td></tr>
            <tr><td class="label">Agama</td><td>:</td><td>{{ $biodata->agama ?? '-' }}</td></tr>
            <tr><td class="label">Pekerjaan</td><td>:</td><td>{{ $biodata->pekerjaan ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>
        <p>Benar yang bersangkutan merupakan warga Desa Suruh dan berdasarkan data yang ada, termasuk dalam kategori <strong>keluarga tidak mampu / prasejahtera</strong>.</p>
        <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $detail->keperluan ?? $surat->keterangan ?? '-' }}</strong>.</p>


    {{-- 3. SURAT KETERANGAN USAHA --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Usaha')
        <p>Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono, Kabupaten Sidoarjo, menerangkan dengan sebenar-benarnya bahwa:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>:</td><td>{{ $biodata->tempat_lahir ?? '-' }}, {{ $biodata->tanggal_lahir ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>
        <p>Benar yang bersangkutan mempunyai usaha dengan keterangan sebagai berikut:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama Usaha</td><td>:</td><td>{{ $detail->nama_usaha ?? '-' }}</td></tr>
            <tr><td class="label">Jenis Usaha</td><td>:</td><td>{{ $detail->jenis_usaha ?? '-' }}</td></tr>
            <tr><td class="label">Alamat Usaha</td><td>:</td><td>{{ $detail->alamat_usaha ?? '-' }}</td></tr>
            <tr><td class="label">Lama Usaha</td><td>:</td><td>{{ $detail->lama_usaha ?? '-' }}</td></tr>
        </table>
        <p>Surat keterangan usaha ini dibuat untuk keperluan {{ $detail->keperluan ?? $surat->keterangan ?? '-' }}.</p>


    {{-- 4. SURAT KETERANGAN PINDAH --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Pindah')
        <p>Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono, Kabupaten Sidoarjo, menerangkan bahwa:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama Kepala Keluarga</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Alamat Asal</td><td>:</td><td>{{ $detail->alamat_asal ?? $biodata->alamat ?? '-' }}</td></tr>
            <tr><td class="label">Alamat Tujuan</td><td>:</td><td>{{ $detail->alamat_tujuan ?? '-' }}</td></tr>
            <tr><td class="label">Alasan Pindah</td><td>:</td><td>{{ $detail->alasan_pindah ?? $surat->keterangan ?? '-' }}</td></tr>
            <tr><td class="label">Jumlah Pengikut</td><td>:</td><td>{{ $detail->jumlah_anggota ?? '-' }} orang</td></tr>
        </table>
        <p>Demikian surat keterangan pindah ini dibuat dengan sebenar-benarnya untuk dipergunakan sebagaimana mestinya.</p>


    {{-- 5. SURAT KETERANGAN KELAHIRAN --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Kelahiran')
        <p>Yang bertanda tangan di bawah ini Kepala Desa Suruh, menerangkan bahwa telah lahir seorang anak:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama Bayi</td><td>:</td><td>{{ $detail->nama_bayi ?? '-' }}</td></tr>
            <tr><td class="label">Jenis Kelamin</td><td>:</td><td>{{ $detail->jenis_kelamin_bayi ?? '-' }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>:</td><td>{{ $detail->tempat_lahir_bayi ?? '-' }}, {{ $detail->tanggal_lahir_bayi ?? '-' }}</td></tr>
            <tr><td class="label">Jam Lahir</td><td>:</td><td>{{ $detail->jam_lahir_bayi ?? '-' }}</td></tr>
        </table>
        <p>Anak dari pasangan suami istri:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama Ayah</td><td>:</td><td>{{ $detail->nama_ayah ?? '-' }}</td></tr>
            <tr><td class="label">Nama Ibu</td><td>:</td><td>{{ $detail->nama_ibu ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $detail->alamat_orangtua ?? $biodata->alamat ?? '-' }}</td></tr>
        </table>
        <p>Surat keterangan ini dibuat untuk keperluan pengurusan Akta Kelahiran.</p>


    {{-- 6. SURAT KETERANGAN KEMATIAN --}}
    @elseif($surat->jenis_surat === 'Surat Keterangan Kematian')
        <p>Yang bertanda tangan di bawah ini Kepala Desa Suruh, menerangkan bahwa:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $biodata->nama_lengkap ?? '-' }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>
        <p>Telah meninggal dunia pada:</p>
        <table class="tabel-data">
            <tr><td class="label">Hari / Tanggal</td><td>:</td><td>{{ $detail->hari_wafat ?? '-' }}, {{ $detail->tanggal_wafat ?? '-' }}</td></tr>
            <tr><td class="label">Tempat</td><td>:</td><td>{{ $detail->tempat_wafat ?? '-' }}</td></tr>
            <tr><td class="label">Penyebab</td><td>:</td><td>{{ $detail->penyebab_wafat ?? '-' }}</td></tr>
        </table>
        <p>Surat keterangan ini dibuat untuk keperluan pengurusan Akta Kematian.</p>


    {{-- 7. SURAT PENGAJUAN TANAH --}}
    @elseif($surat->jenis_surat === 'Surat Pengajuan Tanah')
        <p>Yang bertanda tangan di bawah ini Kepala Desa Suruh, menerangkan bahwa:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama Pemohon</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>
        <p>Mengajukan permohonan tanah dengan rincian:</p>
        <table class="tabel-data">
            <tr><td class="label">Lokasi Tanah</td><td>:</td><td>{{ $detail->lokasi_tanah ?? '-' }}</td></tr>
            <tr><td class="label">Luas Tanah</td><td>:</td><td>{{ $detail->luas_tanah ?? '-' }} m²</td></tr>
            <tr><td class="label">Status Tanah</td><td>:</td><td>{{ $detail->status_tanah ?? '-' }}</td></tr>
            <tr><td class="label">Peruntukan</td><td>:</td><td>{{ $detail->peruntukan_tanah ?? $surat->keterangan ?? '-' }}</td></tr>
        </table>
        <p>Demikian surat pengajuan tanah ini dibuat untuk dipergunakan sebagaimana mestinya.</p>


    {{-- ========================================================= --}}
    {{-- 8. SURAT PENGANTAR NIKAH (SUDAH DIPERBAIKI TOTAL)         --}}
    {{-- ========================================================= --}}
    @elseif($surat->jenis_surat === 'Surat Pengantar Nikah')

        @php
            $detailObj = is_array($detail) ? (object) $detail : $detail;
            $suami = [];
            $istri = [];

            if ($biodata->jenis_kelamin == 'Laki-laki' || $biodata->jenis_kelamin == 'L') {
                $suami['nama']      = $biodata->nama_lengkap;
                $suami['nik']       = $biodata->nik;
                $suami['ttl']       = $biodata->tempat_lahir . ', ' . \Carbon\Carbon::parse($biodata->tanggal_lahir)->translatedFormat('d F Y');
                $suami['agama']     = $biodata->agama;
                $suami['status']    = $biodata->status_perkawinan;
                $suami['pekerjaan'] = $biodata->pekerjaan;
                $suami['alamat']    = $biodata->alamat;

                $istri['nama']      = $detailObj->nama_pasangan ?? '-';
                $istri['nik']       = $detailObj->nik_wanita ?? '-'; 
                $istri['ttl']       = ($detailObj->tempat_lahir_pasangan ?? '-') . ', ' . \Carbon\Carbon::parse($detailObj->tanggal_lahir_pasangan ?? now())->translatedFormat('d F Y');
                $istri['agama']     = $detailObj->agama_pasangan ?? '-';
                $istri['status']    = $detailObj->status_perkawinan_pasangan ?? '-';
                $istri['pekerjaan'] = $detailObj->pekerjaan_pasangan ?? '-';
                $istri['alamat']    = $detailObj->alamat_pasangan ?? '-';

            } else {
                $istri['nama']      = $biodata->nama_lengkap;
                $istri['nik']       = $biodata->nik;
                $istri['ttl']       = $biodata->tempat_lahir . ', ' . \Carbon\Carbon::parse($biodata->tanggal_lahir)->translatedFormat('d F Y');
                $istri['agama']     = $biodata->agama;
                $istri['status']    = $biodata->status_perkawinan;
                $istri['pekerjaan'] = $biodata->pekerjaan;
                $istri['alamat']    = $biodata->alamat;

                $suami['nama']      = $detailObj->nama_pasangan ?? '-';
                $suami['nik']       = $detailObj->nik_pria ?? '-'; 
                $suami['ttl']       = ($detailObj->tempat_lahir_pasangan ?? '-') . ', ' . \Carbon\Carbon::parse($detailObj->tanggal_lahir_pasangan ?? now())->translatedFormat('d F Y');
                $suami['agama']     = $detailObj->agama_pasangan ?? '-';
                $suami['status']    = $detailObj->status_perkawinan_pasangan ?? '-';
                $suami['pekerjaan'] = $detailObj->pekerjaan_pasangan ?? '-';
                $suami['alamat']    = $detailObj->alamat_pasangan ?? '-';
            }
        @endphp

        <p>Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono, Kabupaten Sidoarjo, menerangkan bahwa:</p>

        {{-- CALON SUAMI --}}
        <div class="bold" style="margin-bottom: 2px;">I. CALON SUAMI:</div>
        <table class="tabel-data">
            <tr><td class="label">Nama Lengkap</td><td>:</td><td>{{ $suami['nama'] }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $suami['nik'] }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>:</td><td>{{ $suami['ttl'] }}</td></tr>
            <tr><td class="label">Agama</td><td>:</td><td>{{ $suami['agama'] }}</td></tr>
            <tr><td class="label">Pekerjaan</td><td>:</td><td>{{ $suami['pekerjaan'] }}</td></tr>
            <tr><td class="label">Status Perkawinan</td><td>:</td><td>{{ $suami['status'] }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $suami['alamat'] }}</td></tr>
        </table>

        {{-- CALON ISTRI --}}
        <div class="bold" style="margin-top: 5px; margin-bottom: 2px;">II. CALON ISTRI:</div>
        <table class="tabel-data">
            <tr><td class="label">Nama Lengkap</td><td>:</td><td>{{ $istri['nama'] }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $istri['nik'] }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>:</td><td>{{ $istri['ttl'] }}</td></tr>
            <tr><td class="label">Agama</td><td>:</td><td>{{ $istri['agama'] }}</td></tr>
            <tr><td class="label">Pekerjaan</td><td>:</td><td>{{ $istri['pekerjaan'] }}</td></tr>
            <tr><td class="label">Status Perkawinan</td><td>:</td><td>{{ $istri['status'] }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $istri['alamat'] }}</td></tr>
        </table>
        
        <p style="margin-top: 5px; margin-bottom: 2px;"><strong>Rencana Pernikahan:</strong></p>
        <table class="tabel-data">
            <tr><td class="label">Tanggal</td><td>:</td><td>{{ isset($detailObj->tanggal_nikah) ? \Carbon\Carbon::parse($detailObj->tanggal_nikah)->translatedFormat('d F Y') : '-' }}</td></tr>
            <tr><td class="label">Lokasi</td><td>:</td><td>{{ $detailObj->lokasi_nikah ?? '-' }}</td></tr>
        </table>

        <p style="margin-top: 5px;">Surat pengantar ini dibuat untuk keperluan pengurusan administrasi pernikahan di KUA setempat.</p>


    {{-- 9. SURAT PENGANTAR SKCK --}}
    @elseif($surat->jenis_surat === 'Surat Pengantar SKCK')
        <p>Yang bertanda tangan di bawah ini Kepala Desa Suruh, Kecamatan Sukodono, Kabupaten Sidoarjo, menerangkan bahwa:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td>:</td><td>{{ $biodata->tempat_lahir ?? '-' }}, {{ $biodata->tanggal_lahir ?? '-' }}</td></tr>
            <tr><td class="label">Alamat</td><td>:</td><td>{{ $biodata->alamat ?? '-' }}</td></tr>
        </table>
        <p>Berdasarkan catatan kami, yang bersangkutan berkelakuan baik dan tidak pernah tersangkut perkara pidana.</p>
        <p>Surat pengantar ini dibuat untuk keperluan pengajuan <strong>SKCK</strong> di kepolisian setempat.</p>


    {{-- FALLBACK --}}
    @else
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>
        <table class="tabel-data">
            <tr><td class="label">Nama</td><td>:</td><td>{{ $biodata->nama_lengkap ?? $user->name }}</td></tr>
            <tr><td class="label">NIK</td><td>:</td><td>{{ $biodata->nik ?? '-' }}</td></tr>
        </table>
        <p>Surat ini dibuat untuk keperluan: {{ $surat->keterangan ?? '-' }}.</p>
    @endif

</div>

<div class="ttd-kanan">
    Suruh, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
    Kepala Desa Suruh
    <br><br>
    @if(!empty($qrBase64))
        <img src="data:image/svg+xml;base64,{{ $qrBase64 }}" style="width:75px; height:75px; margin-bottom:5px;">
        <br>
    @else
        <br><br><br>
    @endif
    <strong>Suwono</strong>
</div>

<div class="clear"></div>

</body>
</html>