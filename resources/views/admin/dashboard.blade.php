{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layout')

@section('title', 'Dashboard Admin | Sistem Absensi QR')
@section('pageTitle', 'Dashboard')
@section('pageSubtitle', 'Overview kehadiran siswa hari ini')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    
    * {
        font-family: 'Inter', sans-serif;
    }

    /* Animated Background */
    .dashboard-wrapper {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    .dashboard-wrapper::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(74, 150, 104, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        top: -200px;
        right: -200px;
        animation: float 20s infinite ease-in-out;
    }

    .dashboard-wrapper::after {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(34, 197, 94, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        bottom: -150px;
        left: -150px;
        animation: float 15s infinite ease-in-out reverse;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(30px, -30px) scale(1.1); }
    }

    /* 3D Card Styles with Glassmorphism */
    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 28px;
        box-shadow: 
            0 8px 32px rgba(74, 150, 104, 0.12),
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.6);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        transform-style: preserve-3d;
        perspective: 1000px;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(74, 150, 104, 0.05) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.6s ease;
        transform: scale(0);
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 
            0 20px 60px rgba(74, 150, 104, 0.2),
            0 8px 16px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 1);
        border-color: rgba(74, 150, 104, 0.3);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card:hover::after {
        opacity: 1;
        transform: scale(1);
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.2) rotate(5deg);
        opacity: 0.25;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
        position: relative;
        z-index: 2;
    }

    .stat-value {
        font-size: 42px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
        position: relative;
        z-index: 2;
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-icon {
        position: absolute;
        top: 24px;
        right: 24px;
        font-size: 48px;
        opacity: 0.12;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
    }

    .stat-change {
        font-size: 13px;
        font-weight: 600;
        margin-top: 12px;
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stat-change::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    .stat-change.positive {
        color: #059669;
    }

    .stat-change.positive::before {
        background: #10b981;
        box-shadow: 0 0 12px rgba(16, 185, 129, 0.5);
    }

    .stat-change.negative {
        color: #dc2626;
    }

    .stat-change.negative::before {
        background: #ef4444;
        box-shadow: 0 0 12px rgba(239, 68, 68, 0.5);
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.7; }
    }

    /* Chart Card 3D */
    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 
            0 8px 32px rgba(74, 150, 104, 0.12),
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.6);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .chart-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #4a9668, #22c55e, #4a9668);
        background-size: 200% 100%;
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }

    .chart-title {
        font-size: 20px;
        font-weight: 900;
        color: #0f172a;
        background: linear-gradient(135deg, #0f172a 0%, #4a9668 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .chart-subtitle {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-top: 4px;
    }

    #rangeSelect {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    #rangeSelect:hover {
        border-color: #4a9668;
        box-shadow: 0 4px 12px rgba(74, 150, 104, 0.15);
        transform: translateY(-2px);
    }

    #rangeSelect:focus {
        outline: none;
        border-color: #4a9668;
        box-shadow: 0 0 0 4px rgba(74, 150, 104, 0.1);
    }

    /* Table Card 3D */
    .table-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 
            0 8px 32px rgba(74, 150, 104, 0.12),
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.6);
    }

    .table-header {
        margin-bottom: 24px;
    }

    .table-title {
        font-size: 20px;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 8px;
        background: linear-gradient(135deg, #0f172a 0%, #4a9668 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .table-count {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead th {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        padding: 14px 18px;
        text-align: left;
        font-size: 11px;
        font-weight: 800;
        color: #2d5f3f;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #4a9668;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .custom-table thead th:first-child {
        border-top-left-radius: 12px;
    }

    .custom-table thead th:last-child {
        border-top-right-radius: 12px;
    }

    .custom-table tbody tr {
        transition: all 0.2s ease;
        position: relative;
    }

    .custom-table tbody tr::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, rgba(74, 150, 104, 0.05) 0%, transparent 100%);
        transition: width 0.3s ease;
        pointer-events: none;
    }

    .custom-table tbody tr:hover {
        background: rgba(232, 245, 233, 0.5);
        transform: translateX(4px);
    }

    .custom-table tbody tr:hover::after {
        width: 100%;
    }

    .custom-table tbody td {
        padding: 16px 18px;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #e8f5e9;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease;
    }

    .status-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .status-hadir {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-terlambat {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-izin {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .status-sakit {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
    }

    .status-alpha {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    /* Ranking Card */
    .ranking-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 
            0 8px 32px rgba(74, 150, 104, 0.12),
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.6);
        margin-top: 24px;
    }

    .ranking-card h3 {
        font-size: 20px;
        font-weight: 900;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #0f172a 0%, #f59e0b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    #rankingTable tr {
        transition: all 0.2s ease;
    }

    #rankingTable tr:hover {
        background: rgba(232, 245, 233, 0.5);
        transform: scale(1.02);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #94a3b8;
    }

    .empty-state-icon {
        font-size: 56px;
        margin-bottom: 16px;
        opacity: 0.4;
        animation: float 3s infinite ease-in-out;
    }

    .empty-state-text {
        font-size: 15px;
        font-weight: 600;
    }

    /* Scroll Animation */
    .fade-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-card, .chart-card, .table-card, .ranking-card {
            padding: 24px;
        }

        .stat-value {
            font-size: 32px;
        }

        .stat-icon {
            font-size: 40px;
        }
    }

    /* Loading Animation */
    @keyframes shimmerLoading {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
</style>

<div class="dashboard-wrapper">
<div class="space-y-6">

    <!-- ==== STAT CARDS ==== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Total Siswa -->
        <div class="stat-card fade-in">
            <div class="stat-icon">👥</div>
            <div class="stat-label">Total Siswa</div>
            <div class="stat-value">{{ $totalSiswa }}</div>
            <div class="stat-change positive">Terdaftar di sistem</div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="stat-card fade-in">
            <div class="stat-icon">✅</div>
            <div class="stat-label">Hadir Hari Ini</div>
            <div class="stat-value" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $hadir }}</div>
            <div class="stat-change positive">
                {{ $totalSiswa > 0 ? round(($hadir / $totalSiswa) * 100, 1) : 0 }}% dari total siswa
            </div>
        </div>

        <!-- Tidak Hadir -->
        <div class="stat-card fade-in">
            <div class="stat-icon">❌</div>
            <div class="stat-label">Tidak Hadir</div>
            <div class="stat-value" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                {{ max($totalSiswa - $hadir, 0) }}
            </div>
            <div class="stat-change negative">
                {{ $totalSiswa > 0 ? round((max($totalSiswa - $hadir, 0) / $totalSiswa) * 100, 1) : 0 }}% dari total siswa
            </div>
        </div>

    </div>

    <!-- ==== GRAFIK & TABEL ==== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

<!-- Grafik (2 kolom) -->
<div class="lg:col-span-2 chart-card">
    <div class="chart-header">
        <div>
            <h3 class="chart-title">📈 Grafik Kehadiran — <span id="rangeLabel">(Realtime)</span></h3>
            <p class="chart-subtitle">
                Perbandingan siswa paling cepat hadir & paling terlambat (Senin–Jumat)
            </p>
        </div>

        <!-- Dropdown Filter -->
        <select id="rangeSelect">
            <option value="minggu-ini">Minggu Ini</option>
            <option value="minggu-lalu">Minggu Lalu</option>
            <option value="bulan-ini">Bulan Ini</option>
        </select>
    </div>

    <canvas id="attendanceChart" style="max-height: 280px;"></canvas>

    <!-- Audio Notifikasi -->
    <audio id="notifSound">
        <source src="https://assets.mixkit.co/sfx/preview/mixkit-correct-answer-tone-2870.mp3" type="audio/mpeg">
    </audio>

    <!-- Ranking Card -->
    <div class="ranking-card">
        <h3>🏆 Ranking Kehadiran Bulan Ini</h3>
        <table class="w-full text-sm">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="p-3 text-left font-bold text-gray-700">#</th>
                    <th class="p-3 text-left font-bold text-gray-700">Nama</th>
                    <th class="p-3 text-left font-bold text-gray-700">Jumlah Hadir</th>
                </tr>
            </thead>
            <tbody id="rankingTable"></tbody>
        </table>
    </div>
</div>

<script>
let chart;
let lastCount = 0;

async function loadChart(range = 'minggu-ini') {
    const res = await fetch(`/admin/graph?range=${range}`);
    const data = await res.json();

    const ctx = document.getElementById("attendanceChart").getContext("2d");

    const formatTime = (min) => {
        if (min === null) return "-";
        const h = Math.floor(min / 60);
        const m = min % 60;
        return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
    };

    if (chart) chart.destroy();

    chart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: "⚡ Hadir Paling Awal",
                    data: data.bestTimes,
                    backgroundColor: "rgba(34,197,94,0.7)",
                    borderColor: "rgba(34,197,94,1)",
                    borderWidth: 2,
                    borderRadius: 8,
                },
                {
                    label: "🐌 Hadir Paling Akhir",
                    data: data.latestTimes,
                    backgroundColor: "rgba(220,38,38,0.7)",
                    borderColor: "rgba(220,38,38,1)",
                    borderWidth: 2,
                    borderRadius: 8,
                }
            ]
        },
        options: {
            animation: {
                duration: 1000,
                easing: 'easeOutCubic'
            },
            scales: {
                y: {
                    ticks: { 
                        callback: value => formatTime(value),
                        font: { weight: 600 }
                    },
                    title: { 
                        display: true, 
                        text: "Waktu (HH:MM)",
                        font: { weight: 700, size: 13 }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: { weight: 600 },
                        padding: 15
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { weight: 700 },
                    bodyFont: { weight: 600 },
                    callbacks: {
                        afterBody: function(context) {
                            let idx = context[0].dataIndex;
                            return [
                                "",
                                `👤 Datang Pertama: ${data.bestNames[idx]}`,
                                `🚪 Datang Terakhir: ${data.latestNames[idx]}`
                            ];
                        }
                    }
                }
            }
        }
    });

    /** 🔔 Notifikasi Realtime **/
    const currentCount = data.bestNames.filter(v => v !== "-").length;
    if (currentCount > lastCount) {
        document.getElementById('notifSound').play();
    }
    lastCount = currentCount;
}

/** Realtime Refresh setiap 5 detik */
setInterval(() => {
    const range = document.getElementById("rangeSelect").value;
    loadChart(range);
}, 5000);

/** Filter ubah range */
document.getElementById('rangeSelect').addEventListener('change', (e) => {
    document.getElementById('rangeLabel').innerText = 
        e.target.options[e.target.selectedIndex].text;
    loadChart(e.target.value);
});

/** Load awal */
loadChart();

/** Load Ranking */
fetch("/admin/ranking")
    .then(res => res.json())
    .then(data => {
        let tbody = "";
        data.forEach((row, index) => {
            const medal = index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : '';
            tbody += `
                <tr class="border-b border-gray-100">
                    <td class="p-3 font-bold text-gray-600">${medal} ${index+1}</td>
                    <td class="p-3 font-semibold text-gray-800">${row.nama}</td>
                    <td class="p-3 font-bold text-green-600">${row.total_hadir}</td>
                </tr>
            `;
        });
        document.getElementById('rankingTable').innerHTML = tbody;
    });
</script>

        </div>

        <!-- Tabel Kehadiran Hari Ini (1 kolom) -->
        <div class="table-card">
            <div class="table-header">
                <h4 class="table-title">📋 Kehadiran Hari Ini</h4>
                <p class="table-count">{{ count($absensiHariIni) }} siswa telah absen</p>
            </div>

            <div style="max-height: 500px; overflow-y: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>

                    <tbody id="todayList">
                        @forelse($absensiHariIni as $a)
                        <tr>
                            <td style="font-weight: 600;">{{ $a->user->nama }}</td>
                            <td>
                                <span class="status-badge 
                                    @if($a->status == 'hadir') status-hadir
                                    @elseif($a->status == 'terlambat') status-terlambat
                                    @elseif($a->status == 'izin') status-izin
                                    @elseif($a->status == 'sakit') status-sakit
                                    @else status-alpha
                                    @endif
                                ">
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>
                            <td style="font-weight: 600; color: #64748b;">
                                {{ $a->waktu_absen ? \Carbon\Carbon::parse($a->waktu_absen)->format('H:i') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📭</div>
                                    <div class="empty-state-text">Belum ada absensi hari ini</div>
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
</div>

@endsection