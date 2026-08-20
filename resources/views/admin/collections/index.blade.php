@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-units">
  <div class="filter-bar">
    <form action="" method="GET" class="d-flex align-items-center gap-2">

      <div class="search">

        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
          <circle cx="11" cy="11" r="7" />
          <path d="m21 21-4.3-4.3" />
        </svg>

        <input class="input" name="filter_holding_no" value="{{ request('filter_data') }}" placeholder="Search by holding number">
        <input class="input" name="filter_road" value="{{ request('filter_data') }}" placeholder="Search road number">
        <input class="input" name="filter_data" value="{{ request('filter_data') }}" placeholder="Search name / number / amount">

        <select class="select" name="filter_status">
          <option value="" disabled {{ request()->has('filter_status') ? '' : 'selected' }}>-select status-</option>
          <option value="0" {{ request('filter_status') == '0' ? 'selected' : '' }}>Unpaid</option>
          <option value="1" {{ request('filter_status') == '1' ? 'selected' : '' }}>Paid</option>
        </select>

      </div>

      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('admin.collection.index') }}" class="btn btn-secondary">Reset</a>

    </form>
    <!-- <a href="" class="btn btn-primary" style="margin-left:auto;">
      + Add Collection
    </a> -->
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Type Index</h3><span class="hint">96 of 148 units shown</span>
    </div>
    <div class="table-wrap">
      <table class="ledger">
        <thead>
          <tr>
            <th>Member ID</th>
            <th>Road No</th>
            <th>Holding No</th>
            <th>Name</th>
            <th>Number</th>
            <th>Email</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $member)
          <tr>
            <td>{{ $member->unique_id }}</td>
            <td>{{ $member->road }}</td>
            <td>{{ $member->holding_no }}</td>
            <td>{{ $member->name }}</td>
            <td>{{ $member->number }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->amount }}</td>
            <td>
              @if($member->payment_status == 1)
              <span class="badge green"><i class="dot"></i>Paid</span>
              @else
              <span class="badge red"><i class="dot"></i>Unpaid</span>
              @endif
            </td>
            <td>
              @if (hasPermission('collections', 'download'))
              @if($member->payment_status == 1)
              <a href="{{ route('admin.collection.receipt', $member->id) }}" target="_blank" class="btn btn-info btn-sm" title="Money Receipt"><i class="bi bi-receipt"></i></a>
              @endif
              @endif
              @if (hasPermission('collections', 'edit'))
              <a href="{{ route('admin.collection.edit', $member->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
              @endif
              @if (hasPermission('collections', 'change_status'))
              <form id="change-status-{{ $member->id }}" action="{{ route('admin.collection.change.status', $member->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success btn-sm" title="Change Payment Status" onclick="changePaymentStatus()">
                  <i class="bi bi-{{ $member->payment_status == 1 ? 'toggle-on' : 'toggle-off' }}"></i>
                </button>
              </form>
              @endif
              @if (hasPermission('collections', 'delete'))
              <form action="{{ route('admin.collection.destroy', $member->id) }}" method="POST" id="delete-form-{{ $member->id }}" style="display: inline;">
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
      {{ $data->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@endsection