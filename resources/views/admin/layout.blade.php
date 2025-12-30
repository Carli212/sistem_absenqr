<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <script src="{{ asset('build/assets/app.js') }}" defer></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f7fa;
            position: relative;
            min-height: 100vh;
        }

        /* ===== MODERN GRADIENT BACKGROUND ===== */
        .modern-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-orb-bg {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.5;
            animation: floatBg 30s ease-in-out infinite;
        }

        .orb-bg-1 {
            top: -20%;
            right: -15%;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.4) 0%, transparent 70%);
            animation-delay: 0s;
        }

        .orb-bg-2 {
            bottom: -25%;
            left: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.35) 0%, transparent 70%);
            animation-delay: 10s;
        }

        .orb-bg-3 {
            top: 40%;
            left: 30%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%);
            animation-delay: 20s;
        }

        @keyframes floatBg {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(70px, -70px) scale(1.2); }
            66% { transform: translate(-50px, 50px) scale(0.9); }
        }

        .grid-pattern-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 50px 50px;
            opacity: 0.7;
        }

        /* ===== SIDEBAR MODERN ===== */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 30px rgba(102, 126, 234, 0.1);
            z-index: 1000;
            border-right: 1px solid rgba(102, 126, 234, 0.15);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-header {
            padding: 32px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .sidebar-logo {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-title {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 4px;
            letter-spacing: -0.3px;
            position: relative;
            z-index: 1;
        }

        .sidebar-subtitle {
            font-size: 13px;
            opacity: 0.9;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        .menu-section {
            flex: 1;
            overflow-y: auto;
            padding: 20px 16px;
            background: white;
        }

        .menu-section::-webkit-scrollbar {
            width: 6px;
        }

        .menu-section::-webkit-scrollbar-track {
            background: transparent;
        }

        .menu-section::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .menu-section::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .menu-item {
            padding: 14px 18px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            color: #475569;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 6px;
            position: relative;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 0 10px 10px 0;
            transition: width 0.3s ease;
        }

        .menu-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
            color: #667eea;
            transform: translateX(4px);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .menu-item:hover::before {
            width: 4px;
        }

        .menu-icon {
            font-size: 20px;
            width: 24px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .menu-item:hover .menu-icon {
            transform: scale(1.15);
        }

        .active-menu {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            color: #667eea;
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .active-menu::before {
            width: 4px;
        }

        .active-menu .menu-icon {
            transform: scale(1.1);
        }

        .logout-section {
            padding: 16px;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .logout-btn {
            width: 100%;
            padding: 14px 18px;
            border-radius: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 14px;
            color: #dc2626;
            background: #fee2e2;
            border: 2px solid #fecaca;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #fecaca;
            border-color: #fca5a5;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.25);
        }

        .main-content {
            margin-left: 280px;
            padding: 0;
            min-height: 100vh;
            position: relative;
        }

        .top-bar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 24px 36px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.08);
        }

        .menu-toggle {
            display: none;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 2px solid rgba(102, 126, 234, 0.3);
            padding: 12px 16px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 20px;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .menu-toggle:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
            transform: scale(1.05);
        }

        .page-header {
            flex: 1;
        }

        .page-title {
            font-size: 28px;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 14px;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 14px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
        }

        .user-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 17px;
            border: 2px solid white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
        }

        .user-role {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
        }

        .content-area {
            padding: 36px;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }

            .user-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .top-bar {
                padding: 18px 24px;
            }

            .page-title {
                font-size: 22px;
            }

            .content-area {
                padding: 24px;
            }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 999;
            animation: fadeIn 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Menu Divider */
        .menu-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #e2e8f0 50%, transparent 100%);
            margin: 16px 0;
        }

        /* Menu Label */
        .menu-label {
            font-size: 11px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 8px 18px;
            margin-top: 12px;
        }
    </style>
</head>

<body>

    <!-- MODERN GRADIENT BACKGROUND -->
    <div class="modern-bg">
        <div class="gradient-orb-bg orb-bg-1"></div>
        <div class="gradient-orb-bg orb-bg-2"></div>
        <div class="gradient-orb-bg orb-bg-3"></div>
        <div class="grid-pattern-bg"></div>
    </div>

    <!-- SIDEBAR OVERLAY (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">
            <div class="sidebar-logo">📊</div>
            <div class="sidebar-title">Admin Panel</div>
            <div class="sidebar-subtitle">Sistem Absensi QR</div>
        </div>

        <nav class="menu-section">
            <div class="menu-label">Main Menu</div>
            
            <a href="{{ route('admin.dashboard') }}"
                class="menu-item @if(request()->routeIs('admin.dashboard')) active-menu @endif">
                <span class="menu-icon">📊</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.qr') }}"
                class="menu-item @if(request()->routeIs('admin.qr')) active-menu @endif">
                <span class="menu-icon">🧾</span>
                <span>QR Code</span>
            </a>

            <a href="{{ route('admin.absensi.manual') }}"
                class="menu-item @if(request()->routeIs('admin.absensi.manual')) active-menu @endif">
                <span class="menu-icon">📝</span>
                <span>Absensi Manual</span>
            </a>

            <div class="menu-divider"></div>
            <div class="menu-label">Data & Reports</div>

            <a href="{{ route('admin.rekap') }}"
                class="menu-item @if(request()->routeIs('admin.rekap')) active-menu @endif">
                <span class="menu-icon">📚</span>
                <span>Buku Absensi</span>
            </a>

            <a href="{{ route('admin.calendar') }}"
                class="menu-item @if(request()->routeIs('admin.calendar')) active-menu @endif">
                <span class="menu-icon">📅</span>
                <span>Kalender Absensi</span>
            </a>

            <div class="menu-divider"></div>
            <div class="menu-label">Management</div>

            <a href="/admin/users" class="menu-item">
                <span class="menu-icon">👥</span>
                <span>Manajemen Peserta</span>
            </a>

            <a href="{{ route('admin.user.create') }}"
                class="menu-item @if(request()->routeIs('admin.user.create')) active-menu @endif">
                <span class="menu-icon">➕</span>
                <span>Tambah Siswa</span>
            </a>

            <a href="{{ route('admin.settings') }}"
                class="menu-item @if(request()->routeIs('admin.settings')) active-menu @endif">
                <span class="menu-icon">⚙️</span>
                <span>Pengaturan Sistem</span>
            </a>
        </nav>

        <div class="logout-section">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="logout-btn" type="submit">
                    <span class="menu-icon">🚪</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- Top Bar -->
        <div class="top-bar">
            <button class="menu-toggle" id="menuToggle">☰</button>

            <div class="page-header">
                <h1 class="page-title">@yield('pageTitle')</h1>
                <p class="page-subtitle">@yield('pageSubtitle', 'Kelola data sistem absensi')</p>
            </div>

            <div class="user-info">
                <div class="user-avatar">A</div>
                <div class="user-details">
                    <span class="user-name">Admin</span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>

    </main>

    <script>
        // Toggle Sidebar (Mobile)
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Add parallax effect to background orbs
        document.addEventListener('mousemove', (e) => {
            const orbs = document.querySelectorAll('.gradient-orb-bg');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            orbs.forEach((orb, index) => {
                const speed = (index + 1) * 15;
                orb.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
            });
        });
    </script>

</body>

</html>