<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Omah Sinau Semar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #052e16 0%, #16a34a 50%, #15803d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            position: relative;
            overflow: hidden;
        }

        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            opacity: .15;
        }
        body::before {
            width: 500px; height: 500px;
            background: #4ade80;
            top: -100px; right: -100px;
            animation: floatOrb 8s ease-in-out infinite;
        }
        body::after {
            width: 400px; height: 400px;
            background: #f59e0b;
            bottom: -80px; left: -80px;
            animation: floatOrb 10s ease-in-out infinite reverse;
        }
        @keyframes floatOrb {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-20px) scale(1.05); }
        }

        .otp-card {
            background: rgba(255,255,255,.97);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,.25);
            position: relative;
            z-index: 10;
            animation: slideUp .5s ease;
        }
        .otp-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #16a34a, #f59e0b, #16a34a);
            border-radius: 24px 24px 0 0;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .otp-icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 2px solid #bbf7d0;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 1.5rem;
        }

        .otp-title {
            font-size: 1.5rem;
            font-weight: 900;
            color: #1e293b;
            text-align: center;
            margin-bottom: .25rem;
        }
        .otp-subtitle {
            text-align: center;
            color: #64748b;
            font-size: .88rem;
            margin-bottom: .5rem;
        }
        .otp-email {
            text-align: center;
            color: #16a34a;
            font-weight: 700;
            font-size: .9rem;
            margin-bottom: 2rem;
        }

        /* OTP Input boxes */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .otp-input {
            width: 52px; height: 58px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 900;
            font-family: monospace;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            outline: none;
            transition: all .2s;
            color: #1e293b;
            background: #f8fafc;
        }
        .otp-input:focus {
            border-color: #16a34a;
            background: #f0fdf4;
            box-shadow: 0 0 0 3px rgba(22,163,74,.12);
        }
        .otp-input.filled {
            border-color: #16a34a;
            background: #f0fdf4;
            color: #15803d;
        }

        /* Hidden actual input */
        #otpHidden { display: none; }

        .btn-verify {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #16a34a, #15803d);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            transition: .2s;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(22,163,74,.35);
        }
        .btn-verify:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(22,163,74,.45); }
        .btn-verify:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        .resend-section {
            text-align: center;
            margin-top: 1.25rem;
            font-size: .85rem;
            color: #64748b;
        }
        .resend-link {
            color: #16a34a;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }
        .resend-link:hover { text-decoration: underline; }

        .alert-danger {
            border-radius: 12px; font-size: .88rem;
            border: none; background: #fef2f2; color: #b91c1c;
            padding: 12px 16px; margin-bottom: 1.25rem;
        }

        .back-link {
            display: block; text-align: center;
            margin-top: 1.5rem;
            color: rgba(255,255,255,.85);
            text-decoration: none; font-size: .88rem;
            position: relative; z-index: 10;
            transition: color .2s;
        }
        .back-link:hover { color: #fff; }

        .timer {
            display: inline-block;
            background: #fef9c3;
            color: #a16207;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: .8rem;
            font-weight: 700;
            margin-top: 8px;
        }
    </style>
</head>
<body>

<div>
    <div class="otp-card">
        <div class="otp-icon">
            <i class="bi bi-shield-lock-fill" style="color:#16a34a;"></i>
        </div>
        <h1 class="otp-title">Verifikasi OTP</h1>
        <p class="otp-subtitle">Kode verifikasi telah dikirim ke</p>
        <p class="otp-email">{{ session('otp_email') }}</p>

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.otp.verify') }}" method="POST" id="otpForm">
            @csrf
            <input type="hidden" name="otp" id="otpHidden">

            <div class="otp-inputs">
                <input type="text" class="otp-input" maxlength="1" data-index="0" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" data-index="1" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" data-index="2" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" data-index="3" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" data-index="4" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" data-index="5" inputmode="numeric">
            </div>

            <button type="submit" class="btn-verify" id="btnVerify" disabled>
                <i class="bi bi-shield-check me-2"></i>Verifikasi
            </button>
        </form>

        <div class="resend-section">
            <span>Tidak menerima kode?</span>
            <div class="timer" id="timer">Kirim ulang dalam <span id="countdown">5:00</span></div>
        </div>
    </div>

    <a href="{{ route('admin.login') }}" class="back-link">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
    </a>
</div>

<script>
// OTP Input Logic
const inputs = document.querySelectorAll('.otp-input');
const hiddenInput = document.getElementById('otpHidden');
const btnVerify = document.getElementById('btnVerify');

inputs.forEach((input, index) => {
    input.addEventListener('input', (e) => {
        const val = e.target.value.replace(/\D/g, '');
        e.target.value = val;

        if (val) {
            e.target.classList.add('filled');
            if (index < inputs.length - 1) inputs[index + 1].focus();
        } else {
            e.target.classList.remove('filled');
        }
        updateHidden();
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && index > 0) {
            inputs[index - 1].focus();
            inputs[index - 1].value = '';
            inputs[index - 1].classList.remove('filled');
            updateHidden();
        }
    });

    input.addEventListener('paste', (e) => {
        e.preventDefault();
        const paste = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
        paste.split('').forEach((char, i) => {
            if (inputs[i]) {
                inputs[i].value = char;
                inputs[i].classList.add('filled');
            }
        });
        if (inputs[paste.length - 1]) inputs[paste.length - 1].focus();
        updateHidden();
    });
});

function updateHidden() {
    const otp = Array.from(inputs).map(i => i.value).join('');
    hiddenInput.value = otp;
    btnVerify.disabled = otp.length !== 6;
}

// Auto submit when 6 digits entered
inputs[inputs.length - 1].addEventListener('input', () => {
    const otp = Array.from(inputs).map(i => i.value).join('');
    if (otp.length === 6) {
        setTimeout(() => document.getElementById('otpForm').submit(), 300);
    }
});

// Focus first input on load
inputs[0].focus();

// Countdown Timer 5 menit
let timeLeft = 300;
const countdownEl = document.getElementById('countdown');

const timer = setInterval(() => {
    timeLeft--;
    const m = Math.floor(timeLeft / 60);
    const s = timeLeft % 60;
    countdownEl.textContent = m + ':' + String(s).padStart(2, '0');

    if (timeLeft <= 0) {
        clearInterval(timer);
        document.getElementById('timer').innerHTML =
            '<a class="resend-link" href="{{ route("admin.login") }}">Kode kadaluarsa. Login ulang</a>';
    }
}, 1000);
</script>
</body>
</html>