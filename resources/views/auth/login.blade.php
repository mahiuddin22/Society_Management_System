<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Floating Header Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-wrapper {
            max-width: 500px;
            width: 40%;
            position: relative;
            padding-top: 60px;
            /* space for floating header */
        }

        .header-box {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #0d6efd;
            color: white;
            width: 90%;
            border-radius: 0.5rem;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 2;
        }

        .header-icon {
            background: #ffffff;
            color: #0d6efd;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 26px;
            margin: -45px auto 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .form-label.required::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }

        .forgot-password {
            text-align: right;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 pt-5 login-wrapper">

            <!-- Floating Header -->
            <div class="header-box">
                <!-- <div class="header-icon">
                    <i class="bi bi-book"></i>
                </div> -->
                Login
            </div>
            @include('admin.layouts.partials.message')
            <!-- Form -->
            <div class="card-body pt-3">
                <form class="needs-validation" novalidate method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email" required />
                        <div class="invalid-feedback">Please enter email.</div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label required">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="********" required />
                            <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </span>
                            <div class="invalid-feedback">Password is required.</div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot your password?</a>
                    </div>
                    @endif

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS for validation and password toggle -->
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
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }
    </script>
</body>

</html>