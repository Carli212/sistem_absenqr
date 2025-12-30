@extends('admin.layout')

@section('title', 'Absensi Manual | Sistem Absensi QR')
@section('pageTitle', 'Absensi Manual')
@section('pageSubtitle', 'Kelola absensi siswa secara manual')

@section('content')

<style>
    /* Card Styling */
    .manual-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 36px;
        box-shadow: 
            0 10px 40px rgba(102, 126, 234, 0.15),
            0 0 1px rgba(255, 255, 255, 0.8) inset;
        border: 1px solid rgba(102, 126, 234, 0.2);
        transition: all 0.3s ease;
    }

    .manual-card:hover {
        box-shadow: 0 15px 50px rgba(102, 126, 234, 0.2);
    }

    /* Section Title */
    .section-title {
        font-size: 24px;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Alert Notifications */
    .alert-success {
        padding: 16px 24px;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 2px solid #6ee7b7;
        color: #065f46;
        border-radius: 14px;
        font-weight: 700;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideDown 0.4s ease;
    }

    .alert-error {
        padding: 16px 24px;
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: 2px solid #fca5a5;
        color: #991b1b;
        border-radius: 14px;
        font-weight: 700;
        margin-bottom: 24px;
        animation: shake 0.5s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    .error-list {
        list-style: disc;
        margin-left: 24px;
        margin-top: 8px;
        font-size: 14px;
    }

    /* Form Elements */
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.3s ease;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    /* Submit Button */
    .btn-submit {
        padding: 14px 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.4);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* Table Styling */
    .table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
        border: 2px solid #f1f5f9;
    }

    .table-manual {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-manual thead th {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 800;
        color: #4338ca;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-bottom: 2px solid #667eea;
    }

    .table-manual thead th:first-child {
        border-top-left-radius: 14px;
    }

    .table-manual thead th:last-child {
        border-top-right-radius: 14px;
        text-align: center;
    }

    .table-manual tbody tr {
        transition: all 0.2s ease;
        position: relative;
    }

    .table-manual tbody tr::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, transparent 100%);
        transition: width 0.3s ease;
        pointer-events: none;
    }

    .table-manual tbody tr:hover {
        background: rgba(224, 231, 255, 0.3);
        transform: translateX(4px);
    }

    .table-manual tbody tr:hover::after {
        width: 100%;
    }

    .table-manual tbody td {
        padding: 16px 20px;
        font-size: 14px;
        color: #1e293b;
        font-weight: 600;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-manual tbody tr:last-child td {
        border-bottom: none;
    }

    .table-manual tbody tr:last-child td:first-child {
        border-bottom-left-radius: 14px;
    }

    .table-manual tbody tr:last-child td:last-child {
        border-bottom-right-radius: 14px;
    }

    /* Status Badge */
    .status-badge {
        padding: 7px 16px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        border: 2px solid;
        transition: all 0.2s ease;
    }

    .status-badge:hover {
        transform: scale(1.05);
    }

    .status-hadir {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-color: #6ee7b7;
    }

    .status-terlambat {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border-color: #fcd34d;
    }

    .status-izin,
    .status-sakit {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
        border-color: #93c5fd;
    }

    .status-alpha {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-color: #fca5a5;
    }

    .status-manual {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
        border-color: #a5b4fc;
    }

    /* Delete Button */
    .btn-delete {
        padding: 8px 18px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(239, 68, 68, 0.25);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4);
    }

    .btn-delete:active {
        transform: translateY(0);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 56px 24px;
        color: #94a3b8;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.5;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .empty-text {
        font-size: 16px;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .manual-card {
            padding: 24px;
        }

        .section-title {
            font-size: 20px;
        }

        .btn-submit {
            width: 100%;
        }

        .table-manual thead th,
        .table-manual tbody td {
            padding: 12px 14px;
            font-size: 13px;
        }
    }
</style>

<div class="space-y-6 max-w-6xl mx-auto">

    {{-- FORM TAMBAH ABSENSI --}}
    <div class="manual-card">

        <h2 class="section-title">
            📝 Tambah Absensi Manual
        </h2>

        {{-- NOTIF SUCCESS --}}
        @if (session('success'))
            <div class="alert-success">
                <span style="font-size: 22px;">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- NOTIF ERROR --}}
        @if ($errors->any())
            <div class="alert-error">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <span style="font-size: 22px;">⚠️</span>
                        <strong>Terjadi kesalahan:</strong>
                    </div>
                    <ul class="error-list">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.absensi.manual.store') }}" method="POST"
              class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            @csrf

            {{-- Siswa --}}
            <div class="md:col-span-2">
                <label class="form-label">👤 Pilih Siswa</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="form-label">📅 Tanggal</label>
                <input type="date" name="tanggal"
                       value="{{ date('Y-m-d') }}"
                       class="form-input"
                       required>
            </div>

            {{-- Status --}}
            <div>
                <label class="form-label">✅ Status</label>
                <select name="status" class="form-select" required>
                    <option value="hadir">Hadir</option>
                    <option value="terlambat">Terlambat</option>
                    <option value="alpha">Alpha</option>
                    <option value="sakit">Sakit</option>
                    <option value="izin">Izin</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="text-right">
                <button type="submit" class="btn-submit">
                    💾 Simpan
                </button>
            </div>
        </form>

    </div>


    {{-- DAFTAR ABSENSI --}}
    <div class="manual-card">

        <h2 class="section-title">📋 Daftar Absensi Manual</h2>

        <div class="table-wrapper">
            <table class="table-manual">
                <thead>
                    <tr>
                        <th>👤 Nama</th>
                        <th>📅 Tanggal</th>
                        <th>✅ Status</th>
                        <th>🔧 Metode</th>
                        <th>🕐 Waktu</th>
                        <th>⚙️ Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($absensi as $item)
                        <tr>
                            <td style="font-weight: 700;">{{ $item->user->nama }}</td>

                            <td style="font-family: monospace; font-weight: 600;">
                                {{ $item->tanggal ? date('d/m/Y', strtotime($item->tanggal)) : '-' }}
                            </td>

                            <td>
                                <span class="status-badge 
                                    @if($item->status == 'hadir') status-hadir
                                    @elseif($item->status == 'terlambat') status-terlambat
                                    @elseif(in_array($item->status, ['izin','sakit'])) status-izin
                                    @elseif($item->status == 'manual') status-manual
                                    @else status-alpha @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            <td style="text-transform: capitalize; font-weight: 600;">
                                {{ $item->metode ? ucfirst($item->metode) : 'Manual' }}
                            </td>

                            <td style="font-family: monospace; font-weight: 600; color: #64748b;">
                                {{ $item->waktu_absen ? date('H:i:s', strtotime($item->waktu_absen)) : '-' }}
                            </td>

                            <td style="text-align: center;">
                                <form method="POST"
                                      action="{{ route('admin.absensi.manual.delete', $item->id) }}"
                                      onsubmit="return confirm('🗑️ Hapus entri absensi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <div class="empty-text">Belum ada data absensi manual</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection