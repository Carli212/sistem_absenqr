@extends('admin.layout')

@section('title', 'Rekap Absensi | Sistem Absensi QR')
@section('pageTitle', 'Rekap Absensi')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- FILTER CARD --}}
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">

        <h2 class="text-xl font-bold text-gray-800 mb-3">Filter Rekap</h2>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Tanggal --}}
            <div>
                <label class="text-sm font-medium text-gray-600">Tanggal</label>
                <input type="date" name="tanggal"
                    value="{{ request('tanggal') }}"
                    class="mt-1 w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-300 border-gray-300">
            </div>

            {{-- Tombol Filter --}}
            <div class="flex items-end">
                <button
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">
                    Terapkan Filter
                </button>
            </div>

            {{-- Reset --}}
            @if(request()->has('tanggal'))
            <div class="flex items-end">
                <a href="{{ route('admin.rekap') }}"
                   class="w-full px-4 py-2 bg-gray-200 rounded-lg text-center hover:bg-gray-300 transition">
                    Reset
                </a>
            </div>
            @endif

        </form>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 overflow-x-auto">

        <h2 class="text-xl font-bold text-gray-800 mb-4">Data Rekap</h2>

        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-green-50 text-gray-700 border-b">
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Waktu</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">IP Address</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rekap as $r)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">{{ $r->user->nama ?? '-' }}</td>

                    <td class="p-3">
                        {{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}
                    </td>

                    <td class="p-3">
                        {{ $r->waktu_absen ? \Carbon\Carbon::parse($r->waktu_absen)->format('H:i:s') : '-' }}
                    </td>

                    <td class="p-3">
                        @php
                        $status = strtolower($r->status);
                        $badge = match($status) {
                            'hadir'     => 'bg-green-100 text-green-700',
                            'terlambat' => 'bg-yellow-100 text-yellow-700',
                            'sakit'     => 'bg-blue-100 text-blue-700',
                            'izin'      => 'bg-indigo-100 text-indigo-700',
                            'alpha'     => 'bg-red-100 text-red-700',
                            default     => 'bg-gray-200 text-gray-700',
                        };
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>

                    <td class="p-3">{{ $r->ip_address ?? '-' }}</td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500 italic">
                        Tidak ada data absensi untuk tanggal ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
