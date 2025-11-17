@extends('layouts.main')
@section('content')
<h2 class="text-xl font-semibold mb-4 text-green-700">Rekap Absensi</h2>

<form method="GET" class="flex gap-2 mb-4">
    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="border rounded p-2">
    <button class="bg-green-600 text-white px-4 py-2 rounded">Filter</button>
</form>

<table class="w-full border text-sm mb-5">
    <thead class="bg-green-100">
        <tr>
            <th class="p-2 border">Nama</th>
            <th class="p-2 border">Tanggal</th>
            <th class="p-2 border">Waktu</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">IP</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rekap as $r)
        <tr>
            <td class="p-2 border">{{ $r->user->nama }}</td>
            <td class="p-2 border">{{ $r->waktu_absen->format('d-m-Y') }}</td>
            <td class="p-2 border">{{ $r->waktu_absen->format('H:i:s') }}</td>
            <td class="p-2 border">{{ ucfirst($r->status) }}</td>
            <td class="p-2 border">{{ $r->ip_address }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="text-center">
    <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded">⬅ Kembali</a>
</div>
@endsection
