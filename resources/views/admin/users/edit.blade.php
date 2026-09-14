
@extends('admin.layouts.app')

@section('content')

<!-- Edit Form Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="needs-validation" id="EdiUserForm" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" placeholder="Name" required />
                    <div class="invalid-feedback">Please enter name.</div>
                </div>

                <div class="col-md-6">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->role == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a role.</div>
                </div>

                <div class="col-md-12">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" placeholder="Enter Username" required />
                    <div class="invalid-feedback">Please enter a username.</div>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Leave blank to keep current password" minlength="6" />
                    <div class="invalid-feedback">Password must be at least 6 characters.</div>
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" minlength="6" />
                    <div class="invalid-feedback">Passwords must match.</div>
                </div>

            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Update
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const form = document.getElementById('EdiUserForm');

    if (!form) return;

    const fields = form.querySelectorAll('input, select');

    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    function validateField(field) {

        if (field === password) {

            if (password.value && password.value.length < 6) {
                password.setCustomValidity('Password must be at least 6 characters.');
            } else {
                password.setCustomValidity('');
            }

        }

        if (field === passwordConfirmation) {

            if (!password.value && !passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('');
            } else if (passwordConfirmation.value.length < 6) {
                passwordConfirmation.setCustomValidity('Password must be at least 6 characters.');
            } else if (passwordConfirmation.value !== password.value) {
                passwordConfirmation.setCustomValidity('Passwords do not match.');
            } else {
                passwordConfirmation.setCustomValidity('');
            }

        }

        if (field.checkValidity()) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
        }

    }

    fields.forEach(function(field) {

        field.addEventListener('input', function() {
            validateField(field);
        });

        field.addEventListener('change', function() {
            validateField(field);
        });

        field.addEventListener('blur', function() {
            validateField(field);
        });

    });

    password.addEventListener('input', function() {
        validateField(password);
        validateField(passwordConfirmation);
    });

    passwordConfirmation.addEventListener('input', function() {
        validateField(passwordConfirmation);
    });

    form.addEventListener('submit', function(event) {

        validateField(password);
        validateField(passwordConfirmation);

        if (!form.checkValidity()) {

            event.preventDefault();
            event.stopPropagation();

            fields.forEach(function(field) {
                validateField(field);
            });

        }

    });

});
</script>
@endpush