@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-units">
  <div class="filter-bar">
    <div class="search"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
        <circle cx="11" cy="11" r="7" />
        <path d="m21 21-4.3-4.3" />
      </svg><input class="input" placeholder="Search unit / holding no."></div>
    <select class="select">
      <option>All buildings</option>
      <option>Building A</option>
      <option>Building B</option>
      <option>Building C</option>
      <option>Building D</option>
    </select>
    <select class="select">
      <option>All statuses</option>
      <option>Occupied — Owner</option>
      <option>Occupied — Tenant</option>
      <option>Vacant</option>
    </select>
    <a href="{{route('admin.plot-and-units.create')}}" class="btn btn-primary" style="margin-left:auto;">
      + Add Building
    </a>
  </div>

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
            <td>{{ $plotAndUnit->building_type }}</td>
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
              <form action="{{ route('admin.plot-and-units.destroy', $plotAndUnit->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this plot or unit?')"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="12" class="text-center">No plot or unit data available.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      
    </div>
  </div>
</section>
@endsection