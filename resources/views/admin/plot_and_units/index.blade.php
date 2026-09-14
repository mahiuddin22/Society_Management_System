@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-units">
  <div class="filter-bar d-flex align-items-center justify-content-between">

    <form action="" method="GET" class="d-flex align-items-center gap-2" autocomplete="off">

      <div class="search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
          stroke="#6d7469" stroke-width="2">
          <circle cx="11" cy="11" r="7" />
          <path d="m21 21-4.3-4.3" />
        </svg>

        <input class="input" name="holding_no" value="{{ request('holding_no') }}" placeholder="Search unit / holding no.">
      </div>

      <select class="select" name="building_type">
        <option value="">-select building type-</option>
        @foreach ($plot_types as $type)
        <option value="{{ $type->id }}" {{ request('building_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
        @endforeach
      </select>

      <select class="select" name="collection_type">
        <option value="">-select collection type-</option>
        <option value="Group" {{ request('collection_type') == 'Group' ? 'selected' : '' }}>Group</option>
        <option value="Individual" {{ request('collection_type') == 'Individual' ? 'selected' : '' }}>Individual</option>
      </select>

      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-secondary">Reset</a>

    </form>

    @if (hasPermission('plot_and_units', 'create'))
    <a href="{{ route('admin.plot-and-units.create') }}" class="btn btn-primary">+ Add Building</a>
    @endif

  </div>

  <hr class="my-3">

  <div class="grid grid-3 section-row">

    @foreach($plot_types->random(min(3, $plot_types->count())) as $type)
    @php
    $unites_count = \App\Models\PlotAndUnit::where('building_type', $type->id)->count();
    @endphp
    <div class="card">
      <div class="card-head">
        <h3>{{$type->name ?? 'N/A'}}</h3><span class="badge green">{{$unites_count}}</span>
      </div>
      <div class="s hint">Collection Amount ৳{{$type->amount}}/unit</div>
    </div>
    @endforeach

  </div>

  <div class="card">
    <div class="card-head">
      <h3>Plot and Unit Index</h3><span class="hint">{{ $plotAndUnits->count() }} of {{ $plotAndUnits->total() }} plots and units shown</span>
    </div>
    <div class="table-wrap">
      <table class="ledger text-nowrap">
        <thead>
          <tr>
            <th>SL</th>
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
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($plotAndUnits as $plotAndUnit)
          <tr>
            <td>{{ $plotAndUnits->firstItem() + $loop->iteration }}</td>
            <td>{{ $plotAndUnit->unit_road->name}}</td>
            <td>{{ $plotAndUnit->holding_no }}</td>
            <td>{{ $plotAndUnit->plot_type->name ?? 'N/A' }}</td>
            <td>{{ $plotAndUnit->total_flat ?? 'N/A' }}</td>
            <td>{{ $plotAndUnit->occupied_flat ?? 'N/A' }}</td>
            <td>{{ $plotAndUnit->collection_type ?? 'N/A' }}</td>
            <td>৳{{ number_format($plotAndUnit->collection_rate, 2) }}</td>
            <td>৳{{ number_format($plotAndUnit->discount, 2) }}</td>
            <td>৳{{ number_format($plotAndUnit->collection_amount) }}</td>
            <td>{{ $plotAndUnit->name ?? 'N/A' }}</td>
            <td>{{ $plotAndUnit->flat_no ?? 'N/A' }}</td>
            <td>{{ $plotAndUnit->number ?? 'N/A' }}</td>
            <td>{{ $plotAndUnit->email ?? 'N/A' }}</td>
            <td>{{ $plotAndUnit->date }}</td>
            <td>
              @if($plotAndUnit->status == 1)
              <span class="badge green"><i class="dot"></i>Active</span>
              @else
              <span class="badge red"><i class="dot"></i>Expired</span>
              @endif
            </td>
            <td class="text-center">
              @if (hasPermission('plot_and_units', 'view'))
              <a href="{{ route('admin.plot-and-units.view', $plotAndUnit->id) }}" target="__blank" class="btn btn-info btn-sm" title="View"><i class="bi bi-eye"></i></a>
              @endif
              @if (hasPermission('plot_and_units', 'edit'))
              <a href="{{ route('admin.plot-and-units.edit', $plotAndUnit->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
              @endif
              @if (hasPermission('plot_and_units', 'delete'))
              <form action="{{ route('admin.plot-and-units.destroy', $plotAndUnit->id) }}" method="POST" id="delete-form-{{ $plotAndUnit->id }}" style="display: inline;">
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
      {{ $plotAndUnits->links('pagination::bootstrap-5') }}

    </div>
  </div>
</section>
@endsection