@extends('admin.layout')

@section('title', 'Rekap Absensi | Sistem Absensi QR')
@section('pageTitle', 'Rekap Absensi')

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

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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

    .stat-card.green {
        border-color: #6ee7b7;
    }

    .stat-card.green::before {
        background: #10b981;
    }

    .stat-card.yellow {
        border-color: #fcd34d;
    }

    .stat-card.yellow::before {
        background: #f59e0b;
    }

    .stat-card.blue {
        border-color: #93c5fd;
    }

    .stat-card.blue::before {
        background: #3b82f6;
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

    /* Filter Section */
    .filter-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px 16px 0 0;
        padding: 20px 28px;
        color: white;
        font-weight: 900;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .filter-content {
        background: white;
        border-radius: 0 0 16px 16px;
        padding: 28px;
        border: 2px solid #e0e7ff;
        border-top: none;
    }

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
        width: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.4);
    }

    .btn-reset {
        padding: 14px 32px;
        background: #f1f5f9;
        color: #475569;
        border: 2px solid #cbd5e1;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        width: 100%;
    }

    .btn-reset:hover {
        background: #e2e8f0;
        border-color: #94a3b8;
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
    }

    /* ===== MODERN PAGINATION STYLING ===== */
    .custom-pagination-wrapper {
        margin-top: 36px;
        padding-top: 32px;
        border-top: 3px solid #e0e7ff;
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }

    /* Pagination Info */
    .custom-pagination-info {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 16px 32px;
        border-radius: 16px;
        border: 2px solid #e0e7ff;
        font-size: 15px;
        font-weight: 600;
        color: #64748b;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .custom-pagination-info strong {
        color: #667eea;
        font-weight: 900;
        font-size: 17px;
        padding: 0 4px;
    }

    /* Pagination Container */
    .custom-pagination {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* Pagination Button Base */
    .custom-page-btn {
        min-width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 16px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid #e2e8f0;
        background: white;
        color: #475569;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .custom-page-btn:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    }

    /* Active Page */
    .custom-page-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        cursor: default;
        position: relative;
    }

    .custom-page-btn.active::before {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 3px;
        background: white;
        border-radius: 2px;
    }

    .custom-page-btn.active:hover {
        transform: translateY(0);
    }

    /* Disabled State */
    .custom-page-btn.disabled {
        background: #f1f5f9;
        color: #cbd5e1;
        border-color: #e2e8f0;
        cursor: not-allowed;
        opacity: 0.5;
        pointer-events: none;
    }

    /* Previous & Next Buttons */
    .custom-page-btn.nav-btn {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-size: 12px;
        padding: 0 20px;
        gap: 8px;
    }

    /* Dots */
    .custom-page-dots {
        min-width: auto;
        padding: 0 8px;
        color: #94a3b8;
        font-size: 16px;
        font-weight: 900;
        border: none;
        background: transparent;
        box-shadow: none;
        cursor: default;
    }

    .custom-page-dots:hover {
        transform: none;
        background: transparent;
        color: #94a3b8;
        box-shadow: none;
    }

    /* Animation */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .custom-pagination-wrapper {
        animation: slideUp 0.5s ease-out;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .custom-pagination {
            gap: 6px;
        }
        
        .custom-page-btn {
            min-width: 38px;
            height: 38px;
            font-size: 13px;
            padding: 0 12px;
        }
        
        .custom-page-btn.nav-btn {
            padding: 0 16px;
            font-size: 11px;
        }
        
        .custom-pagination-info {
            font-size: 13px;
            padding: 12px 20px;
        }

        .custom-pagination-info strong {
            font-size: 15px;
        }
    }

    @media (max-width: 480px) {
        .custom-page-btn {
            min-width: 36px;
            height: 36px;
            font-size: 12px;
        }
        
        .custom-pagination-info {
            font-size: 12px;
            padding: 10px 16px;
        }

        .custom-pagination-info strong {
            font-size: 14px;
        }
    }
</style>

<div class="space-y-6 max-w-7xl mx-auto">

    {{-- STATS CARDS --}}
    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-label">✅ Total Hadir</div>
            <div class="stat-value">{{ $rekap->where('status', 'hadir')->count() }}</div>
            <div class="stat-icon">✅</div>
        </div>

        <div class="stat-card yellow">
            <div class="stat-label">⏰ Terlambat</div>
            <div class="stat-value">{{ $rekap->where('status', 'terlambat')->count() }}</div>
            <div class="stat-icon">⏰</div>
        </div>

        <div class="stat-card blue">
            <div class="stat-label">📋 Izin/Sakit</div>
            <div class="stat-value">{{ $rekap->whereIn('status', ['izin', 'sakit'])->count() }}</div>
            <div class="stat-icon">📋</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-label">📊 Total Data</div>
            <div class="stat-value">{{ $rekap->count() }}</div>
            <div class="stat-icon">📊</div>
        </div>
    </div>

    {{-- FILTER CARD --}}
    <div style="margin-bottom: 32px;">
        <div class="filter-header">
            🔍 Filter & Pencarian
        </div>
        <div class="filter-content">
            <form method="GET" action="{{ route('admin.rekap') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                {{-- Tanggal --}}
                <div>
                    <label class="form-label">📅 Tanggal</label>
                    <input type="date" name="tanggal"
                        value="{{ request('tanggal') }}"
                        class="form-input">
                </div>

                {{-- Status --}}
                <div>
                    <label class="form-label">✅ Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div class="flex items-end">
                    <button type="submit" class="btn-submit">
                        🔍 Terapkan Filter
                    </button>
                </div>

                {{-- Reset --}}
                @if(request()->hasAny(['tanggal', 'status']))
                <div class="flex items-end">
                    <a href="{{ route('admin.rekap') }}" class="btn-reset" style="text-decoration: none; display: block; text-align: center;">
                        🔄 Reset
                    </a>
                </div>
                @endif

            </form>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="manual-card">
        <h2 class="section-title">📊 Data Rekap Absensi</h2>

        <div class="table-wrapper">
            <table class="table-manual">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>👤 Nama Karyawan</th>
                        <th>📅 Tanggal</th>
                        <th>🕐 Waktu</th>
                        <th>✅ Status</th>
                        <th>🔧 Metode</th>
                        <th>🌐 IP Address</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rekap as $i => $r)
                    <tr>
                        <td style="font-weight: 700;">{{ ($rekap->currentPage() - 1) * $rekap->perPage() + $i + 1 }}</td>

                        <td>
                            <div style="display: flex; align-items: center;">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($r->user->nama ?? 'U', 0, 1)) }}
                                </div>
                                <span style="font-weight: 700;">{{ $r->user->nama ?? '-' }}</span>
                            </div>
                        </td>

                        <td style="font-family: monospace; font-weight: 600;">
                            {{ \Carbon\Carbon::parse($r->waktu_absen)->format('d/m/Y') }}
                        </td>

                        <td style="font-family: monospace; font-weight: 600; color: #64748b;">
                            {{ \Carbon\Carbon::parse($r->waktu_absen)->format('H:i:s') }}
                        </td>

                        <td>
                            @php
                                $statusClass = match($r->status){
                                    'hadir' => 'status-hadir',
                                    'terlambat' => 'status-terlambat',
                                    'izin','sakit' => 'status-izin',
                                    default => 'status-alpha'
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>

                        <td style="text-transform: capitalize; font-weight: 600;">
                            {{ strtoupper($r->metode ?? '-') }}
                        </td>

                        <td style="font-family: monospace; font-size: 12px; color: #64748b;">
                            {{ $r->ip_address ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <div class="empty-text">Tidak ada data absensi</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Custom Pagination --}}
        @if($rekap->hasPages())
        <div class="custom-pagination-wrapper">
            {{-- Pagination Info --}}
            <div class="custom-pagination-info">
                📊 Menampilkan 
                <strong>{{ $rekap->firstItem() }}</strong> 
                sampai 
                <strong>{{ $rekap->lastItem() }}</strong> 
                dari 
                <strong>{{ $rekap->total() }}</strong> 
                data
            </div>
            
            {{-- Pagination Links --}}
            <div class="custom-pagination">
                {{-- Previous Button --}}
                @if ($rekap->onFirstPage())
                    <span class="custom-page-btn nav-btn disabled">
                        ← Prev
                    </span>
                @else
                    <a href="{{ $rekap->previousPageUrl() }}" class="custom-page-btn nav-btn">
                        ← Prev
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($rekap->getUrlRange(1, $rekap->lastPage()) as $page => $url)
                    @if ($page == $rekap->currentPage())
                        <span class="custom-page-btn active">{{ $page }}</span>
                    @elseif ($page == 1 || $page == $rekap->lastPage() || abs($page - $rekap->currentPage()) <= 2)
                        <a href="{{ $url }}" class="custom-page-btn">{{ $page }}</a>
                    @elseif (abs($page - $rekap->currentPage()) == 3)
                        <span class="custom-page-dots">⋯</span>
                    @endif
                @endforeach

                {{-- Next Button --}}
                @if ($rekap->hasMorePages())
                    <a href="{{ $rekap->nextPageUrl() }}" class="custom-page-btn nav-btn">
                        Next →
                    </a>
                @else
                    <span class="custom-page-btn nav-btn disabled">
                        Next →
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

@endsection