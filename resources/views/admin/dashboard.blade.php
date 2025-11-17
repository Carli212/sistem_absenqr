@extends('layouts.main')

@section('content')

<h2 class="text-3xl font-bold mb-6 text-green-700">Dashboard Admin</h2>

<!-- Statistik Kartu -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

    <div class="bg-white rounded-xl shadow p-6">
        <div class="text-gray-500 text-sm">Total Siswa</div>
        <div class="text-3xl font-bold mt-1">{{ $totalSiswa }}</div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <div class="text-gray-500 text-sm">Hadir Hari Ini</div>
        <div class="text-3xl font-bold text-green-600 mt-1">{{ $hadir }}</div>
    </div>

    <a href="{{ route('admin.qr') }}"
       class="bg-green-500 text-white p-6 rounded-xl shadow flex items-center justify-center text-lg font-semibold hover:bg-green-600 transition">
        📱 Tampilkan QR Code
    </a>
</div>

<!-- Tabel Kehadiran -->
<div class="bg-white rounded-xl shadow p-6">

    <h3 class="font-semibold text-xl mb-4">Status Kehadiran Hari Ini</h3>

    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-green-100">
                <tr>
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Tanggal Lahir</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Waktu Absen</th>
                    <th class="p-3 border">IP Address</th>
                </tr>
            </thead>

            <tbody>
                @forelse($absensiHariIni as $a)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3 border">{{ $a->user->nama }}</td>

                    <td class="p-3 border">
                        {{ $a->user->tanggal_lahir ? $a->user->tanggal_lahir->format('d-m-Y') : '-' }}
                    </td>

                    <td class="p-3 border text-green-700 font-semibold">{{ ucfirst($a->status) }}</td>
                    <td class="p-3 border">{{ $a->waktu_absen->format('H:i:s') }}</td>
                    <td class="p-3 border">{{ $a->ip_address }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        Belum ada absensi hari ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
