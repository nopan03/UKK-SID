<!DOCTYPE html>
<html>
<head>
    <title>Surat Selesai</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    
    <h3>Halo, {{ $surat->user->name }}! 👋</h3>
    
    <p>Kabar gembira! Permohonan surat Anda dengan detail berikut:</p>
    
    <ul>
        <li><strong>Jenis Surat:</strong> {{ $surat->jenis_surat }}</li>
        <li><strong>Tanggal Request:</strong> {{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->translatedFormat('d F Y') }}</li>
        <li><strong>Status:</strong> <span style="color: green; font-weight: bold;">SELESAI</span></li>
    </ul>

    <p>
        Surat resmi telah kami lampirkan dalam email ini (format PDF). 
        Silakan unduh dan cetak jika diperlukan.
    </p>

    <br>
    <p>Terima kasih,<br>
    <strong>Pemerintah Desa Suruh</strong></p>

</body>
</html>