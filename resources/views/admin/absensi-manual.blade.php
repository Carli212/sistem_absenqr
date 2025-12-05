@extends('admin.layout')

@section('title', 'Absensi Manual | Sistem Absensi QR')
@section('pageTitle', 'Absensi Manual')
@section('pageSubtitle', 'Kelola absensi siswa secara manual')

@section('content')

<style>
/* Card Styling */
.manual-card {
    background: white;
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 4px 20px rgba(74, 150, 104, 0.12);
    border: 2px solid #c8e6c9;
    transition: all 0.2s ease;
}

.manual-card:hover {
    box-shadow: 0 8px 28px rgba(74, 150, 104, 0.18);
}

/* Section Title */
.section-title {
    font-size: 22px;
    font-weight: 900;
    color: #1b4332;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Alert Notifications */
.alert-success {
    padding: 16px 20px;
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: 2px solid #6ee7b7;
    color: #065f46;
    border-radius: 14px;
    font-weight: 700;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideDown 0.3s ease;
}

.alert-error {
    padding: 16px 20px;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 2px solid #fca5a5;
    color: #991b1b;
    border-radius: 14px;
    font-weight: 700;
    margin-bottom: 24px;
    animation: shake 0.4s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-8px); }
    75% { transform: translateX(8px); }
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
    color: #2d5f3f;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-input,
.form-select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #c8e6c9;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 500;
    color: #1b4332;
    background: #f1f8f4;
    transition: all 0.2s ease;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #4a9668;
    background: white;
    box-shadow: 0 0 0 4px rgba(74, 150, 104, 0.1);
}

/* Submit Button */
.btn-submit {
    padding: 14px 28px;
    background: linear-gradient(135deg, #4a9668 0%, #2d5f3f 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(74, 150, 104, 0.3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 150, 104, 0.4);
}

.btn-submit:active {
    transform: translateY(0);
}

/* Table Styling */
.table-wrapper {
    overflow-x: auto;
    border-radius: 16px;
    border: 2px solid #e8f5e9;
}

.table-manual {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-manual thead th {
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    padding: 14px 16px;
    text-align: left;
    font-size: 12px;
    font-weight: 800;
    color: #2d5f3f;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #a5d6a7;
}

.table-manual thead th:first-child {
    border-top-left-radius: 14px;
}

.table-manual thead th:last-child {
    border-top-right-radius: 14px;
    text-align: center;
}

.table-manual tbody tr {
    transition: background 0.15s ease;
}

.table-manual tbody tr:hover {
    background: #f1f8f4;
}

.table-manual tbody td {
    padding: 14px 16px;
    font-size: 14px;
    color: #1b4332;
    font-weight: 600;
    border-bottom: 1px solid #e8f5e9;
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
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    display: inline-block;
    border: 2px solid;
}

.status-hadir {
    background: #d1fae5;
    color: #065f46;
    border-color: #6ee7b7;
}

.status-terlambat {
    background: #fef3c7;
    color: #92400e;
    border-color: #fcd34d;
}

.status-izin,
.status-sakit {
    background: #dbeafe;
    color: #1e3a8a;
    border-color: #93c5fd;
}

.status-alpha {
    background: #fee2e2;
    color: #991b1b;
    border-color: #fca5a5;
}

.status-manual {
    background: #e0e7ff;
    color: #3730a3;
    border-color: #a5b4fc;
}

/* Delete Button */
.btn-delete {
    padding: 8px 16px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
}

.btn-delete:active {
    transform: translateY(0);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 48px 24px;
    color: #4a9668;
}

.empty-icon {
    font-size: 56px;
    margin-bottom: 16px;
    opacity: 0.4;
}

.empty-text {
    font-size: 15px;
    font-weight: 600;
    font-style: italic;
}

/* Responsive */
@media (max-width: 768px) {
    .manual-card {
        padding: 24px;
    }

    .section-title {
        font-size: 18px;
    }

    .btn-submit {
        width: 100%;
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
                <span style="font-size: 20px;">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- NOTIF ERROR --}}
        @if ($errors->any())
            <div class="alert-error">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <span style="font-size: 20px;">⚠️</span>
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
                            <td>{{ $item->user->nama }}</td>

                            <td>
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

                            <td style="text-transform: capitalize;">
                                {{ $item->metode ? ucfirst($item->metode) : 'Manual' }}
                            </td>

                            <td style="font-family: monospace;">
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