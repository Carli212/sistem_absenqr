@extends('layouts.main')
@section('title', 'Login Siswa | Sistem Absensi QR')

@section('content')
<style>
    .login-siswa-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: linear-gradient(180deg, 
            #87CEEB 0%,
            #98D8E8 25%,
            #7EC8E3 50%,
            #5FB3D1 75%,
            #4A9AB0 100%
        );
        position: relative;
        overflow: hidden;
    }

    /* Matahari */
    .login-siswa-container::before {
        content: '';
        position: absolute;
        top: 8%;
        right: 12%;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, #FFE66D 0%, #FFB347 100%);
        border-radius: 50%;
        box-shadow: 0 0 50px rgba(255, 230, 109, 0.6);
        animation: sunshine 4s ease-in-out infinite;
    }

    @keyframes sunshine {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }

    /* Awan */
    .cloud {
        position: absolute;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 50px;
        animation: floatCloud 30s ease-in-out infinite;
    }

    .cloud-1 {
        top: 15%;
        left: 10%;
        width: 180px;
        height: 50px;
        box-shadow: 
            70px 15px 0 -8px rgba(255, 255, 255, 0.6),
            130px 8px 0 -5px rgba(255, 255, 255, 0.5);
    }

    .cloud-2 {
        top: 25%;
        right: 18%;
        width: 140px;
        height: 40px;
        box-shadow: 
            55px 12px 0 -6px rgba(255, 255, 255, 0.6);
        animation-delay: 5s;
        animation-duration: 35s;
    }

    @keyframes floatCloud {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(25px); }
    }

    /* Pegunungan */
    .mountains {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 35%;
        background: 
            linear-gradient(135deg, transparent 50%, #2d5f3f 50%) 0 0,
            linear-gradient(-135deg, transparent 50%, #3a7754 50%) 0 0,
            linear-gradient(45deg, transparent 50%, #4a9668 50%) 100% 0,
            linear-gradient(-45deg, transparent 50%, #5db07d 50%) 100% 0;
        background-size: 25% 100%, 25% 100%, 25% 100%, 25% 100%;
        background-repeat: no-repeat;
        z-index: 0;
    }

    /* Rumput */
    .grass {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 80px;
        background: linear-gradient(180deg, #5db07d 0%, #4a9668 100%);
        z-index: 0;
    }

    /* Login Card */
    .login-card-siswa {
        max-width: 400px;
        width: 100%;
        background: rgba(255, 255, 255, 0.98);
        border-radius: 24px;
        padding: 40px 36px;
        box-shadow: 0 20px 60px rgba(45, 95, 63, 0.2);
        position: relative;
        z-index: 10;
        animation: slideUp 0.5s ease;
        border: 3px solid #a5d6a7;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-header-siswa {
        text-align: center;
        margin-bottom: 32px;
    }

    .login-logo {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #4a9668 0%, #2d5f3f 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(74, 150, 104, 0.4);
        border: 4px solid white;
    }

    .login-logo img {
        width: 50px;
        height: 50px;
        filter: brightness(0) invert(1);
    }

    .login-title-siswa {
        font-size: 24px;
        font-weight: 900;
        background: linear-gradient(135deg, #2d5f3f 0%, #4a9668 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }

    .login-subtitle-siswa {
        font-size: 13px;
        color: #4a9668;
        font-weight: 600;
    }

    .error-alert-siswa {
        padding: 14px 16px;
        background: #ffebee;
        border: 2px solid #ef9a9a;
        color: #c62828;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: shake 0.4s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-8px); }
        75% { transform: translateX(8px); }
    }

    .form-group-siswa {
        margin-bottom: 20px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon-siswa {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #4a9668;
        font-size: 16px;
        z-index: 1;
    }

    .form-input-siswa {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border: 2px solid #c8e6c9;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        color: #1b4332;
        transition: all 0.2s ease;
        background: #f1f8f4;
    }

    .form-input-siswa:focus {
        outline: none;
        border-color: #4a9668;
        background: white;
        box-shadow: 0 0 0 4px rgba(74, 150, 104, 0.1);
    }

    .form-input-siswa::placeholder {
        color: #81c784;
    }

    .submit-btn-siswa {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #4a9668 0%, #2d5f3f 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(74, 150, 104, 0.4);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .submit-btn-siswa:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 150, 104, 0.5);
    }

    .submit-btn-siswa:active {
        transform: translateY(0);
    }

    .login-footer-siswa {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 2px solid #e8f5e9;
        font-size: 12px;
        color: #4a9668;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .login-card-siswa {
            padding: 32px 24px;
        }

        .login-title-siswa {
            font-size: 22px;
        }

        .mountains {
            height: 30%;
        }

        .grass {
            height: 60px;
        }

        .login-siswa-container::before {
            width: 80px;
            height: 80px;
        }
    }
</style>

<div class="login-siswa-container">
    <!-- Awan -->
    <div class="cloud cloud-1"></div>
    <div class="cloud cloud-2"></div>
    
    <!-- Pegunungan -->
    <div class="mountains"></div>
    
    <!-- Rumput -->
    <div class="grass"></div>

    <!-- Login Card -->
    <div class="login-card-siswa">
        
        <div class="login-header-siswa">
            <div class="login-logo">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Logo">
            </div>
            <h1 class="login-title-siswa">🌿 Sistem Absensi QR</h1>
            <p class="login-subtitle-siswa">Masukkan data untuk mulai absen</p>
        </div>

        @if(session('error'))
        <div class="error-alert-siswa">
            <span style="font-size: 18px;">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <form action="{{ route('login.siswa.process') }}" method="POST">
    @csrf

    <div class="form-group-siswa">
        <div class="input-wrapper">
            <span class="input-icon-siswa">👤</span>
            <input
                type="text"
                name="nama"
                value="{{ old('nama') }}"
                placeholder="Nama Lengkap"
                class="form-input-siswa"
                required
                autofocus>
        </div>
    </div>

    <div class="form-group-siswa">
        <div class="input-wrapper">
            <span class="input-icon-siswa">🔒</span>
            <input
                type="password"
                name="password"
                placeholder="Password"
                class="form-input-siswa"
                required>
        </div>
    </div>

    <!-- ============================ -->
    <!-- 🔐 DEVICE ID (baru ditambah) -->
    <!-- ============================ -->
    <input type="hidden" name="device_id" id="device_id">

    <script>
        // Generate device_id jika belum ada
        if (!localStorage.getItem("device_id")) {
            localStorage.setItem("device_id", crypto.randomUUID());
        }
        document.getElementById("device_id").value = localStorage.getItem("device_id");
    </script>
    <!-- ============================ -->

    <button type="submit" class="submit-btn-siswa">
        <span style="font-size: 18px;">📱</span>
        <span>Mulai Absen</span>
    </button>
</form>

        <div class="login-footer-siswa">
            <p>🌳 Sistem terhubung otomatis dengan IP perangkat Anda</p>
        </div>

    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection