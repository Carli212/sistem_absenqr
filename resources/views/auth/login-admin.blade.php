@extends('layouts.main')

@section('title','Login Admin')

@section('content')
<style>
    /* ===== ANIMATED NATURE BACKGROUND ===== */
    .nature-bg-animated {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
        background: linear-gradient(180deg, 
            #87CEEB 0%,
            #98D8E8 25%,
            #7EC8E3 50%,
            #5FB3D1 75%,
            #4A9AB0 100%
        );
    }

    .sun-animated {
        position: absolute;
        top: 10%;
        right: 12%;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: radial-gradient(circle, #FFE66D 0%, #FFB347 100%);
        box-shadow: 0 0 50px rgba(255, 230, 109, 0.8), 0 0 100px rgba(255, 230, 109, 0.4);
        animation: sunPulseAnim 4s ease-in-out infinite;
    }

    .sun-animated::before,
    .sun-animated::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 120%;
        height: 120%;
        border-radius: 50%;
        border: 2px solid rgba(255, 230, 109, 0.3);
        transform: translate(-50%, -50%);
        animation: sunRaysAnim 3s ease-in-out infinite;
    }

    .sun-animated::after {
        width: 140%;
        height: 140%;
        animation-delay: 1.5s;
    }

    @keyframes sunPulseAnim {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.95; }
    }

    @keyframes sunRaysAnim {
        0%, 100% { 
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.4;
        }
        50% { 
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 0;
        }
    }

    .cloud-animated {
        position: absolute;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 100px;
        opacity: 0.9;
    }

    .cloud-animated::before,
    .cloud-animated::after {
        content: '';
        position: absolute;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 100px;
    }

    .cloud-animated-1 {
        top: 15%;
        left: -200px;
        width: 150px;
        height: 50px;
        animation: cloudDrift1 35s linear infinite;
    }

    .cloud-animated-1::before {
        width: 80px;
        height: 50px;
        top: -25px;
        left: 30px;
    }

    .cloud-animated-1::after {
        width: 100px;
        height: 40px;
        top: -15px;
        left: 80px;
    }

    .cloud-animated-2 {
        top: 25%;
        right: -180px;
        width: 120px;
        height: 40px;
        animation: cloudDrift2 40s linear infinite;
        animation-delay: 5s;
    }

    .cloud-animated-2::before {
        width: 70px;
        height: 40px;
        top: -20px;
        left: 25px;
    }

    .cloud-animated-2::after {
        width: 80px;
        height: 35px;
        top: -12px;
        left: 65px;
    }

    .cloud-animated-3 {
        top: 35%;
        left: -150px;
        width: 100px;
        height: 35px;
        animation: cloudDrift3 45s linear infinite;
        animation-delay: 15s;
    }

    .cloud-animated-3::before {
        width: 60px;
        height: 35px;
        top: -18px;
        left: 20px;
    }

    .cloud-animated-3::after {
        width: 70px;
        height: 30px;
        top: -10px;
        left: 50px;
    }

    @keyframes cloudDrift1 {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(100vw + 200px)); }
    }

    @keyframes cloudDrift2 {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-100vw - 180px)); }
    }

    @keyframes cloudDrift3 {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(100vw + 150px)); }
    }

    .bird-animated {
        position: absolute;
        font-size: 20px;
        animation: birdFlyAnim 25s linear infinite;
    }

    .bird-animated-1 {
        top: 18%;
        left: -50px;
        animation-delay: 0s;
    }

    .bird-animated-2 {
        top: 22%;
        left: -80px;
        animation-delay: 8s;
    }

    .bird-animated-3 {
        top: 28%;
        left: -60px;
        animation-delay: 16s;
    }

    @keyframes birdFlyAnim {
        0% { 
            transform: translateX(0) translateY(0);
            opacity: 0;
        }
        5% { opacity: 1; }
        95% { opacity: 1; }
        100% { 
            transform: translateX(calc(100vw + 100px)) translateY(-30px);
            opacity: 0;
        }
    }

    .butterfly-animated {
        position: absolute;
        font-size: 24px;
        animation: butterflyFlyAnim 30s ease-in-out infinite;
    }

    .butterfly-animated-1 {
        top: 40%;
        left: -50px;
        animation-delay: 0s;
    }

    .butterfly-animated-2 {
        top: 45%;
        left: -70px;
        animation-delay: 10s;
    }

    @keyframes butterflyFlyAnim {
        0% { 
            transform: translateX(0) translateY(0) rotate(0deg);
            opacity: 0;
        }
        5% { opacity: 1; }
        25% { transform: translateX(25vw) translateY(-20px) rotate(5deg); }
        50% { transform: translateX(50vw) translateY(10px) rotate(-5deg); }
        75% { transform: translateX(75vw) translateY(-15px) rotate(3deg); }
        95% { opacity: 1; }
        100% { 
            transform: translateX(100vw) translateY(5px) rotate(0deg);
            opacity: 0;
        }
    }

    .mountains-animated {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200%;
        height: 35%;
        background-image: 
            linear-gradient(135deg, transparent 49%, #2d5f3f 50%, #2d5f3f 51%, transparent 52%),
            linear-gradient(-135deg, transparent 49%, #3a7754 50%, #3a7754 51%, transparent 52%),
            linear-gradient(45deg, transparent 49%, #4a9668 50%, #4a9668 51%, transparent 52%),
            linear-gradient(-45deg, transparent 49%, #5db07d 50%, #5db07d 51%, transparent 52%);
        background-size: 25% 100%, 25% 100%, 25% 100%, 25% 100%;
        background-position: 0 0, 0 0, 100% 0, 100% 0;
        background-repeat: repeat-x;
        animation: mountainParallaxAnim 120s linear infinite;
    }

    @keyframes mountainParallaxAnim {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .grass-animated {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 80px;
        background: linear-gradient(180deg, #5db07d 0%, #4a9668 100%);
        overflow: hidden;
    }

    .grass-blade-animated {
        position: absolute;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #4a9668 0%, #3a7754 100%);
        border-radius: 3px 3px 0 0;
        transform-origin: bottom center;
    }

    .grass-blade-animated:nth-child(1) { left: 5%; height: 25px; animation: grassSwayAnim 3s ease-in-out infinite; }
    .grass-blade-animated:nth-child(2) { left: 12%; height: 20px; animation: grassSwayAnim 2.5s ease-in-out infinite 0.2s; }
    .grass-blade-animated:nth-child(3) { left: 18%; height: 30px; animation: grassSwayAnim 3.2s ease-in-out infinite 0.4s; }
    .grass-blade-animated:nth-child(4) { left: 25%; height: 22px; animation: grassSwayAnim 2.8s ease-in-out infinite 0.6s; }
    .grass-blade-animated:nth-child(5) { left: 32%; height: 28px; animation: grassSwayAnim 3.1s ease-in-out infinite 0.8s; }
    .grass-blade-animated:nth-child(6) { left: 40%; height: 24px; animation: grassSwayAnim 2.9s ease-in-out infinite 1s; }
    .grass-blade-animated:nth-child(7) { left: 48%; height: 26px; animation: grassSwayAnim 3s ease-in-out infinite 1.2s; }
    .grass-blade-animated:nth-child(8) { left: 55%; height: 21px; animation: grassSwayAnim 2.7s ease-in-out infinite 1.4s; }
    .grass-blade-animated:nth-child(9) { left: 63%; height: 29px; animation: grassSwayAnim 3.3s ease-in-out infinite 1.6s; }
    .grass-blade-animated:nth-child(10) { left: 70%; height: 23px; animation: grassSwayAnim 2.6s ease-in-out infinite 1.8s; }
    .grass-blade-animated:nth-child(11) { left: 78%; height: 27px; animation: grassSwayAnim 3.1s ease-in-out infinite 2s; }
    .grass-blade-animated:nth-child(12) { left: 85%; height: 25px; animation: grassSwayAnim 2.9s ease-in-out infinite 2.2s; }
    .grass-blade-animated:nth-child(13) { left: 92%; height: 22px; animation: grassSwayAnim 2.8s ease-in-out infinite 2.4s; }

    @keyframes grassSwayAnim {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-2deg); }
        75% { transform: rotate(2deg); }
    }

    /* ===== LOGIN CARD ===== */
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        position: relative;
    }

    .login-card {
        max-width: 440px;
        width: 100%;
        background: white;
        border-radius: 24px;
        padding: 48px 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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

    .login-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .login-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #5db07d 0%, #3a7754 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        box-shadow: 0 8px 20px rgba(93, 176, 125, 0.4);
    }

    .login-title {
        font-size: 28px;
        font-weight: 900;
        background: linear-gradient(135deg, #3a7754 0%, #2d5f3f 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .login-subtitle {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        color: #1e293b;
        transition: all 0.2s ease;
        background: #f8fafc;
    }

    .form-input:focus {
        outline: none;
        border-color: #5db07d;
        background: white;
        box-shadow: 0 0 0 4px rgba(93, 176, 125, 0.1);
    }

    .input-icon {
        position: relative;
    }

    .input-icon .form-input {
        padding-left: 44px;
    }

    .input-icon-symbol {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        pointer-events: none;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 18px;
        color: #64748b;
        transition: color 0.2s ease;
    }

    .password-toggle:hover {
        color: #334155;
    }

    .error-alert {
        padding: 14px 16px;
        background: #fee2e2;
        border: 2px solid #fecaca;
        color: #991b1b;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: shake 0.4s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    .submit-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #5db07d 0%, #3a7754 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(93, 176, 125, 0.4);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(93, 176, 125, 0.5);
    }

    .login-footer {
        text-align: center;
        margin-top: 28px;
        padding-top: 28px;
        border-top: 1px solid #e2e8f0;
        font-size: 13px;
        color: #64748b;
    }

    @media (max-width: 768px) {
        .sun-animated { width: 70px; height: 70px; }
        .mountains-animated { height: 25%; }
        .grass-animated { height: 50px; }
        .cloud-animated { transform: scale(0.7); }
        .bird-animated, .butterfly-animated { font-size: 16px; }
    }
</style>

<!-- ANIMATED BACKGROUND -->
<div class="nature-bg-animated">
    <div class="sun-animated"></div>
    <div class="cloud-animated cloud-animated-1"></div>
    <div class="cloud-animated cloud-animated-2"></div>
    <div class="cloud-animated cloud-animated-3"></div>
    <div class="bird-animated bird-animated-1">🦅</div>
    <div class="bird-animated bird-animated-2">🕊️</div>
    <div class="bird-animated bird-animated-3">🦜</div>
    <div class="butterfly-animated butterfly-animated-1">🦋</div>
    <div class="butterfly-animated butterfly-animated-2">🦋</div>
    <div class="mountains-animated"></div>
    <div class="grass-animated">
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
        <div class="grass-blade-animated"></div>
    </div>
</div>

<!-- LOGIN CARD -->
<div class="login-container">
    <div class="login-card">
        
        <div class="login-header">
            <div class="login-icon">🔐</div>
            <h2 class="login-title">Admin Portal</h2>
            <p class="login-subtitle">Masuk untuk mengelola sistem absensi</p>
        </div>

        @if(session('error'))
        <div class="error-alert">
            <span style="font-size: 18px;">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('login.admin.process') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-icon">
                    <span class="input-icon-symbol">👤</span>
                    <input 
                        type="text" 
                        name="nama" 
                        class="form-input" 
                        placeholder="Masukkan nama lengkap"
                        required 
                        autofocus
                    />
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor WhatsApp</label>
                <div class="input-icon">
                    <span class="input-icon-symbol">📱</span>
                    <input 
                        type="text" 
                        name="nomor_wa" 
                        class="form-input" 
                        placeholder="08xxxxxxxxxx"
                        required
                    />
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-icon">
                    <span class="input-icon-symbol">🔒</span>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        class="form-input" 
                        placeholder="Masukkan password"
                        required
                    />
                    <span class="password-toggle" onclick="togglePassword()">👁️</span>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                Masuk Dashboard
            </button>
        </form>

        <div class="login-footer">
            <p>Sistem Absensi QR Code © 2025</p>
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordToggle = document.querySelector('.password-toggle');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggle.textContent = '🙈';
    } else {
        passwordInput.type = 'password';
        passwordToggle.textContent = '👁️';
    }
}
</script>

@endsection