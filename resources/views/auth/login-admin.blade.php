@extends('layouts.main')

@section('title','Login Admin')

@section('content')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    .login-container::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 20s ease-in-out infinite;
    }

    .login-container::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        animation: float 25s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
    }

    .login-card {
        max-width: 440px;
        width: 100%;
        background: white;
        border-radius: 24px;
        padding: 48px 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 1;
        animation: slideUp 0.5s ease;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .login-title {
        font-size: 28px;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-input::placeholder {
        color: #94a3b8;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(102, 126, 234, 0.4);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .login-footer {
        text-align: center;
        margin-top: 28px;
        padding-top: 28px;
        border-top: 1px solid #e2e8f0;
        font-size: 13px;
        color: #64748b;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .login-card {
            padding: 32px 24px;
        }

        .login-title {
            font-size: 24px;
        }

        .login-icon {
            width: 70px;
            height: 70px;
            font-size: 32px;
        }
    }
</style>

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