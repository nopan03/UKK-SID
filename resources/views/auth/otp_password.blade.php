<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Ganti Password</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Permintaan Ganti Password</h2>
    <p>Halo,</p>
    <p>Anda meminta kode OTP untuk mengganti password akun Desa Suruh. Masukkan kode berikut di halaman profil:</p>
    
    <div style="background: #f3f4f6; padding: 15px; font-size: 24px; font-weight: bold; letter-spacing: 5px; text-align: center; border-radius: 8px; margin: 20px 0;">
        {{ $otp }}
    </div>

    <p>Kode ini berlaku selama 5 menit. Jangan berikan kode ini kepada siapapun.</p>
    <p>Terima kasih,<br>Admin Desa Suruh</p>
</body>
</html>