@extends('admin.layouts.app')
@section('content')
<section class="panel active" id="panel-dashboard">
  @php
    $money = fn ($value) => number_format((float) $value, 0);
    $maxValue = max(1, (float) $chartMonths->max(fn ($item) => max($item['billed'], $item['collected'])));
    $circumference = 502.65;
    $paidRatio = $monthBilled > 0 ? min(1, $monthPaid / $monthBilled) : 0;
    $paidPercent = round($paidRatio * 100);
  @endphp
  <div class="section-row grid grid-5">
    <div class="stat-card"><div class="label">Today's Collections</div><div class="value"><span class="sym">৳</span>{{ $money($stats['today_collected']) }}</div><div class="delta">Payments recorded today</div></div>
    <div class="stat-card"><div class="label">This Month Collected</div><div class="value"><span class="sym">৳</span>{{ $money($stats['month_collected']) }}</div><div class="delta">Payments recorded this month</div></div>
    <div class="stat-card due"><div class="label">Outstanding Dues</div><div class="value"><span class="sym">৳</span>{{ $money($stats['outstanding']) }}</div><div class="delta">{{ number_format($stats['unpaid_bills']) }} bills with a balance</div></div>
    <div class="stat-card gold"><div class="label">Active Plots / Units</div><div class="value">{{ number_format($stats['active_plots']) }}</div><div class="delta">Currently active records</div></div>
    <div class="stat-card"><div class="label">Bills This Month</div><div class="value">{{ number_format($monthBillCount) }}</div><div class="delta">Billed ৳{{ $money($monthBilled) }}</div></div>
  </div>

  <div class="section-row grid grid-2">
    <div class="card">
      <div class="card-head"><h3>Billing &amp; Collection Trend</h3><span class="hint">Last six months</span></div>
      <div class="table-wrap">
        <svg viewBox="0 0 640 220" width="100%" height="220" role="img" aria-label="Monthly billed and collected amounts">
          <g stroke="#ddd6c2"><line x1="35" y1="20" x2="630" y2="20"/><line x1="35" y1="95" x2="630" y2="95"/><line x1="35" y1="170" x2="630" y2="170"/></g>
          <g font-family="IBM Plex Mono" font-size="9" fill="#6d7469"><text x="2" y="174">৳0</text><text x="2" y="99">৳{{ $money($maxValue / 2) }}</text><text x="2" y="24">৳{{ $money($maxValue) }}</text></g>
          @foreach($chartMonths as $index => $item)
            @php $x = 59 + ($index * 96); $billedHeight = ($item['billed'] / $maxValue) * 150; $collectedHeight = ($item['collected'] / $maxValue) * 150; @endphp
            <rect x="{{ $x }}" y="{{ 170 - $billedHeight }}" width="25" height="{{ $billedHeight }}" rx="2" fill="#b8392c"><title>{{ $item['label'] }} bills: ৳{{ $money($item['billed']) }}</title></rect>
            <rect x="{{ $x + 31 }}" y="{{ 170 - $collectedHeight }}" width="25" height="{{ $collectedHeight }}" rx="2" fill="#2b6242"><title>{{ $item['label'] }} collections: ৳{{ $money($item['collected']) }}</title></rect>
            <text x="{{ $x + 28 }}" y="192" text-anchor="middle" font-family="IBM Plex Mono" font-size="10" fill="#6d7469">{{ $item['label'] }}</text>
          @endforeach
        </svg>
      </div>
      <div class="legend"><span><i style="background:#b8392c"></i> Bills raised</span><span><i style="background:#2b6242"></i> Payments received</span></div>
    </div>
    <div class="card">
      <div class="card-head"><h3>This Month: Paid vs Due</h3><span class="hint">{{ now()->format('F Y') }}</span></div>
      <svg viewBox="0 0 220 220" width="100%" height="220" role="img" aria-label="{{ $paidPercent }} percent of this month's bills collected">
        <g transform="translate(110,110)">
          <circle r="80" fill="none" stroke="#b8392c" stroke-width="24"/>
          <circle r="80" fill="none" stroke="#2b6242" stroke-width="24" stroke-dasharray="{{ $circumference * $paidRatio }} {{ $circumference * (1 - $paidRatio) }}" transform="rotate(-90)"/>
          <text text-anchor="middle" y="-2" font-family="IBM Plex Mono" font-size="21" font-weight="600" fill="#20241e">{{ $paidPercent }}%</text>
          <text text-anchor="middle" y="16" font-family="Inter" font-size="10.5" fill="#6d7469">collected</text>
        </g>
      </svg>
      <div class="legend"><span><i style="background:#2b6242"></i> Paid — ৳{{ $money($monthPaid) }}</span><span><i style="background:#b8392c"></i> Due — ৳{{ $money($monthDue) }}</span></div>
    </div>
  </div>

  <div class="section-row row row-cols-1 row-cols-xl-3 g-3">
    <div class="col"><div class="card h-100">
      <div class="card-head"><h3>Recent Bills</h3><a href="{{ route('admin.bills.index') }}" class="btn btn-ghost btn-sm">View all →</a></div>
      <div class="table-wrap"><table class="ledger text-nowrap w-100"><thead><tr><th>Bill / Holding</th><th>Month</th><th class="num">Amount</th><th>Status</th></tr></thead><tbody>
        @forelse($recentBills as $bill)<tr>
          <td><div>{{ $bill->bill_number }}</div><span class="hint small">Holding {{ $bill->plotAndUnit->holding_no ?? '—' }} · Road {{ $bill->plotAndUnit->road->number ?? '—' }}</span></td>
          <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $bill->billing_month)->format('M Y') }}</td><td class="num">৳{{ $money($bill->net_amount) }}</td>
          <td><span class="badge {{ $bill->status === 'Paid' ? 'green' : ($bill->status === 'Partial' ? 'gold' : 'red') }}"><i class="dot"></i>{{ $bill->status }}</span></td>
        </tr>@empty<tr><td colspan="4" class="text-center hint py-3">No bills recorded yet.</td></tr>@endforelse
      </tbody></table></div>
    </div></div>

    <div class="col"><div class="card h-100">
      <div class="card-head"><h3>Recent Collections</h3><a href="{{ route('admin.payments.index') }}" class="btn btn-ghost btn-sm">View all →</a></div>
      <div class="table-wrap"><table class="ledger text-nowrap w-100"><thead><tr><th>Date / Receipt</th><th>Resident / Holding</th><th>Method</th><th class="num">Amount</th></tr></thead><tbody>
        @forelse($recentCollections as $payment)<tr>
          <td><div>{{ $payment->payment_date->format('d M Y') }}</div><span class="hint small">{{ $payment->payment_number }}</span></td>
          <td><div>{{ $payment->bill->plotAndUnit->name ?? '—' }}</div><span class="hint small">Holding {{ $payment->bill->plotAndUnit->holding_no ?? '—' }}</span></td><td>{{ $payment->method }}</td><td class="num">৳{{ $money($payment->amount) }}</td>
        </tr>@empty<tr><td colspan="4" class="text-center hint py-3">No collections recorded yet.</td></tr>@endforelse
      </tbody></table></div>
    </div></div>

    <div class="col"><div class="card h-100">
      <div class="card-head"><h3>Active Plots / Units</h3><a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-ghost btn-sm">View all →</a></div>
      <div class="table-wrap"><table class="ledger text-nowrap w-100"><thead><tr><th>Holding / Road</th><th>Resident</th><th>Type</th><th>Status</th></tr></thead><tbody>
        @forelse($recentPlots as $plot)<tr>
          <td><a href="{{ route('admin.plot-and-units.show', $plot->id) }}">Holding {{ $plot->holding_no }}</a><div class="hint small">Road {{ $plot->road->number ?? '—' }}</div></td><td>{{ $plot->name }}</td><td>{{ $plot->plotType->name ?? '—' }}</td><td><span class="badge green"><i class="dot"></i>{{ $plot->status }}</span></td>
        </tr>@empty<tr><td colspan="4" class="text-center hint py-3">No active plots or units found.</td></tr>@endforelse
      </tbody></table></div>
    </div></div>
  </div>
</section>
@endsection
