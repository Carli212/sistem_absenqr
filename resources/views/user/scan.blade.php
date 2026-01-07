@extends('layouts.main')
@section('title', 'Scan QR | Sistem Absensi QR')

@section('content')

<style>
/* ==== (CSS KAMU TIDAK SAYA UBAH) ==== */
body {
    margin: 0;
    overflow-x: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
/* … SEMUA CSS KAMU TETAP … */
</style>

<div class="scan-container">
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
    <div class="bg-circle bg-circle-3"></div>

    <div class="scan-card">
        <div class="scan-header">
            <h1 class="scan-title">📷 Scan Kode QR</h1>
            <p class="scan-subtitle">
                Arahkan kamera ke QR Code yang diberikan admin
            </p>
        </div>

        <div id="reader" style="position: relative;">
            <div class="camera-corner corner-tl"></div>
            <div class="camera-corner corner-tr"></div>
            <div class="camera-corner corner-bl"></div>
            <div class="camera-corner corner-br"></div>

            <div class="scan-overlay">
                <div class="scan-line"></div>
            </div>
        </div>

        <p id="status">🔍 Menunggu pemindaian...</p>

        <div class="info-badge">
            💡 Pastikan QR Code terlihat jelas
        </div>

        <!-- MANUAL INPUT -->
        <div class="mt-6 w-full">
            <p class="text-sm font-semibold text-gray-600 mb-2">
                🔑 Atau masukkan kode QR manual
            </p>

            <div class="flex gap-2">
                <input
                    type="text"
                    id="manualKode"
                    placeholder="QR-XXXX"
                    class="flex-1 px-4 py-3 rounded-xl border-2 border-indigo-200
                           text-center uppercase font-bold tracking-widest"
                >
                <button
                    type="button"
                    id="btnManual"
                    class="px-5 py-3 rounded-xl bg-indigo-600 text-white font-bold"
                >
                    Kirim
                </button>
            </div>
        </div>

        <button id="btnFallback" class="fallback-btn">
            📁 Upload QR (Fallback)
        </button>
        <input type="file" id="filePicker" accept="image/*" class="hidden" />
    </div>

    <a href="{{ route('login.siswa.show') }}" class="back-btn">
        ⬅️ Kembali ke Login
    </a>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let html5QrCode = null;
const statusEl = document.getElementById('status');
let locked = false;

function updateStatus(text, loading = false) {
    statusEl.innerHTML = text;
    statusEl.classList.toggle('status-processing', loading);
}

function stopScanner() {
    if (html5QrCode) {
        html5QrCode.stop().catch(()=>{});
        html5QrCode = null;
    }
}

function startScanner() {
    if (locked) return;

    html5QrCode = new Html5Qrcode("reader");
    updateStatus("📸 Mengaktifkan kamera...", true);

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        decodedText => {
            stopScanner();
            submitCode(decodedText);
        }
    ).then(() => {
        updateStatus("📷 Kamera aktif");
    }).catch(() => {
        updateStatus("⚠️ Kamera tidak tersedia");
        document.getElementById('btnFallback').style.display = 'inline-block';
    });
}

function submitCode(kode) {
    if (locked) return;
    locked = true;

    updateStatus("⏳ Memproses QR...", true);

    fetch("{{ route('user.scan.process') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ kode })
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: data.status === 'success' ? 'success' : 'info',
            title: data.message,
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = "{{ route('user.dashboard') }}";
        });
    })
    .catch(() => {
        locked = false;
        updateStatus("❌ Error, coba lagi");
        startScanner();
    });
}

document.getElementById('btnManual').addEventListener('click', () => {
    const kode = document.getElementById('manualKode').value.trim();
    if (!kode) {
        Swal.fire('Kode kosong', 'Masukkan kode QR', 'warning');
        return;
    }
    stopScanner();
    submitCode(kode);
});

document.getElementById('filePicker').addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;

    stopScanner();
    html5QrCode = new Html5Qrcode("reader");
    html5QrCode.scanFile(file, true)
        .then(text => submitCode(text))
        .catch(() => Swal.fire('Gagal', 'QR tidak terbaca', 'error'));
});

window.addEventListener('load', startScanner);
</script>

@endsection
