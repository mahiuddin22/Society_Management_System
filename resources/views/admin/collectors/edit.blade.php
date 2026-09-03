@extends('admin.layouts.app')

@section('content')

<!-- Edit Form Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" value="{{ $user->name }}" required />
                    <div class="invalid-feedback">Please enter name.</div>
                </div>
                <div class="col-md-6">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->role == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a role.</div>
                </div>
                <div class="col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}" required />
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" />
                    <div class="invalid-feedback">Please enter a password.</div>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" />
                    <div class="invalid-feedback">Please confirm your password.</div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
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