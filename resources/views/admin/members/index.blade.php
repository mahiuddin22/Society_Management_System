@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-units">
  <div class="filter-bar d-flex align-items-center justify-content-between">
    <form action="" method="GET" class="d-flex align-items-center gap-2">

      <div class="search">

        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
          <circle cx="11" cy="11" r="7" />
          <path d="m21 21-4.3-4.3" />
        </svg>

        <input class="input" name="filter_data" value="{{ request('filter_data') }}" placeholder="Search by name / flat no / number / email" type="text">

      </div>

      <button type="submit" class="btn btn-primary">Filter</button>
      @if(request()->filled('filter_data'))
      <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Reset</a>
      @endif

    </form>
    @if (hasPermission('plot_and_units', 'create'))
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">+ Add Member</a>
    @endif
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Member Index</h3><span class="hint">{{ $data->count() }} of {{ $data->total() }} members shown</span>
    </div>
    <div class="table-wrap">
      <table class="ledger">
        <thead>
          <tr>
            <th>Name</th>
            <th>Flat No</th>
            <th>Number</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $member)
          <tr>
            <td>{{ $member->name ?? '--' }}</td>
            <td>{{ $member->flat_no ?? '--' }}</td>
            <td>{{ $member->number ?? '--' }}</td>
            <td>{{ $member->email ?? '--' }}</td>
            <td>
              @if (hasPermission('collections', 'download'))
              @endif
              @if (hasPermission('collections', 'edit'))
              <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
              @endif
              @if (hasPermission('collections', 'delete'))
              <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" id="delete-form-{{ $member->id }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
              </form>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="12" class="text-center">No member data available.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      {{ $data->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@endsection