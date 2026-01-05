@extends('layouts.main')
@section('title', 'Login Siswa | Sistem Absensi QR')

@section('content')
<style>
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

    /* Character Container */
    .character-container {
        position: relative;
        width: 280px;
        height: 280px;
        margin-bottom: 32px;
        animation: characterFloat 4s ease-in-out infinite;
    }

    @keyframes characterFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }

    /* Character - Bear Body */
    .character-bear {
        width: 200px;
        height: 220px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border-radius: 45% 45% 40% 40%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .character-bear.excited {
        animation: bearExcited 0.5s ease;
    }

    @keyframes bearExcited {
        0%, 100% { transform: translate(-50%, -50%) scale(1); }
        25% { transform: translate(-50%, -50%) scale(1.05) rotate(-5deg); }
        75% { transform: translate(-50%, -50%) scale(1.05) rotate(5deg); }
    }

    /* Bear Ears */
    .bear-ear {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border-radius: 50%;
        position: absolute;
        top: -20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .bear-ear.left {
        left: 10px;
        animation: earWiggle 2s ease-in-out infinite;
    }

    .bear-ear.right {
        right: 10px;
        animation: earWiggle 2s ease-in-out infinite 0.5s;
    }

    @keyframes earWiggle {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(10deg); }
    }

    .bear-ear-inner {
        width: 35px;
        height: 35px;
        background: #fde68a;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Bear Face */
    .bear-face {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 160px;
        height: 140px;
    }

    /* Bear Eyes Container */
    .bear-eyes {
        position: absolute;
        top: 30px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        display: flex;
        justify-content: space-between;
    }

    /* Individual Eye */
    .bear-eye {
        width: 45px;
        height: 50px;
        background: white;
        border-radius: 50% 50% 45% 45%;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
    }

    /* Eyelid for blinking */
    .bear-eyelid {
        position: absolute;
        top: -50px;
        left: 0;
        right: 0;
        height: 50px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border-radius: 50% 50% 45% 45%;
        transition: top 0.15s ease;
        z-index: 2;
    }

    /* Blinking animation */
    .bear-eye.blinking .bear-eyelid {
        top: 0;
    }

    /* Bear Pupil */
    .bear-pupil {
        width: 20px;
        height: 20px;
        background: #1e293b;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.15s ease;
        box-shadow: 
            0 0 0 3px #4338ca,
            inset -3px -3px 5px rgba(0, 0, 0, 0.3);
        z-index: 1;
    }

    .bear-pupil::after {
        content: '';
        width: 7px;
        height: 7px;
        background: white;
        border-radius: 50%;
        position: absolute;
        top: 3px;
        left: 4px;
        animation: sparkle 3s ease-in-out infinite;
    }

    @keyframes sparkle {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(0.9); }
    }

    /* Bear Hands - NATURAL & CUTE */
    .bear-hand {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border-radius: 50%;
        position: absolute;
        top: 20px;
        opacity: 0;
        transform: scale(0) translateY(30px);
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
        z-index: 10;
    }

    .bear-hand.left {
        left: -5px;
        rotate: -15deg;
    }

    .bear-hand.right {
        right: -5px;
        rotate: 15deg;
    }

    .bear-hand.show {
        opacity: 1;
        transform: scale(1) translateY(0);
    }

    /* Hand Palm Center */
    .hand-pad {
        width: 28px;
        height: 28px;
        background: #fde68a;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Hand Fingers - NATURAL LOOK */
    .hand-finger {
        width: 12px;
        height: 18px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border-radius: 40% 40% 50% 50%;
        position: absolute;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Finger positioning for natural hand look */
    .bear-hand.left .hand-finger:nth-child(2) { 
        top: -8px; 
        left: 2px;
        height: 16px;
        rotate: -25deg;
    }
    .bear-hand.left .hand-finger:nth-child(3) { 
        top: -10px; 
        left: 13px;
        height: 19px;
        rotate: -10deg;
    }
    .bear-hand.left .hand-finger:nth-child(4) { 
        top: -9px; 
        right: 12px;
        height: 17px;
        rotate: 5deg;
    }

    .bear-hand.right .hand-finger:nth-child(2) { 
        top: -8px; 
        right: 2px;
        height: 16px;
        rotate: 25deg;
    }
    .bear-hand.right .hand-finger:nth-child(3) { 
        top: -10px; 
        right: 13px;
        height: 19px;
        rotate: 10deg;
    }
    .bear-hand.right .hand-finger:nth-child(4) { 
        top: -9px; 
        left: 12px;
        height: 17px;
        rotate: -5deg;
    }

    /* Bear Nose */
    .bear-nose {
        width: 38px;
        height: 30px;
        background: #1e293b;
        border-radius: 50% 50% 45% 45%;
        position: absolute;
        top: 65px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        animation: noseWiggle 3s ease-in-out infinite;
    }

    @keyframes noseWiggle {
        0%, 100% { transform: translateX(-50%) scale(1); }
        50% { transform: translateX(-50%) scale(1.05); }
    }

    .bear-nose::before {
        content: '';
        width: 14px;
        height: 9px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        position: absolute;
        top: 5px;
        left: 7px;
    }

    /* Bear Mouth - CUTE & SIMPLE SMILE */
    .bear-mouth {
        width: 50px;
        height: 25px;
        border: 0;
        position: absolute;
        top: 90px;
        left: 50%;
        transform: translateX(-50%);
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Simple curve line for smile */
    .bear-mouth::before {
        content: '';
        width: 50px;
        height: 25px;
        border: 4px solid #1e293b;
        border-top: none;
        border-radius: 0 0 50% 50%;
        position: absolute;
        transition: all 0.4s ease;
    }

    /* Happy smile - wider and more curved */
    .bear-mouth.smile::before {
        width: 70px;
        height: 35px;
        border-width: 4px;
        animation: happySmileBounce 0.5s ease;
    }

    @keyframes happySmileBounce {
        0% { 
            transform: scale(1) translateY(0); 
        }
        50% { 
            transform: scale(1.1) translateY(-2px); 
        }
        100% { 
            transform: scale(1) translateY(0); 
        }
    }

    /* Cute simple tongue - only shows when smiling */
    .bear-tongue {
        width: 20px;
        height: 12px;
        background: #f472b6;
        border-radius: 0 0 50% 50%;
        position: absolute;
        bottom: -2px;
        transform: translateY(10px) scale(0.5);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .bear-mouth.smile .bear-tongue {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    /* Smile Dimples */
    .bear-dimple {
        width: 8px;
        height: 8px;
        background: rgba(0, 0, 0, 0.15);
        border-radius: 50%;
        position: absolute;
        top: 88px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .bear-dimple.left { left: 15px; }
    .bear-dimple.right { right: 15px; }

    .bear-mouth.smile ~ .bear-dimple {
        opacity: 1;
    }

    /* Bear Cheeks - ENHANCED */
    .bear-cheek {
        width: 50px;
        height: 38px;
        background: rgba(251, 146, 60, 0.35);
        border-radius: 50%;
        position: absolute;
        top: 68px;
        transition: all 0.3s ease;
        animation: cheekGlow 3s ease-in-out infinite;
    }

    .bear-cheek.left { left: -12px; }
    .bear-cheek.right { right: -12px; }

    @keyframes cheekGlow {
        0%, 100% { 
            background: rgba(251, 146, 60, 0.35);
            transform: scale(1);
        }
        50% { 
            background: rgba(251, 146, 60, 0.5);
            transform: scale(1.08);
        }
    }

    /* Enhanced cheeks when happy */
    .bear-mouth.smile ~ .bear-cheek {
        background: rgba(251, 146, 60, 0.6);
        transform: scale(1.15);
    }

    /* Bear Belly */
    .bear-belly {
        width: 120px;
        height: 100px;
        background: #fde68a;
        border-radius: 50%;
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        animation: bellyBreathe 3s ease-in-out infinite;
    }

    @keyframes bellyBreathe {
        0%, 100% { transform: translateX(-50%) scale(1, 1); }
        50% { transform: translateX(-50%) scale(1.02, 0.98); }
    }

    /* Happy Jump Animation */
    .character-container.happy {
        animation: happyJump 0.6s ease;
    }

    @keyframes happyJump {
        0%, 100% { transform: translateY(0); }
        30% { transform: translateY(-25px) scale(1.05); }
        50% { transform: translateY(-30px) scale(1.05); }
        70% { transform: translateY(-10px) scale(0.98); }
    }

    /* Nodding Animation */
    .character-bear.nodding {
        animation: happyNod 0.6s ease;
    }

    @keyframes happyNod {
        0%, 100% { 
            transform: translate(-50%, -50%) rotateX(0deg); 
        }
        25% { 
            transform: translate(-50%, -48%) rotateX(12deg) scale(1.02); 
        }
        75% { 
            transform: translate(-50%, -52%) rotateX(-8deg) scale(1.02); 
        }
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
        
        <!-- LEFT SIDE - CHARACTER ILLUSTRATION -->
        <div class="login-illustration">
            <div class="character-container" id="characterContainer">
                <!-- Bear Character -->
                <div class="character-bear" id="bearBody">
                    <!-- Ears -->
                    <div class="bear-ear left">
                        <div class="bear-ear-inner"></div>
                    </div>
                    <div class="bear-ear right">
                        <div class="bear-ear-inner"></div>
                    </div>

                    <!-- Belly -->
                    <div class="bear-belly"></div>

                    <!-- Face -->
                    <div class="bear-face">
                        <!-- Eyes with Eyelids -->
                        <div class="bear-eyes" id="bearEyes">
                            <div class="bear-eye" id="leftEye">
                                <div class="bear-eyelid"></div>
                                <div class="bear-pupil" id="leftPupil"></div>
                            </div>
                            <div class="bear-eye" id="rightEye">
                                <div class="bear-eyelid"></div>
                                <div class="bear-pupil" id="rightPupil"></div>
                            </div>
                        </div>

                        <!-- Hands for covering eyes -->
                        <div class="bear-hand left" id="leftHand">
                            <div class="hand-pad"></div>
                            <div class="hand-finger"></div>
                            <div class="hand-finger"></div>
                            <div class="hand-finger"></div>
                        </div>
                        <div class="bear-hand right" id="rightHand">
                            <div class="hand-pad"></div>
                            <div class="hand-finger"></div>
                            <div class="hand-finger"></div>
                            <div class="hand-finger"></div>
                        </div>

                        <!-- Cheeks -->
                        <div class="bear-cheek left"></div>
                        <div class="bear-cheek right"></div>

                        <!-- Nose -->
                        <div class="bear-nose"></div>

                        <!-- Simple cute mouth -->
                        <div class="bear-mouth" id="bearMouth">
                            <div class="bear-tongue"></div>
                        </div>

                        <!-- Dimples -->
                        <div class="bear-dimple left"></div>
                        <div class="bear-dimple right"></div>
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

// ========== CHARACTER INTERACTIONS ==========
const leftPupil = document.getElementById('leftPupil');
const rightPupil = document.getElementById('rightPupil');
const leftEye = document.getElementById('leftEye');
const rightEye = document.getElementById('rightEye');
const bearEyes = document.getElementById('bearEyes');
const leftHand = document.getElementById('leftHand');
const rightHand = document.getElementById('rightHand');
const bearBody = document.getElementById('bearBody');
const bearMouth = document.getElementById('bearMouth');
const characterContainer = document.getElementById('characterContainer');
const namaInput = document.getElementById('namaInput');
const passwordInput = document.getElementById('passwordInput');
const submitBtn = document.getElementById('submitBtn');

let isPasswordFocused = false;
let blinkInterval;

// ========== AUTO BLINKING ==========
function startBlinking() {
    blinkInterval = setInterval(() => {
        if (!isPasswordFocused) {
            blink();
        }
    }, Math.random() * 3000 + 2000); // Random blink every 2-5 seconds
}

function blink() {
    leftEye.classList.add('blinking');
    rightEye.classList.add('blinking');
    
    setTimeout(() => {
        leftEye.classList.remove('blinking');
        rightEye.classList.remove('blinking');
    }, 150);
}

// Start automatic blinking
startBlinking();

// ========== EYES FOLLOW MOUSE ==========
document.addEventListener('mousemove', (e) => {
    if (!isPasswordFocused) {
        const pupils = [leftPupil, rightPupil];
        pupils.forEach((pupil) => {
            const eye = pupil.parentElement;
            const eyeRect = eye.getBoundingClientRect();
            const eyeCenterX = eyeRect.left + eyeRect.width / 2;
            const eyeCenterY = eyeRect.top + eyeRect.height / 2;
            
            const angle = Math.atan2(e.clientY - eyeCenterY, e.clientX - eyeCenterX);
            const distance = Math.min(10, Math.hypot(e.clientX - eyeCenterX, e.clientY - eyeCenterY) / 30);
            
            const pupilX = Math.cos(angle) * distance;
            const pupilY = Math.sin(angle) * distance;
            
            pupil.style.transform = `translate(calc(-50% + ${pupilX}px), calc(-50% + ${pupilY}px))`;
        });
    }
});

// ========== HAPPY NOD + SMILE WHEN TYPING NAME ==========
let typingTimeout;
namaInput.addEventListener('input', () => {
    // Clear previous timeout
    clearTimeout(typingTimeout);
    
    // Add happy animations
    bearBody.classList.add('nodding');
    bearMouth.classList.add('smile');
    characterContainer.classList.add('happy');
    
    // Blink happily
    blink();
    
    // Remove animations after delay
    typingTimeout = setTimeout(() => {
        bearBody.classList.remove('nodding');
        characterContainer.classList.remove('happy');
    }, 600);
    
    setTimeout(() => {
        bearMouth.classList.remove('smile');
    }, 2000);
});

// Keep smile while typing
namaInput.addEventListener('focus', () => {
    bearMouth.classList.add('smile');
    setTimeout(blink, 300);
});

namaInput.addEventListener('blur', () => {
    setTimeout(() => {
        bearMouth.classList.remove('smile');
    }, 500);
});

// ========== COVER EYES WITH HANDS WHEN PASSWORD FOCUSED ==========
passwordInput.addEventListener('focus', () => {
    isPasswordFocused = true;
    
    // Hide pupils first
    leftPupil.style.opacity = '0';
    rightPupil.style.opacity = '0';
    
    // Show hands covering eyes
    setTimeout(() => {
        leftHand.classList.add('show');
        rightHand.classList.add('show');
    }, 150);
    
    // Remove smile
    bearMouth.classList.remove('smile');
});

passwordInput.addEventListener('blur', () => {
    isPasswordFocused = false;
    
    // Remove hands
    leftHand.classList.remove('show');
    rightHand.classList.remove('show');
    
    // Show pupils again
    setTimeout(() => {
        leftPupil.style.opacity = '1';
        rightPupil.style.opacity = '1';
        
        // Happy blink after revealing
        setTimeout(blink, 200);
    }, 400);
});

// ========== EXCITED WHEN CLICKING SUBMIT ==========
submitBtn.addEventListener('click', (e) => {
    bearBody.classList.add('excited');
    bearMouth.classList.add('smile');
    characterContainer.classList.add('happy');
    
    // Multiple happy blinks
    setTimeout(blink, 100);
    setTimeout(blink, 400);
});

// ========== SMILE ON FORM HOVER ==========
const loginForm = document.getElementById('loginForm');
loginForm.addEventListener('mouseenter', () => {
    if (!isPasswordFocused) {
        bearMouth.classList.add('smile');
    }
});

loginForm.addEventListener('mouseleave', () => {
    if (!namaInput.matches(':focus')) {
        setTimeout(() => {
            bearMouth.classList.remove('smile');
        }, 500);
    }
});
</script>

@endsection