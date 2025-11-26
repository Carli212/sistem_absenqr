@extends('layouts.main')
@section('title', 'Dashboard Siswa | Sistem Absensi QR')

@section('content')
<div class="min-h-screen p-6 bg-gray-50">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Halo, {{ session('siswa_nama') }}</h2>
                    <p class="text-sm text-gray-500">Status hari ini: <strong>{{ $statusHariIni ?? 'Belum Absen' }}</strong></p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Hadir bulan ini</div>
                    <div class="text-2xl font-bold text-green-600">{{ $totalBulanIni ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Ringkasan menit datang -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-sm text-gray-500">Menit datang (negatif = datang awal)</div>
                <div class="text-xl font-semibold mt-2">
                    @if($menitDatang === null)
                        -
                    @else
                        {{ $menitDatang }} menit
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-sm text-gray-500">Absensi hari ini</div>
                <div class="text-xl font-semibold mt-2">
                    @if($absenHariIni)
                        {{ ucfirst($absenHariIni->status) }} pada {{ \Carbon\Carbon::parse($absenHariIni->waktu_absen, 'Asia/Jakarta')->format('H:i:s') }}
                    @else
                        Belum absen
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-sm text-gray-500">Aksi</div>
                <div class="mt-2">
                    <a href="{{ route('user.scan') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Scan QR</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline-block ml-2">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg text-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Riwayat -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold mb-4">Riwayat Absensi Terakhir</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Tanggal / Waktu</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                            <tr class="border-t">
                                <td class="p-3">{{ \Carbon\Carbon::parse($r->waktu_absen, 'Asia/Jakarta')->format('d M Y H:i') }}</td>
                                <td class="p-3">{{ ucfirst($r->status) }}</td>
                                <td class="p-3">{{ $r->metode }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3 text-center text-gray-500">Belum ada riwayat absensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
