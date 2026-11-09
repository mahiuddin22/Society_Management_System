@extends('admin.layouts.app')

@section('content')
<section class="panel active">
  <form method="GET" action="{{ route('admin.missing-flats.index') }}" class="card p-3 mb-4">
    <div class="row g-2 align-items-end">
      <div class="col-12 col-md-4">
        <label for="search" class="form-label small fw-semibold mb-1">Holding / Building</label>
        <input id="search" name="search" value="{{ request('search') }}" class="input w-100" placeholder="Search holding or building">
      </div>
      <div class="col-12 col-md-3">
        <label for="road_id" class="form-label small fw-semibold mb-1">Road</label>
        <select id="road_id" name="road_id" class="select w-100">
          <option value="">All roads</option>
          @foreach($roads as $road)<option value="{{ $road->id }}" @selected(request('road_id') == $road->id)>Road {{ $road->number }}</option>@endforeach
        </select>
      </div>
      <div class="col-12 col-md-auto d-flex gap-2">
        <button class="btn btn-primary" type="submit">Filter</button>
        <a href="{{ route('admin.missing-flats.index') }}" class="btn btn-ghost">Clear</a>
      </div>
    </div>
  </form>

  @php
    $totalMissing = $plots->getCollection()->sum(fn ($plot) => max(0, (int)$plot->total_flat - (int)$plot->occupied_flat));
  @endphp
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
      <div class="card p-3 h-100"><span class="hint small">Plots with Missing Flats</span><strong class="fs-4 mt-1">{{ $plots->total() }}</strong></div>
    </div>
    <div class="col-12 col-md-6">
      <div class="card p-3 h-100"><span class="hint small">Missing Flats on This Page</span><strong class="fs-4 mt-1">{{ $totalMissing }}</strong></div>
    </div>
  </div>

  <div class="card p-0 overflow-hidden">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead><tr><th>Road</th><th>Holding / Building</th><th class="text-center">Total Flats</th><th class="text-center">Occupied</th><th class="text-center">Missing</th><th>Missing Unit Numbers</th><th style="min-width:220px">Important Note</th><th class="text-end">Action</th></tr></thead>
        <tbody>
          @forelse($plots as $plot)
            @php $missingCount = max(0, (int)$plot->total_flat - (int)$plot->occupied_flat); @endphp
            <tr>
              <td>Road {{ $plot->road?->number ?? '—' }}</td>
              <td><strong>{{ $plot->holding_no }}</strong>@if($plot->building_name)<div class="hint small">{{ $plot->building_name }}</div>@endif</td>
              <td class="text-center">{{ $plot->total_flat ?? 0 }}</td>
              <td class="text-center">{{ $plot->occupied_flat ?? 0 }}</td>
              <td class="text-center"><span class="badge bg-danger-subtle text-danger">{{ $missingCount }}</span></td>
              <td>
                @forelse($plot->missingFlats as $flat)
                  <span class="badge bg-light text-dark border me-1 mb-1">{{ $flat->flat_number }}</span>
                @empty
                  <span class="hint small">Not listed yet</span>
                @endforelse
              </td>
              @php $plotNote = $plot->missingFlats->first(fn ($flat) => filled($flat->note))?->note; @endphp
              <td class="small" style="white-space:pre-wrap">{{ $plotNote ?: '—' }}</td>
              <td class="text-end">
                @php $hasDetails = $plot->missingFlats->isNotEmpty(); @endphp
                <a class="btn btn-sm btn-ghost" href="{{ $hasDetails ? route('admin.missing-flats.edit', $plot) : route('admin.missing-flats.create', ['plot' => $plot->id]) }}" title="{{ $hasDetails ? 'Edit missing unit numbers and note' : 'Add missing unit numbers and note' }}" aria-label="{{ $hasDetails ? 'Edit missing unit numbers and note' : 'Add missing unit numbers and note' }}"><i class="bi {{ $hasDetails ? 'bi-pencil-square' : 'bi-plus-lg' }}"></i></a>
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="text-center py-5 hint">No missing flats found. Plot counts are calculated from total flats minus occupied flats.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($plots->hasPages())<div class="p-3">{{ $plots->links() }}</div>@endif
  </div>
</section>
@endsection
