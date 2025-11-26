{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layout')

@section('title', 'Dashboard Admin | Sistem Absensi QR')
@section('pageTitle', 'Dashboard')
@section('pageSubtitle', 'Overview kehadiran siswa hari ini')

@section('content')

<style>
    /* Card Styles */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #6366f1, #8b5cf6);
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 32px;
        opacity: 0.15;
    }

    .stat-change {
        font-size: 12px;
        font-weight: 600;
        margin-top: 8px;
    }

    .stat-change.positive {
        color: #10b981;
    }

    .stat-change.negative {
        color: #ef4444;
    }

    /* Chart Card */
    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .chart-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .chart-subtitle {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    /* Table Styles */
    .table-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
    }

    .table-header {
        margin-bottom: 20px;
    }

    .table-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
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
        background: #f8fafc;
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .custom-table thead th:first-child {
        border-top-left-radius: 10px;
    }

    .custom-table thead th:last-child {
        border-top-right-radius: 10px;
    }

    .custom-table tbody tr {
        transition: background 0.15s ease;
    }

    .custom-table tbody tr:hover {
        background: #f8fafc;
    }

    .custom-table tbody td {
        padding: 14px 16px;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .status-hadir {
        background: #d1fae5;
        color: #065f46;
    }

    .status-terlambat {
        background: #fef3c7;
        color: #92400e;
    }

    .status-izin {
        background: #dbeafe;
        color: #1e3a8a;
    }

    .status-sakit {
        background: #e0e7ff;
        color: #3730a3;
    }

    .status-alpha {
        background: #fee2e2;
        color: #991b1b;
    }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #94a3b8;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state-text {
        font-size: 15px;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-card {
            padding: 20px;
        }

        .stat-value {
            font-size: 28px;
        }

        .chart-card, .table-card {
            padding: 20px;
        }
    }
</style>

<div class="space-y-6">

    <!-- ==== STAT CARDS ==== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Total Siswa -->
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-label">Total Siswa</div>
            <div class="stat-value">{{ $totalSiswa }}</div>
            <div class="stat-change positive">Terdaftar di sistem</div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-label">Hadir Hari Ini</div>
            <div class="stat-value" style="color: #10b981;">{{ $hadir }}</div>
            <div class="stat-change positive">
                {{ $totalSiswa > 0 ? round(($hadir / $totalSiswa) * 100, 1) : 0 }}% dari total siswa
            </div>
        </div>

        <!-- Tidak Hadir -->
        <div class="stat-card">
            <div class="stat-icon">❌</div>
            <div class="stat-label">Tidak Hadir</div>
            <div class="stat-value" style="color: #ef4444;">
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
                    <h3 class="chart-title">📈 Grafik Kehadiran Harian</h3>
                    <p class="chart-subtitle">Data 7 hari terakhir - Waktu hadir tercepat & terlambat</p>
                </div>
            </div>

            <canvas id="attendanceChart" height="140"></canvas>
        </div>

        <!-- Tabel Kehadiran Hari Ini (1 kolom) -->
        <div class="table-card">
            <div class="table-header">
                <h4 class="table-title">📋 Kehadiran Hari Ini</h4>
                <p class="table-count">{{ count($absensiHariIni) }} siswa telah absen</p>
            </div>

            <div style="max-height: 400px; overflow-y: auto;">
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


{{-- ===========================
     JAVASCRIPT CHART
=========================== --}}
<script>
(async function () {

    const ctx = document.getElementById('attendanceChart').getContext('2d');

    function minutesToLabel(mins) {
        if (mins === null) return '-';
        const h = Math.floor(mins / 60);
        const m = mins % 60;
        return String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0');
    }

    const res = await fetch("{{ route('admin.graph.json') }}?days=7");
    const data = await res.json();

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: "⚡ Hadir Paling Awal",
                    data: data.earliest,
                    borderColor: "#10b981",
                    backgroundColor: "rgba(16, 185, 129, 0.1)",
                    borderWidth: 3,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: "#10b981",
                    pointBorderColor: "#ffffff",
                    pointBorderWidth: 2,
                    fill: true
                },
                {
                    label: "🐌 Hadir Paling Akhir",
                    data: data.latest,
                    borderColor: "#ef4444",
                    backgroundColor: "rgba(239, 68, 68, 0.1)",
                    borderWidth: 3,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: "#ef4444",
                    pointBorderColor: "#ffffff",
                    pointBorderWidth: 2,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 13,
                            weight: '600',
                            family: 'Inter'
                        },
                        padding: 16,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleFont: {
                        size: 13,
                        weight: '700',
                        family: 'Inter'
                    },
                    bodyFont: {
                        size: 13,
                        family: 'Inter'
                    },
                    padding: 12,
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + minutesToLabel(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: val => minutesToLabel(val),
                        font: {
                            size: 12,
                            weight: '600',
                            family: 'Inter'
                        },
                        color: '#64748b'
                    },
                    title: {
                        display: true,
                        text: 'Waktu (HH:MM)',
                        font: {
                            size: 13,
                            weight: '700',
                            family: 'Inter'
                        },
                        color: '#475569'
                    },
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12,
                            weight: '600',
                            family: 'Inter'
                        },
                        color: '#64748b'
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

})();
</script>

@endsection