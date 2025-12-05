@extends('layouts.main')
@section('title', 'Scan QR | Sistem Absensi QR')

@section('content')

<style>
.scan-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
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
.scan-container::before {
    content: '';
    position: absolute;
    top: 10%;
    right: 10%;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, #FFE66D 0%, #FFB347 100%);
    border-radius: 50%;
    box-shadow: 0 0 50px rgba(255, 230, 109, 0.6);
    animation: sunshine 4s ease-in-out infinite;
    z-index: 0;
}

@keyframes sunshine {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.05); opacity: 0.9; }
}

/* Awan */
.cloud-scan {
    position: absolute;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 50px;
    z-index: 0;
}

.cloud-scan-1 {
    top: 12%;
    left: 8%;
    width: 160px;
    height: 45px;
    box-shadow: 
        60px 12px 0 -6px rgba(255, 255, 255, 0.6),
        110px 6px 0 -4px rgba(255, 255, 255, 0.5);
    animation: floatCloud 28s ease-in-out infinite;
}

.cloud-scan-2 {
    top: 20%;
    right: 15%;
    width: 130px;
    height: 38px;
    box-shadow: 
        50px 10px 0 -5px rgba(255, 255, 255, 0.6);
    animation: floatCloud 32s ease-in-out infinite;
    animation-delay: 4s;
}

@keyframes floatCloud {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(20px); }
}

/* Pegunungan */
.mountains-scan {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 30%;
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
.grass-scan {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 70px;
    background: linear-gradient(180deg, #5db07d 0%, #4a9668 100%);
    z-index: 0;
}

/* Scan Card */
.scan-card {
    position: relative;
    z-index: 10;
    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 20px 60px rgba(45, 95, 63, 0.25);
    border: 3px solid #a5d6a7;
    border-radius: 28px;
    max-width: 480px;
    width: 95%;
    padding: 40px 36px;
    text-align: center;
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

.scan-header {
    margin-bottom: 28px;
}

.scan-title {
    font-size: 26px;
    font-weight: 900;
    background: linear-gradient(135deg, #2d5f3f 0%, #4a9668 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

.scan-subtitle {
    font-size: 14px;
    color: #4a9668;
    font-weight: 600;
    line-height: 1.5;
}

/* Camera Area */
#reader {
    min-height: 300px;
    width: 100%;
    border-radius: 16px;
    overflow: hidden;
    border: 3px solid #81c784;
    box-shadow: 0 4px 16px rgba(74, 150, 104, 0.15);
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    margin-bottom: 20px;
}

#reader video {
    pointer-events: none !important;
    border-radius: 13px;
}

/* Status Text */
#status {
    margin-top: 16px;
    font-size: 14px;
    color: #2d5f3f;
    font-weight: 700;
    padding: 12px 20px;
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border-radius: 12px;
    border: 2px solid #a5d6a7;
}

/* Button Fallback */
.fallback-btn {
    padding: 12px 20px;
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border: 2px solid #a5d6a7;
    color: #2d5f3f;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    display: none;
    margin-top: 16px;
}

.fallback-btn:hover {
    background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 150, 104, 0.25);
}

/* Back Button */
.back-btn {
    position: relative;
    z-index: 50;
    margin-top: 28px;
    padding: 14px 32px;
    background: white;
    color: #2d5f3f;
    font-weight: 700;
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(45, 95, 63, 0.2);
    border: 3px solid #a5d6a7;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
    font-size: 15px;
    letter-spacing: 0.3px;
}

.back-btn:hover {
    background: #e8f5e9;
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(45, 95, 63, 0.3);
}

.back-btn:active {
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 640px) {
    .scan-card {
        padding: 32px 24px;
    }

    .scan-title {
        font-size: 24px;
    }

    #reader {
        min-height: 250px;
    }

    .mountains-scan {
        height: 25%;
    }

    .grass-scan {
        height: 50px;
    }

    .scan-container::before {
        width: 80px;
        height: 80px;
    }
}

/* SweetAlert Custom Style */
.swal2-popup {
    border: 3px solid #a5d6a7 !important;
    border-radius: 20px !important;
}

.swal2-confirm {
    background: linear-gradient(135deg, #4a9668 0%, #2d5f3f 100%) !important;
    border: none !important;
    border-radius: 10px !important;
    font-weight: 700 !important;
    padding: 12px 28px !important;
}

.swal2-title {
    color: #1b4332 !important;
    font-weight: 900 !important;
}
</style>

<div class="scan-container">
    <!-- Awan -->
    <div class="cloud-scan cloud-scan-1"></div>
    <div class="cloud-scan cloud-scan-2"></div>
    
    <!-- Pegunungan -->
    <div class="mountains-scan"></div>
    
    <!-- Rumput -->
    <div class="grass-scan"></div>

    <!-- Card Scan -->
    <div class="scan-card">
        
        <div class="scan-header">
            <h1 class="scan-title">📷 Scan Kode QR</h1>
            <p class="scan-subtitle">
                Arahkan kamera ke QR Code yang diberikan oleh admin untuk melakukan absensi
            </p>
        </div>

        <!-- Area Kamera -->
        <div id="reader"></div>

        <p id="status">🔍 Menunggu pemindaian...</p>

        <form id="scanForm" action="{{ route('user.scan.process') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="kode" id="kode">
        </form>

        <button id="btnFallback" class="fallback-btn">
            📁 Upload Gambar (Fallback)
        </button>
        <input type="file" id="filePicker" accept="image/*" class="hidden" />
    </div>

    <!-- Tombol Kembali -->
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

function startScanner() {
    statusEl.innerText = "🔍 Mencoba mengaktifkan kamera...";

    html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        onScanSuccess
    )
    .then(() => {
        statusEl.innerText = "📸 Kamera aktif, silakan arahkan ke QR Code";
    })
    .catch(err => {
        statusEl.innerText = "⚠️ Kamera tidak tersedia atau ditolak: " + err;
        document.getElementById('btnFallback').style.display = 'inline-block';
    });
}

function onScanSuccess(decodedText) {
    html5QrCode.stop().then(() => {
        statusEl.innerText = "🔍 QR terdeteksi, memproses...";
        postCode(decodedText);
    }).catch(e => {
        statusEl.innerText = "🔍 QR terdeteksi (error stop), memproses...";
        postCode(decodedText);
    });
}

function postCode(kode) {
    fetch("{{ route('user.scan.process') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ kode: kode })
    })
    .then(res => res.text())
    .then(html => {
        if (html.includes('Kode QR tidak valid') || html.includes('kadaluwarsa')) {
            Swal.fire({
                icon: 'error',
                title: '❌ QR Tidak Valid',
                text: 'Kode QR tidak valid atau sudah kedaluwarsa.',
                confirmButtonText: '🔁 Scan Ulang',
                background: '#ffffff',
                color: '#1b4332',
                allowOutsideClick: false,
            }).then(() => startScanner());
        } else if (html.includes('Kamu sudah absen')) {
            Swal.fire({
                icon: 'info',
                title: '⚠️ Sudah Absen',
                text: 'Kamu sudah melakukan absensi hari ini.',
                confirmButtonText: 'Oke',
                background: '#ffffff',
                color: '#1b4332',
            }).then(() => {
                window.location.href = "{{ route('user.dashboard') }}";
            });
        } else if (html.includes('OK')) {
            Swal.fire({
                icon: 'success',
                title: '✅ Absensi Berhasil!',
                text: 'Data absensi Anda telah disimpan.',
                confirmButtonText: 'Lanjut ke Dashboard',
                background: '#ffffff',
                color: '#1b4332',
            }).then(() => {
                window.location.href = "{{ route('user.dashboard') }}";
            });
        } else {
            Swal.fire('Info', html, 'info').then(() => startScanner());
        }
    })
    .catch(err => {
        Swal.fire('Error', 'Terjadi kesalahan koneksi: ' + err, 'error');
        startScanner();
    });
}

/* Fallback: upload file -> decode */
document.getElementById('btnFallback').addEventListener('click', () => {
    document.getElementById('filePicker').click();
});

document.getElementById('filePicker').addEventListener('change', function(e) {
    const file = this.files[0];
    if (!file) return;

    statusEl.innerText = '🔍 Menganalisis gambar...';

    Html5Qrcode.getCameras();

    Html5Qrcode.scanFileInBrowser(file, true)
    .then(decodedText => {
        statusEl.innerText = '✅ QR terdeteksi dari gambar';
        postCode(decodedText);
    })
    .catch(err => {
        statusEl.innerText = '⚠️ Tidak ada QR yang terdeteksi di gambar: ' + err;
        Swal.fire('Tidak ada QR', 'Gambar tidak mengandung QR code yang valid.', 'error');
    });
});

window.addEventListener('load', startScanner);
</script>

@endsection