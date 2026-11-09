<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login - Member Portal</title>

    <!-- Bootstrap 5.3 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --forest-primary: #2b6242;
            --forest-dark: #245338;
            --forest-bg: #f8faf7;
            --forest-tint: #f0f7f3;
            --forest-light: #d8f3dc;
        }

        body {
            position: relative;
            isolation: isolate;
            font-family: 'Inter', sans-serif;
            background-color: var(--forest-bg);
            overflow-x: hidden;
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
            min-height: 600px;
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(390px, .92fr);
            border: 1px solid rgba(226, 232, 226, .9);
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 28px 80px -32px rgba(14, 46, 26, .34), 0 10px 28px rgba(23, 56, 34, .08);
            overflow: hidden;
        }

        .login-visual {
            position: relative;
            isolation: isolate;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px;
            overflow: hidden;
            color: #fff;
            background: #173822;
        }

        .login-visual::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background: linear-gradient(145deg, rgba(9, 31, 18, .84), rgba(19, 61, 35, .55) 48%, rgba(8, 30, 17, .78)), url("{{ !empty($siteSettings?->login_panel_image) ? asset('uploads/settings/'.$siteSettings->login_panel_image) : asset('assets/images/2.jpg') }}") center / cover no-repeat;
            filter: saturate(1.3);
            transform: scale(1.02);
        }

        .brand-lockup { display: flex; align-items: center; gap: 13px; }
        .brand-crest {
            width: 46px; height: 46px; display: inline-flex; align-items: center; justify-content: center;
            border: 1px solid rgba(255,255,255,.26); border-radius: 12px; background: rgba(255,255,255,.13);
            color: #fff; font-size: 15px; font-weight: 700; letter-spacing: .03em; flex-shrink: 0;
        }
        .brand-lockup-name { font-size: 14px; font-weight: 700; line-height: 1.3; }
        .brand-lockup-caption { margin-top: 3px; color: rgba(255,255,255,.72); font-size: 11px; letter-spacing: .11em; text-transform: uppercase; }
        .visual-copy { max-width: 440px; padding: 34px 0; }
        .visual-eyebrow { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 18px; color: #d8e9dc; font-size: 11px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
        .visual-eyebrow::before { content: ""; width: 24px; height: 1px; background: #d8e9dc; }
        .visual-copy h2 { margin: 0 0 14px; color: #fff; font-family: Georgia, serif; font-size: clamp(32px, 4vw, 46px); font-weight: 500; line-height: 1.08; letter-spacing: -.025em; }
        .visual-copy p { max-width: 370px; margin: 0; color: rgba(255,255,255,.78); font-size: 14px; line-height: 1.75; }
        .visual-footer { display: flex; align-items: center; gap: 9px; color: rgba(255,255,255,.82); font-size: 12px; }

        .login-form-panel { display: flex; flex-direction: column; justify-content: center; min-width: 0; padding: 48px 54px; background: #fff; }
        .member-form-header { margin-bottom: 28px; }
        .member-form-header h1 { margin: 0 0 7px; color: #173822; font-size: 28px; font-weight: 700; letter-spacing: -.035em; }
        .member-form-header p { margin: 0; color: #6d7469; font-size: 13px; line-height: 1.6; }
        .member-form-content { padding: 0; }

        @media (max-width: 767.98px) {
            .login-card { max-width: 480px; min-height: 0; grid-template-columns: 1fr; }
            .login-visual { min-height: 220px; padding: 24px; }
            .visual-copy { padding: 24px 0 4px; }
            .visual-copy h2 { max-width: 360px; font-size: 29px; }
            .visual-copy p, .visual-footer { display: none; }
            .login-form-panel { padding: 30px 26px; }
            .member-form-header { margin-bottom: 22px; }
        }

        .icon-badge {
            width: 52px;
            height: 52px;
            background-color: var(--forest-light);
            color: var(--forest-primary);
        }

        .phone-input-field {
            height: 46px;
            font-size: 14px;
            border: 1.5px solid #c8d3c5;
            color: #1e293b;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .phone-input-field:focus {
            border-color: var(--forest-primary);
            box-shadow: 0 0 0 3px rgba(43, 98, 66, 0.15);
            outline: none;
        }

        .input-group-text-custom {
            background-color: #ffffff;
            border: 1.5px solid #c8d3c5;
            border-right: none;
            color: #64748b;
        }

        .phone-input-field:focus+.input-group-text-custom,
        .input-group:focus-within .input-group-text-custom {
            border-color: var(--forest-primary);
        }

        .btn-forest {
            background-color: var(--forest-primary) !important;
            border-color: var(--forest-dark) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(43, 98, 66, 0.22);
        }

        .btn-forest:hover {
            background-color: var(--forest-dark) !important;
            transform: translateY(-1px);
        }

        .text-forest {
            color: var(--forest-primary) !important;
        }
    </style>
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center p-3">

    <div class="login-card">
        <aside class="login-visual">
            <div class="brand-lockup">
                <div class="brand-crest">U3</div>
                <div><div class="brand-lockup-name">Uttara Sector 3</div><div class="brand-lockup-caption">Welfare Society</div></div>
            </div>
            <div class="visual-copy">
                <span class="visual-eyebrow">Member Portal</span>
                <h2>Connected to the community you call home.</h2>
                <p>Access your society services and payment information through a secure member portal.</p>
            </div>
            <div class="visual-footer"><i class="bi bi-shield-lock-fill"></i><span>Secure sign-in with your registered number</span></div>
        </aside>

        <main class="login-form-panel">
        <!-- Header -->
        <div class="member-form-header">
            <div class="icon-badge rounded-3 d-inline-flex align-items-center justify-content-center mb-3 shadow-sm">
                <i class="bi bi-person-badge-fill fs-4"></i>
            </div>
            <h1>Member sign in</h1>
            <p>Enter your registered phone number to receive a one-time sign-in code.</p>
        </div>

        <!-- Body -->
        <div class="member-form-content">

            @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 small rounded-3 mb-3" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            <form method="POST" action="{{ route('member.otp.send') }}" autocomplete="off">
                @csrf

                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold small mb-1 text-dark">
                        Phone Number <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom rounded-start-3">
                            <i class="bi bi-telephone-fill"></i>
                        </span>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="form-control phone-input-field rounded-end-3 @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}"
                            placeholder="e.g. 017XXXXXXXX"
                            required
                            autofocus>
                    </div>
                    @error('phone')
                    <div class="text-danger small mt-1 fw-medium" style="font-size: 11.5px;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-forest w-100 py-2 d-flex align-items-center justify-content-center gap-2 rounded-3 fw-semibold mb-3">
                    <i class="bi bi-send-fill"></i>
                    <span>Send OTP Code</span>
                </button>

                <!-- Sub Navigation -->
                <div class="d-flex align-items-center justify-content-between pt-3 border-top small">
                    <span class="text-secondary">Admin or staff?</span>
                    <a href="{{ route('login') }}" class="text-forest fw-semibold text-decoration-none d-inline-flex align-items-center gap-1">
                        <span>Admin Login</span>
                        <i class="bi bi-chevron-right small"></i>
                    </a>
                </div>

            </form>
        </div>

        </main>
    </div>

</body>

</html>
