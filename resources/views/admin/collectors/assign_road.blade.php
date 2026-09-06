@extends('admin.layouts.app')

@section('content')
<style>
    .road-option {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        min-height: 70px;
        padding: 14px 16px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .road-option:hover {
        border-color: #86b7fe;
        background-color: #f8fbff;
    }

    .road-checkbox {
        width: 24px;
        height: 24px;
        margin: 0;
        cursor: pointer;
        flex-shrink: 0;
    }

    .road-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f1f3f5;
        color: #495057;
        font-size: 20px;
        flex-shrink: 0;
    }

    .road-name {
        font-size: 18px;
        font-weight: 500;
        color: #212529;
    }

    .road-option:has(.road-checkbox:checked) {
        border-color: #0dcaf0;
        background-color: #f0f6ff;
    }

    .road-option:has(.road-checkbox:checked) .road-icon {
        background-color: #0dcaf0;
        color: #fff;
    }

    .road-option:has(.road-checkbox:checked) .road-name {
        color: #0dcaf0;
        font-weight: 600;
    }
</style>
<div class="card shadow-sm border-0">
    <div class="card-header bg-white p-3 p-md-4">
        <h5 class="mb-1 fw-semibold">Assign Roads to Collector</h5>
        <small class="text-muted">
            Select the roads assigned to {{ $collector->name }}
        </small>
    </div>


    <div class="card-body p-3 p-md-4">

        <form action="{{ route('admin.collectors.update.road', $collector->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                @foreach($roads as $road)
                <div class="col-md-6 col-lg-4">
                    <label for="road{{ $road->id }}" class="road-option">

                        <input class="form-check-input road-checkbox" type="checkbox" name="roads[]" value="{{ $road->id }}"
                            id="road{{ $road->id }}" {{ $road->collector_id == $collector->id ? 'checked' : '' }}>

                        <span class="road-icon">
                            <i class="bi bi-signpost-2"></i>
                        </span>

                        <span class="road-name">
                            {{ $road->name }}
                        </span>

                    </label>
                </div>
                @endforeach

            </div>

            <div class="border-top mt-4 pt-4 d-flex justify-content-end gap-1">
                <a href="{{ route('admin.collectors.index') }}" class="btn btn-secondary ms-2 px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Assign Roads</button>
            </div>

        </form>

    </div>


</div>

@endsection