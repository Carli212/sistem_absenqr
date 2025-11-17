@extends('layouts.main')
@section('title', 'Absen Berhasil | Sistem Absensi QR')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-green-200 via-emerald-300 to-teal-400">
    <div class="bg-white rounded-2xl shadow-xl p-8 text-center w-full max-w-sm border border-green-200">
        <div class="text-5xl mb-4">✅</div>
        <h1 class="text-2xl font-bold text-green-700 mb-2">Absen Berhasil!</h1>
        <p class="text-gray-600 mb-6">Data absensi Anda sudah tercatat. Jangan lupa semangat hari ini! 💪</p>

        <a href="{{ route('user.dashboard') }}" 
           class="bg-white text-emerald-600 font-semibold px-6 py-2 rounded-lg shadow-lg hover:bg-emerald-200 transition">
           📊 Lihat Dashboard
        </a>
    </div>
</div>
@endsection
