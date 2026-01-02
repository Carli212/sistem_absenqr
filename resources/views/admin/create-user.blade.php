@extends('admin.layout')

@section('title', 'Tambah Siswa | Sistem Absensi QR')
@section('pageTitle', 'Tambah Siswa')

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

    .manual-card:hover {
        box-shadow: 0 15px 50px rgba(102, 126, 234, 0.2);
        transform: translateY(-2px);
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
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Alert Notifications */
    .alert-success {
        padding: 20px 28px;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 3px solid #6ee7b7;
        color: #065f46;
        border-radius: 16px;
        font-weight: 700;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        animation: slideDown 0.5s ease;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
    }

    .alert-password {
        padding: 32px;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 4px solid #3b82f6;
        border-radius: 24px;
        margin-bottom: 32px;
        animation: slideDown 0.5s ease, pulse 2s ease-in-out infinite;
        box-shadow: 0 12px 32px rgba(59, 130, 246, 0.3);
        position: relative;
        overflow: hidden;
    }

    .alert-password::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
        animation: shine 3s linear infinite;
    }

    @keyframes shine {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 12px 32px rgba(59, 130, 246, 0.3);
        }
        50% {
            box-shadow: 0 12px 32px rgba(59, 130, 246, 0.5);
        }
    }

    .password-box {
        background: white;
        border: 4px solid #3b82f6;
        border-radius: 16px;
        padding: 24px;
        margin: 20px 0;
        text-align: center;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.2) inset;
        position: relative;
    }

    .password-label {
        font-size: 13px;
        font-weight: 800;
        color: #3b82f6;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 12px;
    }

    .password-value {
        font-family: 'Courier New', monospace;
        font-size: 40px;
        font-weight: 900;
        color: #dc2626;
        letter-spacing: 6px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        animation: blink 2s ease-in-out infinite;
        user-select: all;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .copy-btn {
        margin-top: 16px;
        padding: 12px 32px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .copy-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(59, 130, 246, 0.4);
    }

    .alert-error {
        padding: 20px 28px;
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: 3px solid #fca5a5;
        color: #991b1b;
        border-radius: 16px;
        font-weight: 700;
        margin-bottom: 24px;
        animation: shake 0.5s ease;
        box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-8px); }
        20%, 40%, 60%, 80% { transform: translateX(8px); }
    }

    .error-list {
        list-style: none;
        margin-left: 0;
        margin-top: 12px;
        font-size: 14px;
    }

    .error-list li {
        padding: 8px 0;
        padding-left: 32px;
        position: relative;
    }

    .error-list li::before {
        content: '❌';
        position: absolute;
        left: 0;
        font-size: 16px;
    }

    /* Form Elements */
    .form-group {
        position: relative;
        animation: fadeInUp 0.6s ease;
        animation-fill-mode: both;
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }
    .form-group:nth-child(4) { animation-delay: 0.4s; }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 800;
        color: #475569;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label .required {
        color: #ef4444;
        font-size: 18px;
        animation: pulse 1.5s ease-in-out infinite;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 16px 20px;
        border: 3px solid #e2e8f0;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 6px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    .form-input::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    .form-hint {
        font-size: 13px;
        color: #64748b;
        margin-top: 10px;
        display: flex;
        align-items: start;
        gap: 8px;
        padding: 12px 16px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        font-weight: 600;
    }

    /* Buttons */
    .btn-submit {
        padding: 18px 40px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 800;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .btn-submit:hover::before {
        left: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(16, 185, 129, 0.5);
    }

    .btn-submit:active {
        transform: translateY(-1px);
    }

    .btn-cancel {
        padding: 18px 40px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
        border: 3px solid #cbd5e1;
        border-radius: 14px;
        font-weight: 800;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-cancel:hover {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        border-color: #94a3b8;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 40px;
        animation: fadeInUp 0.6s ease;
    }

    .btn-back {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 16px;
        color: white;
        font-size: 24px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .btn-back:hover {
        transform: translateY(-3px) rotate(-5deg);
        box-shadow: 0 8px 28px rgba(102, 126, 234, 0.5);
    }

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 3px solid #fcd34d;
        border-radius: 20px;
        padding: 28px;
        display: flex;
        align-items: start;
        gap: 20px;
        box-shadow: 0 8px 24px rgba(245, 158, 11, 0.2);
        animation: fadeInUp 0.6s ease;
        animation-delay: 0.5s;
        animation-fill-mode: both;
    }

    .info-icon {
        font-size: 48px;
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .info-title {
        font-weight: 900;
        color: #92400e;
        margin-bottom: 12px;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-list {
        list-style: none;
        margin-left: 0;
        color: #92400e;
        font-weight: 600;
        font-size: 14px;
        line-height: 2;
    }

    .info-list li {
        padding-left: 28px;
        position: relative;
    }

    .info-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #10b981;
        font-weight: 900;
        font-size: 18px;
    }

    /* Progress Steps */
    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        padding: 20px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border-radius: 16px;
        border: 2px solid rgba(102, 126, 234, 0.2);
    }

    .step {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .step-number {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: white;
        font-weight: 900;
        font-size: 20px;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    }

    .step-text {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .manual-card {
            padding: 24px;
        }

        .section-title {
            font-size: 22px;
        }

        .password-value {
            font-size: 28px;
            letter-spacing: 3px;
        }

        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }

        .progress-steps {
            flex-direction: column;
            gap: 16px;
        }

        .info-box {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="space-y-6 max-w-5xl mx-auto">

    {{-- HEADER WITH BACK BUTTON --}}
    <div class="page-header">
    <a href="{{ route('admin.user.index') }}" class="btn-back">
            ⬅️
        </a>
        <div>
            <h1 class="section-title" style="margin-bottom: 8px;">➕ Tambah Siswa Baru</h1>
            <p style="color: #64748b; font-size: 15px; font-weight: 600;">Isi data siswa dengan lengkap dan benar untuk mendaftarkan ke sistem</p>
        </div>
    </div>

    {{-- PROGRESS STEPS --}}
    <div class="progress-steps">
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-text">📝 Isi Form</div>
        </div>
        <div class="step">
            <div class="step-number">2</div>
            <div class="step-text">💾 Simpan Data</div>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <div class="step-text">🔑 Dapatkan Password</div>
        </div>
        <div class="step">
            <div class="step-number">4</div>
            <div class="step-text">✅ Selesai</div>
        </div>
    </div>

    {{-- PASSWORD NOTIFICATION --}}
    @if(session('new_user_password'))
        <div class="alert-password">
            <div style="display: flex; align-items: start; gap: 20px; position: relative; z-index: 1;">
                <div style="font-size: 64px; animation: bounce 1s ease-in-out infinite;">🔑</div>
                <div style="flex: 1;">
                    <h3 style="font-size: 22px; font-weight: 900; color: #1e40af; margin-bottom: 12px; display: flex; align-items: center; gap: 12px;">
                        <span>🎉</span> Password Siswa Berhasil Dibuat!
                    </h3>
                    <p style="font-size: 15px; color: #1e3a8a; font-weight: 700; margin-bottom: 16px;">
                        Salin dan berikan password ini kepada siswa untuk login pertama kali:
                    </p>
                    <div class="password-box">
                        <div class="password-label">🔐 PASSWORD LOGIN</div>
                        <div class="password-value" id="generatedPassword">{{ session('new_user_password') }}</div>
                        <button class="copy-btn" onclick="copyPassword()">
                            📋 Salin Password
                        </button>
                    </div>
                    <div style="background: rgba(255,255,255,0.5); border-radius: 12px; padding: 16px; margin-top: 16px;">
                        <p style="font-size: 13px; color: #1e40af; font-weight: 800; text-align: center; margin: 0;">
                            ⚠️ PENTING: Password ini hanya ditampilkan SEKALI. Pastikan sudah disalin sebelum meninggalkan halaman!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert-success">
            <span style="font-size: 32px;">✅</span>
            <div>
                <div style="font-size: 16px; font-weight: 900; margin-bottom: 4px;">Berhasil!</div>
                <div style="font-size: 14px;">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    {{-- FORM CARD --}}
    <div class="manual-card">
        <div style="position: relative; z-index: 1;">
            <h2 class="section-title">📝 Form Data Siswa</h2>
            <p style="color: #64748b; font-size: 15px; font-weight: 600; margin-bottom: 32px;">
                Lengkapi semua informasi siswa di bawah ini dengan teliti
            </p>

            {{-- ERROR MESSAGES --}}
            @if ($errors->any())
                <div class="alert-error">
                    <div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                            <span style="font-size: 28px;">⚠️</span>
                            <strong style="font-size: 16px;">Terjadi kesalahan input:</strong>
                        </div>
                        <ul class="error-list">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Lengkap --}}
                    <div class="md:col-span-2 form-group">
                        <label class="form-label">
                            <span>👤 Nama Lengkap</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                               required 
                               class="form-input"
                               placeholder="Contoh: Ahmad Fauzi Rahman">
                        <div class="form-hint">
                            <span>💡</span>
                            <span>Masukkan nama lengkap siswa sesuai dengan identitas resmi (KTP/Kartu Pelajar)</span>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="md:col-span-2 form-group">
                        <label class="form-label">
                            <span>🔐 Password Login</span>
                            <span style="color: #3b82f6; font-size: 11px; text-transform: none;">(Opsional)</span>
                        </label>
                        <input type="password" name="password"
                               class="form-input"
                               placeholder="Biarkan kosong untuk generate otomatis">
                        <div class="form-hint">
                            <span>💡</span>
                            <span>Kosongkan field ini jika ingin sistem membuat password acak yang aman. Password akan ditampilkan setelah data berhasil disimpan.</span>
                        </div>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="form-group">
                        <label class="form-label">
                            <span>📅 Tanggal Lahir</span>
                        </label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                               class="form-input">
                        <div class="form-hint">
                            <span>💡</span>
                            <span>Pilih tanggal lahir siswa dari kalender</span>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label">
                            <span>✅ Status Siswa</span>
                            <span class="required">*</span>
                        </label>
                        <select name="status" required class="form-select">
                            <option value="aktif" selected>✅ Aktif - Dapat Melakukan Absensi</option>
                            <option value="lulus">🎓 Lulus / Tidak Aktif</option>
                        </select>
                        <div class="form-hint">
                            <span>💡</span>
                            <span>Status "Aktif" memungkinkan siswa untuk melakukan absensi harian</span>
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div style="border-top: 3px solid #e0e7ff; padding-top: 32px; margin-top: 40px;">
                    <div style="display: flex; gap: 16px; justify-content: flex-end; flex-wrap: wrap;">
                        <a href="{{ route('admin.user.index') }}" class="btn-back">
                            ❌ Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            💾 Simpan Data Siswa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- INFO BOX --}}
    <div class="info-box">
        <div class="info-icon">💡</div>
        <div style="flex: 1;">
            <h4 class="info-title">
                <span>📌</span> Tips & Panduan Penting
            </h4>
            <ul class="info-list">
                <li>Pastikan nama ditulis dengan lengkap, jelas, dan sesuai identitas resmi</li>
                <li>Password otomatis akan dibuat sistem jika field password dikosongkan</li>
                <li>Password yang di-generate hanya ditampilkan SATU KALI dan tidak bisa dilihat lagi</li>
                <li>Wajib menyalin password dan memberikannya kepada siswa untuk login pertama kali</li>
                <li>Status "Aktif" memungkinkan siswa melakukan absensi, status "Tidak Aktif" menonaktifkan akses</li>
                <li>Data siswa dapat diubah kapan saja melalui menu Manajemen Peserta</li>
            </ul>
        </div>
    </div>

</div>

<script>
function copyPassword() {
    const password = document.getElementById('generatedPassword').innerText;
    navigator.clipboard.writeText(password).then(() => {
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '✅ Password Tersalin!';
        btn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
        }, 2000);
    }).catch(err => {
        alert('Gagal menyalin password. Silakan salin manual.');
    });
}
</script>

@endsection