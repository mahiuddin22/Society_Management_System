@extends('admin.layouts.app')
@section('content')

<section class="panel active" id="panel-units">

    <div class="card">

        {{-- <div class="card-head">
            <h3>Add Types</h3>
        </div> --}}

        <form action="{{ route('admin.plot_type.store') }}" method="POST" autocomplete="off">
            @csrf

            <div class="row g-3">

                <!-- {{-- Name --}} -->
                <div class="col-md-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('road') }}" placeholder="" required>
                </div>

                <!-- Fees -->
                <div class="col-md-4">
                    <label for="fees" class="form-label">Fee <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fees" name="fees" value="{{ old('holding_no') }}" placeholder="" required>
                </div>

                <!-- {{-- Status --}} -->
                <div class="col-md-4">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('admin.plot_type.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Types</button>
            </div>

        </form>

    </div>

</section>

@endsection