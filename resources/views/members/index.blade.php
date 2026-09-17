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
          @forelse($data as $member)
          <tr>
            <td>{{ $data->firstItem() + $loop->iteration  - 1}}</td>
            <td>{{ $member->unique_id}}</td>
            <td>{{ $member->unit_road->name}}</td>
            <td>{{ $member->holding_no }}</td>
            <td>{{ $member->plot_type->name ?? 'N/A' }}</td>
            <td>{{ $member->total_flat ?? 'N/A' }}</td>
            <td>{{ $member->occupied_flat ?? 'N/A' }}</td>
            <td>{{ $member->collection_type ?? 'N/A' }}</td>
            <td>৳{{ number_format($member->collection_rate, 2) }}</td>
            <td>৳{{ number_format($member->discount, 2) }}</td>
            <td>৳{{ number_format($member->collection_amount) }}</td>
            <td>{{ $member->name ?? 'N/A' }}</td>
            <td>{{ $member->flat_no ?? 'N/A' }}</td>
            <td>{{ $member->number ?? 'N/A' }}</td>
            <td>{{ $member->email ?? 'N/A' }}</td>
            <td>{{ $member->date }}</td>
            <td>
              @if($member->status == 1)
              <span class="badge green"><i class="dot"></i>Active</span>
              @else
              <span class="badge red"><i class="dot"></i>Expired</span>
              @endif
            </td>
            <td>
              @if($member->payment_status == 1)
              <span class="badge green"><i class="dot"></i>Paid</span>
              @else
              <span class="badge red"><i class="dot"></i>Unpaid</span>
              @endif
            </td>
            <td class="text-center">{{ $member->payment_date ?? '--' }}</td>
            <td>
              @if (hasPermission('my_payments', 'download'))
              <a href="{{ route('member.receipt', $member->id) }}" target="_blank" class="btn btn-info btn-sm" title="Money Receipt"><i class="bi bi-receipt"></i></a>
              @endif

              @if (hasPermission('my_payments', 'pay'))
              <a href="{{ route('member.pay', $member->id) }}" target="_blank" class="btn btn-info btn-sm" title="Pay bill"><i class="bi bi-wallet2"></i></a>
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