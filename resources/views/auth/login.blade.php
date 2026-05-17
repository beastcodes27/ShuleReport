<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login &mdash; {{ config('app.name', 'ShuleReport') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── System palette (mirrors custom.css) ── */
        :root {
            --primary:        #c2b280;   /* Earth Beige */
            --primary-hover:  #b0a070;
            --secondary:      #b88d0b;   /* Harvest Gold */
            --dark:           #3e2723;   /* Deep Umber */
            --light:          #fdfaf5;   /* Warm White */
            --bg:             #f1f5f9;   /* body background */
            --sidebar-bg:     #f5f5dc;   /* Beige sidebar */
            --border:         #d7ccc8;
            --danger:         #dc2626;
            --radius:         10px;
            --shadow:         0 4px 20px rgba(62,39,35,.10);
            --transition:     .2s ease;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--dark);
            -webkit-font-smoothing: antialiased;
        }

        /* ── split layout ── */
        .page {
            display: flex;
            min-height: 100vh;
        }

        /* Left panel */
        .panel-left {
            flex: 0 0 42%;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }

        /* decorative circles — solid, on-brand */
        .panel-left::before {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(184,141,11,.10);
            top: -80px; left: -80px;
        }
        .panel-left::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(194,178,128,.15);
            bottom: -50px; right: -50px;
        }

        .panel-left-content { position: relative; z-index: 1; text-align: center; }

        .brand-icon {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: var(--secondary);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 24px rgba(184,141,11,.35);
        }
        .brand-icon svg {
            width: 38px; height: 38px;
            fill: none;
            stroke: #fff;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .brand-name {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -.6px;
            color: var(--dark);
            margin-bottom: 6px;
        }
        .brand-tagline {
            font-size: 14px;
            color: var(--secondary);
            font-weight: 500;
        }

        .panel-divider {
            width: 48px; height: 3px;
            background: var(--secondary);
            border-radius: 99px;
            margin: 24px auto;
        }

        .panel-blurb {
            font-size: 14px;
            color: #6d4c41;
            line-height: 1.7;
            max-width: 280px;
        }

        /* stat pills */
        .stat-pills {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 32px;
            width: 100%;
            max-width: 260px;
        }
        .stat-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            box-shadow: var(--shadow);
        }
        .stat-pill-icon {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: rgba(184,141,11,.12);
            display: flex; align-items: center; justify-content: center;
            color: var(--secondary);
            font-size: 16px;
            flex-shrink: 0;
        }
        .stat-pill-text { line-height: 1.3; }
        .stat-pill-label { font-size: 11px; color: #9e9e9e; }
        .stat-pill-value { font-size: 13px; font-weight: 600; color: var(--dark); }

        /* Right panel */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            background: var(--light);
        }

        /* Card */
        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: slideUp .4s ease both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0);     }
        }

        .login-card-top {
            height: 5px;
            background: var(--secondary);
        }

        .login-card-body { padding: 36px 36px 40px; }

        .headline  { font-size: 22px; font-weight: 700; letter-spacing: -.4px; color: var(--dark); margin-bottom: 4px; }
        .subline   { font-size: 13px; color: #8d6e63; margin-bottom: 28px; }

        /* Error */
        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #dc2626;
            font-size: 13px;
            padding: 10px 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        /* Fields */
        .field { margin-bottom: 18px; }

        label.field-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 7px;
            letter-spacing: .2px;
            text-transform: uppercase;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #a1887f;
            pointer-events: none;
            display: flex;
            font-size: 16px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            background: var(--light);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            color: var(--dark);
            font-family: inherit;
            font-size: 14px;
            padding: 11px 14px 11px 40px;
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }
        input::placeholder { color: #bcaaa4; }
        input:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(184,141,11,.15);
            background: #fff;
        }
        input.is-invalid {
            border-color: var(--danger) !important;
            box-shadow: 0 0 0 3px rgba(220,38,38,.1) !important;
        }
        .invalid-feedback {
            display: block;
            font-size: 12px;
            color: var(--danger);
            margin-top: 5px;
            padding-left: 2px;
        }

        /* Password toggle */
        .toggle-pw {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #a1887f;
            cursor: pointer;
            padding: 2px;
            font-size: 16px;
            display: flex;
            transition: color var(--transition);
        }
        .toggle-pw:hover { color: var(--dark); }

        /* Remember + forgot */
        .row-aux {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .checkbox-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }
        .checkbox-wrap input[type="checkbox"] {
            appearance: none; -webkit-appearance: none;
            width: 17px; height: 17px;
            border: 1.5px solid var(--border);
            border-radius: 4px;
            background: var(--light);
            flex-shrink: 0;
            cursor: pointer;
            position: relative;
            transition: background var(--transition), border-color var(--transition);
        }
        .checkbox-wrap input[type="checkbox"]:checked {
            background: var(--secondary);
            border-color: var(--secondary);
        }
        .checkbox-wrap input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 10'%3E%3Cpath d='M1 5l3.5 3.5L11 1' stroke='%23fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' fill='none'/%3E%3C/svg%3E") center/10px no-repeat;
        }
        .checkbox-label {
            font-size: 13px;
            color: #6d4c41;
        }
        .forgot-link {
            font-size: 13px;
            font-weight: 500;
            color: var(--secondary);
            text-decoration: none;
            transition: color var(--transition);
        }
        .forgot-link:hover { color: var(--primary-hover); text-decoration: underline; }

        /* Submit */
        .btn-login {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: var(--secondary);
            color: var(--light);
            font-family: inherit;
            font-size: 14.5px;
            font-weight: 600;
            letter-spacing: .3px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            box-shadow: 0 4px 14px rgba(184,141,11,.35);
        }
        .btn-login:hover {
            background: #a57c0a;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(184,141,11,.4);
        }
        .btn-login:active { transform: translateY(0); }

        .btn-login .loader {
            display: none;
            width: 18px; height: 18px;
            border: 2.5px solid rgba(255,255,255,.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            margin: auto;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn-login.loading .btn-text { display: none; }
        .btn-login.loading .loader   { display: block; }

        /* Register link */
        .register-row {
            text-align: center;
            font-size: 13px;
            color: #8d6e63;
            margin-top: 22px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .register-row a {
            color: var(--secondary);
            font-weight: 600;
            text-decoration: none;
            transition: color var(--transition);
        }
        .register-row a:hover { color: #a57c0a; text-decoration: underline; }

        /* Responsive: stack on small screens */
        @media (max-width: 768px) {
            .panel-left { display: none; }
            .panel-right { background: var(--bg); }
            .login-card  { box-shadow: var(--shadow); }
        }
    </style>
</head>
<body>

<div class="page">

    {{-- ── Left decorative panel ── --}}
    <div class="panel-left">
        <div class="panel-left-content">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            </div>
            <div class="brand-name">ShuleReport</div>
            <div class="brand-tagline">School Management Portal</div>
            <div class="panel-divider"></div>
            <p class="panel-blurb">
                Manage academic records, reports, and school data — all in one place.
            </p>

            <div class="stat-pills">
                <div class="stat-pill">
                    <div class="stat-pill-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-pill-text">
                        <div class="stat-pill-label">Students Managed</div>
                        <div class="stat-pill-value">Real-time Records</div>
                    </div>
                </div>
                <div class="stat-pill">
                    <div class="stat-pill-icon"><i class="bi bi-bar-chart-fill"></i></div>
                    <div class="stat-pill-text">
                        <div class="stat-pill-label">Academic Reports</div>
                        <div class="stat-pill-value">Instant Generation</div>
                    </div>
                </div>
                <div class="stat-pill">
                    <div class="stat-pill-icon"><i class="bi bi-shield-check-fill"></i></div>
                    <div class="stat-pill-text">
                        <div class="stat-pill-label">Access Control</div>
                        <div class="stat-pill-value">Role-based Security</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Right form panel ── --}}
    <div class="panel-right">
        <div class="login-card">
            <div class="login-card-top"></div>
            <div class="login-card-body">

                <h1 class="headline">Sign in</h1>
                <p class="subline">Enter your credentials to access your account</p>

                {{-- global error --}}
                @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                    <div class="error-box">
                        <i class="bi bi-exclamation-circle-fill" style="margin-top:1px"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    {{-- Email --}}
                    <div class="field">
                        <label class="field-label" for="email">Email address</label>
                        <div class="input-wrap">
                            <span class="input-icon"><i class="bi bi-envelope-fill"></i></span>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="you@school.ac"
                                required
                                autocomplete="email"
                                autofocus
                                class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                            >
                        </div>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field">
                        <label class="field-label" for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            >
                            <button type="button" class="toggle-pw" onclick="togglePassword()" aria-label="Toggle visibility">
                                <i class="bi bi-eye-fill" id="eye-show"></i>
                                <i class="bi bi-eye-slash-fill" id="eye-hide" style="display:none"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="row-aux">
                        <label class="checkbox-wrap">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkbox-label">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-login" id="submitBtn">
                        <span class="btn-text">Sign in &nbsp;<i class="bi bi-arrow-right"></i></span>
                        <span class="loader"></span>
                    </button>
                </form>

                @if (Route::has('register'))
                    <div class="register-row">
                        Don't have an account? <a href="{{ route('register') }}">Create one</a>
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>

<script>
    function togglePassword() {
        const input   = document.getElementById('password');
        const eyeShow = document.getElementById('eye-show');
        const eyeHide = document.getElementById('eye-hide');
        if (input.type === 'password') {
            input.type = 'text';
            eyeShow.style.display = 'none';
            eyeHide.style.display = '';
        } else {
            input.type = 'password';
            eyeShow.style.display = '';
            eyeHide.style.display = 'none';
        }
    }

    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.classList.add('loading');
        btn.disabled = true;
    });
</script>

</body>
</html>
