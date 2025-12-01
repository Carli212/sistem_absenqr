@extends('layouts.main')
@section('title', 'Dashboard Siswa | Absensi QR')

@section('content')

<style>
/* ===========================
   GLOBAL STYLE 
=========================== */
body {
    background: linear-gradient(135deg, #4f46e5, #8b5cf6) !important;
}

/* Card styling */
.card {
    background: white;
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

/* Foto profil */
.profile-pic {
    width: 85px;
    height: 85px;
    border-radius: 16px;
    object-fit: cover;
    background: #d1d5db;
}

/* Status badge */
.badge-status {
    font-size: 13px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 20px;
    text-transform: capitalize;
}

.badge-hadir { background: #d1fae5; color: #065f46; }
.badge-terlambat { background: #fef3c7; color: #92400e; }
.badge-sakit, .badge-izin { background: #e0e7ff; color: #3730a3; }
.badge-alpha { background: #fee2e2; color: #b91c1c; }

/* Scan button floating (mobile) */
.scan-floating {
    position: fixed;
    bottom: 22px;
    right: 20px;
    background: linear-gradient(135deg,#4f46e5,#8b5cf6);
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    padding: 16px 20px;
    border-radius: 50px;
    color: white;
    font-weight: bold;
    display: none;
}

@media (max-width: 768px) {
    .scan-floating { 
        display: block;
        z-index: 50;
    }
}

/* Desktop scan button */
.btn-scan-desktop {
    background: #4f46e5;
    color: white;
    padding: 12px 20px;
    border-radius: 12px;
    font-weight: bold;
    transition: 0.2s;
}
.btn-scan-desktop:hover {
    background: #4338ca;
}

/* Logout */
.logout-btn {
    background: #ef4444;
    color: white;
    padding: 10px 18px;
    border-radius: 12px;
    font-weight: bold;
}
.logout-btn:hover {
    background: #dc2626;
}

/* Kalender */
.calendar-box {
    border-radius: 18px;
    padding: 20px;
    background: white;
    border: 1px solid #e5e7eb;
}

/* Tabel Riwayat */
.table-container {
    overflow-x: auto;
}

.table-history {
    width: 100%;
    border-collapse: collapse;
}

.table-history th {
    background: #f3f4f6;
    padding: 12px;
    text-align: left;
    font-size: 13px;
    text-transform: uppercase;
    font-weight: 700;
    color: #374151;
}

.table-history td {
    padding: 12px;
    background: white;
    border-bottom: 1px solid #f3f4f6;
}
</style>

<div class="max-w-5xl mx-auto p-4 mt-6 space-y-6 text-gray-900">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-white drop-shadow">
            Dashboard, {{ session('siswa_nama') }}
        </h2>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- CARD PROFIL & STATUS -->
    <div class="card grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Foto profil -->
        <img src="{{ $foto ?? '/default-avatar.png' }}" class="profile-pic">

        <!-- Status Today -->
        <div class="md:col-span-2">
            <p class="font-bold text-gray-800 text-lg">Absensi hari ini</p>

            <p class="text-sm mt-1">
                Status: 
                <span class="badge-status 
                    @if($status == 'hadir') badge-hadir
                    @elseif($status == 'terlambat') badge-terlambat
                    @elseif($status == 'izin') badge-izin
                    @elseif($status == 'sakit') badge-sakit
                    @else badge-alpha @endif">
                    {{ ucfirst($status) }}
                </span>
            </p>

            <p class="mt-2 font-semibold text-gray-700">
                {{ ucfirst($status) }} pada {{ $jam_absen }}
            </p>

            <p class="text-gray-500 text-sm mt-1">
                Menit datang (negatif = datang awal):  
                <b>{{ $selisihMenit }} menit</b>
            </p>
        </div>
    </div>

    <!-- KALENDER -->
    <div class="calendar-box">
        <p class="font-semibold text-gray-700 mb-1">Kalender</p>
        <p class="text-gray-900 text-lg font-bold">
            {{ \Carbon\Carbon::now()->translatedFormat('D, d M Y') }}
        </p>
    </div>

    <!-- RIWAYAT ABSENSI -->
    <div class="card">
        <h3 class="font-bold text-lg mb-3">Riwayat Absensi Terakhir</h3>

        <div class="table-container">
            <table class="table-history">
                <thead>
                    <tr>
                        <th>Tanggal / Waktu</th>
                        <th>Status</th>
                        <th>Metode</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $r)
                    <tr>
                        <td>{{ $r->tanggal }} {{ \Carbon\Carbon::parse($r->waktu_absen)->format('H:i') }}</td>
                        <td>{{ ucfirst($r->status) }}</td>
                        <td>{{ strtoupper($r->metode) }}</td>
                        <td>{{ $r->ip_address }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- FLOATING SCAN BUTTON (mobile only) -->
<a href="{{ route('user.scan') }}" class="scan-floating">
    📷 Scan QR
</a>

@endsection
