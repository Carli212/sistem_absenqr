@extends('admin.layout')

@section('title','Buku Absensi | Kalender')
@section('pageTitle','📅 Buku Absensi')
@section('pageSubtitle','Pantau kehadiran dalam satu tampilan kalender')

@section('content')

<style>
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }
    .day-cell {
        background: #fff;
        border-radius: 10px;
        padding: 12px;
        text-align: center;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
        border: 1px solid #ddd;
    }
    .day-cell:hover {
        transform: scale(1.05);
        box-shadow: 0px 3px 12px rgba(0,0,0,0.05);
    }

    .hadir { background: #d1fae5; color:#065f46; }
    .terlambat { background: #fff3c7; color:#92400e; }
    .alpha { background: #ffe5e5; color:#b91c1c; }
    .kosong { background:#f8fafc; color:#94a3b8; }

    .today { outline: 3px solid #2d6a4f; }
</style>

<div class="calendar-container space-y-4">

    <div class="flex justify-between items-center mb-3">
        <button onclick="changeMonth('prev')" class="px-4 py-2 rounded-lg bg-white border hover:bg-gray-100 shadow-sm">
            ⬅
        </button>

        <h2 id="monthLabel" class="text-xl font-extrabold tracking-wide text-gray-800">
            📅 {{ now()->translatedFormat('F Y') }}
        </h2>

        <button onclick="changeMonth('next')" class="px-4 py-2 rounded-lg bg-white border hover:bg-gray-100 shadow-sm">
            ➡
        </button>
    </div>

    <div id="calendarContent" class="calendar-grid"></div>
</div>


<div id="detailModal" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-50 backdrop-blur-sm">
    <div class="bg-white w-[380px] rounded-xl shadow-xl p-5 relative">

        <button onclick="closeModal()" class="absolute right-3 top-3 text-gray-500 hover:text-red-500">
            ✖
        </button>

        <h2 class="text-lg font-bold mb-2">📅 Detail Absensi</h2>
        <p id="modalDate" class="text-sm text-gray-500 mb-3"></p>

        <div id="modalContent" class="text-sm max-h-[300px] overflow-y-auto"></div>
    </div>
</div>



<script>
let currentMonth = {{ now()->month }};
let currentYear  = {{ now()->year }};

loadCalendar();

function changeMonth(dir){
    currentMonth = dir === 'prev' ? currentMonth - 1 : currentMonth + 1;

    if(currentMonth < 1){ currentMonth = 12; currentYear--; }
    if(currentMonth > 12){ currentMonth = 1; currentYear++; }

    loadCalendar();
}

function loadCalendar(){
    document.getElementById('monthLabel').innerHTML =
        `📅 ${new Date(currentYear,currentMonth-1).toLocaleString('id-ID',{month:'long', year:'numeric'})}`;

    fetch(`/admin/calendar/data/${currentYear}/${currentMonth}`)
        .then(res => res.json())
        .then(data => renderCalendar(data));
}

function renderCalendar(data){
    let content = document.getElementById('calendarContent');
    content.innerHTML = "";

    ['Min','Sen','Sel','Rab','Kam','Jum','Sab'].forEach(d=>{
        content.innerHTML += `<div class="font-bold text-gray-600 text-center">${d}</div>`;
    });

    for(let i=0;i<data.firstDay;i++){
        content.innerHTML += `<div class="day-cell kosong"></div>`;
    }

    let map = {};
    data.events.forEach(e => map[e.date] = e.status);

    for(let day=1;day<=data.daysInMonth;day++){
        let date = `${currentYear}-${String(currentMonth).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
        let status = map[date] ?? 'kosong';
        let css = status;

        if(date === data.today) css += " today";

        content.innerHTML += `<div class="day-cell ${css}" onclick="openDetail('${date}')">${day}</div>`;
    }
}

function openDetail(date){
    document.getElementById('detailModal').classList.remove('hidden');
    document.getElementById('modalDate').innerHTML = `Tanggal: <b>${date}</b>`;

    let content = document.getElementById('modalContent');
    content.innerHTML = `<p class="text-gray-400 italic">Memuat...</p>`;

    fetch(`/admin/calendar/detail/${date}`)
        .then(res => res.json())
        .then(data => {
            if(!data.data.length){
                content.innerHTML = `<p class="text-gray-400 italic">Belum ada absensi.</p>`;
                return;
            }

            let t = `<table class="w-full text-[13px] border">
                <tr class="bg-gray-100 font-semibold">
                    <td class="p-1">Nama</td>
                    <td class="p-1">Status</td>
                    <td class="p-1">Waktu</td>
                </tr>`;

            data.data.forEach(r=>{
                t += `<tr>
                        <td class="border p-1">${r.nama}</td>
                        <td class="border p-1">${r.status}</td>
                        <td class="border p-1">${r.waktu}</td>
                    </tr>`;
            });

            t += `</table>`;
            content.innerHTML = t;
        });
}

function closeModal(){
    document.getElementById('detailModal').classList.add('hidden');
}
</script>

@endsection
