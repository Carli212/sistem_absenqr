@extends('layouts.main')
@section('title', 'Absen Berhasil | Sistem Absensi QR')

@section('content')

<style>
body {
    margin: 0;
    overflow-x: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Success Container */
.success-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 24px;
    position: relative;
    overflow: hidden;
}

/* Animated Background Elements */
.bg-circle {
    position: absolute;
    border-radius: 50%;
    opacity: 0.08;
    animation: float 20s ease-in-out infinite;
}

.bg-circle-1 {
    width: 500px;
    height: 500px;
    background: white;
    top: -150px;
    left: -150px;
    animation-delay: 0s;
}

.bg-circle-2 {
    width: 350px;
    height: 350px;
    background: white;
    bottom: -100px;
    right: -100px;
    animation-delay: 5s;
}

.bg-circle-3 {
    width: 250px;
    height: 250px;
    background: white;
    top: 40%;
    right: 5%;
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% { 
        transform: translate(0, 0) scale(1);
    }
    33% { 
        transform: translate(30px, -30px) scale(1.1);
    }
    66% { 
        transform: translate(-20px, 20px) scale(0.9);
    }
}
 
/* Success Card */
.success-card {
    position: relative;
    z-index: 10;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    box-shadow: 
        0 20px 60px rgba(102, 126, 234, 0.3),
        0 0 1px rgba(255, 255, 255, 0.8) inset;
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 28px;
    max-width: 480px;
    width: 95%;
    padding: 48px 40px;
    text-align: center;
    animation: slideUp 0.6s ease;
    transition: all 0.3s ease;
}

.success-card:hover {
    box-shadow: 
        0 25px 70px rgba(102, 126, 234, 0.4),
        0 0 1px rgba(255, 255, 255, 0.8) inset;
    transform: translateY(-5px);
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Success Icon */
.success-icon-wrapper {
    width: 120px;
    height: 120px;
    margin: 0 auto 28px;
    position: relative;
    animation: iconPop 0.8s ease 0.3s both;
}

@keyframes iconPop {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.success-icon {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 64px;
    box-shadow: 
        0 12px 40px rgba(16, 185, 129, 0.4),
        0 0 0 8px rgba(16, 185, 129, 0.1);
    position: relative;
    animation: pulse 2s ease-in-out infinite 1.5s;
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 
            0 12px 40px rgba(16, 185, 129, 0.4),
            0 0 0 8px rgba(16, 185, 129, 0.1);
    }
    50% {
        box-shadow: 
            0 16px 50px rgba(16, 185, 129, 0.5),
            0 0 0 12px rgba(16, 185, 129, 0.15);
    }
}

/* Checkmark Animation */
.checkmark {
    display: inline-block;
    animation: checkmark 0.5s ease 0.8s both;
}

@keyframes checkmark {
    0% {
        transform: rotate(-45deg) scale(0);
    }
    100% {
        transform: rotate(0deg) scale(1);
    }
}

/* Success Title */
.success-title {
    font-size: 32px;
    font-weight: 900;
    background: linear-gradient(135deg, #10b981, #059669);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
    animation: fadeInUp 0.6s ease 0.4s both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Success Message */
.success-message {
    font-size: 16px;
    color: #64748b;
    font-weight: 600;
    line-height: 1.7;
    margin-bottom: 32px;
    animation: fadeInUp 0.6s ease 0.6s both;
}

/* Success Details */
.success-details {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    border: 2px solid #c4b5fd;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 32px;
    animation: fadeInUp 0.6s ease 0.8s both;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(102, 126, 234, 0.15);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-size: 13px;
    font-weight: 700;
    color: #4338ca;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
}

/* Button Primary */
.btn-primary {
    display: inline-block;
    padding: 16px 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 14px;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 24px rgba(102, 126, 234, 0.35);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-decoration: none;
    animation: fadeInUp 0.6s ease 1s both;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 32px rgba(102, 126, 234, 0.45);
}

.btn-primary:active {
    transform: translateY(-1px);
}

/* Confetti Animation */
.confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    background: #667eea;
    opacity: 0;
    animation: confettiFall 3s ease-out;
}

@keyframes confettiFall {
    0% {
        opacity: 1;
        transform: translateY(0) rotate(0deg);
    }
    100% {
        opacity: 0;
        transform: translateY(100vh) rotate(720deg);
    }
}

.confetti:nth-child(1) { left: 10%; background: #667eea; animation-delay: 0s; }
.confetti:nth-child(2) { left: 20%; background: #764ba2; animation-delay: 0.2s; }
.confetti:nth-child(3) { left: 30%; background: #10b981; animation-delay: 0.4s; }
.confetti:nth-child(4) { left: 40%; background: #f59e0b; animation-delay: 0.6s; }
.confetti:nth-child(5) { left: 50%; background: #ef4444; animation-delay: 0.8s; }
.confetti:nth-child(6) { left: 60%; background: #667eea; animation-delay: 1s; }
.confetti:nth-child(7) { left: 70%; background: #764ba2; animation-delay: 1.2s; }
.confetti:nth-child(8) { left: 80%; background: #10b981; animation-delay: 1.4s; }
.confetti:nth-child(9) { left: 90%; background: #f59e0b; animation-delay: 1.6s; }

/* Celebration Badge */
.celebration-badge {
    display: inline-block;
    padding: 10px 20px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 2px solid #fcd34d;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    color: #92400e;
    margin-top: 20px;
    animation: fadeInUp 0.6s ease 1.2s both;
}

/* Responsive */
@media (max-width: 640px) {
    .success-card {
        padding: 40px 28px;
    }

    .success-icon-wrapper {
        width: 100px;
        height: 100px;
    }

    .success-icon {
        font-size: 52px;
    }

    .success-title {
        font-size: 26px;
    }

    .success-message {
        font-size: 15px;
    }

    .btn-primary {
        padding: 14px 32px;
        font-size: 14px;
    }

    .bg-circle-1,
    .bg-circle-2,
    .bg-circle-3 {
        display: none;
    }
}
</style>

<div class="success-container">
    <!-- Background Circles -->
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
    <div class="bg-circle bg-circle-3"></div>

    <!-- Confetti -->
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>

    <!-- Success Card -->
    <div class="success-card">
        
        <!-- Success Icon -->
        <div class="success-icon-wrapper">
            <div class="success-icon">
                <span class="checkmark">✅</span>
            </div>
        </div>

        <!-- Success Title -->
        <h1 class="success-title">
            Absen Berhasil!
        </h1>

        <!-- Success Message -->
        <p class="success-message">
            Data absensi Anda sudah tercatat dengan sempurna. Jangan lupa semangat hari ini! 💪✨
        </p>

        <!-- Success Details -->
        <div class="success-details">
            <div class="detail-row">
                <span class="detail-label">📅 Tanggal</span>
                <span class="detail-value">
    {{ \Carbon\Carbon::parse($absen->waktu_absen)->translatedFormat('l, d F Y') }}
</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">⏰ Waktu</span>
                <span class="detail-value">
    {{ \Carbon\Carbon::parse($absen->waktu_absen)->format('H:i:s') }} WIB
</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">✅ Status</span>
                <span class="detail-value"
      style="color: {{ $absen->status === 'terlambat' ? '#f59e0b' : '#059669' }};">
    {{ strtoupper($absen->status) }}
</span>
            </div>
        </div>

        <!-- Dashboard Button -->
        <a href="{{ route('user.dashboard') }}" class="btn-primary">
            📊 Lihat Dashboard
        </a>

        <!-- Celebration Badge -->
        <div class="celebration-badge">
            🎉 Selamat! Anda tepat waktu!
        </div>

    </div>
</div>

<script>
// Set current date and time
document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    
    // Format date
    const dateOptions = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    const formattedDate = now.toLocaleDateString('id-ID', dateOptions);
    document.getElementById('current-date').textContent = formattedDate;
    
    // Format time
    const timeOptions = { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit',
        hour12: false
    };
    const formattedTime = now.toLocaleTimeString('id-ID', timeOptions) + ' WIB';
    document.getElementById('current-time').textContent = formattedTime;
});
</script>

@endsection