{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layout')

@section('title', 'Dashboard Admin | Sistem Absensi QR')
@section('pageTitle', 'Dashboard')
@section('pageSubtitle', 'Overview kehadiran siswa hari ini')

@section('content')

<style>
    /* ===== STAT CARD ===== */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        transition: 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover { transform: translateY(-2px); }

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
        margin-bottom: 4px;
    }
    .stat-icon {
        position: absolute; top: 20px; right: 20px;
        font-size: 32px; opacity: 0.15;
    }

    /* ===== TABLE ===== */
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .custom-table thead th {
        background: #f8fafc;
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        border-bottom: 2px solid #e2e8f0;
    }
    .custom-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }
    .custom-table tbody tr:hover { background: #f8fafc; }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-hadir     { background:#d1fae5; color:#065f46; }
    .status-terlambat { background:#fef3c7; color:#92400e; }
    .status-izin      { background:#dbeafe; color:#1e3a8a; }
    .status-sakit     { background:#e0e7ff; color:#3730a3; }
    .status-alpha     { background:#fee2e2; color:#991b1b; }

    .empty-state { text-align:center; padding:48px 24px; color:#94a3b8; }
    .empty-state-icon { font-size:48px; margin-bottom:16px; opacity:0.5; }
</style>

<div class="space-y-6">

    <!-- ===== STAT KOTAK ATAS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-label">Total Siswa</div>
            <div class="stat-value">{{ $totalSiswa }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-label">Hadir Hari Ini</div>
            <div class="stat-value" style="color:#10b981;">{{ $hadir }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">❌</div>
            <div class="stat-label">Tidak Hadir</div>
            <div class="stat-value" style="color:#ef4444;">
                {{ $totalSiswa - $hadir }}
            </div>
        </div>

    </div>

    <!-- ===== GRAFIK & TABLE ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ===== GRAFIK ===== -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6 border">
            <h3 class="text-xl font-bold mb-2">📈 Grafik Kehadiran 7 Hari Terakhir</h3>
            <p class="text-sm text-gray-500 mb-4">Waktu hadir tercepat dan terlambat</p>

            <canvas id="attendanceChart" height="140"></canvas>
        </div>

        <!-- ===== TABEL KEHADIRAN HARI INI ===== -->
        <div class="bg-white rounded-xl shadow p-6 border">

            <h4 class="text-lg font-bold mb-2">📋 Kehadiran Hari Ini</h4>
            <p class="text-sm text-gray-500 mb-4">
                <span id="countToday">{{ count($absensiHariIni) }}</span> siswa telah absen
            </p>

            <div style="max-height: 400px; overflow-y:auto;">
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
                            <td style="font-weight:600;">{{ $a->user->nama }}</td>

                            <td>
                                <span class="status-badge 
                                    @if($a->status=='hadir') status-hadir
                                    @elseif($a->status=='terlambat') status-terlambat
                                    @elseif($a->status=='izin') status-izin
                                    @elseif($a->status=='sakit') status-sakit
                                    @else status-alpha @endif">
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>

                            <td style="font-weight:600; color:#64748b;">
                                {{ $a->waktu_absen ? \Carbon\Carbon::parse($a->waktu_absen)->format('H:i') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📭</div>
                                    <div class="empty-state-text">Belum ada absensi</div>
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

{{-- ============================================================
     JAVASCRIPT: GRAFIK + AUTO REFRESH TABEL KEHADIRAN
============================================================ --}}
<script>
(async function () {

    /* ==================== GRAFIK ====================== */
    function minutesToLabel(mins) {
        if (mins === null) return '-';
        const h = Math.floor(mins / 60);
        const m = mins % 60;
        return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`;
    }

    const ctx = document.getElementById("attendanceChart").getContext("2d");
    const res = await fetch("{{ route('admin.graph.json') }}?days=7");
    const data = await res.json();

    new Chart(ctx, {
        type: "line",
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: "Hadir Paling Awal",
                    data: data.earliest,
                    borderColor: "#10b981",
                    backgroundColor: "rgba(16,185,129,0.1)",
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: "Hadir Paling Akhir",
                    data: data.latest,
                    borderColor: "#ef4444",
                    backgroundColor: "rgba(239,68,68,0.1)",
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: (ctx) =>
                            ctx.dataset.label + ": " + minutesToLabel(ctx.parsed.y)
                    }
                }
            }
        }
    });

})();
</script>

<!-- ============================================================
     AUTO REFRESH — Kehadiran Hari Ini (Realtime 5 detik)
============================================================ -->
<script>
async function refreshTodayAttendance() {
    try {
        const res = await fetch("{{ route('admin.absensi.json') }}");
        const json = await res.json();

        const tbody = document.getElementById("todayList");
        tbody.innerHTML = "";

        document.getElementById("countToday").innerText = json.data.length;

        if (json.data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-state-icon">📭</div>
                            <div class="empty-state-text">Belum ada absensi</div>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        json.data.forEach(a => {
            let badge = "status-alpha";

            if (a.status === "Hadir") badge = "status-hadir";
            else if (a.status === "Terlambat") badge = "status-terlambat";
            else if (a.status === "Izin") badge = "status-izin";
            else if (a.status === "Sakit") badge = "status-sakit";

            tbody.innerHTML += `
                <tr>
                    <td style="font-weight:600;">${a.nama}</td>
                    <td><span class="status-badge ${badge}">${a.status}</span></td>
                    <td style="font-weight:600; color:#64748b;">${a.waktu ?? '-'}</td>
                </tr>
            `;
        });

    } catch (e) {
        console.error("Gagal refresh tabel:", e);
    }
}

// Jalankan pertama kali
refreshTodayAttendance();
// Loop setiap 5 detik
setInterval(refreshTodayAttendance, 5000);
</script>

@endsection
