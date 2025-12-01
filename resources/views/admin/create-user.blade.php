@extends('admin.layout')

@section('title', 'Tambah Siswa | Sistem Absensi QR')
@section('pageTitle', 'Tambah Siswa')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Jika ada password baru yang di-generate, tampilkan --}}
    @if(session('new_user_password'))
        <div class="p-4 mb-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg shadow">
            <strong>Password Siswa Baru:</strong>
            <span class="font-mono text-red-600">{{ session('new_user_password') }}</span>

            <p class="text-xs text-gray-500 mt-1">Salin dan berikan password ini kepada siswa untuk login.</p>
        </div>
    @endif

    @if(session('success'))
        <div class="p-3 rounded-lg bg-green-50 border border-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
        <h1 class="text-2xl font-extrabold text-gray-800">Tambah Siswa Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Isi data siswa dengan benar.</p>

        @if ($errors->any())
            <div class="mt-4 p-3 rounded-lg bg-red-50 border border-red-100 text-red-700">
                <b>Ada beberapa kesalahan:</b>
                <ul class="list-disc ml-5 mt-2 text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.user.store') }}" method="POST" class="mt-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           required class="w-full px-3 py-2 border rounded-lg shadow-sm">
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password Login (opsional)</label>
                    <input type="password" name="password"
                           class="w-full px-3 py-2 border rounded-lg shadow-sm">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan untuk auto-generate password (admin akan melihatnya setelah submit).</p>
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="w-full px-3 py-2 border rounded-lg shadow-sm">
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Siswa</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg shadow-sm">
                        <option value="aktif">Aktif</option>
                        <option value="lulus">Lulus / Tidak aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-gray-50 border">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
