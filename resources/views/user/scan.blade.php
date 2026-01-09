@extends('layouts.main')
@section('title', 'Scan QR | Sistem Absensi QR')

@section('content')

<style>
body {
    margin: 0;
    overflow-x: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Scan Container */
.scan-container {
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
    opacity: 0.1;
    animation: float 20s ease-in-out infinite;
}

.bg-circle-1 {
    width: 400px;
    height: 400px;
    background: white;
    top: -100px;
    left: -100px;
    animation-delay: 0s;
}

.bg-circle-2 {
    width: 300px;
    height: 300px;
    background: white;
    bottom: -50px;
    right: -50px;
    animation-delay: 5s;
}

.bg-circle-3 {
    width: 200px;
    height: 200px;
    background: white;
    top: 50%;
    right: 10%;
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

/* Scan Card */
.scan-card {
    position: relative;
    z-index: 10;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    box-shadow: 
        0 20px 60px rgba(102, 126, 234, 0.3),
        0 0 1px rgba(255, 255, 255, 0.8) inset;
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 28px;
    max-width: 520px;
    width: 95%;
    padding: 44px 40px;
    text-align: center;
    animation: slideUp 0.6s ease;
    transition: all 0.3s ease;
}

.scan-card:hover {
    box-shadow: 
        0 25px 70px rgba(102, 126, 234, 0.4),
        0 0 1px rgba(255, 255, 255, 0.8) inset;
    transform: translateY(-5px);
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Scan Header */
.scan-header {
    margin-bottom: 32px;
}

.scan-title {
    font-size: 32px;
    font-weight: 900;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.scan-subtitle {
    font-size: 15px;
    color: #64748b;
    font-weight: 600;
    line-height: 1.6;
    max-width: 400px;
    margin: 0 auto;
}

/* Camera Area */
#reader {
    min-height: 320px;
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    border: 3px solid #c4b5fd;
    box-shadow: 
        0 8px 32px rgba(102, 126, 234, 0.2),
        0 0 0 1px rgba(102, 126, 234, 0.1) inset;
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    margin-bottom: 24px;
    position: relative;
    transition: all 0.3s ease;
}

#reader:hover {
    border-color: #a78bfa;
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
}

#reader video {
    pointer-events: none !important;
    border-radius: 17px;
}

/* Scanning Animation Overlay */
.scan-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    z-index: 5;
}

.scan-line {
    position: absolute;
    left: 10%;
    right: 10%;
    height: 2px;
    background: linear-gradient(90deg, 
        transparent 0%, 
        #667eea 50%, 
        transparent 100%);
    box-shadow: 0 0 10px rgba(102, 126, 234, 0.8);
    animation: scanning 2s ease-in-out infinite;
}

@keyframes scanning {
    0% { top: 10%; opacity: 0; }
    50% { opacity: 1; }
    100% { top: 90%; opacity: 0; }
}

/* Status Text */
#status {
    margin-top: 20px;
    font-size: 15px;
    color: #1e293b;
    font-weight: 700;
    padding: 14px 24px;
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    border-radius: 14px;
    border: 2px solid #c4b5fd;
    display: inline-block;
    min-width: 280px;
    transition: all 0.3s ease;
}

#status:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
}

/* Status Icons Animation */
.status-processing {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
}

/* Button Fallback */
.fallback-btn {
    padding: 14px 28px;
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    border: 2px solid #c4b5fd;
    color: #4338ca;
    border-radius: 14px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: none;
    margin-top: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.fallback-btn:hover {
    background: linear-gradient(135deg, #c7d2fe 0%, #a78bfa 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}

.fallback-btn:active {
    transform: translateY(0);
}

/* Back Button */
.back-btn {
    position: relative;
    z-index: 50;
    margin-top: 32px;
    padding: 16px 36px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    color: #4338ca;
    font-weight: 700;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.25);
    border: 2px solid rgba(255, 255, 255, 0.5);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    font-size: 15px;
    letter-spacing: 0.3px;
}

.back-btn:hover {
    background: white;
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(102, 126, 234, 0.35);
    border-color: #c4b5fd;
}

.back-btn:active {
    transform: translateY(-1px);
}

/* Info Badge */
.info-badge {
    display: inline-block;
    padding: 8px 16px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 2px solid #fcd34d;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    color: #92400e;
    margin-top: 16px;
    animation: slideUp 0.8s ease;
}

/* Camera Corner Decorations */
.camera-corner {
    position: absolute;
    width: 40px;
    height: 40px;
    border: 3px solid #8b5cf6;
    pointer-events: none;
    opacity: 0.6;
}

.corner-tl {
    top: 10px;
    left: 10px;
    border-right: none;
    border-bottom: none;
    border-radius: 8px 0 0 0;
}

.corner-tr {
    top: 10px;
    right: 10px;
    border-left: none;
    border-bottom: none;
    border-radius: 0 8px 0 0;
}

.corner-bl {
    bottom: 10px;
    left: 10px;
    border-right: none;
    border-top: none;
    border-radius: 0 0 0 8px;
}

.corner-br {
    bottom: 10px;
    right: 10px;
    border-left: none;
    border-top: none;
    border-radius: 0 0 8px 0;
}

/* Responsive */
@media (max-width: 640px) {
    .scan-card {
        padding: 36px 28px;
    }

    .scan-title {
        font-size: 26px;
    }

    .scan-subtitle {
        font-size: 14px;
    }

    #reader {
        min-height: 280px;
    }

    .camera-corner {
        width: 30px;
        height: 30px;
    }

    .bg-circle-1,
    .bg-circle-2,
    .bg-circle-3 {
        display: none;
    }
}

/* SweetAlert Custom Style */
.swal2-popup {
    border: 3px solid #c4b5fd !important;
    border-radius: 24px !important;
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3) !important;
}

.swal2-confirm {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none !important;
    border-radius: 12px !important;
    font-weight: 700 !important;
    padding: 14px 32px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.swal2-confirm:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
}

.swal2-title {
    color: #1e293b !important;
    font-weight: 900 !important;
}

.swal2-html-container {
    color: #64748b !important;
    font-weight: 600 !important;
}

.swal2-icon {
    border-width: 3px !important;
}

/* Loading Animation */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(102, 126, 234, 0.3);
    border-radius: 50%;
    border-top-color: #667eea;
    animation: spin 1s ease-in-out infinite;
    margin-right: 8px;
    vertical-align: middle;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<div class="scan-container">
    <!-- Background Circles -->
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
    <div class="bg-circle bg-circle-3"></div>

    <!-- Scan Card -->
    <div class="scan-card">
        
        <div class="scan-header">
            <h1 class="scan-title">
                📷 Scan Kode QR
            </h1>
            <p class="scan-subtitle">
                Arahkan kamera ke QR Code yang diberikan oleh admin untuk melakukan absensi dengan cepat dan mudah
            </p>
        </div>

        <!-- Camera Area -->
        <div id="reader" style="position: relative;">
            <!-- Camera Corners -->
            <div class="camera-corner corner-tl"></div>
            <div class="camera-corner corner-tr"></div>
            <div class="camera-corner corner-bl"></div>
            <div class="camera-corner corner-br"></div>
            
            <!-- Scan Line -->
            <div class="scan-overlay">
                <div class="scan-line"></div>
            </div>
        </div>

        <p id="status">🔍 Menunggu pemindaian...</p>

        <div class="info-badge">
            💡 Pastikan QR Code terlihat jelas di kamera
        </div>

        <form id="scanForm" action="{{ route('user.scan.process') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="kode" id="kode">
        </form>

        <button id="btnFallback" class="fallback-btn">
            📁 Upload Gambar QR (Fallback)
        </button>
        <input type="file" id="filePicker" accept="image/*" class="hidden" />
    </div>

    <!-- Back Button -->
    <a href="{{ route('login.siswa.show') }}" class="back-btn">
        ⬅️ Kembali ke Login
    </a>

</div>

<!-- Script QR + SweetAlert -->
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let html5QrCode;
const statusEl = document.getElementById('status');

function updateStatus(text, isProcessing = false) {
    statusEl.innerHTML = text;
    statusEl.classList.toggle('status-processing', isProcessing);
}

function startScanner() {
    updateStatus('<span class="loading-spinner"></span>📸 Mengaktifkan kamera...', true);
    html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        onScanSuccess
    ).then(() => {
        updateStatus('📷 Kamera aktif, arahkan ke QR Code');
    }).catch(() => {
        updateStatus('⚠️ Kamera tidak tersedia atau tidak diizinkan');
        document.getElementById('btnFallback').style.display = 'inline-block';
    });
}

function onScanSuccess(decodedText) {
    html5QrCode.stop().catch(() => {});
    updateStatus('<span class="loading-spinner"></span>⏳ Memproses QR Code...', true);
    postCode(decodedText);
}

function postCode(kode) {
    fetch("{{ route('user.scan.process') }}", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            kode: kode,
            device_id: localStorage.getItem("device_id")
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success' || data.status === 'info') {
            Swal.fire({
                icon: data.status === 'success' ? 'success' : 'info',
                title: 'Informasi',
                text: data.message,
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "{{ route('user.success') }}";
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: '❌ Gagal',
                text: data.message,
                confirmButtonText: 'Coba Lagi',
                allowOutsideClick: false
            }).then(() => {
                updateStatus('🔍 Menunggu pemindaian...');
                startScanner();
            });
        }
    })
    .catch(() => {
        Swal.fire('❌ Error', 'Gagal terhubung ke server', 'error')
            .then(() => startScanner());
    });
}

// Fallback upload
document.getElementById('btnFallback').addEventListener('click', () => {
    document.getElementById('filePicker').click();
});

document.getElementById('filePicker').addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    updateStatus('<span class="loading-spinner"></span>📤 Memproses gambar...', true);
    html5QrCode.scanFile(file, true)
        .then(decodedText => postCode(decodedText))
        .catch(() => {
            Swal.fire('❌ Gagal', 'QR tidak terdeteksi', 'error');
            updateStatus('🔍 Menunggu pemindaian...');
        });
});

window.addEventListener('load', startScanner);
</script>

@endsection