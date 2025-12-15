@extends('layouts.main')
@section('title','Dashboard Siswa')
@section('content')

<style>
    body {
        margin: 0;
        overflow-x: hidden;
    }

    /* Nature Background Scene */
    .nature-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        background: linear-gradient(to bottom, #87CEEB 0%, #98D8E8 50%, #b8e6f0 100%);
    }

    /* Sun */
    .sun {
        position: absolute;
        top: 60px;
        right: 120px;
        width: 80px;
        height: 80px;
        background: radial-gradient(circle, #FFD700 0%, #FFA500 60%, #FF8C00 100%);
        border-radius: 50%;
        box-shadow: 0 0 60px rgba(255, 215, 0, 0.6);
        animation: sunPulse 4s ease-in-out infinite;
    }

    @keyframes sunPulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    /* Mountains */
    .mountain-far {
        position: absolute;
        bottom: 200px;
        width: 100%;
        height: 250px;
        background: linear-gradient(to top, #4a5f7a 0%, #8da3c5 100%);
        clip-path: polygon(0% 100%, 15% 40%, 30% 60%, 45% 20%, 60% 50%, 75% 30%, 90% 55%, 100% 100%);
        opacity: 0.5;
    }

    .mountain-near {
        position: absolute;
        bottom: 150px;
        width: 100%;
        height: 300px;
        background: linear-gradient(to top, #2d4a3e 0%, #4a8b6a 100%);
        clip-path: polygon(0% 100%, 20% 50%, 40% 70%, 55% 25%, 70% 60%, 85% 40%, 100% 100%);
        opacity: 0.7;
    }

    /* Clouds */
    .cloud {
        position: absolute;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 100px;
        animation: cloudMove 50s linear infinite;
    }

    .cloud::before,
    .cloud::after {
        content: '';
        position: absolute;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 100px;
    }

    .cloud1 {
        width: 100px;
        height: 35px;
        top: 80px;
        left: -150px;
    }

    .cloud1::before {
        width: 45px;
        height: 45px;
        top: -22px;
        left: 18px;
    }

    .cloud1::after {
        width: 55px;
        height: 40px;
        top: -18px;
        right: 18px;
    }

    .cloud2 {
        width: 120px;
        height: 40px;
        top: 150px;
        left: -200px;
        animation-duration: 60s;
        animation-delay: 5s;
    }

    .cloud2::before {
        width: 50px;
        height: 50px;
        top: -25px;
        left: 20px;
    }

    .cloud2::after {
        width: 60px;
        height: 45px;
        top: -20px;
        right: 20px;
    }

    @keyframes cloudMove {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(calc(100vw + 300px));
        }
    }

    /* Birds */
    .bird {
        position: absolute;
        width: 16px;
        height: 16px;
        animation: birdFly 30s linear infinite;
    }

    .bird::before,
    .bird::after {
        content: '';
        position: absolute;
        background: #333;
        width: 12px;
        height: 2px;
        border-radius: 2px;
        top: 8px;
    }

    .bird::before {
        left: -6px;
        transform: rotate(-20deg);
        animation: wingFlap 0.5s ease-in-out infinite;
    }

    .bird::after {
        right: -6px;
        transform: rotate(20deg);
        animation: wingFlap 0.5s ease-in-out infinite 0.25s;
    }

    .bird1 {
        top: 100px;
        left: -40px;
    }

    .bird2 {
        top: 130px;
        left: -60px;
        animation-delay: 4s;
        animation-duration: 35s;
    }

    @keyframes birdFly {
        from {
            transform: translate(0, 0);
        }

        to {
            transform: translateX(calc(100vw + 100px));
        }
    }

    @keyframes wingFlap {

        0%,
        100% {
            transform: rotate(-20deg);
        }

        50% {
            transform: rotate(-30deg);
        }
    }

    /* Ground */
    .ground {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 150px;
        background: linear-gradient(to bottom, #4a8b3f 0%, #2d5a28 100%);
    }

    /* Dashboard Content */
    .dashboard-content {
        position: relative;
        z-index: 10;
        min-height: 100vh;
        padding: 20px;
    }

    .dashboard-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .profile-pic {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #40c057;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #4a8b3f 0%, #2d5a28 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(74, 139, 63, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(74, 139, 63, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #e03131 0%, #c92a2a 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(224, 49, 49, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(224, 49, 49, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #1c7ed6 0%, #1864ab 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(28, 126, 214, 0.3);
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(28, 126, 214, 0.4);
    }

    .status-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .status-hadir {
        background: #d3f9d8;
        color: #2b8a3e;
    }

    .status-terlambat {
        background: #ffe3e3;
        color: #c92a2a;
    }

    .status-belum {
        background: #e7f5ff;
        color: #1864ab;
    }

    /* tambahan untuk mode baru */
    .status-early {
        background: #e7f5ff;
        color: #1c7ed6;
    }

    .status-ontime {
        background: #d3f9d8;
        color: #2f9e44;
    }

    .status-late {
        background: #ffe3e3;
        color: #c92a2a;
    }

    .calendar-box {
        background: linear-gradient(135deg, #40c057 0%, #2b8a3e 100%);
        padding: 20px;
        border-radius: 16px;
        text-align: center;
        color: white;
        box-shadow: 0 8px 24px rgba(64, 192, 87, 0.3);
    }

    .calendar-day {
        font-size: 48px;
        font-weight: 900;
        line-height: 1;
    }

    .calendar-info {
        font-size: 14px;
        margin-top: 8px;
        opacity: 0.95;
    }
</style>

<!-- Nature Background -->
<div class="nature-background">
    <div class="sun"></div>
    <div class="cloud cloud1"></div>
    <div class="cloud cloud2"></div>
    <div class="bird bird1"></div>
    <div class="bird bird2"></div>
    <div class="mountain-far"></div>
    <div class="mountain-near"></div>
    <div class="ground"></div>
</div>

<!-- Dashboard Content -->
<div class="dashboard-content page-fade">
    <div class="max-w-5xl mx-auto">

        <!-- Header Card -->
        <div class="dashboard-card glass-card">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">
                        Hi, {{ session('siswa_nama') }}!
                    </h2>
                    <p class="text-sm text-gray-600">
                        Selamat datang di Dashboard Sistem Absensi
                    </p>
                </div>

                <div class="flex gap-2">

                    <a href="{{ route('profile') }}" class="btn-primary">
                        ✏️ Edit Profil
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-danger">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Status & Calendar Card -->
        <div class="dashboard-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Left: Profile & Status -->
                <div class="flex items-center gap-4">
                    <img src="{{ $foto }}" class="profile-pic" alt="Foto Profil">

                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Status Absensi Hari Ini</h3>

                        <div class="mb-2">
                            @if($status_code === 'late')
                            <span class="status-badge status-late">🔴 {{ $status_label }}</span>
                            @elseif($status_code === 'early')
                            <span class="status-badge status-early">🌅 {{ $status_label }}</span>
                            @elseif($status_code === 'good' || $status_code === 'ontime')
                            <span class="status-badge status-ontime">✅ {{ $status_label }}</span>
                            @else
                            <span class="status-badge status-belum">⏳ {{ $status_label }}</span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600">
                            <strong>Waktu:</strong>
                            {{ $jam_absen !== '-' ? \Carbon\Carbon::parse($jam_absen)->format('H:i:s') . ' WIB' : '-' }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <strong>Selisih:</strong> {{ $selisihMenit }} menit
                        </p>
                    </div>
                </div>

                <!-- Right: Calendar -->
                <div class="flex items-center justify-center">
                    <div class="calendar-box w-full max-w-xs">
                        <div class="calendar-day" id="day"></div>
                        <div class="text-lg font-semibold" id="weekday"></div>
                        <div class="calendar-info" id="month-year"></div>

                        <div class="mt-4 pt-4 border-t border-white/30">
                            @if($absenHariIni)
                            <div class="font-bold">✔ Sudah Absen Hari Ini</div>
                            @else
                            <div class="font-semibold opacity-90">Belum Absen</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Absensi Card -->
        <div class="dashboard-card">
            <h3 class="text-xl font-bold mb-4 text-gray-800 flex items-center gap-2">
                📚 Riwayat Absensi Terbaru
            </h3>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-green-600 to-green-700 text-blod">
                            <th class="p-3 text-left font-semibold">Tanggal</th>
                            <th class="p-3 text-left font-semibold">Status</th>
                            <th class="p-3 text-left font-semibold">Metode</th>
                            <th class="p-3 text-left font-semibold">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($riwayat as $item)
                        <tr class="border-b border-gray-200 hover:bg-green-50 transition-colors">
                            <td class="p-3 text-gray-700">{{ $item->tanggal }}</td>
                            <td class="p-3">
                                @if($item->status == 'hadir')
                                <span class="text-green-600 font-semibold">✅ Hadir</span>
                                @elseif($item->status == 'terlambat')
                                <span class="text-yellow-600 font-semibold">⚠️ Terlambat</span>
                                @else
                                <span class="text-red-600 font-semibold">❌ Alpha</span>
                                @endif
                            </td>
                            <td class="p-3 text-gray-700 font-medium">{{ strtoupper($item->metode) }}</td>
                            <td class="p-3 text-gray-600 text-sm">{{ $item->ip_address }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-8 text-gray-500 italic">
                                Belum ada riwayat absensi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    const d = new Date();
    document.getElementById("day").textContent = d.getDate();
    document.getElementById("weekday").textContent = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"][d.getDay()];
    document.getElementById("month-year").textContent = d.toLocaleString('id-ID', {
        month: 'long',
        year: 'numeric'
    });
</script>

@endsection