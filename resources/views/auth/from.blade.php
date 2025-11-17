@extends('layouts.main')

@section('content')
<h2 class="text-2xl font-semibold text-center mb-4">Login Siswa</h2>

@if(session('error'))
  <div class="bg-red-100 text-red-700 p-2 rounded mb-3">{{ session('error') }}</div>
@endif

<form action="{{ route('login.process') }}" method="POST" class="space-y-4">
  @csrf
  <div>
    <label class="block mb-1 font-medium">Nama Lengkap</label>
    <input type="text" name="nama" required class="w-full border rounded-lg p-2 focus:outline-none focus:ring focus:ring-indigo-300">
  </div>

  <div>
    <label class="block mb-1 font-medium">Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" required class="w-full border rounded-lg p-2 focus:outline-none focus:ring focus:ring-indigo-300">
  </div>

  <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
    Mulai
  </button>
</form>
@endsection
