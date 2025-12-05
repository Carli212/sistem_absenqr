@extends('admin.layout')

@section('title', 'Pengaturan Sistem | Sistem Absensi QR')
@section('pageTitle', 'Pengaturan Sistem')
@section('pageSubtitle', 'Atur jam, mode absensi, dan preferensi admin')

@section('content')

<style>
    .settings-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(15, 118, 110, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .settings-tabs {
        display: flex;
        gap: 8px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 16px;
        overflow-x: auto;
        padding-bottom: 4px;
    }

    .settings-tab-btn {
        white-space: nowrap;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid transparent;
        background: transparent;
        color: #475569;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .settings-tab-btn span.icon {
        font-size: 15px;
    }

    .settings-tab-btn.active {
        background: linear-gradient(135deg, #22c55e, #0ea5e9);
        color: #ffffff;
        border-color: rgba(34, 197, 94, 0.8);
        box-shadow: 0 3px 12px rgba(34, 197, 94, 0.45);
    }

    .settings-tab-btn:not(.active):hover {
        background: #ecfeff;
        border-color: #bae6fd;
        color: #0369a1;
    }

    .settings-section {
        display: none;
    }

    .settings-section.active {
        display: block;
    }

    .settings-label {
        font-size: 13px;
        font-weight: 700;
        color: #064e3b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .settings-description {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .settings-input,
    .settings-select {
        width: 100%;
        border-radius: 12px;
        border: 2px solid #d1fae5;
        padding: 10px 12px;
        font-size: 14px;
        font-weight: 500;
        color: #0f172a;
        background: #ecfdf5;
        transition: all 0.15s ease;
    }

    .settings-input:focus,
    .settings-select:focus {
        outline: none;
        border-color: #22c55e;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.25);
    }

    .settings-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #bbf7d0;
    }

    .settings-save-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(22, 163, 74, 0.4);
        transition: all 0.15s ease;
    }

    .settings-save-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(22, 163, 74, 0.5);
    }

    .settings-save-btn:active {
        transform: translateY(0);
    }

    .settings-pill {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 999px;
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bfdbfe;
    }

    .settings-alert {
        border-radius: 14px;
        padding: 10px 12px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13px;
        margin-bottom: 14px;
    }

    .settings-alert-success {
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .settings-alert-note {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e3a8a;
    }

    .settings-alert-icon {
        font-size: 16px;
        margin-top: 1px;
    }

    @media (max-width: 768px) {
        .settings-card {
            padding: 18px;
        }
    }
</style>

<div class="max-w-5xl mx-auto space-y-5">

    {{-- Flash success --}}
    @if(session('success'))
        <div class="settings-alert settings-alert-success">
            <div class="settings-alert-icon">✅</div>
            <div>
                <strong>{{ session('success') }}</strong>
                <div class="text-xs text-emerald-700 mt-1">
                    Perubahan langsung digunakan di dashboard siswa & admin.
                </div>
            </div>
        </div>
    @endif

    <div class="settings-card">

        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    ⚙ Panel Pengaturan
                    <span class="settings-pill">Futuristic</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Semua aturan inti sistem tersentral di satu tempat. Ubah sekali, berlaku untuk seluruh modul.
                </p>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="settings-tabs" id="settingsTabs">
            <button class="settings-tab-btn active" data-tab="absen">
                <span class="icon">🕒</span>
                Jam & Mode Absensi
            </button>
            <button class="settings-tab-btn" data-tab="export">
                <span class="icon">📤</span>
                Export & Rekap
            </button>
            <button class="settings-tab-btn" data-tab="user">
                <span class="icon">👥</span>
                Manajemen Siswa
            </button>
            <button class="settings-tab-btn" data-tab="system">
                <span class="icon">🌐</span>
                Sistem & Tahun Ajaran
            </button>
        </div>

        {{-- TAB: ABSEN SETTINGS (fungsional) --}}
        <div class="settings-section active" id="tab-absen">

            <div class="settings-alert settings-alert-note">
                <div class="settings-alert-icon">💡</div>
                <div>
                    <strong>Mode absensi mempengaruhi cara sistem menilai keterlambatan.</strong>
                    <div class="text-xs mt-1">
                        Jam & mode di sini juga dipakai di halaman dashboard siswa untuk menghitung status
                        <span class="font-semibold">Datang Awal / Tepat Waktu / Terlambat</span>.
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Jam Awal --}}
                    <div>
                        <label class="settings-label">Jam Masuk Paling Awal</label>
                        <p class="settings-description">
                            Di bawah jam ini akan dihitung sebagai <b>Datang terlalu awal</b>.
                        </p>
                        <input type="time"
                               name="jam_awal"
                               value="{{ old('jam_awal', $jamAwal) }}"
                               class="settings-input">
                        @error('jam_awal')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jam Tepat --}}
                    <div>
                        <label class="settings-label">Batas Datang Awal / Tepat Waktu</label>
                        <p class="settings-description">
                            Sampai jam ini masih dihitung <b>Datang Awal</b>, setelahnya jadi <b>Tepat Waktu</b>/<b>Terlambat</b>.
                        </p>
                        <input type="time"
                               name="jam_tepat"
                               value="{{ old('jam_tepat', $jamTepat) }}"
                               class="settings-input">
                        @error('jam_tepat')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jam Terlambat --}}
                    <div>
                        <label class="settings-label">Batas Akhir Tidak Terlambat</label>
                        <p class="settings-description">
                            Di atas jam ini status otomatis <b>Terlambat</b>.
                        </p>
                        <input type="time"
                               name="jam_terlambat"
                               value="{{ old('jam_terlambat', $jamTerlambat) }}"
                               class="settings-input">
                        @error('jam_terlambat')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Mode Absen --}}
                    <div>
                        <label class="settings-label">Mode Penilaian Absensi</label>
                        <p class="settings-description">
                            Atur seberapa ketat sekolah menilai keterlambatan siswa.
                        </p>
                        <select name="mode_absen" class="settings-select">
                            <option value="strict" {{ $modeAbsen === 'strict' ? 'selected' : '' }}>
                                Strict — toleransi kecil, banyak siswa jadi "terlambat"
                            </option>
                            <option value="normal" {{ $modeAbsen === 'normal' ? 'selected' : '' }}>
                                Normal — seimbang antara disiplin dan realita
                            </option>
                            <option value="relaxed" {{ $modeAbsen === 'relaxed' ? 'selected' : '' }}>
                                Relaxed — cocok untuk uji coba / masa transisi
                            </option>
                        </select>
                        @error('mode_absen')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col justify-between gap-3">
                        <div>
                            <div class="settings-label">Preview Singkat</div>
                            <p class="settings-description">
                                Aturan ini langsung dipakai di:
                            </p>
                            <ul class="text-xs text-slate-600 list-disc ml-4 space-y-1">
                                <li>Dashboard siswa (Status + Selisih menit)</li>
                                <li>Riwayat absensi (label Terlambat / Tepat waktu)</li>
                                <li>Perhitungan laporan rekap</li>
                            </ul>
                        </div>
                        <div>
                            <span class="settings-badge">
                                <span>🧠</span> Semua perubahan tersimpan di tabel <code>settings</code>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="settings-save-btn">
                        💾 Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        {{-- TAB: EXPORT & REKAP (informasi + link) --}}
        <div class="settings-section" id="tab-export">
            <div class="settings-alert settings-alert-note">
                <div class="settings-alert-icon">📤</div>
                <div>
                    <strong>Export Rekap Sudah Siap Dipakai.</strong>
                    <div class="text-xs mt-1">
                        Di halaman <b>Rekap Absensi</b> kamu bisa filter tanggal lalu klik tombol
                        <b>Export</b> untuk mengunduh data dalam bentuk CSV yang bisa dibuka di Excel.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="p-4 rounded-xl border border-emerald-100 bg-emerald-50/60">
                    <h3 class="text-sm font-bold text-emerald-800 mb-1">Rekap per Tanggal</h3>
                    <p class="text-xs text-emerald-900 mb-2">
                        Gunakan halaman rekap untuk melihat siapa saja yang hadir/tidak hadir pada tanggal tertentu.
                    </p>
                    <a href="{{ route('admin.rekap') }}"
                       class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-800 underline">
                        Buka halaman Rekap →
                    </a>
                </div>

                <div class="p-4 rounded-xl border border-sky-100 bg-sky-50/70">
                    <h3 class="text-sm font-bold text-sky-900 mb-1">Export ke Excel (CSV)</h3>
                    <p class="text-xs text-sky-900 mb-2">
                        Tombol export menggunakan route <code>admin.rekap.export</code>.
                        Filter tanggal → klik export → file siap didownload.
                    </p>
                    <p class="text-[11px] text-sky-700">
                        Format kolom: Nama, Tanggal, Waktu, Status, Metode, IP Address.
                    </p>
                </div>
            </div>
        </div>

        {{-- TAB: MANAJEMEN SISWA (shortcut ke halaman yang sudah ada) --}}
        <div class="settings-section" id="tab-user">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">

                <div class="p-4 rounded-xl border border-emerald-100 bg-emerald-50/60">
                    <h3 class="text-sm font-bold text-emerald-900 mb-1">Tambah Siswa Baru</h3>
                    <p class="text-xs text-emerald-900 mb-2">
                        Formulir sederhana untuk menambah akun siswa, lengkap dengan password otomatis.
                    </p>
                    <a href="{{ route('admin.user.create') }}"
                       class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-800 underline">
                        Buka halaman Tambah Siswa →
                    </a>
                </div>

                <div class="p-4 rounded-xl border border-amber-100 bg-amber-50/70">
                    <h3 class="text-sm font-bold text-amber-900 mb-1">Kelola Absensi Manual</h3>
                    <p class="text-xs text-amber-900 mb-2">
                        Untuk koreksi data, izin khusus, atau perbaikan absensi yang lupa tercatat.
                    </p>
                    <a href="{{ route('admin.absensi.manual') }}"
                       class="inline-flex items-center gap-1 text-xs font-semibold text-amber-800 underline">
                        Buka halaman Absensi Manual →
                    </a>
                </div>

            </div>

            <p class="text-[11px] text-slate-500 mt-4">
                Untuk versi berikutnya, tab ini bisa diupgrade menjadi <b>manajemen peserta lengkap</b>:
                filter by kelas, status (aktif/lulus), dan summary kehadiran.
            </p>
        </div>

        {{-- TAB: SISTEM & TAHUN AJARAN (placeholder untuk next phase) --}}
        <div class="settings-section" id="tab-system">
            <div class="settings-alert settings-alert-note">
                <div class="settings-alert-icon">🚧</div>
                <div>
                    <strong>Zona Pengembangan Berikutnya.</strong>
                    <div class="text-xs mt-1">
                        Di sini nanti kita bisa taruh:
                        <ul class="list-disc ml-4 mt-1 space-y-1">
                            <li>Identitas sekolah (nama, logo, alamat)</li>
                            <li>Tahun ajaran aktif & periode</li>
                            <li>Opsi reset arsip per tahun ajaran</li>
                        </ul>
                    </div>
                </div>
            </div>

            <p class="text-xs text-slate-600 mt-3">
                Saat ini pengaturan inti sudah difokuskan ke <b>jam & mode absensi</b> dulu supaya fungsi
                utama sistem bisa stabil tanpa nambah kompleksitas berlebihan.
            </p>
        </div>

    </div>
</div>

<script>
    const tabButtons = document.querySelectorAll('.settings-tab-btn');
    const tabSections = document.querySelectorAll('.settings-section');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-tab');

            tabButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

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
