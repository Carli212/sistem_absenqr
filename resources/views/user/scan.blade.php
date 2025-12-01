@extends('layouts.main')
@section('title', 'Scan QR | Sistem Absensi QR')

@section('content')

<div id="scan-page" 
     class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-sky-500 via-blue-500 to-indigo-600 relative overflow-hidden text-gray-900">

    <!-- Cahaya lembut background -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.2),transparent_70%)] pointer-events-none"></div>

    <!-- Card utama -->
    <div class="relative z-10 bg-white/95 shadow-2xl border border-blue-200 rounded-3xl max-w-md w-[90%] text-center p-8">
        
        <h1 class="text-2xl font-extrabold mb-3 text-blue-700 drop-shadow">📷 Scan Kode QR</h1>

        <p class="text-sm text-gray-600 mb-6 font-medium leading-relaxed">
            Arahkan kamera ke QR Code yang diberikan oleh admin untuk melakukan absensi.
        </p>

        <!-- Area Kamera -->
        <div 
            id="reader"
            style="min-height: 280px;"
            class="w-full h-64 rounded-xl overflow-hidden border-2 border-blue-400 shadow-inner bg-gray-100">
        </div>

        <p id="status" class="mt-4 text-sm text-gray-700 font-semibold">
            🔍 Menunggu pemindaian...
        </p>

        <form id="scanForm" action="{{ route('user.scan.process') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="kode" id="kode">
        </form>

        <div class="mt-4 flex items-center justify-center gap-3">
            <button id="btnFallback" class="px-3 py-2 bg-gray-100 rounded-lg text-sm">📁 Upload Gambar (Fallback)</button>
            <input type="file" id="filePicker" accept="image/*" class="hidden" />
        </div>
    </div>

    <!-- Tombol kembali -->
    <div class="relative z-50 mt-8">
        <a href="{{ route('login.siswa.show') }}"
        class="back-button inline-block bg-white text-blue-700 font-semibold px-8 py-3 rounded-xl shadow-lg 
                hover:bg-blue-100 hover:shadow-xl active:scale-[0.97] transition-all duration-300 text-sm tracking-wide">
            ⬅️ Kembali ke Login
        </a>
    </div>

</div>

<!-- Script QR + SweetAlert -->
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let html5QrCode;
const statusEl = document.getElementById('status');

function startScanner() {
    // clear previous
    statusEl.innerText = "🔍 Mencoba mengaktifkan kamera...";

    html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        onScanSuccess
    )
    .then(() => {
        statusEl.innerText = "📸 Kamera aktif, silakan arahkan ke QR Code.";
    })
    .catch(err => {
        statusEl.innerText = "⚠️ Kamera tidak tersedia atau ditolak: " + err;
        // biarkan tombol fallback muncul (upload)
        document.getElementById('btnFallback').style.display = 'inline-block';
    });
}

function onScanSuccess(decodedText) {
    // stop camera dan proses
    html5QrCode.stop().then(() => {
        statusEl.innerText = "🔍 QR terdeteksi, memproses...";
        postCode(decodedText);
    }).catch(e => {
        // jika gagal stop, tetap coba post
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
                confirmButtonColor: '#2563eb',
                background: '#f9fafb',
                color: '#1e293b',
                allowOutsideClick: false,
            }).then(() => startScanner());
        } else if (html.includes('Kamu sudah absen')) {
            Swal.fire({
                icon: 'info',
                title: '⚠️ Sudah Absen',
                text: 'Kamu sudah melakukan absensi hari ini.',
                confirmButtonText: 'Oke',
                confirmButtonColor: '#2563eb',
                background: '#f9fafb',
                color: '#1e293b',
            }).then(() => {
                window.location.href = "{{ route('user.dashboard') }}";
            });
        } else if (html.includes('OK')) {
            Swal.fire({
                icon: 'success',
                title: '✅ Absensi Berhasil!',
                text: 'Data absensi Anda telah disimpan.',
                confirmButtonText: 'Lanjut ke Dashboard',
                confirmButtonColor: '#16a34a',
                background: '#f9fafb',
                color: '#1e293b',
            }).then(() => {
                window.location.href = "{{ route('user.dashboard') }}";
            });
        } else {
            // fallback generic
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

    Html5Qrcode.getCameras(); // ensure lib loaded

    // html5-qrcode supports scanFileInBrowser
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

// start scanner ketika halaman load
window.addEventListener('load', startScanner);
</script>

<style>
#reader video { pointer-events: none !important; }
#reader { position: relative; z-index: 5; }
.back-button { position: relative; z-index: 50 !important; }
#btnFallback { display: none; } /* tampilkan hanya kalau kamera gagal */
</style>

@endsection
