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
            font-family: 'Inter', sans-serif;
            background-color: var(--forest-bg);
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

    <div class="card border shadow-sm rounded-4 overflow-hidden w-100" style="max-width: 440px;">

        <!-- Header -->
        <div class="card-header bg-transparent border-bottom text-center pt-4 pb-3 px-4" style="background: linear-gradient(180deg, var(--forest-tint) 0%, #ffffff 100%);">
            <div class="icon-badge rounded-3 d-inline-flex align-items-center justify-content-center mb-3 shadow-sm">
                <i class="bi bi-person-badge-fill fs-4"></i>
            </div>
            <h5 class="fw-bold mb-1 text-dark">Member Portal</h5>
            <p class="text-secondary small mb-0">Sign in with OTP using your registered phone number</p>
        </div>

        <!-- Body -->
        <div class="card-body p-4">

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

    </div>

</body>

</html>