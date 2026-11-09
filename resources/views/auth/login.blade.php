<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login &bull; Uttara Sector 3 Welfare Society</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <!-- Google Fonts: Inter & Newsreader -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Newsreader:ital,opsz,wght@0,6..72,500;0,6..72,600;1,6..72,400&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CDN & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <style>
        :root {
            --forest-900: #0f2416;
            --forest-800: #173822;
            --forest-700: #1e492c;
            --forest-600: #2a613c;
            --forest-100: #e2ede5;
            --forest-50:  #f0f6f2;
            
            --ink-900: #1a1e1b;
            --ink-700: #414a44;
            --ink-500: #6d7469;
            --line:    #e4e8e3;
            --line-strong: #c8cec6;
            
            --paper-bg: #f8faf8;
            --card-bg:  #ffffff;
            --radius-m: 12px;
            --radius-s: 7px;
        }

        * {
            box-sizing: border-box;
        }

        /* Full-height login layout with room to scroll on short screens */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            min-height: 100dvh;
            overflow-x: hidden;
        }

        body {
            position: relative;
            isolation: isolate;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f1f5f2;
            background-image:
                radial-gradient(circle at 12% 15%, rgba(42, 97, 60, 0.10), transparent 30%),
                radial-gradient(circle at 90% 85%, rgba(23, 56, 34, 0.08), transparent 32%);
            color: var(--ink-900);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(14px, 4vh, 32px) 14px;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
        }

        body::before {
            z-index: -2;
            inset: -12px;
            background: url("{{ !empty($siteSettings?->login_background_image) ? asset('uploads/settings/'.$siteSettings->login_background_image) : asset('assets/images/4.jpg') }}") center / cover no-repeat;
            filter: blur(8px) saturate(.82);
            transform: scale(1.02);
        }

        body::after {
            z-index: -1;
            background: rgba(255, 255, 255, .76);
        }

        .login-card {
            width: 100%;
            max-width: 1000px;
            min-height: 610px;
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(390px, 0.92fr);
            background: var(--card-bg);
            border: 1px solid var(--line);
            border-radius: 20px;
            box-shadow: 0 28px 80px -32px rgba(14, 46, 26, 0.34), 0 10px 28px rgba(23, 56, 34, 0.08);
            overflow: hidden;
        }

        .login-visual {
            position: relative;
            isolation: isolate;
            min-height: 610px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px;
            color: #fff;
            background: #173822;
            overflow: hidden;
        }

        .login-visual::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background-image:
                linear-gradient(145deg, rgba(9, 31, 18, 0.84) 0%, rgba(19, 61, 35, 0.55) 48%, rgba(8, 30, 17, 0.78) 100%),
                url("{{ !empty($siteSettings?->login_panel_image) ? asset('uploads/settings/'.$siteSettings->login_panel_image) : asset('assets/images/2.jpg') }}");
            background-position: center;
            background-size: cover;
            filter: saturate(1.3);
            transform: scale(1.02);
        }

        .brand-lockup {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-lockup-name {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .01em;
            line-height: 1.3;
        }

        .brand-lockup-caption {
            margin-top: 3px;
            color: rgba(255, 255, 255, .72);
            font-size: 11px;
            letter-spacing: .11em;
            text-transform: uppercase;
        }

        .visual-copy {
            max-width: 440px;
            padding: 34px 0;
        }

        .visual-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            color: #d8e9dc;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .visual-eyebrow::before {
            content: "";
            width: 24px;
            height: 1px;
            background: #d8e9dc;
        }

        .visual-copy h2 {
            margin: 0 0 14px;
            color: #fff;
            font-family: 'Newsreader', Georgia, serif;
            font-size: clamp(32px, 4vw, 46px);
            font-weight: 500;
            line-height: 1.08;
            letter-spacing: -.025em;
        }

        .visual-copy p {
            max-width: 370px;
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: 14px;
            line-height: 1.75;
        }

        .visual-footer {
            display: flex;
            align-items: center;
            gap: 9px;
            color: rgba(255, 255, 255, .82);
            font-size: 12px;
        }

        .login-form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 52px 54px;
            background: #fff;
            min-width: 0;
        }

        .login-form-heading {
            margin-bottom: 30px;
        }

        /* Brand Crest Badge */
        .brand-crest {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, .13);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, .26);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: .03em;
            box-shadow: 0 5px 15px rgba(3, 19, 10, .18);
            flex-shrink: 0;
        }

        .brand-title {
            font-family: 'Newsreader', serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--forest-900);
            line-height: 1.15;
            margin-bottom: 2px;
        }

        .brand-subtitle {
            font-size: 13px;
            color: var(--ink-500);
            margin-bottom: 0;
        }

        .login-kicker {
            display: block;
            margin-bottom: 8px;
            color: var(--forest-700);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .login-form-heading .brand-title {
            margin-bottom: 7px;
            font-family: 'Inter', sans-serif;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -.04em;
        }

        @media (max-width: 767.98px) {
            html, body {
                height: auto;
                min-height: 100%;
            }

            body {
                min-height: 100dvh;
                padding: 16px;
            }

            .login-card {
                max-width: 480px;
                min-height: 0;
                grid-template-columns: 1fr;
            }

            .login-visual {
                min-height: 230px;
                padding: 26px;
            }

            .visual-copy {
                padding: 24px 0 4px;
            }

            .visual-copy h2 {
                max-width: 360px;
                font-size: 30px;
            }

            .visual-copy p,
            .visual-footer {
                display: none;
            }

            .login-form-panel {
                padding: 30px 26px 28px;
            }

            .login-form-heading {
                margin-bottom: 22px;
            }
        }

        /* Inputs */
        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-700);
            margin-bottom: 7px;
        }

        .form-control {
            height: 46px;
            font-size: 14px;
            border-radius: 9px;
            border: 1px solid var(--line-strong);
            background-color: var(--card-bg);
            color: var(--ink-900);
            padding: 8px 13px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .form-control::placeholder {
            color: #a4aca0;
            font-size: 12.5px;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: var(--forest-700);
            box-shadow: 0 0 0 2px rgba(30, 73, 44, 0.12);
        }

        /* Password Group & Eye Button */
        .input-group-password {
            position: relative;
        }

        .input-group-password .form-control {
            padding-right: 44px;
        }

        /* Fix: Suppress Bootstrap's red (!) icon specifically on password so it won't collide with the eye */
        .input-group-password .form-control.is-invalid {
            background-image: none !important;
        }

        .password-toggle-btn {
            position: absolute;
            right: 0;
            top: 0;
            height: 46px;
            width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            color: var(--ink-500);
            cursor: pointer;
            z-index: 5;
            font-size: 13.5px;
            transition: color .15s ease;
        }

        .password-toggle-btn:hover {
            color: var(--forest-800);
        }

        /* Turn toggle red when invalid */
        .form-control.is-invalid ~ .password-toggle-btn {
            color: #dc3545;
        }

        /* Primary Action Button */
        .btn-forest {
            height: 46px;
            background-color: var(--forest-800);
            color: #ffffff;
            border: 1px solid var(--forest-900);
            border-radius: var(--radius-s);
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.15s ease;
        }

        .btn-forest:hover {
            background-color: var(--forest-700);
            color: #ffffff;
        }

        .form-check-input {
            width: 16px;
            height: 16px;
            margin-top: 0.12em;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--forest-800);
            border-color: var(--forest-800);
        }

        .form-check-label {
            font-size: 12px;
            color: var(--ink-700);
            cursor: pointer;
            user-select: none;
        }

        .invalid-feedback.d-block {
            text-align: left;
            margin-top: 3px;
            font-size: 11px;
            color: #dc3545;
        }

        .login-footer-hint {
            font-size: 11px;
            color: var(--ink-500);
            text-align: center;
            border-top: 1px solid var(--line);
            padding-top: 12px;
            margin-top: 14px;
            line-height: 1.35;
        }

        .login-footer-hint a {
            color: var(--forest-700);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer-hint a:hover {
            text-decoration: underline;
        }

        /* Strip Bootstrap's exclamation mark SVG icon completely from inputs that have a right-side toggle button */
        .input-group-password input.form-control,
        .input-group-password input.form-control.is-invalid,
        .was-validated .input-group-password input.form-control:invalid {
            background-image: none !important;
            padding-right: 48px !important;
        }

        /* Give the password toggle button the error color when the input is invalid */
        .input-group-password input.is-invalid ~ .password-toggle-btn,
        .was-validated .input-group-password input:invalid ~ .password-toggle-btn {
            color: #dc3545 !important;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <aside class="login-visual">
            <div class="brand-lockup">
                <div class="brand-crest"><span>U3</span></div>
                <div>
                    <div class="brand-lockup-name">Uttara Sector 3</div>
                    <div class="brand-lockup-caption">Welfare Society</div>
                </div>
            </div>

            <div class="visual-copy">
                <span class="visual-eyebrow">Office Portal</span>
                <h2>Serving our community, together.</h2>
                <p>Manage society services and community operations through one secure office portal.</p>
            </div>

            <div class="visual-footer"><i class="bi bi-shield-lock-fill"></i><span>Secure access for authorized staff</span></div>
        </aside>

        <main class="login-form-panel">
            <div class="login-form-heading">
                <span class="login-kicker">Staff sign in</span>
                <h1 class="brand-title">Welcome back</h1>
                <p class="brand-subtitle">Sign in with your office account to continue.</p>
            </div>

        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center py-2 px-3 mb-2" 
            role="alert" 
            style="font-size: 12px; line-height: 1.4;">
            <i class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0" style="font-size: 13px;"></i>
            <div class="flex-grow-1 pe-3">
                {{ $error }}
            </div>
            <button type="button" 
                    class="btn-close position-relative p-0" 
                    data-bs-dismiss="alert" 
                    aria-label="Close"
                    style="font-size: 9px; margin-left: auto;">
            </button>
        </div>
        @endforeach

        <!-- Form -->
        <form class="needs-validation" novalidate method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username / Email -->
            <div class="mb-2">
                <label for="email" class="form-label">Username / Email</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="admin@example.com" 
                    autocomplete="username"
                    required 
                    autofocus
                />
            </div>

            <!-- Password -->
            <div class="mb-2">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label mb-0">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="color: var(--forest-700); font-size: 11.5px; text-decoration: none;">
                            Forgot?
                        </a>
                    @endif
                </div>

                <div class="input-group-password">
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password" 
                        autocomplete="current-password"
                        required 
                    />
                    <button type="button" class="password-toggle-btn" onclick="togglePassword()" title="Toggle password visibility">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check d-flex align-items-center gap-2">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label mb-0" for="remember">Keep me signed in</label>
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-1">
                <button type="submit" class="btn btn-forest">
                    <span>Sign In</span>
                    <i class="bi bi-arrow-right-short" style="font-size: 16px;"></i>
                </button>
            </div>

            <div class="login-footer-hint">
                Need access? <a href="mailto:support@sector3welfare.org">Contact Admin</a>
            </div>
        </form>

        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            const isPassword = passwordInput.getAttribute('type') === 'password';

            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            icon.classList.toggle('bi-eye', !isPassword);
            icon.classList.toggle('bi-eye-slash', isPassword);
        }
    </script>
</body>

</html>
