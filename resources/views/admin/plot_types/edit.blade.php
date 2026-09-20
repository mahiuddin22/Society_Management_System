@extends('admin.layouts.app')
@section('content')

<section class="panel active" id="panel-units">

    <div class="card">

        {{-- <div class="card-head">
            <h3>Edit Types</h3>
        </div> --}}

        <form action="{{ route('admin.plot_type.update', $plot_type->id) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- {{-- Name --}} -->
                <div class="col-md-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $plot_type->name }}" placeholder="e.g. 1/A" required>
                </div>

                <!-- Fee -->
                <div class="col-md-4">
                    <label for="fees" class="form-label">Fee <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fees" name="fees" value="{{ $plot_type->fees }}" placeholder="e.g. 2" required>
                </div>

                <!-- {{-- Status --}} -->
                <div class="col-md-4">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="1" {{ $plot_type->status == 'Active' ? 'selected': '' }}>Active</option>
                        <option value="0" {{ $plot_type->status == 'Inactive' ? 'selected': '' }}>Inactive</option>
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