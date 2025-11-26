@extends('admin.layout')

@section('title', 'Tambah Siswa | Sistem Absensi QR')
@section('pageTitle', 'Tambah Siswa')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Card utama --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800">Tambah Siswa Baru</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Isi data siswa. Tanggal lahir harus sesuai format login agar siswa bisa login nanti.
                </p>
            </div>

            <div class="text-right">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-50 border hover:bg-gray-100 transition text-sm">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if ($errors->any())
            <div class="mt-4 p-3 rounded-lg bg-red-50 border border-red-100 text-red-700">
                <div class="font-semibold">Ada beberapa kesalahan:</div>
                <ul class="list-disc ml-5 mt-2 text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="mt-4 p-3 rounded-lg bg-green-50 border border-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.user.store') }}" method="POST" class="mt-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Contoh: Budi Santoso"
                        required
                        class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300"
                    >
                </div>

                {{-- Nomor WA (opsional) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WA (opsional)</label>
                    <input
                        type="text"
                        name="nomor_wa"
                        value="{{ old('nomor_wa') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300"
                    >
                    <p class="text-xs text-gray-400 mt-1">
                        Digunakan bila ingin menghubungi siswa via WA (boleh dikosongkan).
                    </p>
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                    <input
                        type="date"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir') }}"
                        required
                        class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300"
                    >
                    <p class="text-xs text-gray-400 mt-1">Pastikan format YYYY-MM-DD agar sesuai form login siswa.</p>
                </div>

                {{-- Status (aktif/lulus) - optional untuk manajemen --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Siswa</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300">
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="lulus" {{ old('status') == 'lulus' ? 'selected' : '' }}>Lulus / Non-aktif</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Opsional — membantu filter di dashboard nanti.</p>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-gray-50 border hover:bg-gray-100 transition text-sm">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 transition">
                    Simpan Siswa
                </button>
            </div>
        </form>
    </div>

    {{-- Info kecil / bantuan --}}
    <div class="text-sm text-gray-500">
        Tip: kamu bisa menambahkan banyak siswa lewat seeder/factory untuk testing. Jika mau, aku bisa buatkan script seeder + factory yang menghasilkan 25 siswa contoh.
    </div>
</div>
@endsection
