@extends('admin.layouts.app')

@section('content')
<!-- ============ BUILDINGS & UNITS ============ -->
<section class="panel" id="panel-units">
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
    <button class="btn btn-primary" style="margin-left:auto;">+ Add Building</button>
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
    <table class="ledger">
      <thead>
        <tr>
          <th>Holding No.</th>
          <th>Building</th>
          <th>Unit</th>
          <th>Type</th>
          <th>Owner</th>
          <th class="num">Sub. Rate</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>UTS3-A-04B</td>
          <td>Building A</td>
          <td>4B</td>
          <td>Apartment</td>
          <td>Kamal Hossain</td>
          <td class="num">৳2,500</td>
          <td><span class="badge green">Occupied</span></td>
          <td><button class="btn btn-ghost btn-sm">Edit</button></td>
        </tr>
        <tr>
          <td>UTS3-A-01A</td>
          <td>Building A</td>
          <td>1A</td>
          <td>Apartment</td>
          <td>Fahmida Begum</td>
          <td class="num">৳2,500</td>
          <td><span class="badge red">Due</span></td>
          <td><button class="btn btn-ghost btn-sm">Edit</button></td>
        </tr>
        <tr>
          <td>UTS3-B-06C</td>
          <td>Building B</td>
          <td>6C</td>
          <td>Apartment</td>
          <td>Shahidul Islam</td>
          <td class="num">৳2,300</td>
          <td><span class="badge green">Occupied</span></td>
          <td><button class="btn btn-ghost btn-sm">Edit</button></td>
        </tr>
        <tr>
          <td>UTS3-D-03B</td>
          <td>Building D</td>
          <td>3B</td>
          <td>Land (Plot)</td>
          <td>Delwar Hossain</td>
          <td class="num">৳1,800</td>
          <td><span class="badge neutral">Vacant</span></td>
          <td><button class="btn btn-ghost btn-sm">Edit</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
@endsection