<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f1f5f9;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #ffffff;
            padding: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 16px rgba(0, 0, 0, 0.04);
            z-index: 1000;
            border-right: 1px solid #e2e8f0;
            transition: transform 0.3s ease;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 28px 24px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-title {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .sidebar-subtitle {
            font-size: 13px;
            opacity: 0.9;
            font-weight: 500;
        }

        /* Menu Section */
        .menu-section {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
        }

        .menu-section::-webkit-scrollbar {
            width: 5px;
        }

        .menu-section::-webkit-scrollbar-track {
            background: transparent;
        }

        .menu-section::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .menu-item {
            padding: 13px 16px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 13px;
            font-size: 14.5px;
            color: #475569;
            font-weight: 600;
            transition: all 0.15s ease;
            margin-bottom: 4px;
            position: relative;
            text-decoration: none;
        }

        .menu-item:hover {
            background: #f1f5f9;
            color: #6366f1;
            transform: translateX(2px);
        }

        .menu-icon {
            font-size: 19px;
            width: 22px;
            text-align: center;
            transition: transform 0.15s ease;
        }

        .menu-item:hover .menu-icon {
            transform: scale(1.1);
        }

        .active-menu {
            background: linear-gradient(135deg, #eef2ff 0%, #f5f3ff 100%);
            color: #6366f1;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.15);
        }

        .active-menu .menu-icon {
            transform: scale(1.05);
        }

        /* Logout Section */
        .logout-section {
            padding: 16px;
            border-top: 1px solid #e2e8f0;
            background: #fafafa;
        }

        .logout-btn {
            width: 100%;
            padding: 13px 16px;
            border-radius: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ef4444;
            background: #fef2f2;
            border: 1px solid #fecaca;
            transition: all 0.15s ease;
            cursor: pointer;
            font-size: 14.5px;
        }

        .logout-btn:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(239, 68, 68, 0.2);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 280px;
            padding: 0;
            min-height: 100vh;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 20px 32px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .menu-toggle {
            display: none;
            background: #f1f5f9;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px;
            color: #475569;
            transition: all 0.15s ease;
        }

        .menu-toggle:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .page-header {
            flex: 1;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
        }

        .user-role {
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
        }

        /* Content Area */
        .content-area {
            padding: 32px;
        }

        /* Responsive */
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
                padding: 16px 20px;
            }

            .page-title {
                font-size: 22px;
            }

            .content-area {
                padding: 20px;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR OVERLAY (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        
        <div class="sidebar-header">
            <div class="sidebar-title">Admin Panel</div>
            <div class="sidebar-subtitle">Sistem Absensi QR</div>
        </div>

        <nav class="menu-section">
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

            <a href="{{ route('admin.rekap') }}"
               class="menu-item @if(request()->routeIs('admin.rekap')) active-menu @endif">
                <span class="menu-icon">📚</span>
                <span>Rekap Absensi</span>
            </a>

            <a href="{{ route('admin.user.create') }}"
               class="menu-item @if(request()->routeIs('admin.user.create')) active-menu @endif">
                <span class="menu-icon">➕</span>
                <span>Tambah Siswa</span>
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
    </script>

</body>

</html>