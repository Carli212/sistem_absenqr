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

    /* Modern Gradient Background */
    .dashboard-wrapper {
        background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    .gradient-orb-dash {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.4;
        animation: floatOrb 25s ease-in-out infinite;
    }

    .orb-dash-1 {
        top: -15%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.3) 0%, transparent 70%);
        animation-delay: 0s;
    }

    .orb-dash-2 {
        bottom: -20%;
        left: -15%;
        width: 700px;
        height: 700px;
        background: radial-gradient(circle, rgba(118, 75, 162, 0.25) 0%, transparent 70%);
        animation-delay: 8s;
    }

    .orb-dash-3 {
        top: 50%;
        left: 40%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(79, 70, 229, 0.2) 0%, transparent 70%);
        animation-delay: 15s;
    }

    @keyframes floatOrb {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(60px, -60px) scale(1.15); }
        66% { transform: translate(-40px, 40px) scale(0.95); }
    }

    .grid-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            linear-gradient(rgba(102, 126, 234, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(102, 126, 234, 0.03) 1px, transparent 1px);
        background-size: 60px 60px;
        opacity: 0.6;
    }

    /* 3D Glassmorphism Cards */
    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 
            0 10px 40px rgba(102, 126, 234, 0.15),
            0 2px 12px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 1);
        border: 1px solid rgba(255, 255, 255, 0.8);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        transform-style: preserve-3d;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .stat-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 
            0 25px 70px rgba(102, 126, 234, 0.25),
            0 10px 20px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 1);
        border-color: rgba(102, 126, 234, 0.4);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card:hover .stat-icon-large {
        transform: scale(1.2) rotate(8deg);
        opacity: 0.3;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 12px;
        position: relative;
        z-index: 2;
    }

    .stat-value {
        font-size: 48px;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
        background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-value.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-value.danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-icon-large {
        position: absolute;
        top: 28px;
        right: 28px;
        font-size: 56px;
        opacity: 0.15;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
    }

    .stat-change {
        font-size: 14px;
        font-weight: 600;
        margin-top: 12px;
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stat-change::before {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    .stat-change.positive {
        color: #059669;
    }

    .stat-change.positive::before {
        background: #10b981;
        box-shadow: 0 0 16px rgba(16, 185, 129, 0.6);
    }

    .stat-change.negative {
        color: #dc2626;
    }

    .stat-change.negative::before {
        background: #ef4444;
        box-shadow: 0 0 16px rgba(239, 68, 68, 0.6);
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.6; }
    }

    /* Chart Card */
    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 36px;
        box-shadow: 
            0 10px 40px rgba(102, 126, 234, 0.15),
            0 2px 12px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 1);
        border: 1px solid rgba(255, 255, 255, 0.8);
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
        background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
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
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .chart-title {
        font-size: 22px;
        font-weight: 900;
        color: #0f172a;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .chart-subtitle {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        margin-top: 6px;
    }

    #rangeSelect {
        background: rgba(255, 255, 255, 1);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    #rangeSelect:hover {
        border-color: #667eea;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
        transform: translateY(-2px);
    }

    #rangeSelect:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
    }

    /* Table Card */
    .table-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 36px;
        box-shadow: 
            0 10px 40px rgba(102, 126, 234, 0.15),
            0 2px 12px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 1);
        border: 1px solid rgba(255, 255, 255, 0.8);
    }

    .table-header {
        margin-bottom: 28px;
    }

    .table-title {
        font-size: 22px;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 8px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .table-count {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead th {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 800;
        color: #4338ca;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        border-bottom: 2px solid #667eea;
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
        transition: all 0.3s ease;
        position: relative;
    }

    .custom-table tbody tr::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.08) 0%, transparent 100%);
        transition: width 0.3s ease;
        pointer-events: none;
    }

    .custom-table tbody tr:hover {
        background: rgba(224, 231, 255, 0.4);
        transform: translateX(6px);
    }

    .custom-table tbody tr:hover::after {
        width: 100%;
    }

    .custom-table tbody td {
        padding: 18px 20px;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #e0e7ff;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-block;
        padding: 7px 16px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .status-badge:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.18);
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
        border-radius: 20px;
        padding: 32px;
        box-shadow: 
            0 8px 32px rgba(102, 126, 234, 0.12),
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.7);
        margin-top: 28px;
    }

    .ranking-card h3 {
        font-size: 20px;
        font-weight: 900;
        margin-bottom: 24px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    #rankingTable tr {
        transition: all 0.3s ease;
    }

    #rankingTable tr:hover {
        background: rgba(224, 231, 255, 0.4);
        transform: scale(1.02);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 56px 24px;
        color: #94a3b8;
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
        animation: floatEmpty 3s infinite ease-in-out;
    }

    @keyframes floatEmpty {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .empty-state-text {
        font-size: 16px;
        font-weight: 600;
    }

    /* Animation */
    .fade-in {
        animation: fadeInUp 0.7s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
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
            font-size: 36px;
        }

        .stat-icon-large {
            font-size: 48px;
        }

        .chart-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="dashboard-wrapper">
    <!-- Background Orbs -->
    <div class="gradient-orb-dash orb-dash-1"></div>
    <div class="gradient-orb-dash orb-dash-2"></div>
    <div class="gradient-orb-dash orb-dash-3"></div>
    <div class="grid-pattern"></div>

    <div class="space-y-6" style="position: relative; z-index: 10;">

        <!-- ==== STAT CARDS ==== -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Total Siswa -->
            <div class="stat-card fade-in">
                <div class="stat-icon-large">👥</div>
                <div class="stat-label">Total Siswa</div>
                <div class="stat-value">{{ $totalSiswa }}</div>
                <div class="stat-change positive">Terdaftar di sistem</div>
            </div>

            <!-- Hadir Hari Ini -->
            <div class="stat-card fade-in">
                <div class="stat-icon-large">✅</div>
                <div class="stat-label">Hadir Hari Ini</div>
                <div class="stat-value success">{{ $hadir }}</div>
                <div class="stat-change positive">
                    {{ $totalSiswa > 0 ? round(($hadir / $totalSiswa) * 100, 1) : 0 }}% dari total siswa
                </div>
            </div>

            <!-- Tidak Hadir -->
            <div class="stat-card fade-in">
                <div class="stat-icon-large">❌</div>
                <div class="stat-label">Tidak Hadir</div>
                <div class="stat-value danger">
                    {{ max($totalSiswa - $hadir, 0) }}
                </div>
                <div class="stat-change negative">
                    {{ $totalSiswa > 0 ? round((max($totalSiswa - $hadir, 0) / $totalSiswa) * 100, 1) : 0 }}% dari total siswa
                </div>
            </div>

        </div>
{{-- ALERT STATUS HARI INI --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

    {{-- HADIR --}}
    <div class="p-5 rounded-xl bg-green-100 border-2 border-green-300">
        <div class="text-sm font-bold text-green-800">🟢 Hadir Hari Ini</div>
        <div class="text-3xl font-black text-green-900">
            {{ $hadirHariIni }}
        </div>
    </div>

    {{-- TERLAMBAT --}}
    <div class="p-5 rounded-xl bg-yellow-100 border-2 border-yellow-300">
        <div class="text-sm font-bold text-yellow-800">⏰ Terlambat</div>
        <div class="text-3xl font-black text-yellow-900">
            {{ $terlambatHariIni }}
        </div>
    </div>

    {{-- BELUM ABSEN --}}
    <div class="p-5 rounded-xl bg-red-100 border-2 border-red-300">
        <div class="text-sm font-bold text-red-800">⚫ Belum Absen</div>
        <div class="text-3xl font-black text-red-900">
            {{ $belumAbsen }}
        </div>
    </div>

    {{-- STATUS QR --}}
    <div class="p-5 rounded-xl {{ $qrAktif ? 'bg-indigo-100 border-indigo-300' : 'bg-gray-200 border-gray-400' }} border-2">
        <div class="text-sm font-bold">
            🔒 Status QR
        </div>
        <div class="text-xl font-black">
            {{ $qrAktif ? 'AKTIF' : 'TIDAK AKTIF' }}
        </div>
    </div>

</div>

{{-- ================= GRAFIK & RANKING ================= --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ===== GRAFIK ===== --}}
            <div class="lg:col-span-2 chart-card">
                <div class="chart-header">
                    <div>
                        <h3 class="chart-title">
                            📈 Grafik Kehadiran — <span id="rangeLabel">Minggu Ini</span>
                        </h3>
                        <p class="chart-subtitle">
                            Tepat waktu vs Terlambat (Realtime)
                        </p>
                    </div>

                    <select id="rangeSelect">
                        <option value="minggu-ini">Minggu Ini</option>
                        <option value="minggu-lalu">Minggu Lalu</option>
                        <option value="bulan-ini">Bulan Ini</option>
                    </select>
                </div>

                <canvas id="attendanceChart" height="220"></canvas>

                <audio id="notifSound">
                    <source src="https://assets.mixkit.co/sfx/preview/mixkit-correct-answer-tone-2870.mp3">
                </audio>

                {{-- ===== RANKING ===== --}}
                <div class="ranking-card">
                    <h3>🏆 Ranking Kehadiran Bulan Ini</h3>
                    <table class="w-full text-sm">
                        <tbody id="rankingTable"></tbody>
                    </table>
                </div>
            </div>

            {{-- ===== TABEL HARI INI ===== --}}
            <div class="table-card">
                <h4 class="table-title">📋 Kehadiran Hari Ini</h4>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensiHariIni as $a)
                        <tr>
                            <td>{{ $a->user->nama }}</td>
                            <td>{{ ucfirst($a->status) }}</td>
                            <td>{{ $a->waktu_absen ? \Carbon\Carbon::parse($a->waktu_absen)->format('H:i') : '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3">Belum ada absensi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- ================= SCRIPT FINAL (SATU-SATUNYA) ================= --}}
<script>
let chart = null;
let lastCount = 0;

function formatTime(min) {
    if (!min) return '-';
    const h = Math.floor(min / 60);
    const m = min % 60;
    return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`;
}

async function loadChart(range = 'minggu-ini') {
    const res = await fetch(`/admin/graph/filter?range=${range}`);
    const data = await res.json();

    const ctx = document.getElementById('attendanceChart').getContext('2d');
    if (chart) chart.destroy();

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Waktu Kehadiran',
                data: data.bestTimes.map(v => v ?? 0),
                backgroundColor: data.bestTimes.map(v => {
                    if (!v) return '#cbd5e1';        // kosong
                    if (v <= 450) return '#10b981'; // <= 07:30 (hijau)
                    if (v <= 480) return '#f59e0b'; // <= 08:00 (kuning)
                    return '#ef4444';               // > 08:00 (merah)
                }),
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            animation: { duration: 800 },
            scales: {
                x: {
                    ticks: { callback: v => formatTime(v) },
                    title: {
                        display: true,
                        text: 'Jam Kehadiran'
                    }
                }
            },
            plugins: {
                annotation: {
                    annotations: {
                        batasTepat: {
                            type: 'line',
                            xMin: 450,
                            xMax: 450,
                            borderColor: '#10b981',
                            borderWidth: 2,
                            label: {
                                content: '07:30 Tepat Waktu',
                                enabled: true,
                                position: 'start'
                            }
                        },
                        batasTelat: {
                            type: 'line',
                            xMin: 480,
                            xMax: 480,
                            borderColor: '#ef4444',
                            borderWidth: 2,
                            label: {
                                content: '08:00 Terlambat',
                                enabled: true,
                                position: 'start'
                            }
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => `⏰ ${formatTime(ctx.raw)}`,
                        afterBody: ctx => {
                            const i = ctx[0].dataIndex;
                            return `👤 ${data.bestNames[i] ?? '-'}`;
                        }
                    }
                }
            }
        }
    });

    const count = data.bestNames.filter(v => v && v !== '-').length;
    if (count > lastCount) document.getElementById('notifSound').play();
    lastCount = count;
}

// realtime
setInterval(() => {
    loadChart(document.getElementById('rangeSelect').value);
}, 5000);

document.getElementById('rangeSelect').addEventListener('change', e => {
    document.getElementById('rangeLabel').innerText =
        e.target.options[e.target.selectedIndex].text;
    loadChart(e.target.value);
});

loadChart();

// ranking
fetch('/admin/ranking')
    .then(r => r.json())
    .then(data => {
        document.getElementById('rankingTable').innerHTML =
            data.map((r,i)=>`
                <tr>
                    <td>${i+1}</td>
                    <td>${r.nama}</td>
                    <td>${r.total_hadir}</td>
                </tr>
            `).join('');
            
    });
</script>
@endsection