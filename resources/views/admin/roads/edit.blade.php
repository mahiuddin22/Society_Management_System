@extends('admin.layouts.app')

@section('content')

<!-- Edit Form Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.roads.update', $road->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" value="{{ $road->name }}" required />
                    <div class="invalid-feedback">Please enter name.</div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.roads.index') }}" class="btn btn-secondary">
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