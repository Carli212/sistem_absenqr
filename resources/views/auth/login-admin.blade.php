@extends('layouts.main')

@section('title','Login Admin')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* ===== MODERN GRADIENT BACKGROUND ===== */
    .modern-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        z-index: 0;
    }

    .gradient-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.6;
        animation: float 20s ease-in-out infinite;
    }

    .orb-1 {
        top: -10%;
        left: -5%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, #f093fb 0%, #f5576c 100%);
        animation-delay: 0s;
    }

    .orb-2 {
        bottom: -10%;
        right: -5%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, #4facfe 0%, #00f2fe 100%);
        animation-delay: 5s;
    }

    .orb-3 {
        top: 40%;
        left: 50%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, #43e97b 0%, #38f9d7 100%);
        animation-delay: 10s;
    }

    @keyframes float {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        33% {
            transform: translate(50px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-30px, 30px) scale(0.9);
        }
    }

    .grid-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 50px 50px;
        opacity: 0.5;
    }

    /* ===== MAIN CONTAINER ===== */
    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
        z-index: 10;
    }

    .login-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 1100px;
        width: 100%;
        background: rgba(255, 255, 255, 0.98);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 
            0 30px 90px rgba(0, 0, 0, 0.3),
            0 0 1px rgba(255, 255, 255, 0.8) inset;
        animation: slideIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* ===== LEFT SIDE - BRANDING ===== */
    .login-brand {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .brand-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        opacity: 0.5;
    }

    .brand-content {
        position: relative;
        z-index: 2;
    }

    .brand-logo {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin-bottom: 30px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .brand-title {
        font-size: 36px;
        font-weight: 800;
        color: white;
        margin-bottom: 16px;
        line-height: 1.2;
        letter-spacing: -1px;
    }

    .brand-description {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.6;
        margin-bottom: 40px;
    }

    .brand-features {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
        font-size: 14px;
        font-weight: 500;
    }

    .feature-icon {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    /* ===== RIGHT SIDE - FORM ===== */
    .login-form-section {
        padding: 60px 50px;
        background: white;
    }

    .form-header {
        margin-bottom: 40px;
    }

    .form-title {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .form-subtitle {
        font-size: 15px;
        color: #64748b;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        z-index: 2;
    }

    .form-input {
        width: 100%;
        padding: 15px 16px 15px 52px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        color: #1e293b;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-input:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-input::placeholder {
        color: #94a3b8;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 20px;
        transition: opacity 0.2s ease;
        z-index: 2;
    }

    .password-toggle:hover {
        opacity: 0.7;
    }

    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #475569;
        cursor: pointer;
        user-select: none;
    }

    .remember-me input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #667eea;
    }

    .forgot-password {
        font-size: 14px;
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .forgot-password:hover {
        color: #764ba2;
    }

    .submit-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        letter-spacing: 0.3px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.5);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .divider {
        display: flex;
        align-items: center;
        margin: 28px 0;
        color: #94a3b8;
        font-size: 13px;
        font-weight: 500;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .divider span {
        padding: 0 16px;
    }

    .social-login {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .social-btn {
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .social-btn:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
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
        25% { transform: translateX(-8px); }
        75% { transform: translateX(8px); }
    }

    .form-bottom-text {
        text-align: center;
        margin-top: 24px;
        font-size: 14px;
        color: #64748b;
    }

    .form-bottom-text a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }

    .form-bottom-text a:hover {
        text-decoration: underline;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 968px) {
        .login-container {
            grid-template-columns: 1fr;
            max-width: 480px;
        }

        .login-brand {
            display: none;
        }

        .login-form-section {
            padding: 40px 30px;
        }
    }

    @media (max-width: 480px) {
        .login-wrapper {
            padding: 20px 16px;
        }

        .login-form-section {
            padding: 32px 24px;
        }

        .form-title {
            font-size: 24px;
        }

        .social-login {
            grid-template-columns: 1fr;
        }
    }

    /* Loading State */
    .submit-btn.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .submit-btn.loading::after {
        content: '';
        width: 16px;
        height: 16px;
        border: 2px solid white;
        border-top-color: transparent;
        border-radius: 50%;
        display: inline-block;
        margin-left: 10px;
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<!-- Modern Gradient Background -->
<div class="modern-background">
    <div class="gradient-orb orb-1"></div>
    <div class="gradient-orb orb-2"></div>
    <div class="gradient-orb orb-3"></div>
    <div class="grid-overlay"></div>
</div>

<!-- Login Container -->
<div class="login-wrapper">
    <div class="login-container">
        
        <!-- Left Side - Branding -->
        <div class="login-brand">
            <div class="brand-pattern"></div>
            <div class="brand-content">
                <div class="brand-logo">📊</div>
                <h1 class="brand-title">Sistem Absensi<br>Terintegrasi</h1>
                <p class="brand-description">
                    Platform manajemen kehadiran modern dengan teknologi QR Code untuk efisiensi maksimal
                </p>
                <div class="brand-features">
                    <div class="feature-item">
                        <div class="feature-icon">⚡</div>
                        <span>Absensi real-time dengan QR Code</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📱</div>
                        <span>Dashboard responsif & mobile-friendly</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🔒</div>
                        <span>Keamanan data terjamin</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📈</div>
                        <span>Laporan analytics komprehensif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-form-section">
            <div class="form-header">
                <h2 class="form-title">Selamat Datang Kembali</h2>
                <p class="form-subtitle">Silakan masuk ke akun admin Anda</p>
            </div>

            @if(session('error'))
            <div class="error-alert">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login.admin.process') }}" id="loginForm">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <span class="input-icon">👤</span>
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
                    <div class="input-wrapper">
                        <span class="input-icon">📱</span>
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
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
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

                <div class="form-footer">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="forgot-password">Lupa password?</a>
                </div>

                <button type="submit" class="submit-btn">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="divider">
                <span>ATAU MASUK DENGAN</span>
            </div>

            <div class="social-login">
                <button class="social-btn">
                    <span>🔵</span>
                    <span>Google</span>
                </button>
                <button class="social-btn">
                    <span>📘</span>
                    <span>Microsoft</span>
                </button>
            </div>

            <p class="form-bottom-text">
                Belum punya akun? <a href="#">Daftar sekarang</a>
            </p>
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

    // Form submission with loading state
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('.submit-btn');
        submitBtn.classList.add('loading');
        submitBtn.textContent = 'Memproses';
    });

    // Add subtle parallax effect to gradient orbs
    document.addEventListener('mousemove', (e) => {
        const orbs = document.querySelectorAll('.gradient-orb');
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        
        orbs.forEach((orb, index) => {
            const speed = (index + 1) * 20;
            orb.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
        });
    });
</script>

@endsection