@extends('layouts.main')

@section('title', 'Absensi Manual')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">📝 Absensi Manual</h1>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.absensi.manual.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="user_id" class="block font-semibold mb-1">Pilih Siswa</label>
            <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-md focus:ring focus:ring-blue-200">
                <option value="">-- Pilih Siswa --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block font-semibold mb-1">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal"
                class="w-full border-gray-300 rounded-md focus:ring focus:ring-blue-200" required>
        </div>

        <div class="mb-4">
            <label for="status" class="block font-semibold mb-1">Status Kehadiran</label>
            <select name="status" id="status" class="w-full border-gray-300 rounded-md focus:ring focus:ring-blue-200">
                <option value="Hadir">Hadir</option>
                <option value="Tidak Hadir">Tidak Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            Simpan Absensi
        </button>
    </form>

    <hr class="my-6">

    <h2 class="text-lg font-semibold mb-2">📋 Daftar Absensi Manual</h2>
    <div class="overflow-x-auto">
        <table class="w-full border text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">Tanggal</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $item->user->nama }}</td>
                        <td class="border px-3 py-2">{{ $item->tanggal }}</td>
                        <td class="border px-3 py-2">{{ $item->status }}</td>
                        <td class="border px-3 py-2 text-center">
                            <form action="{{ route('admin.absensi.manual.delete', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            Belum ada data absensi manual.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
