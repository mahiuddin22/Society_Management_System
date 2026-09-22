@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-units">

  {{-- 1. Filter & Actions Header --}}
  <div class="filter-bar d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <form action="" method="GET" class="d-flex align-items-center flex-wrap gap-2" autocomplete="off">
      
      <div class="search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
          <circle cx="11" cy="11" r="7" />
          <path d="m21 21-4.3-4.3" />
        </svg>
        <input class="input" name="holding_no" value="{{ request('holding_no') }}" placeholder="Search holding or road...">
      </div>

      <select class="select" name="building_type">
        <option value="">All Building Types</option>
        @foreach ($plot_types as $type)
          <option value="{{ $type->id }}" {{ request('building_type') == $type->id ? 'selected' : '' }}>
            {{ $type->name }}
          </option>
        @endforeach
      </select>

      <select class="select" name="collection_type">
        <option value="">All Collection Types</option>
        <option value="Group" {{ request('collection_type') == 'Group' ? 'selected' : '' }}>Group</option>
        <option value="Individual" {{ request('collection_type') == 'Individual' ? 'selected' : '' }}>Individual</option>
      </select>

      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-ghost">Reset</a>
    </form>

    @if (hasPermission('plot_and_units', 'create'))
    <a href="{{ route('admin.plot-and-units.create') }}" class="btn btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      Add Building
    </a>
    @endif
  </div>

  {{-- 2. Overview Metric Cards --}}
  @if($plot_types->isNotEmpty())
  <div class="grid grid-3 section-row">
    @foreach($plot_types->take(3) as $type)
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="label">{{ $type->name ?? 'Plot Type' }}</span>
        <span class="badge green">{{ $type->units_count ?? $type->plot_and_units_count ?? 0 }} units</span>
      </div>
      <div class="value">
        <span class="sym">৳</span>{{ number_format((float)($type->fees ?? $type->amount ?? 0), 2) }}
        <span class="hint" style="font-size: 11px; font-weight: normal;">/ unit</span>
      </div>
    </div>
    @endforeach
  </div>
  @endif

  {{-- 3. Register Ledger Table --}}
  <div class="card p-0 overflow-hidden">
      

    <div class="table-wrap">
      <table class="ledger text-nowrap w-100">
        <thead>
          <tr>
            <th>Holding &amp; Road</th>
            <th>Type</th>
            <th>Occupancy</th>
            <th>Resident / Contact</th>
            <th class="num">Net Fee</th>
            <th>Status</th>
            <th class="text-end pe-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($plotAndUnits as $unit)
          <tr>
            {{-- Holding & Road --}}
            <td>
              <div class="fw-medium text-dark">{{ $unit->holding_no }}</div>
              <span class="hint small">{{ 'Road - ' .  $unit->road->number ?? 'N/A' }}</span>
            </td>

            {{-- Type & Mode --}}
            <td>
              <div>{{ $unit->plotType->name ?? 'N/A' }}</div>
              <span class="hint small" style="font-size: 10px;">{{ $unit->collection_type ?? 'Standard' }}</span>
            </td>

            {{-- Flats Occupancy --}}
            <td>
              <span class="fw-medium">{{ $unit->occupied_flat ?? 0 }}</span>
              <span class="text-muted">/ {{ $unit->total_flat ?? 0 }} flats</span>
            </td>

            {{-- Resident Details --}}
            <td>
              <div class="fw-medium text-dark">{{ $unit->name ?? '—' }}</div>
              <span class="hint small">{{ $unit->phone ?? 'No phone' }}</span>
            </td>

            {{-- Financial Metric --}}
            <td class="num">
              <span class="fw-medium text-dark"> {{ number_format($unit->total_amount ?? 0) }} ৳</span>
              <div class="text-muted small" style="font-size: 10.5px;">{{ number_format($unit->collection_rate) }} ৳</div>
            </td>

            {{-- Status --}}
            <td>
              @if($unit->status == 'Active')
                <span class="badge green"><i class="dot"></i>Active</span>
              @else
                <span class="badge red"><i class="dot"></i>Inactive</span>
              @endif
            </td>

            {{-- Consolidated Actions --}}
            <td class="text-end pe-3">
              <div class="d-inline-flex align-items-center gap-1">
                @if (hasPermission('plot_and_units', 'view'))
                <a href="{{ route('admin.plot-and-units.show', $unit->id) }}" class="btn btn-ghost btn-sm px-2" title="View Details">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </a>
                @endif

                @if (hasPermission('plot_and_units', 'edit'))
                <a href="{{ route('admin.plot-and-units.edit', $unit->id) }}" class="btn btn-ghost btn-sm px-2" title="Edit Unit">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                  </svg>
                </a>
                @endif

                @if (hasPermission('plot_and_units', 'delete'))
                <form action="{{ route('admin.plot-and-units.destroy', $unit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this unit record?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-ghost btn-sm px-2 text-danger" title="Delete Unit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                  </button>
                </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              <div class="empty-note">No building or unit records found matching your query.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($plotAndUnits->hasPages())
    <div class="p-3 border-top d-flex justify-content-end">
      {{ $plotAndUnits->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
  </div>

</section>
@endsection