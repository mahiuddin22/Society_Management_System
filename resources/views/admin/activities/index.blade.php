@extends('admin.layouts.app')

@section('content')

<!-- Filter Form -->
<form action="{{ route('admin.activities.index') }}" method="GET" class="row g-2 mb-3 mt-2">
    <div class="col-md-4">
        <input type="text" name="name" class="form-control form-control-sm" value="{{ $name }}" placeholder="Search by name" />
    </div>

    <div class="col-md-4">
        <select class="form-select form-select-sm" name="activity_key">
            <option value="">Select Activity Key</option>
            @foreach ($activitiesearch as $activity)
            <option value="{{ $activity->activity_key }}" {{ $activity->activity_key == $activity_key ? 'selected' : '' }}>{{ $activity->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 d-grid">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    </div>
</form>

<!-- Create Button under filter form -->
<div class="d-flex justify-content-end mb-3">
    @if(hasPermission('activities', 'create'))
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
                        <th>Name (Menu)</th>
                        <th>Activity Key</th>
                        @if(hasPermission('permissions', 'edit') || hasPermission('permissions', 'delete'))
                        <th class="text-center">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $activity->name }}</td>
                        <td>{{ $activity->activity_key }}</td>
                        @if(hasPermission('permissions', 'edit') || hasPermission('permissions', 'delete'))
                        <td class="text-center">

                            @if(hasPermission('activities', 'edit'))
                            <a href="{{ route('admin.activities.edit', $activity->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endif

                            @if(hasPermission('activities', 'delete'))
                            <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger " title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif

                        </td>
                        @endif
                    </tr>
                    @endforeach
                    <!-- Additional rows -->
                </tbody>
                {{ $activities->links() }}
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
            <form id="createUserForm" action="{{ route('admin.activities.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Activity name" required />
                            <div class="invalid-feedback">Please enter activity name.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="activity_key" class="form-label">Activity Key</label>
                            <input type="text" id="activity_key" name="activity_key" class="form-control" placeholder="ex: create" required />
                            <div class="invalid-feedback">Please enter an activity key.</div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Add Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection