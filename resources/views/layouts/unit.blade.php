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
            --nav-bg: #1f2454;
            --nav-bg-soft: #252b60;
            --nav-line: rgba(255,255,255,0.14);
            --text-light: #ffffff;
            --text-soft: rgba(255,255,255,0.78);
            --body-bg: #2c316c;
            --content-bg: #2c316c;
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

        .unit-topbar {
            background: var(--nav-bg);
            border-bottom: 1px solid var(--nav-line);
            min-height: 68px;
            display: flex;
            align-items: center;
            padding: 0 22px;
        }

        .unit-topbar-inner {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .unit-left {
            display: flex;
            align-items: center;
            gap: 28px;
            min-width: 0;
        }

        .unit-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            flex-shrink: 0;
        }

        .unit-brand-logo {
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

        .unit-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .unit-brand-text {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.4px;
            color: #fff;
        }

        .unit-menu {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 26px;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }

        .unit-menu > li {
            position: relative;
        }

        .unit-menu > li > a {
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

        .unit-menu > li > a:hover {
            color: #fff;
        }

        .unit-menu > li > a.active {
            color: #fff;
            font-weight: 700;
        }

        .unit-menu > li > a.active::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 3px;
            background: var(--active-line);
            border-radius: 999px;
        }

        .unit-menu .dropdown-menu {
            background: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 8px 0;
            min-width: 220px;
            box-shadow: 0 14px 30px rgba(0,0,0,0.18);
            margin-top: 6px;
        }

        .unit-menu .dropdown-item {
            font-size: 14px;
            padding: 10px 14px;
            color: #1f2937;
        }

        .unit-menu .dropdown-item:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .unit-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .top-icon-btn,
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

        .welcome-bar {
            background: var(--nav-bg);
            color: #fff;
            padding: 14px 28px 16px;
            font-size: 14px;
            font-weight: 700;
            border-top: 1px solid rgba(255,255,255,0.04);
        }

        .app-page {
            padding: 0;
            background: var(--content-bg);
            min-height: calc(100vh - 112px);
        }

        .page-shell {
            min-height: calc(100vh - 112px);
        }

        @media (max-width: 992px) {
            .unit-topbar {
                padding: 10px 14px;
            }

            .unit-topbar-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .unit-left,
            .unit-right {
                width: 100%;
                justify-content: space-between;
            }

            .unit-left {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .unit-menu {
                gap: 16px;
            }

            .unit-menu > li > a {
                padding: 10px 2px 12px;
            }

            .welcome-bar {
                padding: 12px 18px;
            }
        }

        @media (max-width: 768px) {
            .unit-menu {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <link rel="stylesheet" href="{{ asset('css/sop-dark.css') }}">

    <div class="unit-topbar">
        <div class="unit-topbar-inner">
            <div class="unit-left">
                <div class="unit-brand">
                    <div class="unit-brand-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    </div>
                    <div class="unit-brand-text">SOPoltesa</div>
                </div>

                <ul class="unit-menu">
                    <li>
                        <a href="{{ route('unit.dashboard') }}"
                           class="{{ request()->routeIs('unit.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="#"
                           class="dropdown-toggle {{ request()->routeIs('unit.sop') || request()->routeIs('unit.sop.detail') || request()->routeIs('unit.sop.edit') || request()->routeIs('unit.revisi') ? 'active' : '' }}"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Register SOP
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('unit.sop') }}">SOP Saya</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('unit.revisi') }}">Revisi SOP</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('unit.arsip') }}"
                           class="{{ request()->routeIs('unit.arsip') ? 'active' : '' }}">
                            Log Arsip SOP
                        </a>
                    </li>
                </ul>
            </div>

            <div class="unit-right">
                <div class="theme-switch"></div>

                <button type="button" class="top-icon-btn" title="Pengaturan">
                    <i class="bi bi-gear"></i>
                </button>

                <button type="button" class="top-icon-btn" title="Bookmark">
                    <i class="bi bi-bookmark"></i>
                </button>

                <div title="{{ session('nama_unit') ?? session('name') ?? 'Unit Kerja' }}">
                    <button type="button" class="top-icon-btn">
                        <i class="bi bi-person-circle"></i>
                    </button>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="welcome-bar">
        Welcome, {{ session('nama_unit') ?? session('name') ?? 'Unit Kerja' }}
    </div>

    <div class="app-page">
        <div class="page-shell">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>