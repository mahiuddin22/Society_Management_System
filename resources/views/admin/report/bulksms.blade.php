@extends('admin.layouts.app')
@section('content')
<section class="panel active" id="panel-report">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><h2 class="mb-0">Bulk SMS Report</h2>@include('admin.report.exports')</div>
  @include('admin.report.filters')
  <div class="card">
    <div class="card-head"><h3>SMS History</h3><span class="hint">{{ $rows->count() }} of {{ $rows->total() }} messages shown</span></div>
    <div class="table-wrap"><table class="ledger text-nowrap">
      <thead><tr><th>Sent at</th><th>Phone</th><th>Type</th><th>Language</th><th>Message</th><th>Sending method</th><th>Scheduled at</th><th>Status</th></tr></thead>
      <tbody>@forelse($rows as $row)<tr><td>{{ $row->created_at?->format('Y-m-d H:i') }}</td><td>{{ $row->phone_no }}</td><td>{{ ucfirst($row->sms_type) }}</td><td>{{ ucfirst($row->language) }}</td><td>{{ $row->sms_type==='draft' ? ($row->draftsms?->message ?? 'Draft unavailable') : $row->custom_sms }}</td><td>{{ str_replace('_',' ',ucfirst($row->sending_method)) }}</td><td>{{ $row->schedule_time ?: '—' }}</td><td>{{ ucfirst($row->status) }}</td></tr>@empty<tr><td colspan="8" class="text-center">No SMS history found for this date range.</td></tr>@endforelse</tbody>
    </table>{{ $rows->links('pagination::bootstrap-5') }}</div>
  </div>
</section>
@endsection
