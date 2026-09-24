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

        /* 100% Viewport-fitted without scrolling on mobile */
        html, body {
            height: 100%;
            height: 100dvh;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--paper-bg);
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(23, 56, 34, 0.04) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(23, 56, 34, 0.05) 0%, transparent 45%);
            color: var(--ink-900);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            background: var(--card-bg);
            border: 1px solid var(--line);
            border-radius: var(--radius-m);
            box-shadow: 
                0 4px 6px -1px rgba(23, 56, 34, 0.03),
                0 14px 28px -4px rgba(23, 56, 34, 0.08);
            padding: 22px 24px;
        }

        /* Brand Crest Badge */
        .brand-crest {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--forest-800) 0%, var(--forest-900) 100%);
            color: #ffffff;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Newsreader', serif;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(23, 56, 34, 0.2);
            margin-bottom: 6px;
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
            font-size: 11.5px;
            color: var(--ink-500);
            margin-bottom: 14px;
        }

        /* Inputs */
        .form-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--ink-700);
            margin-bottom: 4px;
        }

        .form-control {
            height: 38px;
            font-size: 13px;
            border-radius: var(--radius-s);
            border: 1px solid var(--line-strong);
            background-color: var(--card-bg);
            color: var(--ink-900);
            padding: 5px 12px;
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
            padding-right: 38px;
        }

        /* Fix: Suppress Bootstrap's red (!) icon specifically on password so it won't collide with the eye */
        .input-group-password .form-control.is-invalid {
            background-image: none !important;
        }

        .password-toggle-btn {
            position: absolute;
            right: 0;
            top: 0;
            height: 38px;
            width: 38px;
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
            height: 38px;
            background-color: var(--forest-800);
            color: #ffffff;
            border: 1px solid var(--forest-900);
            border-radius: var(--radius-s);
            font-size: 13px;
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
            width: 14px;
            height: 14px;
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
            padding-right: 42px !important;
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
        
        <!-- Header -->
        <div class="text-center">
            <div class="brand-crest">
                <span>U3</span>
            </div>
            <h1 class="brand-title">Welcome Back</h1>
            <p class="brand-subtitle">Uttara Sector 3 Welfare Society &bull; Office</p>
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