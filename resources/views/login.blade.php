<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem SOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --navy: #1f2f6b;
            --navy-dark: #182454;
            --yellow: #f7c718;
            --yellow-dark: #efb800;
            --bg: #f3f3f3;
            --border: #d5d5d5;
            --input: #e8eef9;
            --text: #24304f;
            --muted: #6b7280;
            --danger: #d62828;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        .bg-city {
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: 0.18;
            z-index: 0;
        }

        .bg-city svg {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 42%;
            min-width: 320px;
            max-width: 760px;
            height: auto;
        }

        .page-wrap {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px 96px;
        }

        .login-area {
            width: 100%;
            max-width: 1000px;
        }

        .brand-top {
            text-align: center;
            margin-bottom: 18px;
        }

        .brand-top .brand-core {
            font-size: 64px;
            line-height: 1;
            font-weight: 900;
            letter-spacing: -2px;
            display: inline-flex;
            align-items: center;
            gap: 0;
        }

        .brand-top .brand-core .core {
            color: var(--navy);
        }

        .brand-top .brand-core .tax {
            color: var(--yellow);
        }

        .brand-top .brand-sub {
            margin-top: 6px;
            font-size: 13px;
            color: #5f6780;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .login-box {
            background: #fff;
            border: 1px solid #cfcfcf;
            border-radius: 6px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.12);
            overflow: hidden;
        }

        .login-left {
            background: #fff;
            padding: 32px 28px 22px;
        }

        .login-right {
            position: relative;
            min-height: 100%;
            background:
                linear-gradient(rgba(31,47,107,0.82), rgba(31,47,107,0.82)),
                url('{{ asset('images/login-sop-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            color: #fff;
            overflow: hidden;
        }

        .login-right.no-image {
            background:
                linear-gradient(rgba(31,47,107,0.88), rgba(31,47,107,0.88)),
                linear-gradient(135deg, #283979, #1f2f6b);
        }

        .wave-lines {
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: 0.78;
        }

        .wave-lines svg {
            width: 100%;
            height: 100%;
        }

        .right-content {
            position: relative;
            z-index: 2;
            padding: 42px 34px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            min-height: 100%;
        }

        .right-title {
            font-size: 58px;
            line-height: 0.98;
            font-weight: 800;
            margin: 0 0 18px;
            letter-spacing: -1px;
        }

        .right-desc {
            font-size: 16px;
            line-height: 1.5;
            color: rgba(255,255,255,0.96);
            max-width: 470px;
            margin-bottom: 18px;
        }

        .right-btn {
            display: inline-block;
            background: #f6d34c;
            color: var(--navy);
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 17px;
            text-decoration: none;
            box-shadow: inset 0 -2px 0 rgba(0,0,0,0.08);
        }

        .right-btn:hover {
            background: #f1ca33;
            color: var(--navy-dark);
        }

        .right-copy {
            position: absolute;
            right: 14px;
            bottom: 10px;
            font-size: 12px;
            color: rgba(255,255,255,0.72);
            z-index: 2;
        }

        .login-title {
            font-size: 30px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 22px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 400;
            color: #2d3550;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            height: 42px;
            border-radius: 6px;
            border: 1px solid #cfd4da;
            background: #e9eff8;
            color: #1f2937;
            font-size: 14px;
            box-shadow: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #8fb2ec;
            background: #edf3fd;
            box-shadow: 0 0 0 0.18rem rgba(82, 132, 214, 0.16);
        }

        .password-wrap {
            display: flex;
            align-items: stretch;
        }

        .password-wrap .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: none;
        }

        .btn-eye {
            width: 46px;
            border: 1px solid #9aa0a6;
            border-left: none;
            background: #f0f0f0;
            color: #70757a;
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .btn-eye:hover {
            background: #e7e7e7;
        }

        .captcha-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .captcha-box {
            width: 140px;
            height: 52px;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #bdbdbd;
            background:
                radial-gradient(circle at 25% 30%, rgba(255,255,255,0.25), transparent 35%),
                linear-gradient(135deg, #0f0f0f 0%, #7a7a7a 45%, #f0f0f0 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .captcha-box::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                repeating-linear-gradient(
                    110deg,
                    rgba(0,0,0,0.16) 0px,
                    rgba(0,0,0,0.16) 2px,
                    transparent 2px,
                    transparent 12px
                );
            mix-blend-mode: multiply;
            opacity: 0.35;
        }

        .captcha-text {
            position: relative;
            z-index: 2;
            color: #111;
            font-size: 28px;
            font-style: italic;
            letter-spacing: 1px;
            text-shadow: 1px 1px 0 rgba(255,255,255,0.6);
            transform: rotate(-8deg);
            user-select: none;
        }

        .captcha-refresh {
            color: #0d6efd;
            font-size: 24px;
            line-height: 1;
            text-decoration: none;
        }

        .captcha-input-wrap {
            flex: 1;
            display: flex;
            align-items: stretch;
        }

        .captcha-lock {
            width: 44px;
            border: 1px solid #d2d6db;
            border-right: none;
            background: #f1f3f4;
            color: #70757a;
            display: flex;
            align-items: center;
            justify-content: center;
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }

        .captcha-input {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            background: #f5f5f5;
        }

        .forgot-link {
            margin-top: 18px;
            margin-bottom: 16px;
        }

        .forgot-link a {
            color: #1f2937;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
        }

        .forgot-link a:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 6px;
            background: var(--yellow);
            color: var(--navy);
            font-size: 16px;
            font-weight: 800;
        }

        .btn-login:hover {
            background: var(--yellow-dark);
            color: var(--navy);
        }

        .bottom-links {
            text-align: center;
            margin-top: 14px;
            font-size: 14px;
            line-height: 1.6;
        }

        .bottom-links a {
            color: #de2d2d;
            font-weight: 700;
            text-decoration: none;
        }

        .bottom-links a:hover {
            text-decoration: underline;
        }

        .footer-logos {
            margin-top: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            color: var(--navy);
            font-weight: 800;
            font-size: 22px;
        }

        .footer-logos .mini-logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .footer-logos .mini-dot {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--yellow), var(--navy));
            display: inline-block;
        }

        @media (max-width: 991.98px) {
            .right-title {
                font-size: 44px;
            }
        }

        @media (max-width: 767.98px) {
            .page-wrap {
                padding: 18px 12px 40px;
            }

            .brand-top .brand-core {
                font-size: 44px;
            }

            .login-left {
                padding: 26px 18px 20px;
            }

            .login-right {
                min-height: 360px;
            }

            .right-title {
                font-size: 38px;
            }

            .captcha-row {
                flex-direction: column;
                align-items: stretch;
            }

            .captcha-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="bg-city">
        <svg viewBox="0 0 900 500" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" stroke="#7c7c7c" stroke-width="4">
                <path d="M40 460 L40 330 L70 270 L70 460" />
                <path d="M95 460 L95 250 L145 250 L145 460" />
                <path d="M120 250 L120 210 L135 210 L135 250" />
                <path d="M180 460 L180 380 L260 300 L260 460" />
                <path d="M290 460 L290 140 L360 140 L360 460" />
                <path d="M305 140 L305 100 L345 100 L345 140" />
                <path d="M315 180 L335 180 M315 210 L335 210 M315 240 L335 240 M315 270 L335 270 M315 300 L335 300 M315 330 L335 330 M315 360 L335 360 M315 390 L335 390" />
                <path d="M390 460 L390 350 L470 310 L470 460" />
                <path d="M500 460 L500 390 L570 340 L570 460" />
                <path d="M610 460 L610 250 L690 250 L690 460" />
                <path d="M630 250 L630 200 L670 200 L670 250" />
                <path d="M720 460 L720 330 L790 290 L790 460" />
                <path d="M0 460 L860 460" />
            </g>
            <g fill="#8c8c8c">
                <circle cx="12" cy="300" r="8"/>
                <circle cx="210" cy="380" r="5"/>
                <circle cx="430" cy="430" r="4"/>
                <circle cx="585" cy="320" r="6"/>
            </g>
        </svg>
    </div>

    <div class="page-wrap">
        <div class="login-area">
            <div class="brand-top">
                <div class="brand-core">
                    <span class="core">SOP</span><span class="tax">oltesa</span>
                </div>
                <div class="brand-sub">Sistem Informasi SOP Politeknik Negeri Sambas</div>
            </div>

            <div class="login-box">
                <div class="row g-0">
                    <div class="col-lg-5">
                        <div class="login-left">
                            <div class="login-title">Login</div>

                            @if(session('error'))
                                <div class="alert alert-danger py-2 small">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('login.proses') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">ID Pengguna</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kata Sandi</label>
                                    <div class="password-wrap">
                                        <input type="password" name="password" id="password" class="form-control" required>
                                        <button type="button" class="btn-eye" onclick="togglePassword()">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pemilihan Bahasa</label>
                                    <select class="form-select" name="bahasa">
                                        <option value="id-ID" selected>id-ID</option>
                                        <option value="en-US">en-US</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <div class="captcha-row">
                                        <div class="captcha-box">
                                            <div class="captcha-text">198350</div>
                                        </div>

                                        <a href="#" class="captcha-refresh" title="Refresh captcha">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </a>

                                        <div class="captcha-input-wrap">
                                            <div class="captcha-lock">
                                                <i class="bi bi-lock-fill"></i>
                                            </div>
                                            <input type="text" class="form-control captcha-input" placeholder="Masukkan Captcha">
                                        </div>
                                    </div>
                                </div>

                                <div class="forgot-link">
                                    <a href="#">Lupa Kata Sandi?</a>
                                </div>

                                <button type="submit" class="btn btn-login">Login</button>

                                <div class="bottom-links">
                                    Pengguna Baru? <a href="#">Daftar di sini</a><br>
                                    <a href="#">Aktivasi Akun SOP</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="login-right no-image">
                            <div class="wave-lines">
                                <svg viewBox="0 0 800 600" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                    <g fill="none" stroke="#f7c718" stroke-width="2">
                                        <path d="M-60 60 C120 20, 180 180, 340 170 S560 110, 860 180"/>
                                        <path d="M-60 82 C120 42, 180 202, 340 192 S560 132, 860 202"/>
                                        <path d="M-60 104 C120 64, 180 224, 340 214 S560 154, 860 224"/>
                                        <path d="M-60 126 C120 86, 180 246, 340 236 S560 176, 860 246"/>
                                        <path d="M-60 148 C120 108, 180 268, 340 258 S560 198, 860 268"/>
                                        <path d="M-60 170 C120 130, 180 290, 340 280 S560 220, 860 290"/>
                                        <path d="M-60 192 C120 152, 180 312, 340 302 S560 242, 860 312"/>
                                        <path d="M-60 214 C120 174, 180 334, 340 324 S560 264, 860 334"/>
                                        <path d="M-60 236 C120 196, 180 356, 340 346 S560 286, 860 356"/>
                                        <path d="M-60 258 C120 218, 180 378, 340 368 S560 308, 860 378"/>
                                        <path d="M-60 280 C120 240, 180 400, 340 390 S560 330, 860 400"/>
                                    </g>
                                </svg>
                            </div>

                            <div class="right-content">
                                <h2 class="right-title">SOP<br>POLTESA</h2>
                                <div class="right-desc">
                                    Pengelola SOP dapat mengakses sistem ini untuk pengajuan,
                                    revisi, verifikasi, dan arsip dokumen SOP secara terintegrasi.
                                </div>
                                <a href="#" class="right-btn">Lihat panduan penting SOP</a>
                            </div>

                            <div class="right-copy">
                                Hak Cipta © {{ date('Y') }} Politeknik Negeri Sambas
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-logos">
                <span class="mini-logo"><span class="mini-dot"></span> SOP</span>
                <span class="mini-logo">POLTESA</span>
                <span class="mini-logo">LAYANAN DIGITAL</span>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>