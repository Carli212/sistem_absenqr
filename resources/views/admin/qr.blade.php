@extends('admin.layout')

@section('title', 'QR Code Absensi | Sistem Absensi QR')
@section('pageTitle', 'QR Code Absensi')

@section('content')

<div class="max-w-xl mx-auto bg-white border border-gray-100 shadow-md rounded-2xl p-6 text-center space-y-5">

    <h2 class="text-xl font-bold text-green-700">QR Absensi (5 Menit Sekali)</h2>

    <p class="text-gray-600 text-sm">
        QR Code ini otomatis berubah setiap <b>5 menit</b>.  
        Siswa harus memindai QR ini untuk melakukan absensi.
    </p>

    {{-- QR Box --}}
    <div class="flex justify-center">
        <div id="qrWrap" class="bg-gray-50 border rounded-xl p-5 shadow-inner">
            <p class="text-gray-400 text-sm">Memuat QR...</p>
        </div>
    </div>

    {{-- Expire Info --}}
    <p id="expireText" class="text-sm text-gray-500"></p>

    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block px-5 py-2.5 bg-gray-200 rounded-lg text-gray-700 font-medium
                  hover:bg-gray-300 transition">
            ⬅ Kembali
        </a>
    </div>

</div>


{{-- SCRIPT --}}
<script>
async function fetchQr() {
    try {
        const res = await fetch("{{ route('admin.qr.json') }}");
        const data = await res.json();

        // Base64 decode → SVG
        document.getElementById('qrWrap').innerHTML = atob(data.svg);

        document.getElementById('expireText').innerText =
            "Kadaluarsa pada: " + data.expired_at;

    } catch (err) {
        console.error("QR Fetch Error:", err);
    }
}

// Ambil QR saat halaman dibuka
fetchQr();

// Refresh setiap 1 menit
setInterval(fetchQr, 60000);
</script>

@endsection
