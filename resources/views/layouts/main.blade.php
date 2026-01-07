<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

{{-- FAVICON / APP ICON --}}
<link rel="icon" href="{{ asset('icon/favicon.png') }}" type="image/png">
<link rel="icon" sizes="32x32" href="{{ asset('icon/logo-32.png') }}">
<link rel="icon" sizes="64x64" href="{{ asset('icon/logo-64.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icon/logo-180.png') }}">
<link rel="manifest" href="{{ asset('build/manifest.json') }}">

    {{-- Tailwind via Vite --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('head')
</head>

<body class="bg-gray-100">

<main class="min-h-screen">
    @yield('content')
</main>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Lottie --}}
<script src="https://unpkg.com/lottie-web@5.7.4/build/player/lottie.min.js"></script>

{{-- =========================================================
    NOTIFIKASI ABSENSI (early, ontime, late)
========================================================= --}}
@if(session('notif_absen'))
<script>
document.addEventListener("DOMContentLoaded", () => {

    const notif = @json(session('notif_absen'));

    if (notif.type === "late") {
        Swal.fire({
            title: "Kamu Terlambat ⚠️",
            html: `
                <img src="https://media.tenor.com/a6O98Xz97NIAAAAM/frog-fall-jump.gif"
                     style="width:230px;border-radius:12px;margin-bottom:15px;">
                <p class='text-sm'>Waktu absen: ${notif.time}</p>
                <p class='mt-1 text-red-600 font-bold'>yhahaha mampua! 🐸💨</p>
            `,
            showConfirmButton: false,
            timer: 2600,
        });
        return;
    }

    if (notif.type === "early") {
        Swal.fire({
            title: "Datang Paling Awal 🌅",
            html: `
                <div id="lottieBox" style="width:200px;height:200px;margin:0 auto;"></div>
                <p class="mt-2 text-sm">Waktu absen: ${notif.time}</p>
            `,
            showConfirmButton: false,
            timer: 2400,
            didOpen: () => {
                lottie.loadAnimation({
                    container: document.getElementById("lottieBox"),
                    renderer: "svg",
                    loop: false,
                    autoplay: true,
                    path: "https://lottie.host/fd0407f8-541e-471e-bbfd-33e329b0110c/sunrise.json"
                });
            }
        });
        return;
    }

    if (notif.type === "ontime") {
        Swal.fire({
            title: "Hadir Tepat Waktu 🔥",
            html: `
                <div id="lottieBox" style="width:200px;height:200px;margin:0 auto;"></div>
                <p class="mt-2 text-sm">Waktu absen: ${notif.time}</p>
            `,
            showConfirmButton: false,
            timer: 2400,
            didOpen: () => {
                lottie.loadAnimation({
                    container: document.getElementById("lottieBox"),
                    renderer: "svg",
                    loop: false,
                    autoplay: true,
                    path: "https://lottie.host/3c35573a-d73b-4d47-9d91-57c1f6ed88ee/success.json"
                });
            }
        });
    }
});
</script>
@endif

{{-- =========================================================
    DEVICE ERROR (LOGIN)
========================================================= --}}
@if(session('device_error'))
<script>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "HP Tidak Cocok! 🐸💥",
        html: `
            <img src="https://media.tenor.com/l8sH3u7AFnMAAAAd/frog-fall.gif"
                 style="width:180px;border-radius:12px;margin:0 auto;">
            <p class='mt-3 text-sm text-gray-700'>
                {{ session('device_error') }}
            </p>
            <p class="text-red-600 font-bold mt-1">Jangan curang yaa 😭📵</p>
        `,
        confirmButtonText: "Oke, paham 😔",
        confirmButtonColor: "#d9534f",
    });
});
</script>
@endif

</body>
</html>
