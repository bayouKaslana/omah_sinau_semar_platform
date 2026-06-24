<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; margin: 0; padding: 20px; }
        .card { max-width: 480px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #052e16, #16a34a); padding: 32px 24px; text-align: center; }
        .header h2 { color: white; margin: 0; font-size: 1.4rem; }
        .header p { color: rgba(255,255,255,0.75); margin: 8px 0 0; font-size: 0.88rem; }
        .body { padding: 32px 24px; text-align: center; }
        .otp-box { background: #f0fdf4; border: 2px dashed #16a34a; border-radius: 12px; padding: 20px; margin: 20px 0; }
        .otp-code { font-size: 2.5rem; font-weight: 900; color: #16a34a; letter-spacing: 8px; font-family: monospace; }
        .warning { font-size: 0.82rem; color: #94a3b8; margin-top: 16px; }
        .footer { background: #f8fafc; padding: 16px 24px; text-align: center; font-size: 0.78rem; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
<div class="card">
    <div class="header">
        <h2>Kode OTP Login</h2>
        <p>Omah Sinau Semar - Admin Panel</p>
    </div>
    <div class="body">
        <p style="color:#475569;">Gunakan kode berikut untuk masuk ke panel admin:</p>
        <div class="otp-box">
            <div class="otp-code">{{ $otp }}</div>
        </div>
        <p style="color:#475569;font-size:0.88rem;">Kode berlaku selama <strong>5 menit</strong>.</p>
        <p class="warning">Jika Anda tidak mencoba login, abaikan email ini.</p>
    </div>
    <div class="footer">{{ date('Y') }} Omah Sinau Semar. All Rights Reserved.</div>
</div>
</body>
</html>