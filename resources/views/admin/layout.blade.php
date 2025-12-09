<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: transparent;
            position: relative;
            min-height: 100vh;
        }

        /* ===== ANIMATED NATURE BACKGROUND ===== */
        .nature-bg-animated {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            background: linear-gradient(180deg,
                    #e0f2f1 0%,
                    #b2dfdb 100%);
        }

        .sun-animated {
            position: absolute;
            top: 8%;
            left: -120px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 230, 109, 0.8) 0%, rgba(255, 179, 71, 0.6) 100%);
            box-shadow: 0 0 50px rgba(255, 230, 109, 0.5);
            animation: sunRiseAnim 180s linear infinite;
        }

        @keyframes sunRiseAnim {
            0% {
                left: -120px;
                top: 15%;
                opacity: 0.5;
            }

            25% {
                left: 25%;
                top: 8%;
                opacity: 1;
            }

            50% {
                left: 50%;
                top: 5%;
                opacity: 1;
            }

            75% {
                left: 75%;
                top: 8%;
                opacity: 1;
            }

            100% {
                left: calc(100% + 120px);
                top: 15%;
                opacity: 0.5;
            }
        }

        .cloud-animated {
            position: absolute;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 100px;
            opacity: 0.8;
        }

        .cloud-animated::before,
        .cloud-animated::after {
            content: '';
            position: absolute;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 100px;
        }

        .cloud-animated-1 {
            top: 15%;
            left: -200px;
            width: 150px;
            height: 50px;
            animation: cloudDrift1 35s linear infinite;
        }

        .cloud-animated-1::before {
            width: 80px;
            height: 50px;
            top: -25px;
            left: 30px;
        }

        .cloud-animated-1::after {
            width: 100px;
            height: 40px;
            top: -15px;
            left: 80px;
        }

        .cloud-animated-2 {
            top: 25%;
            right: -180px;
            width: 120px;
            height: 40px;
            animation: cloudDrift2 40s linear infinite;
            animation-delay: 5s;
        }

        .cloud-animated-2::before {
            width: 70px;
            height: 40px;
            top: -20px;
            left: 25px;
        }

        .cloud-animated-2::after {
            width: 80px;
            height: 35px;
            top: -12px;
            left: 65px;
        }

        .cloud-animated-3 {
            top: 35%;
            left: -150px;
            width: 100px;
            height: 35px;
            animation: cloudDrift3 45s linear infinite;
            animation-delay: 15s;
        }

        .cloud-animated-3::before {
            width: 60px;
            height: 35px;
            top: -18px;
            left: 20px;
        }

        .cloud-animated-3::after {
            width: 70px;
            height: 30px;
            top: -10px;
            left: 50px;
        }

        @keyframes cloudDrift1 {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(100vw + 200px));
            }
        }

        @keyframes cloudDrift2 {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(100vw + 200px));
            }
        }

        @keyframes cloudDrift3 {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(100vw + 200px));
            }
        }

        /* ===== BURUNG REALISTIS ===== */
        .bird-animated {
            position: absolute;
            width: 40px;
            height: 40px;
            animation: birdFlyRightToLeft 30s linear infinite;
        }

        .bird-animated svg {
            width: 100%;
            height: 100%;
        }

        .bird-animated-1 {
            top: 18%;
            right: -50px;
            animation-delay: 0s;
        }

        .bird-animated-2 {
            top: 22%;
            right: -80px;
            animation-delay: 10s;
        }

        .bird-animated-3 {
            top: 28%;
            right: -60px;
            animation-delay: 20s;
        }

        @keyframes birdFlyRightToLeft {
            0% {
                transform: translateX(0) translateY(0);
                opacity: 0;
            }

            5% {
                opacity: 1;
            }

            95% {
                opacity: 1;
            }

            100% {
                transform: translateX(calc(-100vw - 100px)) translateY(sin(3.14) * 30px);
                opacity: 0;
            }
        }

        .wing-left,
        .wing-right {
            animation: wingFlap 0.3s ease-in-out infinite;
            transform-origin: center;
        }

        .wing-right {
            animation-delay: 0.15s;
        }

        @keyframes wingFlap {

            0%,
            100% {
                transform: rotateY(0deg);
            }

            50% {
                transform: rotateY(60deg);
            }
        }

        /* ===== KUPU-KUPU REALISTIS ===== */
        .butterfly-animated {
            position: absolute;
            width: 35px;
            height: 35px;
            animation: butterflyCircleAnim 20s ease-in-out infinite;
        }

        .butterfly-animated svg {
            width: 100%;
            height: 100%;
        }

        .butterfly-animated-1 {
            bottom: 100px;
            left: 20%;
            animation-delay: 0s;
        }

        .butterfly-animated-2 {
            bottom: 120px;
            left: 60%;
            animation-delay: 5s;
        }

        @keyframes butterflyCircleAnim {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(50px, -40px) rotate(90deg);
            }

            50% {
                transform: translate(0, -80px) rotate(180deg);
            }

            75% {
                transform: translate(-50px, -40px) rotate(270deg);
            }

            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }

        .butterfly-wing-left,
        .butterfly-wing-right {
            animation: butterflyWingFlap 0.5s ease-in-out infinite;
            transform-origin: center;
        }

        .butterfly-wing-right {
            animation-delay: 0.25s;
        }

        @keyframes butterflyWingFlap {

            0%,
            100% {
                transform: scaleX(1);
            }

            50% {
                transform: scaleX(0.3);
            }
        }

        /* ===== PEGUNUNGAN REALISTIS ===== */
        .mountains-animated {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 35%;
            z-index: 0;
        }

        .mountain-layer-1 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            clip-path: polygon(0% 100%, 0% 60%, 15% 40%, 30% 55%, 45% 35%, 60% 50%, 75% 30%, 90% 45%, 100% 50%, 100% 100%);
            background: linear-gradient(to bottom, #1a4d2e 0%, #2d5f3f 50%, #3a7754 100%);
        }

        .mountain-layer-2 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 85%;
            clip-path: polygon(0% 100%, 0% 70%, 20% 50%, 35% 60%, 50% 45%, 65% 55%, 80% 40%, 95% 50%, 100% 60%, 100% 100%);
            background: linear-gradient(to bottom, #2d5f3f 0%, #3a7754 50%, #4a9668 100%);
            opacity: 0.9;
        }

        .mountain-layer-3 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 70%;
            clip-path: polygon(0% 100%, 0% 80%, 25% 65%, 40% 70%, 55% 60%, 70% 65%, 85% 55%, 100% 65%, 100% 100%);
            background: linear-gradient(to bottom, #4a9668 0%, #5db07d 50%, #6ec490 100%);
            opacity: 0.85;
        }

        /* ===== RUMPUT REALISTIS ===== */
        .grass-animated {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background: linear-gradient(to bottom, #4a9668 0%, #3a7754 100%);
            overflow: hidden;
        }

        .grass-blade-animated {
            position: absolute;
            bottom: 0;
            width: 2px;
            border-radius: 2px 2px 0 0;
            transform-origin: bottom center;
        }

        .grass-blade-animated:nth-child(odd) {
            background: linear-gradient(to top, #2d5f3f 0%, #4a9668 60%, #5db07d 100%);
        }

        .grass-blade-animated:nth-child(even) {
            background: linear-gradient(to top, #1a4d2e 0%, #3a7754 60%, #4a9668 100%);
        }

        .grass-blade-animated:nth-child(3n) {
            background: linear-gradient(to top, #3a7754 0%, #5db07d 60%, #6ec490 100%);
        }

        .grass-blade-animated:nth-child(1) {
            left: 3%;
            height: 28px;
            animation: grassSwayAnim 3.2s ease-in-out infinite;
        }

        .grass-blade-animated:nth-child(2) {
            left: 7%;
            height: 22px;
            animation: grassSwayAnim 2.8s ease-in-out infinite 0.3s;
        }

        .grass-blade-animated:nth-child(3) {
            left: 11%;
            height: 32px;
            animation: grassSwayAnim 3.5s ease-in-out infinite 0.6s;
        }

        .grass-blade-animated:nth-child(4) {
            left: 15%;
            height: 25px;
            animation: grassSwayAnim 2.9s ease-in-out infinite 0.9s;
        }

        .grass-blade-animated:nth-child(5) {
            left: 19%;
            height: 30px;
            animation: grassSwayAnim 3.3s ease-in-out infinite 1.2s;
        }

        .grass-blade-animated:nth-child(6) {
            left: 23%;
            height: 26px;
            animation: grassSwayAnim 3.0s ease-in-out infinite 1.5s;
        }

        .grass-blade-animated:nth-child(7) {
            left: 27%;
            height: 29px;
            animation: grassSwayAnim 3.1s ease-in-out infinite 1.8s;
        }

        .grass-blade-animated:nth-child(8) {
            left: 31%;
            height: 24px;
            animation: grassSwayAnim 2.7s ease-in-out infinite 2.1s;
        }

        .grass-blade-animated:nth-child(9) {
            left: 35%;
            height: 31px;
            animation: grassSwayAnim 3.4s ease-in-out infinite 2.4s;
        }

        .grass-blade-animated:nth-child(10) {
            left: 39%;
            height: 27px;
            animation: grassSwayAnim 2.85s ease-in-out infinite 2.7s;
        }

        .grass-blade-animated:nth-child(11) {
            left: 43%;
            height: 23px;
            animation: grassSwayAnim 3.15s ease-in-out infinite 3s;
        }

        .grass-blade-animated:nth-child(12) {
            left: 47%;
            height: 28px;
            animation: grassSwayAnim 2.95s ease-in-out infinite 0.5s;
        }

        .grass-blade-animated:nth-child(13) {
            left: 51%;
            height: 30px;
            animation: grassSwayAnim 3.25s ease-in-out infinite 1s;
        }

        .grass-blade-animated:nth-child(14) {
            left: 55%;
            height: 26px;
            animation: grassSwayAnim 3.05s ease-in-out infinite 1.4s;
        }

        .grass-blade-animated:nth-child(15) {
            left: 59%;
            height: 29px;
            animation: grassSwayAnim 2.75s ease-in-out infinite 1.7s;
        }

        .grass-blade-animated:nth-child(16) {
            left: 63%;
            height: 25px;
            animation: grassSwayAnim 3.35s ease-in-out infinite 2s;
        }

        .grass-blade-animated:nth-child(17) {
            left: 67%;
            height: 27px;
            animation: grassSwayAnim 2.88s ease-in-out infinite 2.3s;
        }

        .grass-blade-animated:nth-child(18) {
            left: 71%;
            height: 31px;
            animation: grassSwayAnim 3.12s ease-in-out infinite 2.6s;
        }

        .grass-blade-animated:nth-child(19) {
            left: 75%;
            height: 24px;
            animation: grassSwayAnim 2.92s ease-in-out infinite 2.9s;
        }

        .grass-blade-animated:nth-child(20) {
            left: 79%;
            height: 28px;
            animation: grassSwayAnim 3.18s ease-in-out infinite 0.8s;
        }

        .grass-blade-animated:nth-child(21) {
            left: 83%;
            height: 26px;
            animation: grassSwayAnim 3.08s ease-in-out infinite 1.1s;
        }

        .grass-blade-animated:nth-child(22) {
            left: 87%;
            height: 30px;
            animation: grassSwayAnim 2.98s ease-in-out infinite 1.3s;
        }

        .grass-blade-animated:nth-child(23) {
            left: 91%;
            height: 27px;
            animation: grassSwayAnim 3.22s ease-in-out infinite 1.6s;
        }

        .grass-blade-animated:nth-child(24) {
            left: 95%;
            height: 25px;
            animation: grassSwayAnim 2.82s ease-in-out infinite 1.9s;
        }

        @keyframes grassSwayAnim {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-3deg);
            }

            75% {
                transform: rotate(3deg);
            }
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
            box-shadow: 2px 0 20px rgba(45, 95, 63, 0.08);
            z-index: 1000;
            border-right: 2px solid #a5d6a7;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 28px 24px;
            background: linear-gradient(135deg, #4a9668 0%, #2d5f3f 100%);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '🌿';
            position: absolute;
            top: -15px;
            right: -15px;
            font-size: 100px;
            opacity: 0.12;
            transform: rotate(-15deg);
        }

        .sidebar-header::after {
            content: '🍃';
            position: absolute;
            bottom: -10px;
            left: -10px;
            font-size: 60px;
            opacity: 0.15;
            transform: rotate(25deg);
        }

        .sidebar-title {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }

        .sidebar-subtitle {
            font-size: 13px;
            opacity: 0.95;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        .menu-section {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            background: linear-gradient(180deg, #f1f8f4 0%, #ffffff 100%);
        }

        .menu-section::-webkit-scrollbar {
            width: 5px;
        }

        .menu-section::-webkit-scrollbar-track {
            background: transparent;
        }

        .menu-section::-webkit-scrollbar-thumb {
            background: #a5d6a7;
            border-radius: 10px;
        }

        .menu-item {
            padding: 13px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 13px;
            font-size: 14.5px;
            color: #2d5f3f;
            font-weight: 600;
            transition: all 0.2s ease;
            margin-bottom: 6px;
            position: relative;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .menu-item:hover {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            color: #1b4332;
            transform: translateX(3px);
            border-color: #a5d6a7;
        }

        .menu-icon {
            font-size: 19px;
            width: 22px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .menu-item:hover .menu-icon {
            transform: scale(1.15) rotate(5deg);
        }

        .active-menu {
            background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
            color: #1b4332;
            font-weight: 700;
            box-shadow: 0 3px 12px rgba(74, 150, 104, 0.25);
            border-color: #81c784;
        }

        .active-menu .menu-icon {
            transform: scale(1.1);
        }

        .logout-section {
            padding: 16px;
            border-top: 2px solid #c8e6c9;
            background: linear-gradient(180deg, #f1f8f4 0%, #e8f5e9 100%);
            position: relative;
        }

        .logout-section::before {
            content: '🌾';
            position: absolute;
            bottom: 10px;
            right: 15px;
            font-size: 30px;
            opacity: 0.1;
        }

        .logout-btn {
            width: 100%;
            padding: 13px 16px;
            border-radius: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #c62828;
            background: #ffebee;
            border: 2px solid #ef9a9a;
            transition: all 0.2s ease;
            cursor: pointer;
            font-size: 14.5px;
            position: relative;
            z-index: 1;
        }

        .logout-btn:hover {
            background: #ffcdd2;
            border-color: #e57373;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(198, 40, 40, 0.25);
        }

        .main-content {
            margin-left: 280px;
            padding: 0;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .top-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 32px;
            border-bottom: 2px solid #c8e6c9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(74, 150, 104, 0.08);
        }

        .menu-toggle {
            display: none;
            background: #e8f5e9;
            border: 2px solid #a5d6a7;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #2d5f3f;
            transition: all 0.2s ease;
        }

        .menu-toggle:hover {
            background: #c8e6c9;
            color: #1b4332;
            transform: rotate(90deg);
        }

        .page-header {
            flex: 1;
        }

        .page-title {
            font-size: 26px;
            font-weight: 900;
            color: #1b4332;
            margin-bottom: 2px;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            color: #4a9668;
            font-size: 14px;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-radius: 12px;
            border: 2px solid #a5d6a7;
            transition: all 0.2s ease;
        }

        .user-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 150, 104, 0.2);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4a9668, #2d5f3f);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(45, 95, 63, 0.3);
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 13px;
            font-weight: 700;
            color: #1b4332;
        }

        .user-role {
            font-size: 11px;
            color: #4a9668;
            font-weight: 600;
        }

        .content-area {
            padding: 32px;
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
                padding: 16px 20px;
            }

            .page-title {
                font-size: 22px;
            }

            .content-area {
                padding: 20px;
            }

            .sun-animated {
                width: 60px;
                height: 60px;
            }

            .mountains-animated {
                height: 25%;
            }

            .grass-animated {
                height: 60px;
            }

            .cloud-animated {
                transform: scale(0.6);
            }

            .bird-animated,
            .butterfly-animated {
                font-size: 16px;
            }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(45, 95, 63, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }
    </style>
</head>

<body>

    <!-- ANIMATED BACKGROUND -->
    <div class="nature-bg-animated">
        <div class="sun-animated"></div>
        <div class="cloud-animated cloud-animated-1"></div>
        <div class="cloud-animated cloud-animated-2"></div>
        <div class="cloud-animated cloud-animated-3"></div>
        <div class="bird-animated bird-animated-1">
            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <g class="wing-left">
                    <ellipse cx="30" cy="50" rx="25" ry="15" fill="#1a1a1a" opacity="0.8" />
                </g>
                <ellipse cx="50" cy="50" rx="15" ry="20" fill="#2a2a2a" />
                <g class="wing-right">
                    <ellipse cx="70" cy="50" rx="25" ry="15" fill="#1a1a1a" opacity="0.8" />
                </g>
            </svg>
        </div>
        <div class="bird-animated bird-animated-2">
            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <g class="wing-left">
                    <ellipse cx="30" cy="50" rx="25" ry="15" fill="#1a1a1a" opacity="0.8" />
                </g>
                <ellipse cx="50" cy="50" rx="15" ry="20" fill="#2a2a2a" />
                <g class="wing-right">
                    <ellipse cx="70" cy="50" rx="25" ry="15" fill="#1a1a1a" opacity="0.8" />
                </g>
            </svg>
        </div>
        <div class="bird-animated bird-animated-3">
            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <g class="wing-left">
                    <ellipse cx="30" cy="50" rx="25" ry="15" fill="#1a1a1a" opacity="0.8" />
                </g>
                <ellipse cx="50" cy="50" rx="15" ry="20" fill="#2a2a2a" />
                <g class="wing-right">
                    <ellipse cx="70" cy="50" rx="25" ry="15" fill="#1a1a1a" opacity="0.8" />
                </g>
            </svg>
        </div>

        <!-- Kupu-kupu -->
        <div class="butterfly-animated butterfly-animated-1">
            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <g class="butterfly-wing-left">
                    <ellipse cx="35" cy="40" rx="20" ry="25" fill="#FF6B9D" opacity="0.9" />
                    <ellipse cx="35" cy="40" rx="15" ry="20" fill="#FFB6C1" />
                    <ellipse cx="35" cy="65" rx="18" ry="22" fill="#FF1493" opacity="0.8" />
                </g>
                <ellipse cx="50" cy="50" rx="5" ry="30" fill="#4a1a4a" />
                <g class="butterfly-wing-right">
                    <ellipse cx="65" cy="40" rx="20" ry="25" fill="#FF6B9D" opacity="0.9" />
                    <ellipse cx="65" cy="40" rx="15" ry="20" fill="#FFB6C1" />
                    <ellipse cx="65" cy="65" rx="18" ry="22" fill="#FF1493" opacity="0.8" />
                </g>
            </svg>
        </div>
        <div class="butterfly-animated butterfly-animated-2">
            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <g class="butterfly-wing-left">
                    <ellipse cx="35" cy="40" rx="20" ry="25" fill="#87CEEB" opacity="0.9" />
                    <ellipse cx="35" cy="40" rx="15" ry="20" fill="#B0E0E6" />
                    <ellipse cx="35" cy="65" rx="18" ry="22" fill="#4682B4" opacity="0.8" />
                </g>
                <ellipse cx="50" cy="50" rx="5" ry="30" fill="#2a2a2a" />
                <g class="butterfly-wing-right">
                    <ellipse cx="65" cy="40" rx="20" ry="25" fill="#87CEEB" opacity="0.9" />
                    <ellipse cx="65" cy="40" rx="15" ry="20" fill="#B0E0E6" />
                    <ellipse cx="65" cy="65" rx="18" ry="22" fill="#4682B4" opacity="0.8" />
                </g>
            </svg>
        </div>

        <!-- Pegunungan -->
        <div class="mountains-animated">
            <div class="mountain-layer-1"></div>
            <div class="mountain-layer-2"></div>
            <div class="mountain-layer-3"></div>
        </div>
        <div class="grass-animated">
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
            <div class="grass-blade-animated"></div>
        </div>
    </div>

    <!-- SIDEBAR OVERLAY (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">
            <div class="sidebar-title">🌳 Admin Panel</div>
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
                <span>Buku Absensi</span>
            </a>
            <a href="{{ route('admin.calendar') }}"
                class="menu-item @if(request()->routeIs('admin.calendar')) active-menu @endif">
                <span class="menu-icon">📅</span>
                <span>Kalender Absensi</span>
            </a>

            <a href="{{ route('admin.user.create') }}"
                class="menu-item @if(request()->routeIs('admin.user.create')) active-menu @endif">
                <span class="menu-icon">➕</span>
                <span>Tambah Siswa</span>
            </a>
        </nav>
        <li class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <a href="{{ route('admin.settings') }}" class="flex items-center gap-2 px-4 py-3 hover:bg-green-100 rounded-md">
                ⚙️ <span>Pengaturan Sistem</span>
            </a>
        </li>

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