@extends('admin.layouts.app')

@section('content')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" style="margin-top: 20px;" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Edit Form Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.activities.update', $activity->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Activity Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $activity->name) }}" required>
                    <div class="invalid-feedback">Please enter activity name.</div>
                </div>

                <div class="col-md-6">
                    <label for="activity_key" class="form-label">Activity Key</label>
                    <input type="text" name="activity_key" id="activity_key" class="form-control" value="{{ old('activity_key', $activity->activity_key) }}" required>
                    <div class="invalid-feedback">Please enter activity key.</div>
                </div>

            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Update Activity
                </button>
            </div>
        </form>
    </div>
</div>

@endsection