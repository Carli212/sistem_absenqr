@extends('admin.layout')

@section('title', 'Pengaturan Sistem | Sistem Absensi QR')
@section('pageTitle', 'Pengaturan Sistem')
@section('pageSubtitle', 'Atur jam, mode absensi, dan preferensi admin')

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
        position: relative;
        overflow: hidden;
    }

    .manual-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
        pointer-events: none;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Section Title */
    .section-title {
        font-size: 28px;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 1;
    }

    /* Alert Success */
    .alert-success {
        padding: 20px 28px;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 3px solid #6ee7b7;
        color: #065f46;
        border-radius: 16px;
        font-weight: 700;
        margin-bottom: 24px;
        display: flex;
        align-items: start;
        gap: 16px;
        animation: slideDown 0.5s ease;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
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

    /* Tabs */
    .settings-tabs {
        display: flex;
        gap: 12px;
        border-bottom: 3px solid #e0e7ff;
        margin-bottom: 32px;
        padding-bottom: 16px;
        overflow-x: auto;
        position: relative;
        z-index: 1;
    }

    .settings-tab-btn {
        white-space: nowrap;
        padding: 14px 24px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 800;
        border: 2px solid transparent;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .settings-tab-btn .icon {
        font-size: 20px;
    }

    .settings-tab-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        transform: translateY(-2px);
    }

    .settings-tab-btn:not(.active):hover {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        border-color: #a5b4fc;
        color: #4338ca;
        transform: translateY(-2px);
    }

    /* Tab Content */
    .settings-section {
        display: none;
        animation: fadeIn 0.4s ease;
        position: relative;
        z-index: 1;
    }

    .settings-section.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Form Elements */
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 800;
        color: #475569;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .form-description {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 10px;
        line-height: 1.6;
        font-weight: 600;
    }

    .settings-input,
    .settings-select {
        width: 100%;
        padding: 14px 18px;
        border: 3px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.3s ease;
    }

    .settings-input:focus,
    .settings-select:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    /* Alert Notes */
    .alert-note {
        padding: 20px 24px;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 3px solid #93c5fd;
        border-radius: 16px;
        display: flex;
        align-items: start;
        gap: 16px;
        margin-bottom: 24px;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.15);
    }

    .alert-icon {
        font-size: 32px;
        flex-shrink: 0;
    }

    .alert-title {
        font-weight: 900;
        color: #1e3a8a;
        font-size: 15px;
        margin-bottom: 8px;
    }

    .alert-text {
        font-size: 13px;
        color: #1e40af;
        font-weight: 600;
        line-height: 1.7;
    }

    /* Badges */
    .settings-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #4338ca;
        border: 2px solid #a5b4fc;
    }

    .settings-pill {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border: 2px solid #fcd34d;
    }

    /* Buttons */
    .settings-save-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 36px;
        border-radius: 14px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        font-size: 15px;
        font-weight: 800;
        border: none;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .settings-save-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(16, 185, 129, 0.5);
    }

    .settings-save-btn:active {
        transform: translateY(-1px);
    }

    /* Info Cards */
    .info-card {
        padding: 24px;
        border-radius: 16px;
        border: 3px solid;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .info-card.green {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border-color: #6ee7b7;
    }

    .info-card.blue {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-color: #93c5fd;
    }

    .info-card.amber {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-color: #fcd34d;
    }

    .info-card.purple {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        border-color: #a5b4fc;
    }

    .info-card-title {
        font-size: 15px;
        font-weight: 900;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-card-text {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 12px;
        line-height: 1.6;
    }

    .info-card-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 10px;
        background: rgba(255,255,255,0.5);
        transition: all 0.2s ease;
    }

    .info-card-link:hover {
        background: rgba(255,255,255,0.8);
        transform: translateX(4px);
    }

    /* Preview Box */
    .preview-box {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 3px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        margin-top: 16px;
    }

    .preview-title {
        font-size: 13px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .preview-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .preview-list li {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        padding: 8px 0;
        padding-left: 28px;
        position: relative;
    }

    .preview-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #10b981;
        font-weight: 900;
        font-size: 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .manual-card {
            padding: 24px;
        }

        .section-title {
            font-size: 22px;
        }

        .settings-tabs {
            gap: 8px;
        }

        .settings-tab-btn {
            padding: 10px 16px;
            font-size: 12px;
        }
    }
</style>

<div class="max-w-6xl mx-auto space-y-6">

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="alert-success">
            <div class="alert-icon">✅</div>
            <div>
                <div style="font-size: 16px; font-weight: 900; margin-bottom: 4px;">Pengaturan Berhasil Disimpan!</div>
                <div style="font-size: 14px;">{{ session('success') }}</div>
                <div style="font-size: 12px; margin-top: 8px; opacity: 0.9;">
                    Perubahan langsung digunakan di dashboard siswa & admin.
                </div>
            </div>
        </div>
    @endif

    {{-- MAIN CARD --}}
    <div class="manual-card">
        <div style="position: relative; z-index: 1;">
            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="section-title">
                        ⚙️ Panel Pengaturan Sistem
                        <span class="settings-pill">Advanced</span>
                    </h2>
                    <p style="color: #64748b; font-size: 14px; font-weight: 600;">
                        Semua aturan inti sistem tersentral di satu tempat. Ubah sekali, berlaku untuk seluruh modul.
                    </p>
                </div>
            </div>

            {{-- TABS --}}
            <div class="settings-tabs">
                <button class="settings-tab-btn active" data-tab="absen">
                    <span class="icon">🕒</span>
                    <span>Jam & Mode</span>
                </button>
                <button class="settings-tab-btn" data-tab="export">
                    <span class="icon">📤</span>
                    <span>Export & Rekap</span>
                </button>
                <button class="settings-tab-btn" data-tab="user">
                    <span class="icon">👥</span>
                    <span>Manajemen</span>
                </button>
                <button class="settings-tab-btn" data-tab="system">
                    <span class="icon">🌐</span>
                    <span>Sistem</span>
                </button>
            </div>

            {{-- TAB: JAM & MODE ABSENSI --}}
            <div class="settings-section active" id="tab-absen">
                <div class="alert-note">
                    <div class="alert-icon">💡</div>
                    <div>
                        <div class="alert-title">Mode absensi mempengaruhi cara sistem menilai keterlambatan</div>
                        <div class="alert-text">
                            Jam & mode di sini dipakai di halaman dashboard siswa untuk menghitung status
                            <b>Datang Awal / Tepat Waktu / Terlambat</b>.
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Jam Awal --}}
                        <div>
                            <label class="form-label">⏰ Jam Masuk Paling Awal</label>
                            <p class="form-description">
                                Di bawah jam ini akan dihitung sebagai <b>Datang terlalu awal</b>.
                            </p>
                            <input type="time"
                                   name="jam_awal"
                                   value="{{ old('jam_awal', $jamAwal) }}"
                                   class="settings-input">
                            @error('jam_awal')
                                <p style="color: #ef4444; font-size: 12px; margin-top: 6px; font-weight: 600;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jam Tepat --}}
                        <div>
                            <label class="form-label">✅ Batas Datang Tepat Waktu</label>
                            <p class="form-description">
                                Sampai jam ini masih dihitung <b>Datang Awal</b>, setelahnya jadi <b>Tepat Waktu</b>.
                            </p>
                            <input type="time"
                                   name="jam_tepat"
                                   value="{{ old('jam_tepat', $jamTepat) }}"
                                   class="settings-input">
                            @error('jam_tepat')
                                <p style="color: #ef4444; font-size: 12px; margin-top: 6px; font-weight: 600;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jam Terlambat --}}
                        <div>
                            <label class="form-label">⚠️ Batas Akhir Tidak Terlambat</label>
                            <p class="form-description">
                                Di atas jam ini status otomatis <b>Terlambat</b>.
                            </p>
                            <input type="time"
                                   name="jam_terlambat"
                                   value="{{ old('jam_terlambat', $jamTerlambat) }}"
                                   class="settings-input">
                            @error('jam_terlambat')
                                <p style="color: #ef4444; font-size: 12px; margin-top: 6px; font-weight: 600;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Mode Absen --}}
                        <div>
                            <label class="form-label">🎯 Mode Penilaian Absensi</label>
                            <p class="form-description">
                                Atur seberapa ketat sekolah menilai keterlambatan siswa.
                            </p>
                            <select name="mode_absen" class="settings-select">
                                <option value="strict" {{ $modeAbsen === 'strict' ? 'selected' : '' }}>
                                    🔴 Strict — Toleransi kecil, banyak siswa jadi "terlambat"
                                </option>
                                <option value="normal" {{ $modeAbsen === 'normal' ? 'selected' : '' }}>
                                    🟡 Normal — Seimbang antara disiplin dan realita
                                </option>
                                <option value="relaxed" {{ $modeAbsen === 'relaxed' ? 'selected' : '' }}>
                                    🟢 Relaxed — Cocok untuk uji coba / masa transisi
                                </option>
                            </select>
                            @error('mode_absen')
                                <p style="color: #ef4444; font-size: 12px; margin-top: 6px; font-weight: 600;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="preview-box">
                                <div class="preview-title">📊 Preview Singkat</div>
                                <p class="form-description">Aturan ini langsung dipakai di:</p>
                                <ul class="preview-list">
                                    <li>Dashboard siswa (Status + Selisih menit)</li>
                                    <li>Riwayat absensi (label Terlambat / Tepat waktu)</li>
                                    <li>Perhitungan laporan rekap</li>
                                </ul>
                            </div>
                            <div style="margin-top: 16px;">
                                <span class="settings-badge">
                                    🧠 Tersimpan di tabel <code>settings</code>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div style="border-top: 3px solid #e0e7ff; padding-top: 24px; margin-top: 32px;">
                        <div style="display: flex; justify-content: flex-end;">
                            <button type="submit" class="settings-save-btn">
                                💾 Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- TAB: EXPORT & REKAP --}}
            <div class="settings-section" id="tab-export">
                <div class="alert-note">
                    <div class="alert-icon">📤</div>
                    <div>
                        <div class="alert-title">Export Rekap Sudah Siap Dipakai</div>
                        <div class="alert-text">
                            Di halaman <b>Rekap Absensi</b> kamu bisa filter tanggal lalu klik tombol
                            <b>Export</b> untuk mengunduh data dalam bentuk CSV yang bisa dibuka di Excel.
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="info-card green">
                        <div class="info-card-title" style="color: #065f46;">
                            📊 Rekap per Tanggal
                        </div>
                        <div class="info-card-text" style="color: #047857;">
                            Gunakan halaman rekap untuk melihat siapa saja yang hadir/tidak hadir pada tanggal tertentu.
                        </div>
                        <a href="{{ route('admin.rekap') }}" class="info-card-link" style="color: #065f46;">
                            Buka Halaman Rekap →
                        </a>
                    </div>

                    <div class="info-card blue">
                        <div class="info-card-title" style="color: #1e3a8a;">
                            📥 Export ke Excel (CSV)
                        </div>
                        <div class="info-card-text" style="color: #1e40af;">
                            Filter tanggal → klik export → file siap didownload.
                            Format: Nama, Tanggal, Waktu, Status, Metode, IP.
                        </div>
                        <div style="font-size: 11px; color: #3b82f6; font-weight: 700;">
                            Route: <code>admin.rekap.export</code>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB: MANAJEMEN --}}
            <div class="settings-section" id="tab-user">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="info-card green">
                        <div class="info-card-title" style="color: #065f46;">
                            ➕ Tambah Siswa Baru
                        </div>
                        <div class="info-card-text" style="color: #047857;">
                            Formulir sederhana untuk menambah akun siswa, lengkap dengan password otomatis.
                        </div>
                        <a href="{{ route('admin.user.create') }}" class="info-card-link" style="color: #065f46;">
                            Buka Halaman Tambah Siswa →
                        </a>
                    </div>

                    <div class="info-card amber">
                        <div class="info-card-title" style="color: #92400e;">
                            ✏️ Kelola Absensi Manual
                        </div>
                        <div class="info-card-text" style="color: #b45309;">
                            Untuk koreksi data, izin khusus, atau perbaikan absensi yang lupa tercatat.
                        </div>
                        <a href="{{ route('admin.absensi.manual') }}" class="info-card-link" style="color: #92400e;">
                            Buka Absensi Manual →
                        </a>
                    </div>

                    <div class="info-card blue">
                        <div class="info-card-title" style="color: #1e3a8a;">
                            👥 Daftar Peserta
                        </div>
                        <div class="info-card-text" style="color: #1e40af;">
                            Lihat semua siswa yang terdaftar, edit data, dan kelola status akun.
                        </div>
                        <a href="{{ route('admin.user.index') }}" class="info-card-link" style="color: #1e3a8a;">
    Buka Manajemen Peserta →
</a>

                    </div>

                    <div class="info-card purple">
                        <div class="info-card-title" style="color: #4338ca;">
                            📅 Kalender Absensi
                        </div>
                        <div class="info-card-text" style="color: #4f46e5;">
                            Visualisasi kehadiran dalam bentuk kalender interaktif bulanan.
                        </div>
                        <a href="{{ route('admin.calendar') }}" class="info-card-link" style="color: #4338ca;">
                            Buka Kalender →
                        </a>
                    </div>
                </div>
            </div>

            {{-- TAB: SISTEM --}}
            <div class="settings-section" id="tab-system">
                <div class="alert-note">
                    <div class="alert-icon">🚧</div>
                    <div>
                        <div class="alert-title">Zona Pengembangan Berikutnya</div>
                        <div class="alert-text">
                            Di sini nanti bisa ditambahkan:
                            <ul style="list-style: disc; margin-left: 20px; margin-top: 8px;">
                                <li>Identitas sekolah (nama, logo, alamat)</li>
                                <li>Tahun ajaran aktif & periode</li>
                                <li>Opsi reset arsip per tahun ajaran</li>
                                <li>Pengaturan notifikasi & reminder</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 24px; padding: 24px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 16px; border: 3px solid #e2e8f0;">
                    <p style="font-size: 14px; color: #475569; font-weight: 600; line-height: 1.8;">
                        Saat ini pengaturan inti sudah difokuskan ke <b>jam & mode absensi</b> dulu supaya fungsi
                        utama sistem bisa stabil tanpa menambah kompleksitas berlebihan. Fitur-fitur tambahan akan
                        dikembangkan secara bertahap sesuai kebutuhan.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const tabButtons = document.querySelectorAll('.settings-tab-btn');
    const tabSections = document.querySelectorAll('.settings-section');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-tab');

            // Update active tab
            tabButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Show target section
            tabSections.forEach(sec => {
                if (sec.id === 'tab-' + target) {
                    sec.classList.add('active');
                } else {
                    sec.classList.remove('active');
                }
            });
        });
    });
</script>

@endsection