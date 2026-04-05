<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Informasi SOP' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --nav-bg: #202552;
            --nav-bg-soft: #252b60;
            --nav-line: rgba(255,255,255,0.75);
            --text-light: #ffffff;
            --text-soft: rgba(255,255,255,0.76);
            --text-muted: #c9d0e3;
            --body-bg: #2d3272;
            --content-bg: #31376f;
            --content-border: rgba(255,255,255,0.06);
            --hover-bg: rgba(255,255,255,0.06);
            --active-line: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--body-bg);
            color: #111827;
        }

        a {
            text-decoration: none;
        }

        /* =========================
           TOP MAIN NAV
        ========================= */
        .sidinar-topbar {
            background: var(--nav-bg);
            border-bottom: 1px solid var(--nav-line);
            min-height: 68px;
            display: flex;
            align-items: center;
            padding: 0 22px;
        }

        .sidinar-topbar-inner {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .sidinar-left {
            display: flex;
            align-items: center;
            gap: 28px;
            min-width: 0;
        }

        .sidinar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            flex-shrink: 0;
        }

        .sidinar-brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            overflow: hidden;
            background: #fff;
            border: 2px solid rgba(255,255,255,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidinar-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidinar-brand-text {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.4px;
            color: #fff;
        }

        .sidinar-menu {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 26px;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }

        .sidinar-menu > li {
            position: relative;
        }

        .sidinar-menu > li > a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-soft);
            font-size: 15px;
            font-weight: 500;
            padding: 22px 2px 20px;
            position: relative;
            transition: all 0.2s ease;
        }

        .sidinar-menu > li > a:hover {
            color: #fff;
        }

        .sidinar-menu > li > a.active {
            color: #fff;
            font-weight: 700;
        }

        .sidinar-menu > li > a.active::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 3px;
            background: var(--active-line);
            border-radius: 999px;
        }

        .sidinar-menu .dropdown-menu {
            background: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 8px 0;
            min-width: 220px;
            box-shadow: 0 14px 30px rgba(0,0,0,0.18);
            margin-top: 6px;
        }

        .sidinar-menu .dropdown-item {
            font-size: 14px;
            padding: 10px 14px;
            color: #1f2937;
        }

        .sidinar-menu .dropdown-item:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .sidinar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .top-icon-btn {
            width: 34px;
            height: 34px;
            border: none;
            background: transparent;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            padding: 0;
        }

        .theme-switch {
            width: 52px;
            height: 32px;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            position: relative;
            display: flex;
            align-items: center;
            padding: 0 4px;
            border: 1px solid rgba(255,255,255,0.10);
        }

        .theme-switch::before {
            content: "\f495";
            font-family: "bootstrap-icons";
            color: rgba(255,255,255,0.55);
            font-size: 12px;
            position: absolute;
            left: 8px;
        }

        .theme-switch::after {
            content: "";
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #f1f1eb;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.16);
        }

        /* =========================
           WELCOME BAR
        ========================= */
        .welcome-bar {
            background: var(--nav-bg);
            color: #fff;
            padding: 14px 28px 16px;
            font-size: 14px;
            font-weight: 700;
        }

        /* =========================
           PAGE CONTENT
        ========================= */
        .app-page {
            padding: 0 18px 18px;
            background: var(--content-bg);
            min-height: calc(100vh - 112px);
        }

        .app-content-shell {
            background: transparent;
            border-radius: 14px;
            min-height: calc(100vh - 145px);
            padding: 18px;
            border: 1px solid var(--content-border);
        }

        .page-shell {
            background: transparent;
            padding: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            width: 34px;
            height: 34px;
            border: none;
            background: transparent;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            padding: 0;
        }

        @media (max-width: 992px) {
            .sidinar-topbar {
                padding: 10px 14px;
            }

            .sidinar-topbar-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .sidinar-left,
            .sidinar-right {
                width: 100%;
                justify-content: space-between;
            }

            .sidinar-left {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .sidinar-menu {
                gap: 16px;
            }

            .sidinar-menu > li > a {
                padding: 10px 2px 12px;
            }

            .welcome-bar {
                padding: 12px 18px;
            }
        }

        @media (max-width: 768px) {
            .sidinar-menu {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
                width: 100%;
            }

            .app-page {
                padding: 0 10px 10px;
            }

            .app-content-shell {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- TOP NAV -->
    <div class="sidinar-topbar">
        <div class="sidinar-topbar-inner">
            <div class="sidinar-left">
                <div class="sidinar-brand">
                    <div class="sidinar-brand-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    </div>
                    <div class="sidinar-brand-text">SOPoltesa</div>
                </div>

<ul class="sidinar-menu">
    <!-- Dashboard -->
    <li>
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>
    </li>

    <!-- Manajemen SOP -->
    <li class="dropdown">
        <a href="#"
           class="dropdown-toggle {{ request()->routeIs('admin.verifikasi') || request()->routeIs('admin.verifikasi.detail') || request()->routeIs('admin.penomoran') || request()->routeIs('admin.arsip') ? 'active' : '' }}"
           data-bs-toggle="dropdown"
           aria-expanded="false">
            Manajemen SOP
        </a>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="{{ route('admin.verifikasi') }}">
                    Verifikasi SOP
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('admin.penomoran') }}">
                    Penomoran SOP
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('admin.arsip') }}">
                    Arsip SOP
                </a>
            </li>
        </ul>
    </li>

    <!-- SOP FINAL DIREKTUR -->
    <li>
        <a href="{{ route('admin.final') }}"
           class="{{ request()->routeIs('admin.final') ? 'active' : '' }}">
            SOP Final (Direktur)
        </a>
    </li>
</ul>
</li>
                </ul>
            </div>

            <div class="sidinar-right">
                <div class="theme-switch"></div>

                <button type="button" class="top-icon-btn" title="Pengaturan">
                    <i class="bi bi-gear"></i>
                </button>

                <button type="button" class="top-icon-btn" title="Bookmark">
                    <i class="bi bi-bookmark"></i>
                </button>

                <div title="{{ session('name') ?? 'Admin SOP' }}">
                    <button type="button" class="top-icon-btn">
                        <i class="bi bi-person-circle"></i>
                    </button>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- WELCOME BAR -->
    <div class="welcome-bar">
        Welcome, {{ session('name') ?? 'Admin SOP' }}
    </div>

    <!-- CONTENT -->
    <div class="app-page">
        <div class="app-content-shell">
            <div class="page-shell">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>