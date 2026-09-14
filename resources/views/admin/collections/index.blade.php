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

        <input class="input" name="member_id" value="{{ request('member_id') }}" placeholder="Search by member id">
        <input class="input" name="filter_holding_no" value="{{ request('filter_data') }}" placeholder="Search by holding number">
        <input class="input" name="filter_road" value="{{ request('filter_data') }}" placeholder="Search by road number">
        <input class="input" name="filter_data" value="{{ request('filter_data') }}" placeholder="Search by name / number / amount">

        <select class="select" name="filter_status">
          <option value="" disabled {{ request()->has('filter_status') ? '' : 'selected' }}>-select status-</option>
          <option value="0" {{ request('filter_status') == '0' ? 'selected' : '' }}>Unpaid</option>
          <option value="1" {{ request('filter_status') == '1' ? 'selected' : '' }}>Paid</option>
        </select>

      </div>

      <button type="submit" class="btn btn-primary">Filter</button>
      @if(
      request()->filled('member_id') ||
      request()->filled('filter_holding_no') ||
      request()->filled('filter_road') ||
      request()->filled('filter_data') ||
      request()->filled('filter_status')
      )
      <a href="{{ route('admin.collection.index') }}" class="btn btn-secondary">Reset</a>
      @endif

    </form>
    <!-- <a href="" class="btn btn-primary" style="margin-left:auto;">
      + Add Collection
    </a> -->
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Collection Index</h3><span class="hint">{{ $data->count() }} of {{ $data->total() }} collections shown</span>
    </div>
    <div class="table-wrap">
      <table class="ledger text-nowrap">
        <thead>
          <tr>
            <th>SL</th>
            <th>Member ID</th>
            <th>Road</th>
            <th>Holding No.</th>
            <th>Building Type</th>
            <th>Total Flat</th>
            <th>Occupied Flat</th>
            <th>Collection Type</th>
            <th>Collection Rate</th>
            <th>Discount</th>
            <th>Collection Amount</th>
            <th>Person Name</th>
            <th>Flat No</th>
            <th>Phone No</th>
            <th>Email</th>
            <th>Issue Date</th>
            <th>Status</th>
            <th>Payment Status</th>
            <th>Payment Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $collection)
          <tr>
            <td>{{ $data->firstItem() + $loop->iteration  - 1}}</td>
            <td>{{ $collection->unique_id}}</td>
            <td>{{ $collection->unit_road->name}}</td>
            <td>{{ $collection->holding_no }}</td>
            <td>{{ $collection->plot_type->name ?? 'N/A' }}</td>
            <td>{{ $collection->total_flat ?? 'N/A' }}</td>
            <td>{{ $collection->occupied_flat ?? 'N/A' }}</td>
            <td>{{ $collection->collection_type ?? 'N/A' }}</td>
            <td>৳{{ number_format($collection->collection_rate, 2) }}</td>
            <td>৳{{ number_format($collection->discount, 2) }}</td>
            <td>৳{{ number_format($collection->collection_amount) }}</td>
            <td>{{ $collection->name ?? 'N/A' }}</td>
            <td>{{ $collection->flat_no ?? 'N/A' }}</td>
            <td>{{ $collection->number ?? 'N/A' }}</td>
            <td>{{ $collection->email ?? 'N/A' }}</td>
            <td>{{ $collection->date }}</td>
            <td>
              @if($collection->status == 1)
              <span class="badge green"><i class="dot"></i>Active</span>
              @else
              <span class="badge red"><i class="dot"></i>Expired</span>
              @endif
            </td>
            <td>
              @if($collection->payment_status == 1)
              <span class="badge green"><i class="dot"></i>Paid</span>
              @else
              <span class="badge red"><i class="dot"></i>Unpaid</span>
              @endif
            </td>
            <td class="text-center">{{ $collection->payment_date ?? '--' }}</td>
            <td>
              @if (hasPermission('collections', 'download'))
              @if($collection->payment_status == 1)
              <a href="{{ route('admin.collection.receipt', $collection->id) }}" target="_blank" class="btn btn-info btn-sm" title="Money Receipt"><i class="bi bi-receipt"></i></a>
              @endif
              @endif
              @if (hasPermission('collections', 'edit'))
              <a href="{{ route('admin.collection.edit', $collection->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
              @endif
              @if (hasPermission('collections', 'change_status'))
              <form id="change-status-{{ $collection->id }}" action="{{ route('admin.collection.change.status', $collection->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success btn-sm" title="Change Payment Status" onclick="changePaymentStatus()">
                  <i class="bi bi-{{ $collection->payment_status == 1 ? 'toggle-on' : 'toggle-off' }}"></i>
                </button>
              </form>
              @endif
              @if (hasPermission('collections', 'delete'))
              <form action="{{ route('admin.collection.destroy', $collection->id) }}" method="POST" id="delete-form-{{ $collection->id }}" style="display: inline;">
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