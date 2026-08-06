<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Floating Header Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-wrapper {
            max-width: 500px;
            width: 40%;
            position: relative;
            padding-top: 60px;
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

        .form-label.required::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 pt-5 register-wrapper">

            <!-- Floating Header -->
            <div class="header-box">
                Register
            </div>

            <!-- Form -->
            <div class="card-body pt-3">
                <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-sm-4 col-form-label required d-flex align-items-center">Name</label>
                        <div class="col-sm-8">
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus autocomplete="name">
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="role" class="col-sm-4 col-form-label required d-flex align-items-center">Role</label>
                        <div class="col-sm-8">
                            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="" disabled selected>Select role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                            @error('role')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-4 col-form-label required d-flex align-items-center">Email</label>
                        <div class="col-sm-8">
                            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="username">
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-sm-4 col-form-label required d-flex align-items-center">Password</label>
                        <div class="col-sm-8">
                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password_confirmation" class="col-sm-4 col-form-label required d-flex align-items-center">Confirm Password</label>
                        <div class="col-sm-8">
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required autocomplete="new-password">
                            @error('password_confirmation')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none small">Already registered?</a>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

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
    </script>
</body>

</html>