@extends('admin.layout')

@section('title', 'Manajemen Peserta | Sistem Absensi QR')
@section('pageTitle', 'Manajemen Peserta')
@section('pageSubtitle', 'Kelola data siswa')

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

    /* Header Actions */
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .btn-add {
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
        text-decoration: none;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.4);
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.98) 100%);
        border-radius: 20px;
        padding: 24px;
        border: 2px solid;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        opacity: 0.1;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.blue {
        border-color: #93c5fd;
    }

    .stat-card.blue::before {
        background: #3b82f6;
    }

    .stat-card.green {
        border-color: #6ee7b7;
    }

    .stat-card.green::before {
        background: #10b981;
    }

    .stat-card.gray {
        border-color: #cbd5e1;
    }

    .stat-card.gray::before {
        background: #64748b;
    }

    .stat-card.purple {
        border-color: #c4b5fd;
    }

    .stat-card.purple::before {
        background: #8b5cf6;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 900;
        color: #1e293b;
    }

    .stat-icon {
        position: absolute;
        bottom: 16px;
        right: 16px;
        font-size: 48px;
        opacity: 0.15;
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

    .status-tidak-aktif {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
        border-color: #cbd5e1;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .btn-action {
        padding: 8px 16px;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 11px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-edit {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 2px 10px rgba(59, 130, 246, 0.25);
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 2px 10px rgba(239, 68, 68, 0.25);
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4);
    }

    .btn-action:active {
        transform: translateY(0);
    }

    /* User Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 900;
        font-size: 16px;
        margin-right: 12px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        vertical-align: middle;
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

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
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

        .btn-add {
            width: 100%;
            justify-content: center;
        }

        .table-manual thead th,
        .table-manual tbody td {
            padding: 12px 14px;
            font-size: 13px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
        }
    }
</style>

<div class="space-y-6 max-w-7xl mx-auto">

    {{-- HEADER WITH ADD BUTTON --}}
    <div class="header-actions">
        <div>
            <h1 class="section-title"
    style="
        margin-bottom: 8px;
        -webkit-text-fill-color: #ffffffff;
        background: none;
    ">
    👥 Daftar Peserta
</h1>

            <p style="color: #ffffffff; font-size: 14px; font-weight: 600;">Kelola data siswa yang terdaftar dalam sistem</p>
        </div>
        <a href="{{ route('admin.user.create') }}" class="btn-add">
            ➕ Tambah Siswa Baru
        </a>
    </div>

    {{-- STATISTICS CARDS --}}
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-label">👥 Total Peserta</div>
            <div class="stat-value">{{ $users->count() }}</div>
            <div class="stat-icon">👥</div>
        </div>

        <div class="stat-card green">
            <div class="stat-label">✅ Aktif Hari Ini</div>
            <div class="stat-value">{{ $aktifHariIni }}</div>
        </div>

        <div class="stat-card gray">
            <div class="stat-label">⏸️ Tidak Absen Hari Ini</div>
            <div class="stat-value">{{ $tidakAktifHariIni }}</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="manual-card">
        <h2 class="section-title">📋 Data Peserta</h2>

        <div class="table-wrapper">
            <table class="table-manual">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>👤 Nama</th>
                        <th>✅ Status Akun</th>
                        <th>📅 Tanggal Dibuat</th>
                        <th>⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                    <tr>
                        <td style="font-weight: 700;">{{ $loop->iteration }}</td>

                        <td>
                            <div style="display: flex; align-items: center;">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($u->nama ?? 'U', 0, 1)) }}
                                </div>
                                <span style="font-weight: 700;">{{ $u->nama }}</span>
                            </div>
                        </td>

                        <td>
                            @if($u->absensis->count())
                            <span class="status-badge status-hadir">
                                ✅ Hadir Hari Ini
                            </span>
                            @else
                            <span class="status-badge status-tidak-aktif">
                                ⏸️ Belum Absen
                            </span>
                            @endif
                        </td>


                        <td style="font-family: monospace; font-weight: 600; color: #64748b;">
                            {{ $u->created_at?->format('d/m/Y') ?? '-' }}
                        </td>

                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-edit"
                                    onclick="window.location.href='{{ route('admin.user.edit',$u->id) }}'">
                                    ✏️ Edit
                                </button>

                                <form method="POST"
                                    action="{{ route('admin.user.delete',$u->id) }}"
                                    onsubmit="return confirm('Hapus peserta ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">
                                        🗑️ Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <div class="empty-text">Belum ada data peserta</div>
                                <div style="margin-top: 24px;">
                                    <a href="{{ route('admin.user.create') }}" class="btn-add">
                                        ➕ Tambah Siswa Pertama
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function editUser(id) {
        // Redirect ke halaman edit
        window.location.href = `/admin/users/${id}/edit`;
    }
</script>

@endsection