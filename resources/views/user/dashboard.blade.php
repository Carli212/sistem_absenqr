@extends('layouts.main')
@section('title','Dashboard Siswa')
@section('content')

<style>
    body {
        margin: 0;
        overflow-x: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Dashboard Content */
    .dashboard-content {
        position: relative;
        z-index: 10;
        min-height: 100vh;
        padding: 20px;
    }

    /* Card Styling */
    .manual-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 36px;
        box-shadow: 
            0 10px 40px rgba(102, 126, 234, 0.15),
            0 0 1px rgba(255, 255, 255, 0.8) inset;
        border: 1px solid rgba(102, 126, 234, 0.2);
        transition: all 0.3s ease;
        margin-bottom: 32px;
    }

    .manual-card:hover {
        box-shadow: 0 15px 50px rgba(102, 126, 234, 0.2);
    }

    /* Section Title */
    .section-title {
        font-size: 28px;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-subtitle {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 24px;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.98) 100%);
        border-radius: 20px;
        padding: 28px;
        border: 2px solid;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        opacity: 0.1;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.purple {
        border-color: #c4b5fd;
    }

    .stat-card.purple::before {
        background: #8b5cf6;
    }

    .stat-card.green {
        border-color: #6ee7b7;
    }

    .stat-card.green::before {
        background: #10b981;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 12px;
    }

    .stat-value {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.5;
    }

    .stat-icon {
        position: absolute;
        bottom: 20px;
        right: 20px;
        font-size: 64px;
        opacity: 0.15;
    }

    /* Profile Section */
    .profile-section {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 2px solid #f1f5f9;
    }

    .profile-pic {
        width: 120px;
        height: 120px;
        border-radius: 24px;
        object-fit: cover;
        border: 4px solid #667eea;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .profile-pic:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
    }

    .profile-info h3 {
        font-size: 24px;
        font-weight: 900;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .profile-info p {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
    }

    /* Buttons */
    .btn-primary {
        padding: 14px 28px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.4);
    }

    .btn-danger {
        padding: 14px 28px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(239, 68, 68, 0.4);
    }

    /* Status Badge */
    .status-badge {
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        border: 2px solid;
        transition: all 0.2s ease;
    }

    .status-badge:hover {
        transform: scale(1.05);
    }

    .status-ontime,
    .status-hadir {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-color: #6ee7b7;
    }

    .status-late,
    .status-terlambat {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border-color: #fcd34d;
    }

    .status-early,
    .status-belum {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
        border-color: #93c5fd;
    }

    /* Calendar Box */
    .calendar-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 32px;
        border-radius: 20px;
        text-align: center;
        color: white;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.4);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .calendar-day {
        font-size: 64px;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 8px;
    }

    .calendar-weekday {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .calendar-info {
        font-size: 14px;
        opacity: 0.9;
        font-weight: 600;
    }

    .calendar-status {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid rgba(255, 255, 255, 0.3);
        font-weight: 700;
        font-size: 15px;
    }

    /* Table Styling */
    .table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
        border: 2px solid #f1f5f9;
    }

    .table-manual {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-manual thead th {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 800;
        color: #4338ca;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-bottom: 2px solid #667eea;
    }

    .table-manual thead th:first-child {
        border-top-left-radius: 14px;
    }

    .table-manual thead th:last-child {
        border-top-right-radius: 14px;
    }

    .table-manual tbody tr {
        transition: all 0.2s ease;
        position: relative;
    }

    .table-manual tbody tr::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, transparent 100%);
        transition: width 0.3s ease;
        pointer-events: none;
    }

    .table-manual tbody tr:hover {
        background: rgba(224, 231, 255, 0.3);
        transform: translateX(4px);
    }

    .table-manual tbody tr:hover::after {
        width: 100%;
    }

    .table-manual tbody td {
        padding: 16px 20px;
        font-size: 14px;
        color: #1e293b;
        font-weight: 600;
        border-bottom: 1px solid #f1f5f9;
        background: white;
    }

    .table-manual tbody tr:last-child td {
        border-bottom: none;
    }

    .table-manual tbody tr:last-child td:first-child {
        border-bottom-left-radius: 14px;
    }

    .table-manual tbody tr:last-child td:last-child {
        border-bottom-right-radius: 14px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 56px 24px;
        color: #94a3b8;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.5;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .empty-text {
        font-size: 16px;
        font-weight: 600;
    }

    /* Button Container */
    .btn-container {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .manual-card {
            padding: 24px;
        }

        .profile-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .section-title {
            font-size: 22px;
        }

        .calendar-day {
            font-size: 48px;
        }
    }
</style>

<!-- Dashboard Content -->
<div class="dashboard-content">
    <div class="max-w-7xl mx-auto">

        <!-- Header Card -->
        <div class="manual-card">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="section-title">
                        👋 Hi, {{ session('siswa_nama') }}!
                    </h2>
                    <p class="section-subtitle">
                        Selamat datang di Dashboard Sistem Absensi Modern
                    </p>
                </div>

                <div class="btn-container">
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

        <!-- Status & Calendar Grid -->
        <div class="stats-grid">
            
            <!-- Profile & Status Card -->
            <div class="stat-card purple">
                <div class="profile-section" style="border: none; padding: 0; margin: 0;">
                    <img src="{{ $foto }}" class="profile-pic" alt="Foto Profil">
                    
                    <div class="profile-info">
                        <h3>{{ session('siswa_nama') }}</h3>
                        <div class="stat-label" style="margin-bottom: 12px;">Status Absensi Hari Ini</div>
                        
                        @if($status_code === 'late')
                        <span class="status-badge status-late">🔴 {{ $status_label }}</span>
                        @elseif($status_code === 'early')
                        <span class="status-badge status-early">🌅 {{ $status_label }}</span>
                        @elseif($status_code === 'good' || $status_code === 'ontime')
                        <span class="status-badge status-ontime">✅ {{ $status_label }}</span>
                        @else
                        <span class="status-badge status-belum">⏳ {{ $status_label }}</span>
                        @endif

                        <div style="margin-top: 16px;">
                            <p class="stat-value">
                                <strong>⏰ Waktu:</strong>
                                {{ $jam_absen !== '-' ? \Carbon\Carbon::parse($jam_absen)->format('H:i:s') . ' WIB' : '-' }}
                            </p>
                            <p class="stat-value">
                                <strong>📊 Selisih:</strong> {{ $selisihMenit }} menit
                            </p>
                        </div>
                    </div>
                </div>
                <div class="stat-icon">👤</div>
            </div>

            <!-- Calendar Card -->
            <div class="stat-card green" style="padding: 0; overflow: hidden;">
                <div class="calendar-box" style="border-radius: 18px; height: 100%;">
                    <div class="calendar-day" id="day"></div>
                    <div class="calendar-weekday" id="weekday"></div>
                    <div class="calendar-info" id="month-year"></div>

                    <div class="calendar-status">
                        @if($absenHariIni)
                        ✔️ Sudah Absen Hari Ini
                        @else
                        ⏳ Belum Absen Hari Ini
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Absensi Card -->
        <div class="manual-card">
            <h3 class="section-title">
                📚 Riwayat Absensi Terbaru
            </h3>

            <div class="table-wrapper">
                <table class="table-manual">
                    <thead>
                        <tr>
                            <th>📅 Tanggal</th>
                            <th>✅ Status</th>
                            <th>🔧 Metode</th>
                            <th>🌐 IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                        <tr>
                            <td style="font-family: monospace; font-weight: 700;">{{ $item->tanggal }}</td>
                            <td>
                                @if($item->status == 'hadir')
                                <span class="status-badge status-hadir">Hadir</span>
                                @elseif($item->status == 'terlambat')
                                <span class="status-badge status-terlambat">Terlambat</span>
                                @else
                                <span class="status-badge status-alpha" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #991b1b; border-color: #fca5a5;">Alpha</span>
                                @endif
                            </td>
                            <td style="text-transform: uppercase;">{{ $item->metode }}</td>
                            <td style="font-family: monospace; font-size: 13px; color: #64748b;">{{ $item->ip_address }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <div class="empty-text">Belum ada riwayat absensi</div>
                                </div>
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