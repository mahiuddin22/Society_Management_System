@extends('admin.layouts.app')
@section('content')

<section class="panel active" id="panel-units">

    <div class="card">

        <div class="card-head">
            <h3>Edit Member</h3>
        </div>

        <form action="{{ route('admin.members.update', $data->id) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- {{-- Name --}} -->
                <div class="col-md-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" placeholder="e.g. 1/A" required>
                </div>

                <!-- {{-- Flat No --}} -->
                <div class="col-md-4">
                    <label for="flat_no" class="form-label">Flat No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="flat_no" name="flat_no" value="{{ $data->flat_no }}" placeholder="e.g. 1/A" required>
                </div>

                <!-- {{-- Number --}} -->
                <div class="col-md-4">
                    <label for="number" class="form-label">Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="number" name="number" value="{{ $data->number }}" placeholder="e.g. 1/A" required>
                </div>

                <!-- {{-- Email --}} -->
                <div class="col-md-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ $data->email }}" placeholder="e.g. 1/A" required>
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Member</button>
            </div>

        </form>

    </div>

</section>

@endsection