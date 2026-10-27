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
      <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
      @endif

    </form>
    <!-- <a href="" class="btn btn-primary" style="margin-left:auto;">
      + Add Collection
    </a> -->
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Collection Index</h3><span class="hint">{{ $bills->count() }} of {{ $bills->total() }} collections shown</span>
    </div>
    <table class="ledger text-nowrap w-100">
      <thead>
        <tr>
          <th>Bill / Date</th>
          <th>Resident / Contact</th>
          <th>Road / Holding</th>
          <th>Units &amp; Rate</th>
          <th class="num">Net Due</th>
          <th>Status</th>
          @if (hasPermission('my_payments', 'pay'))
          <th class="text-end pe-3">Action</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse($bills as $bill)
        <tr>
          <!-- 1. Bill / Date -->
          <td>
            <div class="fw-bold font-monospace" style="color: var(--forest-900);">{{ $bill->bill_number }}</div>
            <span class="hint small" style="font-size: 11px;">Month: {{ \Carbon\Carbon::parse($bill->billing_month)->format('Y-M') }} &bull; Due: {{ $bill->due_date->format('d M') }}</span>
          </td>

          <!-- 2. Holding & Resident -->
          <td>
            <div class="fw-medium text-dark">{{ $bill->plotAndUnit->name ?? '—' }}</div>
            <span class="hint small">{{ $bill->plotAndUnit->phone ?? '—' }}</span>
          </td>

          <!-- 3. Type -->
          <td>
            <div>{{ $bill->plot_type_name }}</div>
            <span class="hint small">Road: {{ $bill->plotAndUnit->road->number ?? '-' }} &bull; {{ $bill->plotAndUnit->holding_no ?? '-' }}</span>
          </td>

          <!-- 4. Units & Rate -->
          <td>
            <div>{{ $bill->billing_units }} unit(s) &times; {{ number_format($bill->rate_snapshot) }}৳</div>
            @if($bill->discount_snapshot > 0)
            <div class="text-muted" style="font-size: 10px;">Disc: -৳{{ number_format($bill->discount_snapshot) }}</div>
            @endif
          </td>

          <!-- 5. Net Due -->
          <td class="num">
            <div><span class="fw-bold">{{ number_format($bill->due_balance, 2) }}</span>৳</div>
            <div class="hint" style="font-size: 10px;">Paid: {{ number_format($bill->paid_amount, 2) }}৳</div>
          </td>

          <!-- 6. Status -->
          <td>
            @if($bill->status === 'Paid')
            <span class="badge green"><i class="dot"></i>Paid</span>
            @elseif($bill->status === 'Partial')
            <span class="badge gold"><i class="dot"></i>Partial</span>
            @else
            <span class="badge red"><i class="dot"></i>Unpaid</span>
            @endif
          </td>

          <!-- 7. Action -->
          <td class="text-end pe-3">
            @if($bill->status === 'Paid')

            @if (hasPermission('my_payments', 'download'))
            <a href="{{ route('member.receipt', $bill->id) }}" target="_blank" class="btn btn-info btn-sm" title="Money Receipt"><i class="bi bi-receipt"></i> Receipt</a>
            @endif
            @else

            @if (hasPermission('my_payments', 'pay'))
            <form action="{{ route('bkash-create-payment') }}" method="get" class="d-inline-block">
              <input type="hidden" name="bill_id" value="{{ $bill->id }}">
              <button type="submit" class="btn btn-bkash" title="Pay bill">
                <img src="{{ asset('uploads/settings/bkash.svg') }}" alt="bKash" class="bkash-icon">
                <span>Pay</span>
              </button>
            </form>
            @endif

            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center py-5 text-muted">
            <div class="empty-note">No billing records found for this criteria.</div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>
@endsection