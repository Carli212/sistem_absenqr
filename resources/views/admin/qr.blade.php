@extends('admin.layout')

@section('title', 'QR Code Absensi | Sistem Absensi QR')
@section('pageTitle', 'QR Code Absensi')

@section('content')

<style>
    /* Container */
    .qr-container {
        max-width: 800px;
        margin: 0 auto;
    }

    /* Main Card */
    .qr-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 48px;
        box-shadow: 
            0 20px 60px rgba(102, 126, 234, 0.15),
            0 0 1px rgba(255, 255, 255, 0.8) inset;
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    /* Header */
    .qr-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .qr-icon {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }

    .qr-icon svg {
        width: 40px;
        height: 40px;
        fill: white;
    }

    .qr-title {
        font-size: 28px;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
    }

    .qr-subtitle {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    /* Info Badge */
    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        color: #667eea;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 24px;
        border: 2px solid rgba(102, 126, 234, 0.2);
    }

    /* QR Display */
    .qr-display {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid #f1f5f9;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Loading */
    .qr-loading {
        text-align: center;
        color: #94a3b8;
    }

    .qr-loading-spinner {
        width: 48px;
        height: 48px;
        border: 4px solid #f1f5f9;
        border-top-color: #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 16px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* QR Code */
    #qrWrap svg {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
    }

    /* Expire Info */
    .expire-info {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 24px;
        border: 2px solid rgba(251, 191, 36, 0.3);
        text-align: center;
    }

    /* Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .stat-item {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
        padding: 16px;
        border-radius: 12px;
        text-align: center;
        border: 2px solid rgba(102, 126, 234, 0.15);
    }

    .stat-value {
        font-size: 24px;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 11px;
        color: #667eea;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Buttons */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: #ffffff;
        color: #475569;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .qr-card {
            padding: 32px 24px;
        }

        .qr-display {
            padding: 24px;
            min-height: 320px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .btn-action {
            width: 100%;
        }
    }
</style>

<div class="qr-container">
    <div class="qr-card">
        
        <!-- Header -->
        <div class="qr-header">
            <div class="qr-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M3 11h8V3H3v8zm2-6h4v4H5V5zm8-2v8h8V3h-8zm6 6h-4V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm13-2h-2v3h-3v2h3v3h2v-3h3v-2h-3z"/>
                </svg>
            </div>
            <h2 class="qr-title">QR Code Absensi</h2>
            <p class="qr-subtitle">
                Scan QR Code untuk melakukan absensi. Kode diperbarui otomatis setiap 5 menit.
            </p>
        </div>

        <!-- Info Badge -->
        <div class="text-center">
            <div class="info-badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                </svg>
                <span>Refresh Otomatis Setiap 1 Menit</span>
            </div>
        </div>

        <!-- QR Display -->
        <div class="qr-display">
            <div id="qrWrap">
                <div class="qr-loading">
                    <div class="qr-loading-spinner"></div>
                    <p>Memuat QR Code...</p>
                </div>
            </div>
        </div>

        <!-- Expire Info -->
        <div class="expire-info">
            <span id="expireText">⏰ Memuat informasi kadaluarsa...</span>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">5</div>
                <div class="stat-label">Menit</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">AUTO</div>
                <div class="stat-label">Refresh</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">✓</div>
                <div class="stat-label">Aman</div>
            </div>
        </div>

        <!-- Actions -->
        <div class="text-center space-y-3">
            <button onclick="fetchQr()" class="btn-action btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
                </svg>
                Refresh QR Code
            </button>
            
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn-action btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

    </div>
</div>

<script>
async function fetchQr() {
    try {
        document.getElementById('qrWrap').innerHTML = `
            <div class="qr-loading">
                <div class="qr-loading-spinner"></div>
                <p>Memperbarui QR Code...</p>
            </div>
        `;

        const res = await fetch("{{ route('admin.qr.json') }}");
        const data = await res.json();

        document.getElementById('qrWrap').innerHTML = atob(data.svg);
        document.getElementById('expireText').innerHTML = `⏰ Kadaluarsa pada: <strong>${data.expired_at}</strong>`;

    } catch (err) {
        console.error("QR Error:", err);
        document.getElementById('qrWrap').innerHTML = `
            <div class="qr-loading">
                <p style="color: #dc2626; font-weight: 700;">❌ Gagal memuat QR Code</p>
                <button onclick="fetchQr()" style="margin-top: 12px; padding: 10px 20px; background: #dc2626; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 700;">
                    Coba Lagi
                </button>
            </div>
        `;
    }
}

fetchQr();
setInterval(fetchQr, 60000);
</script>

@endsection