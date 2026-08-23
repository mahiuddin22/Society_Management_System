@extends('admin.layouts.app')
@section('content')

<section class="panel active" id="panel-units">

    <div class="card">

        <div class="card-head">
            <h3>Edit Types</h3>
        </div>

        <form action="{{ route('admin.collection.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- {{-- Name --}} -->
                <div class="col-md-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" placeholder="e.g. 1/A" required>
                </div>

                <!-- {{-- Number --}} -->
                <div class="col-md-4">
                    <label for="number" class="form-label">Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="number" name="number" value="{{ $data->name }}" placeholder="e.g. 1/A" required>
                </div>

                <!-- {{-- Email --}} -->
                <div class="col-md-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ $data->name }}" placeholder="e.g. 1/A" required>
                </div>

                <!-- {{-- Amount --}} -->
                <div class="col-md-4">
                    <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="amount" name="amount" value="{{ $data->amount }}" placeholder="e.g. 2" required>
                </div>

                <div class="col-md-4">
                    <label for="datepicker" class="form-label">Payment Date <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="datepicker" name="payment_date" value="{{ $data->payment_date }}" placeholder="e.g. 2" required>
                </div>

                <!-- {{-- Payment Status --}} -->
                <div class="col-md-4">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="payment_status" required>
                        <option value="">Select Status</option>
                        <option value="1" {{ $data->payment_status == 1 ? 'selected': '' }}>Active</option>
                        <option value="0" {{ $data->payment_status == 0 ? 'selected': '' }}>Inactive</option>
                    </select>
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('admin.collection.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Types</button>
            </div>

        </form>

    </div>

</section>

@endsection