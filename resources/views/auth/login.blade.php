@extends('layouts.main')
@section('title', 'Login Siswa | Sistem Absensi QR')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Background Container */
    .login-siswa-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    /* Animated Background Particles */
    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        animation: particleFloat 15s infinite ease-in-out;
    }

    @keyframes particleFloat {
        0%, 100% {
            transform: translate(0, 0);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translate(100px, -800px);
            opacity: 0;
        }
    }

    /* Main Container - 2 Panel Layout */
    .login-container-siswa {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 1100px;
        width: 100%;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 
            0 20px 60px rgba(102, 126, 234, 0.3),
            0 0 1px rgba(255, 255, 255, 0.8) inset;
        border: 2px solid rgba(102, 126, 234, 0.2);
        position: relative;
        z-index: 10;
        animation: slideIn 0.7s cubic-bezier(0.4, 0, 0.2, 1);
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

    /* LEFT SIDE - CHARACTER ILLUSTRATION */
    .login-illustration {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    /* Robot Character Container */
    .character-container {
        position: relative;
        width: 280px;
        height: 320px;
        margin-bottom: 32px;
        animation: robotFloat 3s ease-in-out infinite;
    }

    @keyframes robotFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    /* Robot Body */
    .robot-body {
        width: 180px;
        height: 200px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 30px;
        position: absolute;
        left: 50%;
        top: 55%;
        transform: translate(-50%, -50%);
        box-shadow: 
            0 20px 40px rgba(0, 0, 0, 0.2),
            inset 0 -5px 20px rgba(0, 0, 0, 0.1);
        border: 4px solid #cbd5e1;
    }

    /* Robot Head */
    .robot-head {
        width: 160px;
        height: 140px;
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        border-radius: 25px;
        position: absolute;
        left: 50%;
        top: 20%;
        transform: translate(-50%, -50%);
        box-shadow: 
            0 15px 35px rgba(0, 0, 0, 0.15),
            inset 0 2px 10px rgba(255, 255, 255, 0.8);
        border: 4px solid #cbd5e1;
        transition: transform 0.3s ease;
    }

    /* Antenna */
    .robot-antenna {
        width: 4px;
        height: 30px;
        background: linear-gradient(to bottom, #94a3b8, #cbd5e1);
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .robot-antenna::after {
        content: '';
        width: 12px;
        height: 12px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        position: absolute;
        top: -8px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 0 15px rgba(102, 126, 234, 0.6);
        animation: antennaBlink 2s ease-in-out infinite;
    }

    @keyframes antennaBlink {
        0%, 100% { opacity: 1; box-shadow: 0 0 15px rgba(102, 126, 234, 0.6); }
        50% { opacity: 0.4; box-shadow: 0 0 5px rgba(102, 126, 234, 0.3); }
    }

    /* Robot Face Screen */
    .robot-face {
        width: 130px;
        height: 90px;
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 15px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 
            inset 0 2px 10px rgba(0, 0, 0, 0.5),
            0 4px 15px rgba(102, 126, 234, 0.3);
        overflow: hidden;
    }

    /* Screen Glow Effect */
    .robot-face::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.3), transparent);
        animation: screenGlow 3s linear infinite;
    }

    @keyframes screenGlow {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Robot Eyes */
    .robot-eyes {
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .robot-eye {
        width: 35px;
        height: 35px;
        background: #667eea;
        border-radius: 50%;
        position: relative;
        box-shadow: 
            0 0 20px rgba(102, 126, 234, 0.8),
            inset 0 2px 8px rgba(255, 255, 255, 0.3);
        transition: all 0.15s ease;
    }

    /* Eye Pupil */
    .robot-pupil {
        width: 15px;
        height: 15px;
        background: #1e293b;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.15s ease;
    }

    .robot-pupil::after {
        content: '';
        width: 5px;
        height: 5px;
        background: white;
        border-radius: 50%;
        position: absolute;
        top: 3px;
        left: 3px;
    }

    /* Robot Mouth */
    .robot-mouth {
        width: 60px;
        height: 4px;
        background: #667eea;
        position: absolute;
        bottom: 25%;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
        box-shadow: 0 0 10px rgba(102, 126, 234, 0.6);
        transition: all 0.3s ease;
    }

    /* Happy Mouth - FIXED */
    .robot-mouth.smile {
        width: 50px;
        height: 25px;
        border: 4px solid #667eea;
        background: transparent;
        border-top: none;
        border-radius: 0 0 25px 25px;
        bottom: 20%;
        box-shadow: 0 0 10px rgba(102, 126, 234, 0.6);
    }

    /* Robot Arms */
    .robot-arm {
        width: 25px;
        height: 100px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        position: absolute;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border: 3px solid #cbd5e1;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .robot-arm.left {
        left: -20px;
        top: 50%;
        transform: rotate(10deg);
        transform-origin: top center;
    }

    .robot-arm.right {
        right: -20px;
        top: 50%;
        transform: rotate(-10deg);
        transform-origin: top center;
    }

    /* Arm Hand */
    .robot-hand {
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);
        border-radius: 50%;
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        border: 3px solid #64748b;
    }

    /* Waving Animation */
    .robot-arm.wave {
        animation: armWave 0.6s ease-in-out;
    }

    @keyframes armWave {
        0%, 100% { transform: rotate(10deg); }
        25% { transform: rotate(-20deg); }
        75% { transform: rotate(20deg); }
    }

    .robot-arm.right.wave {
        animation: armWaveRight 0.6s ease-in-out;
    }

    @keyframes armWaveRight {
        0%, 100% { transform: rotate(-10deg); }
        25% { transform: rotate(20deg); }
        75% { transform: rotate(-20deg); }
    }

    /* Covering Eyes - FIXED SMOOTH */
    .robot-arm.cover {
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .robot-arm.left.cover {
        left: 35px;
        top: 8%;
        transform: rotate(-30deg) scale(0.85);
    }

    .robot-arm.right.cover {
        right: 35px;
        top: 8%;
        transform: rotate(30deg) scale(0.85);
    }

    /* Robot Chest Panel */
    .robot-chest {
        width: 80px;
        height: 60px;
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 12px;
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.4);
    }

    /* Chest Indicators */
    .chest-indicator {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        position: absolute;
        left: 15px;
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.6);
        animation: indicatorBlink 1.5s ease-in-out infinite;
    }

    .chest-indicator:nth-child(1) { top: 15px; }
    .chest-indicator:nth-child(2) { top: 30px; animation-delay: 0.3s; }
    .chest-indicator:nth-child(3) { top: 45px; animation-delay: 0.6s; }

    @keyframes indicatorBlink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    /* Heart Icon in Chest */
    .robot-heart {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 24px;
        animation: heartBeat 1.5s ease-in-out infinite;
    }

    @keyframes heartBeat {
        0%, 100% { transform: translateY(-50%) scale(1); }
        30% { transform: translateY(-50%) scale(1.1); }
        60% { transform: translateY(-50%) scale(0.95); }
    }

    /* Excited Animation */
    .character-container.excited {
        animation: robotExcited 0.6s ease;
    }

    @keyframes robotExcited {
        0%, 100% { transform: translateY(0) scale(1); }
        25% { transform: translateY(-15px) scale(1.03); }
        50% { transform: translateY(-20px) scale(1.03) rotate(2deg); }
        75% { transform: translateY(-10px) scale(1.03) rotate(-2deg); }
    }

    /* Nodding Animation */
    .robot-head.nodding {
        animation: headNod 0.6s ease;
    }

    @keyframes headNod {
        0%, 100% { transform: translate(-50%, -50%); }
        25% { transform: translate(-50%, -48%); }
        75% { transform: translate(-50%, -52%); }
    }

    /* Illustration Text */
    .illustration-title {
        font-size: 32px;
        font-weight: 900;
        color: white;
        margin-bottom: 16px;
        line-height: 1.2;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .illustration-description {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.95);
        line-height: 1.7;
        font-weight: 500;
        text-align: center;
    }

    /* RIGHT SIDE - FORM */
    .login-form-section {
        padding: 60px 50px;
        background: white;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-header {
        margin-bottom: 36px;
        text-align: center;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border: 2px solid #fcd34d;
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        margin-bottom: 16px;
        animation: badgeFloat 3s ease-in-out infinite;
    }

    @keyframes badgeFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    .form-title {
        font-size: 32px;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .form-subtitle {
        font-size: 15px;
        color: #64748b;
        font-weight: 600;
    }

    /* Alert Error */
    .error-alert-siswa {
        padding: 20px 24px;
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: 3px solid #fca5a5;
        color: #991b1b;
        border-radius: 16px;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: shake 0.5s ease;
        box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2);
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-8px); }
        20%, 40%, 60%, 80% { transform: translateX(8px); }
    }

    /* Form Elements */
    .form-group-siswa {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 800;
        color: #475569;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon-siswa {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .form-input-siswa {
        width: 100%;
        padding: 16px 18px 16px 54px;
        border: 3px solid #e2e8f0;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.3s ease;
    }

    .form-input-siswa:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    .form-input-siswa:focus + .input-glow {
        opacity: 1;
    }

    .form-input-siswa::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    .input-glow {
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Submit Button */
    .submit-btn-siswa {
        width: 100%;
        padding: 18px 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
        margin-top: 8px;
    }

    .submit-btn-siswa::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .submit-btn-siswa:hover::before {
        left: 100%;
    }

    .submit-btn-siswa:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(102, 126, 234, 0.5);
    }

    .submit-btn-siswa:active {
        transform: translateY(-1px);
    }

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 3px solid #93c5fd;
        border-radius: 16px;
        padding: 20px;
        margin-top: 24px;
        display: flex;
        align-items: start;
        gap: 12px;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.15);
    }

    .info-icon {
        font-size: 24px;
        flex-shrink: 0;
        animation: iconSwing 2s ease-in-out infinite;
    }

    @keyframes iconSwing {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-10deg); }
        75% { transform: rotate(10deg); }
    }

    .info-text {
        font-size: 12px;
        color: #1e40af;
        font-weight: 600;
        line-height: 1.6;
    }

    /* Footer */
    .login-footer-siswa {
        text-align: center;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 3px solid #e0e7ff;
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    /* Responsive */
    @media (max-width: 968px) {
        .login-container-siswa {
            grid-template-columns: 1fr;
            max-width: 480px;
        }

        .login-illustration {
            display: none;
        }

        .login-form-section {
            padding: 48px 40px;
        }
    }

    @media (max-width: 640px) {
        .login-siswa-container {
            padding: 20px 16px;
        }

        .login-form-section {
            padding: 36px 28px;
        }

        .form-title {
            font-size: 26px;
        }
    }
</style>

<div class="login-siswa-container">
    
    <!-- Particles -->
    <div id="particles"></div>

    <!-- Login Container - 2 Panel -->
    <div class="login-container-siswa">
        
        <!-- LEFT SIDE - ROBOT CHARACTER -->
        <div class="login-illustration">
            <div class="character-container" id="characterContainer">
                <!-- Robot Body -->
                <div class="robot-body">
                    <!-- Arms -->
                    <div class="robot-arm left" id="leftArm">
                        <div class="robot-hand"></div>
                    </div>
                    <div class="robot-arm right" id="rightArm">
                        <div class="robot-hand"></div>
                    </div>

                    <!-- Chest Panel -->
                    <div class="robot-chest">
                        <div class="chest-indicator"></div>
                        <div class="chest-indicator"></div>
                        <div class="chest-indicator"></div>
                        <div class="robot-heart">❤️</div>
                    </div>
                </div>

                <!-- Robot Head -->
                <div class="robot-head" id="robotHead">
                    <!-- Antenna -->
                    <div class="robot-antenna"></div>

                    <!-- Face Screen -->
                    <div class="robot-face">
                        <!-- Eyes -->
                        <div class="robot-eyes">
                            <div class="robot-eye" id="leftEye">
                                <div class="robot-pupil" id="leftPupil"></div>
                            </div>
                            <div class="robot-eye" id="rightEye">
                                <div class="robot-pupil" id="rightPupil"></div>
                            </div>
                        </div>

                        <!-- Mouth -->
                        <div class="robot-mouth" id="robotMouth"></div>
                    </div>
                </div>
            </div>

            <h1 class="illustration-title">Absensi Cepat<br>dengan QR Code</h1>
            <p class="illustration-description">
                Sistem absensi modern yang mudah, cepat, dan akurat untuk siswa
            </p>
        </div>

        <!-- RIGHT SIDE - LOGIN FORM -->
        <div class="login-form-section">
            <div class="form-header">
                <span class="welcome-badge">
                    🎓 Portal Siswa
                </span>
                <h2 class="form-title">Selamat Datang!</h2>
                <p class="form-subtitle">Silakan masuk untuk melakukan absensi</p>
            </div>

            <!-- Error Alert -->
            @if(session('error'))
            <div class="error-alert-siswa">
                <span style="font-size: 24px;">⚠️</span>
                <div>
                    <div style="font-size: 15px; font-weight: 900; margin-bottom: 4px;">Login Gagal!</div>
                    <div style="font-size: 13px;">{{ session('error') }}</div>
                </div>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.siswa.process') }}" method="POST" id="loginForm">
                @csrf

                <div class="form-group-siswa">
                    <label class="form-label">👤 Nama Lengkap</label>
                    <div class="input-wrapper">
                        <span class="input-icon-siswa">👤</span>
                        <input
                            type="text"
                            name="nama"
                            id="namaInput"
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama lengkap Anda"
                            class="form-input-siswa"
                            required
                            autofocus>
                        <div class="input-glow"></div>
                    </div>
                </div>

                <div class="form-group-siswa">
                    <label class="form-label">🔒 Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon-siswa">🔒</span>
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="Masukkan password Anda"
                            class="form-input-siswa"
                            required>
                        <div class="input-glow"></div>
                    </div>
                </div>

                <!-- Device ID -->
                <input type="hidden" name="device_id" id="device_id">

                <button type="submit" class="submit-btn-siswa" id="submitBtn">
                    <span style="font-size: 22px;">📱</span>
                    <span>Mulai Absen</span>
                </button>
            </form>

            <!-- Info Box -->
            <div class="info-box">
                <div class="info-icon">💡</div>
                <div>
                    <div class="info-text">
                        <strong>Tips:</strong> Gunakan nama lengkap yang terdaftar dan password dari admin. 
                        Sistem akan mendeteksi perangkat Anda secara otomatis.
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="login-footer-siswa">
                <span style="font-size: 18px;">🔐</span>
                <span>Sistem terenkripsi & aman</span>
            </div>
        </div>

    </div>
</div>

<script>
// Generate device_id
if (!localStorage.getItem("device_id")) {
    localStorage.setItem("device_id", crypto.randomUUID());
}
document.getElementById("device_id").value = localStorage.getItem("device_id");

// Create particles
function createParticles() {
    const container = document.getElementById('particles');
    if (!container) return;
    
    for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 15 + 's';
        particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
        container.appendChild(particle);
    }
}
createParticles();

// ========== ROBOT INTERACTIONS ==========
const leftPupil = document.getElementById('leftPupil');
const rightPupil = document.getElementById('rightPupil');
const leftEye = document.getElementById('leftEye');
const rightEye = document.getElementById('rightEye');
const leftArm = document.getElementById('leftArm');
const rightArm = document.getElementById('rightArm');
const robotHead = document.getElementById('robotHead');
const robotMouth = document.getElementById('robotMouth');
const characterContainer = document.getElementById('characterContainer');
const namaInput = document.getElementById('namaInput');
const passwordInput = document.getElementById('passwordInput');
const submitBtn = document.getElementById('submitBtn');
const loginForm = document.getElementById('loginForm');

let isPasswordFocused = false;
let eyeBlinkInterval;

// Check if elements exist
if (!leftPupil || !rightPupil || !leftEye || !rightEye) {
    console.error('Robot elements not found');
}

// ========== AUTO EYE BLINK ==========
function startEyeBlink() {
    eyeBlinkInterval = setInterval(() => {
        if (!isPasswordFocused) {
            blinkEyes();
        }
    }, Math.random() * 3000 + 2500);
}

function blinkEyes() {
    if (!leftEye || !rightEye) return;
    
    leftEye.style.transform = 'scaleY(0.1)';
    rightEye.style.transform = 'scaleY(0.1)';
    
    setTimeout(() => {
        leftEye.style.transform = 'scaleY(1)';
        rightEye.style.transform = 'scaleY(1)';
    }, 150);
}

startEyeBlink();

// ========== EYES FOLLOW MOUSE ==========
document.addEventListener('mousemove', (e) => {
    if (isPasswordFocused || !leftPupil || !rightPupil) return;
    
    const pupils = [leftPupil, rightPupil];
    pupils.forEach((pupil) => {
        const eye = pupil.closest('.robot-eye');
        if (!eye) return;
        
        const eyeRect = eye.getBoundingClientRect();
        const eyeCenterX = eyeRect.left + eyeRect.width / 2;
        const eyeCenterY = eyeRect.top + eyeRect.height / 2;
        
        const angle = Math.atan2(e.clientY - eyeCenterY, e.clientX - eyeCenterX);
        const distance = Math.min(8, Math.hypot(e.clientX - eyeCenterX, e.clientY - eyeCenterY) / 40);
        
        const pupilX = Math.cos(angle) * distance;
        const pupilY = Math.sin(angle) * distance;
        
        pupil.style.transform = `translate(calc(-50% + ${pupilX}px), calc(-50% + ${pupilY}px))`;
    });
});

// ========== HAPPY NOD + SMILE WHEN TYPING NAME ==========
let typingTimeout;

if (namaInput) {
    namaInput.addEventListener('input', () => {
        clearTimeout(typingTimeout);
        
        // Happy animations
        if (robotHead) robotHead.classList.add('nodding');
        if (robotMouth) robotMouth.classList.add('smile');
        if (characterContainer) characterContainer.classList.add('excited');
        
        // Wave right arm
        if (rightArm) {
            rightArm.classList.add('wave');
            setTimeout(() => rightArm.classList.remove('wave'), 600);
        }
        
        // Blink happily
        blinkEyes();
        
        typingTimeout = setTimeout(() => {
            if (robotHead) robotHead.classList.remove('nodding');
            if (characterContainer) characterContainer.classList.remove('excited');
        }, 600);
        
        setTimeout(() => {
            if (robotMouth && !namaInput.matches(':focus')) {
                robotMouth.classList.remove('smile');
            }
        }, 2500);
    });

    // Keep smile while focused on name input
    namaInput.addEventListener('focus', () => {
        if (robotMouth) robotMouth.classList.add('smile');
        setTimeout(blinkEyes, 300);
    });

    namaInput.addEventListener('blur', () => {
        setTimeout(() => {
            if (robotMouth && !namaInput.value) {
                robotMouth.classList.remove('smile');
            }
        }, 500);
    });
}

// ========== COVER EYES WHEN PASSWORD FOCUSED - FIXED ==========
if (passwordInput) {
    passwordInput.addEventListener('focus', () => {
        isPasswordFocused = true;
        
        // Dim eyes smoothly
        if (leftEye) {
            leftEye.style.background = '#334155';
            leftEye.style.boxShadow = '0 0 5px rgba(51, 65, 85, 0.3)';
        }
        if (rightEye) {
            rightEye.style.background = '#334155';
            rightEye.style.boxShadow = '0 0 5px rgba(51, 65, 85, 0.3)';
        }
        if (leftPupil) leftPupil.style.opacity = '0';
        if (rightPupil) rightPupil.style.opacity = '0';
        
        // Arms cover eyes smoothly
        if (leftArm) leftArm.classList.add('cover');
        if (rightArm) rightArm.classList.add('cover');
        
        // Remove smile
        if (robotMouth) robotMouth.classList.remove('smile');
    });

    passwordInput.addEventListener('blur', () => {
        isPasswordFocused = false;
        
        // Remove cover classes
        if (leftArm) leftArm.classList.remove('cover');
        if (rightArm) rightArm.classList.remove('cover');
        
        // Show eyes again with smooth transition
        setTimeout(() => {
            if (leftEye) {
                leftEye.style.background = '#667eea';
                leftEye.style.boxShadow = '0 0 20px rgba(102, 126, 234, 0.8), inset 0 2px 8px rgba(255, 255, 255, 0.3)';
            }
            if (rightEye) {
                rightEye.style.background = '#667eea';
                rightEye.style.boxShadow = '0 0 20px rgba(102, 126, 234, 0.8), inset 0 2px 8px rgba(255, 255, 255, 0.3)';
            }
            if (leftPupil) leftPupil.style.opacity = '1';
            if (rightPupil) rightPupil.style.opacity = '1';
            
            // Happy blink after revealing
            setTimeout(blinkEyes, 200);
        }, 500);
    });
}

// ========== EXCITED WHEN CLICKING SUBMIT ==========
if (submitBtn) {
    submitBtn.addEventListener('click', (e) => {
        if (characterContainer) characterContainer.classList.add('excited');
        if (robotMouth) robotMouth.classList.add('smile');
        
        // Both arms wave
        if (leftArm) leftArm.classList.add('wave');
        if (rightArm) rightArm.classList.add('wave');
        
        // Multiple happy blinks
        setTimeout(blinkEyes, 100);
        setTimeout(blinkEyes, 400);
        
        setTimeout(() => {
            if (leftArm) leftArm.classList.remove('wave');
            if (rightArm) rightArm.classList.remove('wave');
        }, 600);
    });
}

// ========== SMILE ON FORM HOVER ==========
if (loginForm) {
    loginForm.addEventListener('mouseenter', () => {
        if (!isPasswordFocused && robotMouth) {
            robotMouth.classList.add('smile');
            blinkEyes();
        }
    });

    loginForm.addEventListener('mouseleave', () => {
        if (robotMouth && namaInput && !namaInput.matches(':focus')) {
            setTimeout(() => {
                robotMouth.classList.remove('smile');
            }, 500);
        }
    });
}
</script>

@endsection