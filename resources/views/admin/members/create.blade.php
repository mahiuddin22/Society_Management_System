@extends('admin.layouts.app')
@section('content')

<section class="panel active" id="panel-units">

    <div class="card">

        <div class="card-head">
            <h3>Add Members</h3>
        </div>

        <form action="{{ route('admin.members.store') }}" method="POST" autocomplete="off">
            @csrf

            <div class="row g-3">

                <!-- {{-- Name --}} -->
                <div class="col-md-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. John Doe" required>
                </div>

                <!-- {{-- Flat No --}} -->
                <div class="col-md-4">
                    <label for="flat_no" class="form-label">Flat No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="flat_no" name="flat_no" value="{{ old('flat_no') }}" placeholder="e.g. 1/A" required>
                </div>

                <!-- {{-- Number --}} -->
                <div class="col-md-4">
                    <label for="number" class="form-label">Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="number" name="number" value="{{ old('number') }}" placeholder="e.g. 1234567890" required>
                </div>

                <!-- {{-- Email --}} -->
                <div class="col-md-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. john.doe@example.com" required>
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Members</button>
            </div>

        </form>

    </div>

</section>

@endsection