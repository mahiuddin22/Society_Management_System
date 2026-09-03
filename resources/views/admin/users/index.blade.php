@extends('admin.layouts.app')

@section('content')

<!-- Filter Form -->
<form action="" method="GET" class="d-flex align-items-center gap-2">

      <div class="search">

        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
          <circle cx="11" cy="11" r="7" />
          <path d="m21 21-4.3-4.3" />
        </svg>
        <input class="input" name="search" value="{{ request('search') }}" placeholder="Search by name / role / email / ">

      </div>

      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('admin.collection.index') }}" class="btn btn-secondary">Reset</a>

    </form>

<!-- Create Button under filter form -->
<div class="d-flex justify-content-end mb-3">
    @if(hasPermission('users', 'create'))
    <a href="#" class="btn btn-success px-4 py-1 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="bi bi-plus-circle me-2"></i> Create
    </a>
    @endif
</div>
<!-- Table Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered nowrap" style="width: 100%">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @if(hasPermission('users', 'edit') || hasPermission('users', 'delete'))
                        <td class="text-center">

                            @if(hasPermission('users', 'edit'))
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endif

                            @if(hasPermission('users', 'delete'))
                            @if($user->name != 'admin')
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger " title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                            @endif

                        </td>
                        @endif
                    </tr>
                    @endforeach
                    <!-- Additional rows -->
                </tbody>
                {{ $users->links() }}
            </table>
        </div>
    </div>
</div>

<!-- Modal (same as before, just add id="createUserForm" on form) -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createModalLabel"><i class="bi bi-person-plus me-2"></i> Add New Activity</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required />
                            <div class="invalid-feedback">Please enter name.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a role.</div>
                        </div>
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required />
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
                            <div class="invalid-feedback">Please enter a password.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" required />
                            <div class="invalid-feedback">Please confirm your password.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection