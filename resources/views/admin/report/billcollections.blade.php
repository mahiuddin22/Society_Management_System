@extends('admin.layouts.app')
@section('content')
<section class="panel active" id="panel-report">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><h2 class="mb-0">Bill Collections Report</h2>@include('admin.report.exports')</div>
  @include('admin.report.filters')
  <div class="card">
    <div class="card-head"><h3>Bill Collections</h3><span class="hint">{{ $rows->count() }} of {{ $rows->total() }} payments shown · Total collected: ৳{{ number_format($total, 2) }}</span></div>
    <div class="table-wrap"><table class="ledger text-nowrap">
      <thead><tr><th>Date</th><th>Receipt</th><th>Holding</th><th>Resident</th><th>Road</th><th>Method</th><th>Transaction</th><th>Collector</th><th>Amount</th></tr></thead>
      <tbody>@forelse($rows as $row)<tr><td>{{ $row->payment_date?->format('Y-m-d') }}</td><td>{{ $row->payment_number }}</td><td>{{ $row->bill?->plotAndUnit?->holding_no }}</td><td>{{ $row->bill?->plotAndUnit?->name }}</td><td>{{ $row->bill?->plotAndUnit?->road?->number }}</td><td>{{ $row->method }}</td><td>{{ $row->transaction_ref ?: '—' }}</td><td>{{ $row->collector?->name ?: '—' }}</td><td>৳{{ number_format($row->amount,2) }}</td></tr>@empty<tr><td colspan="9" class="text-center">No payments found for this date range.</td></tr>@endforelse</tbody>
    </table>{{ $rows->links('pagination::bootstrap-5') }}</div>
  </div>
</section>
@endsection
