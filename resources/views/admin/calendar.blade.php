@extends('admin.layout')

@section('title','Buku Absensi | Kalender')
@section('pageTitle','📅 Buku Absensi')
@section('pageSubtitle','Pantau kehadiran dalam satu tampilan kalender')

@section('content')

<style>
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
    }

    .manual-card:hover {
        box-shadow: 0 15px 50px rgba(102, 126, 234, 0.2);
    }

    /* Section Title */
    .section-title {
        font-size: 24px;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Calendar Header */
    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding: 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }

    .month-label {
        font-size: 28px;
        font-weight: 900;
        color: white;
        text-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .nav-button {
        padding: 12px 24px;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.4);
        border-radius: 12px;
        color: white;
        font-weight: 700;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .nav-button:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.6);
        transform: scale(1.05);
    }

    .nav-button:active {
        transform: scale(0.95);
    }

    /* Calendar Grid */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 12px;
        margin-bottom: 32px;
    }

    .day-name {
        font-weight: 800;
        text-align: center;
        color: #4338ca;
        padding: 16px;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        border-radius: 12px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 2px solid #a5b4fc;
    }

    .day-cell {
        background: white;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        font-weight: 800;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
        position: relative;
        overflow: hidden;
        min-height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .day-cell::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.5) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .day-cell:hover::before {
        opacity: 1;
    }

    .day-cell:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 10px 30px rgba(0,0,0,.15);
    }

    .day-cell.hadir {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-color: #6ee7b7;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
    }

    .day-cell.hadir:hover {
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
    }

    .day-cell.terlambat {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border-color: #fcd34d;
        box-shadow: 0 4px 16px rgba(245, 158, 11, 0.2);
    }

    .day-cell.terlambat:hover {
        box-shadow: 0 8px 24px rgba(245, 158, 11, 0.3);
    }

    .day-cell.alpha {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-color: #fca5a5;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.2);
    }

    .day-cell.alpha:hover {
        box-shadow: 0 8px 24px rgba(239, 68, 68, 0.3);
    }

    .day-cell.izin,
    .day-cell.sakit {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
        border-color: #93c5fd;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.2);
    }

    .day-cell.izin:hover,
    .day-cell.sakit:hover {
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
    }

    .day-cell.kosong {
        background: #f9fafb;
        color: #d1d5db;
        cursor: default;
        border-color: #e5e7eb;
    }

    .day-cell.kosong:hover {
        transform: none;
        box-shadow: none;
    }

    .day-cell.today {
        outline: 4px solid #667eea;
        outline-offset: -4px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            outline-color: #667eea;
        }
        50% {
            outline-color: #764ba2;
        }
    }

    /* Detail Box */
    .detail-box {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 36px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.15);
        border: 1px solid rgba(102, 126, 234, 0.2);
        animation: slideUp 0.4s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 20px 28px;
        color: white;
        font-weight: 900;
        font-size: 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .detail-date {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        margin-top: 4px;
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

    /* Status Badge */
    .status-badge {
        padding: 7px 16px;
        border-radius: 20px;
        font-size: 11px;
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

    .status-hadir {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-color: #6ee7b7;
    }

    .status-terlambat {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border-color: #fcd34d;
    }

    .status-izin,
    .status-sakit {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
        border-color: #93c5fd;
    }

    .status-alpha {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-color: #fca5a5;
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

    /* Legend */
    .legend-container {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        justify-content: center;
        margin-bottom: 32px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: white;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        font-weight: 700;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .legend-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .legend-color {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        border: 2px solid;
    }

    .legend-color.hadir {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border-color: #6ee7b7;
    }

    .legend-color.terlambat {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-color: #fcd34d;
    }

    .legend-color.izin {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-color: #93c5fd;
    }

    .legend-color.alpha {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border-color: #fca5a5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .calendar-grid {
            gap: 8px;
        }

        .day-cell {
            padding: 12px;
            font-size: 14px;
            min-height: 60px;
        }

        .day-name {
            padding: 10px;
            font-size: 11px;
        }

        .manual-card {
            padding: 24px;
        }

        .month-label {
            font-size: 20px;
        }

        .nav-button {
            padding: 8px 16px;
            font-size: 16px;
        }
    }
</style>

<div class="space-y-6 max-w-7xl mx-auto">

    {{-- LEGEND --}}
    <div class="legend-container">
        <div class="legend-item">
            <div class="legend-color hadir"></div>
            <span>✅ Hadir</span>
        </div>
        <div class="legend-item">
            <div class="legend-color terlambat"></div>
            <span>⏰ Terlambat</span>
        </div>
        <div class="legend-item">
            <div class="legend-color izin"></div>
            <span>📋 Izin/Sakit</span>
        </div>
        <div class="legend-item">
            <div class="legend-color alpha"></div>
            <span>❌ Alpha</span>
        </div>
    </div>

    {{-- CALENDAR HEADER --}}
    <div class="calendar-header">
        <button onclick="changeMonth('prev')" class="nav-button">
            ⬅️
        </button>

        <h2 id="monthLabel" class="month-label">
            {{ now()->translatedFormat('F Y') }}
        </h2>

        <button onclick="changeMonth('next')" class="nav-button">
            ➡️
        </button>
    </div>

    {{-- KALENDER --}}
    <div class="manual-card">
        <h2 class="section-title">📅 Kalender Kehadiran</h2>
        <div id="calendarContent" class="calendar-grid"></div>
    </div>

    {{-- DETAIL ABSENSI --}}
    <div id="detailBox" class="detail-box hidden">
        <div class="detail-header">
            <span>📋 Detail Absensi</span>
            <div class="detail-date" id="detailDate"></div>
        </div>

        <div id="detailContent"></div>
    </div>

</div>

<script>
let currentMonth = {{ now()->month }};
let currentYear  = {{ now()->year }};

loadCalendar();

function changeMonth(dir){
    currentMonth += dir === 'prev' ? -1 : 1;

    if(currentMonth < 1){ currentMonth = 12; currentYear--; }
    if(currentMonth > 12){ currentMonth = 1; currentYear++; }

    loadCalendar();
}

function loadCalendar(){
    document.getElementById('monthLabel').innerText =
        new Date(currentYear, currentMonth - 1)
            .toLocaleString('id-ID', { month:'long', year:'numeric' });

    fetch(`/admin/calendar/data/${currentYear}/${currentMonth}`)
        .then(res => res.json())
        .then(renderCalendar);
}

function renderCalendar(data){
    let el = document.getElementById('calendarContent');
    el.innerHTML = '';

    ['Min','Sen','Sel','Rab','Kam','Jum','Sab'].forEach(d => {
        el.innerHTML += `<div class="day-name">${d}</div>`;
    });

    for(let i=0;i<data.firstDay;i++){
        el.innerHTML += `<div class="day-cell kosong"></div>`;
    }

    let map = {};
    data.events.forEach(e => {
        map[e.waktu_absen.substring(0,10)] = e.status;
    });

    for(let d=1; d<=data.daysInMonth; d++){
        let date = `${currentYear}-${String(currentMonth).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        let status = map[date] ?? 'kosong';
        let cls = `day-cell ${status}`;
        if(date === data.today) cls += ' today';

        el.innerHTML += `
            <div class="${cls}" onclick="openDetail('${date}')">
                ${d}
            </div>
        `;
    }
}

function openDetail(date){
    document.getElementById('detailBox').classList.remove('hidden');
    
    // Format tanggal Indonesia
    const dateObj = new Date(date);
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = dateObj.toLocaleDateString('id-ID', options);
    
    document.getElementById('detailDate').innerHTML = formattedDate;

    let content = document.getElementById('detailContent');
    content.innerHTML = `
        <div class="empty-state" style="padding: 32px 24px;">
            <div class="empty-icon" style="font-size: 48px;">⏳</div>
            <div class="empty-text">Memuat data...</div>
        </div>
    `;

    fetch(`/admin/calendar/detail/${date}`)
        .then(res => res.json())
        .then(res => {
            if(!res.data.length){
                content.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <div class="empty-text">Tidak ada data absensi pada tanggal ini</div>
                    </div>
                `;
                return;
            }

            let html = `
                <div class="table-wrapper">
                <table class="table-manual">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>👤 Nama</th>
                            <th>✅ Status</th>
                            <th>🕐 Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            res.data.forEach((r, index) => {
                let statusClass = '';
                if(r.status === 'hadir') statusClass = 'status-hadir';
                else if(r.status === 'terlambat') statusClass = 'status-terlambat';
                else if(r.status === 'izin' || r.status === 'sakit') statusClass = 'status-izin';
                else statusClass = 'status-alpha';

                html += `
                    <tr>
                        <td style="font-weight: 700;">${index + 1}</td>
                        <td style="font-weight: 700;">${r.user.nama}</td>
                        <td>
                            <span class="status-badge ${statusClass}">
                                ${r.status.charAt(0).toUpperCase() + r.status.slice(1)}
                            </span>
                        </td>
                        <td style="font-family: monospace; font-weight: 600; color: #64748b;">
                            ${r.waktu_absen.substring(11,19)}
                        </td>
                    </tr>
                `;
            });

            html += `</tbody></table></div>`;
            content.innerHTML = html;
        });
}
</script>

@endsection