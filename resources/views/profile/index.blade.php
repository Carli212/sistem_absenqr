@extends('layouts.main')
@section('title', 'Profil Siswa')

@section('content')

<style>
.card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}
.profile-img {
    width: 140px;
    height: 140px;
    border-radius: 18px;
    object-fit: cover;
    border: 4px solid #a5d6a7;
    background: #e8f5e9;
}
.input-file {
    border: 1px solid #ddd;
    padding: 10px;
    width: 100%;
    border-radius: 10px;
}
.btn-main {
    background: #4caf50;
    color: white;
    padding: 10px;
    font-weight: bold;
    border-radius: 10px;
}
.btn-back {
    background: #c8e6c9;
    color: #2e7d32;
    padding: 10px;
    font-weight: bold;
    border-radius: 10px;
}
</style>

<div class="max-w-3xl mx-auto mt-10">

    <div class="card text-center bg-gradient-to-r from-green-100 to-green-200">
        <h2 class="text-2xl font-bold text-green-800">{{ $user->nama }}</h2>
        <p class="text-sm text-green-600">Pengaturan Profil Siswa</p>
    </div>

    <div class="card text-center">

        <img id="previewFoto" src="{{ $foto }}" class="profile-img mx-auto mb-4">

        <form action="{{ route('user.updateFoto') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="file" name="foto" class="input-file mb-4" accept="image/*" onchange="previewImage(event)" required>

            <button class="btn-main w-full mb-4" type="submit">Simpan Foto Baru</button>

            <a href="{{ route('user.dashboard') }}" class="btn-back w-full block">← Kembali ke Dashboard</a>

            @if(session('success'))
                <p class="text-green-600 mt-3">{{ session('success') }}</p>
            @endif
        </form>
    </div>

</div>

<script>
function previewImage(event) {
    let img = document.getElementById('previewFoto');
    img.src = URL.createObjectURL(event.target.files[0]);
}
</script>

@endsection