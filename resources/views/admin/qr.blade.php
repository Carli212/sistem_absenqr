@extends('layouts.main')

@section('content')
<h2 class="text-2xl font-bold text-center text-green-700 mb-4">QR Code Absensi</h2>

<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow text-center">

    <p class="text-gray-600 mb-3">QR akan berubah setiap 5 menit.</p>

    <div id="qrWrap" class="inline-block bg-gray-50 p-4 rounded-lg shadow text-center">
        <!-- SVG akan masuk otomatis -->
        <p class="text-gray-400">Memuat QR...</p>
    </div>

    <p id="expireText" class="mt-3 text-sm text-gray-500"></p>

    <div class="mt-4">
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 px-4 py-2 rounded">
            ⬅ Kembali
        </a>
    </div>

</div>

<script>
async function fetchQr() {
    try {
        const res = await fetch("{{ route('admin.qr.json') }}");
        const data = await res.json();

        // decode base64 → SVG → render di html
        document.getElementById('qrWrap').innerHTML =
            atob(data.svg);

        document.getElementById('expireText').innerText =
            'Kadaluarsa: ' + data.expired_at;

    } catch (e) {
        console.error('QR ERROR:', e);
    }
}

// pertama ambil QR
fetchQr();

// auto refresh tiap 1 menit
setInterval(fetchQr, 60000);
</script>
@endsection
