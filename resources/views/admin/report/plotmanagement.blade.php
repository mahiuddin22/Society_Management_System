@extends('admin.layouts.app')
@section('content')
<section class="panel active" id="panel-report">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h2 class="mb-0">Plot Management Report</h2>
    @include('admin.report.exports')
  </div>
  @include('admin.report.filters')
  <div class="card">
    <div class="card-head"><h3>Plot Management</h3><span class="hint">{{ $rows->count() }} of {{ $rows->total() }} plots shown</span></div>
    <div class="table-wrap">
      <table class="ledger text-nowrap">
        <thead><tr><th>SL</th><th>Road</th><th>Holding</th><th>Last updated</th><th>Building</th><th>Plot type</th><th>Contact</th><th>Phone</th><th>Collection</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($rows as $row)
          @php
            $holdingNumbers = collect(explode(',', (string) $row->holding_no))
                ->map(fn ($holding) => ctype_digit(trim($holding)) ? str_pad(trim($holding), 2, '0', STR_PAD_LEFT) : trim($holding))
                ->implode(', ');
          @endphp
          <tr><td>{{ $rows->firstItem() + $loop->index }}</td><td>{{ $row->road?->number }}</td><td>{{ $holdingNumbers }}</td><td>{{ $row->updated_at?->format('Y-m-d') }}</td><td>{{ $row->building_name ?: '—' }}</td><td>{{ $row->plotType?->name }}</td><td>{{ $row->name }}</td><td>{{ $row->phone }}</td><td>{{ $row->collection_type ?: '—' }}</td><td>{{ $row->status }}</td></tr>
          @empty
          <tr><td colspan="10" class="text-center">No plots found.</td></tr>
          @endforelse
        </tbody>
      </table>
      {{ $rows->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@endsection
