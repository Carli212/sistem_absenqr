@extends('admin.layout')

@section('title', 'Edit Peserta | Sistem Absensi QR')
@section('pageTitle', 'Edit Peserta')
@section('pageSubtitle', 'Perbarui data siswa')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="manual-card">
        <h2 class="section-title">✏️ Edit Data Peserta</h2>

        {{-- ALERT ERROR --}}
        @if ($errors->any())
            <div style="background:#fee2e2;padding:16px;border-radius:12px;margin-bottom:20px;">
                <ul style="color:#b91c1c;font-weight:600;">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom:20px;">
                <label style="font-weight:700;color:#334155;">Nama Peserta</label>
                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama', $user->nama) }}"
                    required
                    style="
                        width:100%;
                        margin-top:8px;
                        padding:14px;
                        border-radius:12px;
                        border:2px solid #c7d2fe;
                        font-weight:600;
                        outline:none;
                    "
                >
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end;">
                <a href="{{ route('admin.user.index') }}"
                   style="
                        padding:12px 24px;
                        border-radius:12px;
                        background:#e5e7eb;
                        font-weight:700;
                        text-decoration:none;
                        color:#374151;
                   ">
                    ← Batal
                </a>

                <button type="submit"
                    style="
                        padding:12px 28px;
                        border-radius:12px;
                        background:linear-gradient(135deg,#667eea,#764ba2);
                        color:white;
                        font-weight:800;
                        border:none;
                        cursor:pointer;
                    ">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
