@extends('layouts.main')
@section('title', 'Login Siswa | Sistem Absensi QR')

@section('content')
<div class="min-h-screen flex items-center justify-center"
    style="
        background: linear-gradient(135deg, #1BB3C7 0%, #dbdbdbff 50%, #000000ff 100%);
        background-size: cover;
        background-position: center;
     ">
    <!-- Card Login -->
    <div class="bg-white shadow-xl rounded-2xl w-full 
            max-w-[200px] p-4 text-gray-700 border border-blue-200"
        style="backdrop-filter: blur(2px);">
        
        <!-- Header -->
        <div class="text-center mb-5">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                alt="Logo Sekolah"
                class="mx-auto w-6 mb-2 drop-shadow-md bg-white/90 p-1 rounded-full opacity-95">
            <h1 class="text-lg font-bold text-blue-700">Sistem Absensi QR</h1>
            <p class="text-xs text-gray-500 mt-1">Masukkan data untuk mulai absen</p>
        </div>

        <!-- Notifikasi error -->
        @if(session('error'))
        <div class="bg-red-100 text-red-700 border border-red-300 rounded-md px-3 py-2 mb-3 text-xs text-center shadow-sm">
            {{ session('error') }}
        </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.siswa.process') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Input Nama -->
            <div class="relative">
                <span class="absolute left-3 top-2.5 text-blue-400">
                    <i class="fa-solid fa-user text-xs"></i>
                </span>
                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Nama Lengkap"
                    class="w-full pl-8 pr-3 py-2 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700 placeholder-gray-400 text-xs"
                    required>
            </div>

            <!-- Input Password -->
            <div class="relative">
                <span class="absolute left-3 top-2.5 text-blue-400">
                    <i class="fa-solid fa-lock text-xs"></i>
                </span>
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    class="w-full pl-8 pr-3 py-2 rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700 placeholder-gray-400 text-xs"
                    required>
            </div>

            <!-- Tombol Maju -->
            <div class="pt-2 text-center">
                <button
                    type="submit"
                    style="
                        width: 100%;
                        background: linear-gradient(90deg, #007BFF 0%, #0062E6 100%);
                        color: white;
                        padding: 10px 0;
                        border-radius: 8px;
                        font-weight: 600;
                        font-size: 14px;
                        border: none;
                        box-shadow: 0 4px 12px rgba(0, 98, 230, 0.4);
                        cursor: pointer;
                        transition: all 0.3s ease;
                    "
                    onmouseover="this.style.background='linear-gradient(90deg, #006AE3 0%, #004ECC 100%)'"
                    onmouseout="this.style.background='linear-gradient(90deg, #007BFF 0%, #0062E6 100%)'"
                    onmousedown="this.style.transform='scale(0.97)'"
                    onmouseup="this.style.transform='scale(1)'">
                    <i class="fa-solid fa-qrcode" style="margin-right: 6px;"></i>
                    Mulai Absen
                </button>
            </div>
        </form>

        <!-- Footer Info -->
        <p class="text-center text-[10px] text-gray-500 mt-4 leading-tight">
            Sistem terhubung otomatis dengan IP perangkat Anda
        </p>
    </div>
</div>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
