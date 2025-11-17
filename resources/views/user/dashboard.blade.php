@extends('layouts.main')
@section('title', 'Dashboard Siswa | Sistem Absensi QR')

@section('content')

@php
    use App\Models\User;

    $user = User::find(session('siswa_id'));

    // Foto anti-cache
    $fotoVersion = $user && $user->foto 
        ? asset('profile/'.$user->foto).'?v='.time()
        : null;

    // Progress bar
    $target = 20;
    $progress = min(100, ($totalBulanIni / $target) * 100);
@endphp

<!-- Background -->
<div class="min-h-screen py-10 px-4 flex justify-center"
     style="background: linear-gradient(135deg, #A7D3F3 0%, #74B4E8 40%, #4F91D1 100%);">

    <div class="w-full max-w-3xl">

        <!-- NAVBAR -->
        <div class="rounded-2xl px-6 py-3 mb-6 border shadow-lg flex justify-between items-center"
             style="background:#0A2A43; backdrop-filter: blur(6px);">

            <h1 class="text-xl font-extrabold text-white">
                Dashboard Siswa
            </h1>

            <div class="flex items-center gap-4">

                @if($user && $user->foto)
                    <img src="{{ $fotoVersion }}"
                         class="w-9 h-9 rounded-full object-cover shadow border border-white/40">
                @else
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                         class="w-9 h-9 rounded-full object-cover shadow border border-white/40">
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-white font-semibold text-sm hover:opacity-70">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- CARD -->
        <div class="bg-white shadow-xl border border-gray-200 rounded-3xl p-8">

            <!-- PROFILE -->
            <div class="flex items-center gap-4 bg-gray-50 border rounded-2xl p-4 shadow-sm mb-7">

                @if($user && $user->foto)
                    <img src="{{ $fotoVersion }}"
                         class="w-20 h-20 rounded-full object-cover shadow border">
                @else
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                         class="w-20 h-20 rounded-full object-cover shadow border">
                @endif

                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ $user->nama }}
                    </h2>

                    <p class="text-xs text-gray-500">
                        IP Address: {{ session('ip_address') }}
                    </p>

                    <form action="{{ route('user.updateFoto') }}" method="POST" enctype="multipart/form-data"
                          class="mt-2 flex items-center gap-2">
                        @csrf
                        <input type="file" name="foto" class="text-xs" required>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700">
                            Ubah Foto
                        </button>
                    </form>
                </div>
            </div>

            <!-- STATUS HARI INI -->
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border rounded-xl p-6 mb-7 shadow-sm flex justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Status Hari Ini</p>
                    <h2 class="text-2xl font-extrabold text-blue-700">{{ $statusHariIni }}</h2>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 text-sm">Tanggal</p>
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ \Carbon\Carbon::today()->format('d F Y') }}
                    </h2>
                </div>
            </div>

            <!-- STATISTIK -->
            <div class="grid grid-cols-2 gap-4 mb-7">

                <div class="bg-white border rounded-xl p-4 text-center shadow">
                    <h3 class="text-gray-600 text-sm">Total Kehadiran Bulan Ini</h3>
                    <p class="text-4xl font-bold text-blue-700 mt-2">{{ $totalBulanIni }}</p>
                </div>

                <div class="bg-white border rounded-xl p-4 text-center shadow">
                    <h3 class="text-gray-600 text-sm">Alamat IP</h3>
                    <p class="text-lg font-semibold text-blue-700 mt-2">{{ session('ip_address') }}</p>
                </div>

            </div>

            <!-- PROGRESS BAR (CLEAN) -->
            <div class="bg-white border rounded-xl shadow p-5 mb-7">
                <p class="text-sm font-medium text-gray-700 mb-3">Progress Kehadiran Bulanan</p>

               <div class="h-3 bg-gradient-to-r from-blue-500 via-sky-400 to-cyan-400 rounded-full"
     style="width: {!! $progress !!}%;">
</div>

                <p class="text-xs text-gray-600 font-semibold">
                    {{ $totalBulanIni }} / {{ $target }} hari
                </p>
            </div>

            <!-- RIWAYAT ABSENSI -->
            <div class="bg-white border rounded-2xl shadow p-6">

                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                    Riwayat Absensi Terbaru
                </h3>

                @if($riwayat->isEmpty())
                    <p class="text-center text-gray-500 italic py-4">
                        Belum ada data absensi.
                    </p>
                @else
                    <table class="w-full border-collapse text-sm text-gray-900">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-600 to-sky-600 text-white">
                                <th class="py-2 px-3 text-left">Tanggal</th>
                                <th class="py-2 px-3 text-left">Waktu</th>
                                <th class="py-2 px-3 text-left">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($riwayat as $absen)

                                @php
                                    $icon = $absen->status === 'hadir' ? '✔' :
                                            ($absen->status === 'terlambat' ? '⚠' : '❌');

                                    $color = $absen->status === 'hadir'
                                        ? 'bg-green-200 text-green-800'
                                        : ($absen->status === 'terlambat'
                                            ? 'bg-yellow-200 text-yellow-800'
                                            : 'bg-red-200 text-red-800');
                                @endphp

                                <tr class="border-b odd:bg-white even:bg-blue-50 hover:bg-blue-100 transition">

                                    <td class="py-2 px-3">
                                        {{ \Carbon\Carbon::parse($absen->waktu_absen)->format('d/m/Y') }}
                                    </td>

                                    <td class="py-2 px-3">
                                        {{ \Carbon\Carbon::parse($absen->waktu_absen)->format('H:i:s') }}
                                    </td>

                                    <td class="py-2 px-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1 {{ $color }}">
                                            {{ $icon }} {{ ucfirst($absen->status) }}
                                        </span>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <div class="text-center mt-4">
                    <a href="#" class="text-blue-600 font-semibold hover:underline">
                        Lihat Semua Riwayat
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection