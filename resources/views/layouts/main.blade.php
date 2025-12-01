<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    {{-- Tailwind via Vite --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    {{-- CSRF Token untuk keamanan --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @yield('head') {{-- Tempat untuk tambahan script per halaman --}}
</head>

<body class="bg-gray-100">

    {{-- MAIN CONTENT --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Script Global, digunakan oleh QR Scanner --}}
    <script>
        window.csrf = document.querySelector('meta[name="csrf-token"]').content;
    </script>

    @yield('scripts') {{-- Script tambahan per halaman --}}
</body>

</html>
