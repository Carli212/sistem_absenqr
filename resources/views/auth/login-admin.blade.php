@extends('layouts.main')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #1fb6ff, #009eeb, #f2faff);
        min-height: 100vh;
        padding-top: 40px;
        padding-bottom: 40px;
    }
</style>

<div class="max-w-lg mx-auto bg-white shadow-2xl rounded-2xl p-8">

    <h2 class="text-3xl font-bold text-center mb-2 text-blue-700">Login Admin</h2>

    <p class="text-center text-gray-500 mb-6">Silahkan login untuk masuk ke panel admin</p>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5 text-center font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.admin.process') }}" class="space-y-5">
        @csrf

        <div>
            <label class="text-sm font-semibold">Nama Admin</label>
            <input type="text" name="nama"
                class="w-full border border-gray-300 rounded-xl p-3 mt-1 focus:ring focus:ring-blue-200"
                required>
        </div>

        <div>
            <label class="text-sm font-semibold">Nomor WhatsApp</label>
            <input type="text" name="nomor_wa"
                class="w-full border border-gray-300 rounded-xl p-3 mt-1 focus:ring focus:ring-blue-200"
                required>
        </div>

        <div>
            <label class="text-sm font-semibold">Password</label>
            <input type="password" name="password"
                class="w-full border border-gray-300 rounded-xl p-3 mt-1 focus:ring focus:ring-blue-200"
                required>
        </div>

        <button
            class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-blue-700 transition">
            Login
        </button>

    </form>
</div>

@endsection
