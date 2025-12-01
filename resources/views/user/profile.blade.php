@extends('layouts.main')

@section('title', 'Profil Siswa')

@section('content')

<div class="max-w-lg mx-auto bg-white shadow-md rounded-xl p-6 mt-8">

    <h2 class="text-xl font-bold mb-4">Foto Profil</h2>

    <div class="flex flex-col items-center space-y-4">

        {{-- FOTO --}}
        <img src="{{ $user->foto 
            ? asset('uploads/foto/' . $user->foto)
            : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&size=180' }}" 
            class="w-40 h-40 rounded-full shadow-md object-cover border">

        {{-- FORM UPLOAD --}}
        <form action="{{ route('user.updateFoto') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="w-full space-y-3">
            
            @csrf

            <input type="file" name="foto" 
                class="w-full border p-2 rounded-lg"
                accept="image/png,image/jpeg">

            <button class="w-full py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                Upload Foto Baru
            </button>

        </form>

        @if (session('success'))
            <p class="text-green-600 font-semibold">{{ session('success') }}</p>
        @endif
        
        @if (session('error'))
            <p class="text-red-600 font-semibold">{{ session('error') }}</p>
        @endif

    </div>
</div>

@endsection
