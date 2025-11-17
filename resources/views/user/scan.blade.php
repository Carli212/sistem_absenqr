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

function startScanner() {

    html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        onScanSuccess
    )
    .then(() => {
        document.getElementById('status').innerText =
            "📸 Kamera aktif, silakan arahkan ke QR Code.";
    })
    .catch(err => {
        document.getElementById('status').innerText =
            "⚠️ Gagal mengaktifkan kamera: " + err;
    });

}

function onScanSuccess(decodedText) {

    html5QrCode.stop().then(() => {

        document.getElementById('status').innerText = 
            "🔍 QR terdeteksi, memproses...";

        fetch("{{ route('user.scan.process') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ kode: decodedText })
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

            } else {

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

            }

        })
        .catch(err => {
            Swal.fire('Error', 'Terjadi kesalahan koneksi: ' + err, 'error');
            startScanner();
        });

    });

}

window.addEventListener('load', startScanner);

</script>

<style>

/* ⭐ Kamera tidak boleh menghalangi tombol */
#reader video {
    pointer-events: none !important;
}

/* ⭐ Pastikan kamera tidak menutupi tombol */
#reader {
    position: relative;
    z-index: 5;
}

/* ⭐ Tombol kembali harus di atas semua elemen */
.back-button {
    position: relative;
    z-index: 50 !important;
}

/* Styling default */
#scan-page {
    color: #1e293b !important;
}

footer {
    display: none !important;
}

</style>

@endsection
