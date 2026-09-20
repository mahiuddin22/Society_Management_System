@extends('admin.layouts.app')
@section('content')
<section class="panel active" id="panel-units">
  <div class="filter-bar">
    <form action="" method="GET" class="d-flex align-items-center gap-2" autocomplete="off">

      <div class="search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
          <circle cx="11" cy="11" r="7" />
          <path d="m21 21-4.3-4.3" />
        </svg>

        <input class="input" name="name" value="{{ request('name') }}" placeholder="Search type name">

        <select class="select" name="filter_status">
          <option value="" disabled selected>-select status-</option>
          <option value="Active" {{ request('filter_status') == 'Active' ? 'selected' : '' }}>Active</option>
          <option value="Inactive" {{ request('filter_status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

      </div>

      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('admin.plot_type.index') }}" class="btn btn-secondary">Reset</a>

    </form>
    @if (hasPermission('plot_types', 'create'))
    <a href="{{route('admin.plot_type.create')}}" class="btn btn-primary" style="margin-left:auto;">
      + Add Plot Type
    </a>
    @endif
  </div>

  <div class="card">
    {{-- <div class="card-head">
      <h3>Type Index</h3><span class="hint">96 of 148 units shown</span>
    </div> --}}
    <div class="table-wrap">
      <table class="ledger">
        <thead>
          <tr>
            <th>Name</th>
            <th>Fee</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($plot_types as $type)
          <tr>
            <td>{{ $type->name }}</td>
            <td>{{ $type->fees }}</td>
            <td>
              @if($type->status == 'Active')
              <span class="badge green"><i class="dot"></i>Active</span>
              @else
              <span class="badge red"><i class="dot"></i>Inactive</span>
              @endif
            </td>
            <td>
              @if (hasPermission('plot_types', 'edit'))
              <a href="{{ route('admin.plot_type.edit', $type->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
              @endif
              @if (hasPermission('plot_types', 'change_status'))
              <form id="change-status-{{ $type->id }}" action="{{ route('admin.plot_type.change.status', $type->id) }}" method="POST" class="d-inline" autocomplete="off">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success btn-sm" title="Change Payment Status" onclick="changePaymentStatus()">
                  <i class="bi bi-{{ $type->status == 'Active' ? 'toggle-on' : 'toggle-off' }}"></i>
                </button>
              </form>
              @endif
              @if (hasPermission('plot_types', 'delete'))
              <form action="{{ route('admin.plot_type.destroy', $type->id) }}" method="POST" id="delete-form-{{ $type->id }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
              </form>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="12" class="text-center">No plot or unit data available.</td>
          </tr>
          @endforelse
        </tbody>
      </table>

    </div>
  </div>
</section>
@endsection