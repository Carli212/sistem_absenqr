<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

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

    // ===== LATE =====
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

    // ===== EARLY =====
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

    // ===== ONTIME =====
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
        return;
    }

});
</script>
@endif



{{-- =========================================================
    MODE SAVAGE (HP temen, QR palsu, telat parah)
========================================================= --}}
@if(session('savage_mode'))
<script>
document.addEventListener("DOMContentLoaded", () => {

    const savage = @json(session('savage_mode'));

    let title = "";
    let htmlContent = "";
    let timer = 3000;

    // DEVICE MISMATCH
    if (savage.type === "device_mismatch") {
        title = "Ketahuan Pake HP Temen 😭📵";
        htmlContent = `
            <img src="https://media.tenor.com/_u8AqkNNZjwAAAAi/frog-angry.gif"
                 style="width:220px;border-radius:12px;margin-bottom:10px;">
            <p class='text-sm mt-2'>Akun: <b>${savage.name}</b></p>
            <p class="text-red-600 font-bold mt-1">Jangan nakal ya bro! 😂</p>
        `;
    }

    // QR INVALID
    if (savage.type === "qr_invalid") {
        title = "QR Palsu!? 😳";
        htmlContent = `
            <img src="https://media.tenor.com/VcWnZfaN3WcAAAAi/frog-shocked.gif"
                 style="width:200px;border-radius:12px;margin-bottom:10px;">
            <p class="mt-2">QR Code tidak valid</p>
            <p class="text-yellow-600 font-bold">Jangan nge-prank sistem dong 🐸</p>
        `;
    }

    // QR EXPIRED
    if (savage.type === "qr_expired") {
        title = "QR Udah Expired 😭";
        htmlContent = `
            <img src="https://media.tenor.com/3mFnaqgZrRQAAAAi/frog-stare.gif"
                 style="width:200px;border-radius:12px;margin-bottom:10px;">
            <p class="mt-2">Ayo buruan scan yg baru!</p>
        `;
    }

    // TELAT BANGEEEET
    if (savage.type === "late_extreme") {
        title = "TELAAAT BANGEEET 😂🔥";
        htmlContent = `
            <img src="https://media.tenor.com/Ce1XbBJ0J2cAAAAM/frog-running.gif"
                 style="width:230px;border-radius:12px;margin-bottom:10px;">
            <p class="mt-2"><b>${savage.name}</b>, kamu telat banget cuy</p>
            <p class="text-red-600 font-bold">Waktu absen: ${savage.time}</p>
            <p>Jalanan macet? Atau bangun kesiangan? 😭</p>
        `;
    }

    Swal.fire({
        title,
        html: htmlContent,
        showConfirmButton: false,
        timer: timer
    });

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
