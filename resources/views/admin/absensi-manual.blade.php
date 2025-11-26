@extends('admin.layout')

@section('title', 'Absensi Manual | Sistem Absensi QR')
@section('pageTitle', 'Absensi Manual')

@section('content')

<div class="space-y-6 max-w-6xl mx-auto">

    {{-- FORM TAMBAH ABSENSI --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">

        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            📝 Tambah Absensi Manual
        </h2>

        {{-- NOTIF --}}
        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.absensi.manual.store') }}" method="POST"
              class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf

            {{-- Siswa --}}
            <div class="md:col-span-1">
                <label class="text-sm font-semibold text-gray-700">Pilih Siswa</label>
                <select name="user_id"
                        class="w-full mt-1 border rounded-lg p-2 shadow-sm focus:ring-blue-300"
                        required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">
                            {{ $u->nama }} ({{ $u->tanggal_lahir }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Tanggal</label>
                <input type="date" name="tanggal"
                       value="{{ old('tanggal', \Carbon\Carbon::today('Asia/Jakarta')->toDateString()) }}"
                       class="w-full mt-1 border rounded-lg p-2 shadow-sm focus:ring-blue-300"
                       required>
            </div>

            {{-- Status --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Status</label>
                <select name="status"
                        class="w-full mt-1 border rounded-lg p-2 shadow-sm focus:ring-blue-300"
                        required>
                    <option value="hadir">Hadir</option>
                    <option value="terlambat">Terlambat</option>
                    <option value="alpha">Alpha</option>
                    <option value="sakit">Sakit</option>
                    <option value="izin">Izin</option>
                    <option value="manual">Manual</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="text-right md:col-span-1">
                <button class="px-5 py-2.5 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>

    </div>


    {{-- DAFTAR ABSENSI --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">

        <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
            📋 Daftar Absensi Manual
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Metode</th>
                        <th class="p-3 text-left">Waktu</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($absensi as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $item->user->nama }}</td>

                            <td class="p-3">
                                {{ optional($item->tanggal)->format('d/m/Y') }}
                            </td>

                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    @if($item->status == 'hadir') bg-green-100 text-green-700
                                    @elseif($item->status == 'terlambat') bg-yellow-100 text-yellow-700
                                    @elseif(in_array($item->status, ['izin','sakit'])) bg-blue-100 text-blue-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            <td class="p-3">{{ ucfirst($item->metode ?? 'manual') }}</td>

                            <td class="p-3">
                                {{ $item->waktu_absen
                                    ? \Carbon\Carbon::parse($item->waktu_absen)->format('H:i:s')
                                    : '-' }}
                            </td>

                            <td class="p-3 text-center">
                                <form method="POST"
                                      action="{{ route('admin.absensi.manual.delete', $item->id) }}"
                                      onsubmit="return confirm('Hapus entri ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500 italic">
                                Belum ada data absensi manual.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection
