@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-units">
  <div class="filter-bar d-flex align-items-center justify-content-between">

    <form action="" method="GET" class="d-flex align-items-center gap-2">

      <div class="search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
          stroke="#6d7469" stroke-width="2"><circle cx="11" cy="11" r="7" /><path d="m21 21-4.3-4.3" />
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

    <a href="{{ route('admin.plot-and-units.create') }}" class="btn btn-primary">+ Add Building</a>

  </div>

  <hr class="my-3">

  <div class="grid grid-3 section-row">
    <div class="card">
      <div class="card-head">
        <h3>Building A</h3><span class="badge green">32 units</span>
      </div>
      <div class="s hint">Holding no. UTS3-A · Subscription ৳2,500/unit</div>
    </div>
    <div class="card">
      <div class="card-head">
        <h3>Building B</h3><span class="badge green">28 units</span>
      </div>
      <div class="s hint">Holding no. UTS3-B · Subscription ৳2,300/unit</div>
    </div>
    <div class="card">
      <div class="card-head">
        <h3>Building C</h3><span class="badge green">36 units</span>
      </div>
      <div class="s hint">Holding no. UTS3-C · Subscription ৳2,500/unit</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Unit Register</h3><span class="hint">96 of 148 units shown</span>
    </div>
    <div class="table-wrap">
      <table class="ledger">
        <thead>
          <tr>
            <th>SL</th>
            <th>Road</th>
            <th>Holding No.</th>
            <th>Building Type</th>
            <th>Total Flat</th>
            <th>Occupied Flat</th>
            <th>Collection Type</th>
            <th>Contact person</th>
            <th>Collection Rate</th>
            <th>Discount</th>
            <th>Collection Amount</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($plotAndUnits as $plotAndUnit)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $plotAndUnit->road }}</td>
            <td>{{ $plotAndUnit->holding_no }}</td>
            <td>{{ $plotAndUnit->plot_type->name }}</td>
            <td>{{ $plotAndUnit->total_flat }}</td>
            <td>{{ $plotAndUnit->occupied_flat }}</td>
            <td>{{ $plotAndUnit->collection_type }}</td>
            <td>{{ $plotAndUnit->contact_person }}</td>
            <td>৳{{ number_format($plotAndUnit->collection_rate, 2) }}</td>
            <td>৳{{ number_format($plotAndUnit->discount, 2) }}</td>
            <td>৳{{ number_format($plotAndUnit->collection_amount, 2) }}</td>
            <td>
              <a href="{{ route('admin.plot-and-units.view', $plotAndUnit->id) }}" target="__blank" class="btn btn-info btn-sm" title="View"><i class="bi bi-eye"></i></a>
              <a href="{{ route('admin.plot-and-units.edit', $plotAndUnit->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('admin.plot-and-units.destroy', $plotAndUnit->id) }}" method="POST" id="delete-form" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="12" class="text-center">No plot or unit data available.</td>
          </tr>
          @endforelse
        </tbody>
        {{ $plotAndUnits->links('pagination::bootstrap-5') }}
      </table>

    </div>
  </div>
</section>
@endsection