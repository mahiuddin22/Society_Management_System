@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-units">

  {{-- Centered Responsive Container with Wider Grid Columns --}}
  <div class="row justify-content-center py-4">
    <div class="col-12 col-md-10 col-lg-8 col-xl-7">

      <div class="card p-4">

        {{-- Form Header --}}
        <div class="card-head pb-3 mb-4">
          <div>
            <h3 class="mb-1">Edit Plot Type</h3>
            <span class="hint">Update plot type name, fee, and status.</span>
          </div>
        </div>

        <form action="{{ route('admin.plot_type.update', $plot_type->id) }}" method="POST" autocomplete="off" class="d-flex flex-column gap-3">
          @csrf
          @method('PUT')

          {{-- 1. Name --}}
          <div>
            <label for="name" class="form-label fw-semibold small mb-1">
              Name <span class="text-danger">*</span>
            </label>
            <input 
              type="text" 
              class="input w-100" 
              id="name" 
              name="name" 
              value="{{ old('name', $plot_type->name) }}" 
              placeholder="e.g. Commercial, Residential..." 
              required
            >
            @error('name')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- 2. Fee --}}
          <div>
            <label for="fees" class="form-label fw-semibold small mb-1">
              Plot Fee <span class="text-danger">*</span>
            </label>
            <div class="position-relative">
              <input 
                type="number" 
                step="any" 
                class="input w-100" 
                id="fees" 
                name="fees" 
                value="{{ old('fees', $plot_type->fees) }}" 
                placeholder="0.00" 
                required
              >
            </div>
            @error('fees')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- 3. Description --}}
          <div>
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label for="description" class="form-label fw-semibold small mb-0">
                Short Description
              </label>
            </div>
            <textarea 
              class="input w-100" 
              id="description" 
              name="description" 
              rows="3" 
              placeholder="Brief 5-word description..."
            >{{ old('description', $plot_type->description ?? '') }}</textarea>
            @error('description')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- 4. Status --}}
          <div>
            <label for="status" class="form-label fw-semibold small mb-1">
              Status <span class="text-danger">*</span>
            </label>
            <select class="select w-100" id="status" name="status" required>
              <option value="Active" {{ old('status', $plot_type->status) == 'Active' || old('status', $plot_type->status) == '1' ? 'selected' : '' }}>Active</option>
              <option value="Inactive" {{ old('status', $plot_type->status) == 'Inactive' || old('status', $plot_type->status) == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- Actions Toolbar --}}
          <div class="d-flex align-items-center justify-content-end gap-2 pt-3 mt-2">
            <a href="{{ route('admin.plot_type.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary px-4">Update</button>
          </div>

        </form>

      </div>

    </div>
  </div>

</section>
@endsection