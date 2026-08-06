@extends('admin.layouts.app')

@section('content')
<!-- ============ DASHBOARD ============ -->
<section class="panel active" id="panel-dashboard">

  <div class="section-row grid grid-5">
    <div class="stat-card">
      <div class="label">Today's Collection</div>
      <div class="value"><span class="sym">৳</span>18,400</div>
      <div class="delta up">▲ 12% vs yesterday</div>
    </div>
    <div class="stat-card">
      <div class="label">This Month Collection</div>
      <div class="value"><span class="sym">৳</span>3,42,600</div>
      <div class="delta up">▲ 8% vs last month</div>
    </div>
    <div class="stat-card due">
      <div class="label">Outstanding Dues</div>
      <div class="value"><span class="sym">৳</span>1,86,200</div>
      <div class="delta down">▼ 41 units pending</div>
    </div>
    <div class="stat-card gold">
      <div class="label">Life Members</div>
      <div class="value">248</div>
      <div class="delta up">▲ 3 new this month</div>
    </div>
    <div class="stat-card">
      <div class="label">Open Complaints</div>
      <div class="value">4</div>
      <div class="delta down">2 overdue &gt; 5 days</div>
    </div>
  </div>

  <div class="section-row grid grid-2">
    <div class="card">
      <div class="card-head">
        <h3>Collection Trend — 1 Jul to 23 Jul</h3>
        <span class="hint">Daily paid vs. due</span>
      </div>
      <svg viewBox="0 0 640 220" width="100%" height="220">
        <!-- gridlines -->
        <g stroke="#ddd6c2" stroke-width="1">
          <line x1="30" y1="10" x2="30" y2="180" />
          <line x1="30" y1="180" x2="630" y2="180" />
        </g>
        <g font-family="IBM Plex Mono" font-size="9" fill="#6d7469">
          <text x="4" y="184">0</text>
          <text x="0" y="100">10k</text>
          <text x="0" y="16">20k</text>
        </g>
        <!-- bars: paid (forest) stacked with due (brick), filled in by script.js -->
        <g id="trendBars"></g>
      </svg>
      <div class="legend">
        <span><i style="background:#2b6242"></i> Collected</span>
        <span><i style="background:#b8392c"></i> Due raised</span>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3>Due vs Paid</h3>
        <span class="hint">This month, all buildings</span>
      </div>
      <svg viewBox="0 0 220 220" width="100%" height="220" style="display:block;margin:0 auto;">
        <g transform="translate(110,110)">
          <circle r="80" fill="none" stroke="#f1eee1" stroke-width="24" />
          <circle r="80" fill="none" stroke="#2b6242" stroke-width="24"
            stroke-dasharray="376.99" stroke-dashoffset="94.2" transform="rotate(-90)" />
          <circle r="80" fill="none" stroke="#b8392c" stroke-width="24"
            stroke-dasharray="376.99" stroke-dashoffset="282.7" transform="rotate(174.6)" />
          <text text-anchor="middle" y="-2" font-family="IBM Plex Mono" font-size="21" font-weight="600" fill="#20241e">75%</text>
          <text text-anchor="middle" y="16" font-family="Inter" font-size="10.5" fill="#6d7469">collected</text>
        </g>
      </svg>
      <div class="legend">
        <span><i style="background:#2b6242"></i> Paid — ৳3,42,600</span>
        <span><i style="background:#b8392c"></i> Due — ৳1,14,000</span>
      </div>
    </div>
  </div>

  <div class="section-row grid grid-2">
    <div class="card">
      <div class="card-head">
        <h3>Recent Ledger Entries</h3>
        <a href="#" class="btn btn-ghost btn-sm" onclick="go('payments');return false;">View all →</a>
      </div>
      <div class="table-wrap">
        <table class="ledger">
          <thead>
            <tr>
              <th>Date</th>
              <th>Unit</th>
              <th>Owner</th>
              <th>Type</th>
              <th>Method</th>
              <th>Collector</th>
              <th class="num">Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="num">23 Jul</td>
              <td>B‑A / 4B</td>
              <td>Kamal Hossain</td>
              <td>Subscription</td>
              <td>bKash</td>
              <td>Md. Anwar</td>
              <td class="num">৳2,500</td>
              <td><span class="badge green"><i class="dot"></i>Paid</span></td>
            </tr>
            <tr>
              <td class="num">23 Jul</td>
              <td>B‑C / 2A</td>
              <td>Nasrin Akter</td>
              <td>Picnic Fee</td>
              <td>Cash</td>
              <td>Md. Anwar</td>
              <td class="num">৳1,200</td>
              <td><span class="badge green"><i class="dot"></i>Paid</span></td>
            </tr>
            <tr>
              <td class="num">22 Jul</td>
              <td>B‑B / 6C</td>
              <td>Shahidul Islam</td>
              <td>Subscription</td>
              <td>Bank</td>
              <td>—</td>
              <td class="num">৳2,500</td>
              <td><span class="badge green"><i class="dot"></i>Paid</span></td>
            </tr>
            <tr>
              <td class="num">22 Jul</td>
              <td>B‑A / 1A</td>
              <td>Fahmida Begum</td>
              <td>Subscription</td>
              <td>—</td>
              <td>—</td>
              <td class="num">৳2,500</td>
              <td><span class="badge red"><i class="dot"></i>Due</span></td>
            </tr>
            <tr>
              <td class="num">21 Jul</td>
              <td>B‑D / 3B</td>
              <td>Delwar Hossain</td>
              <td>Late Fee</td>
              <td>Cash</td>
              <td>Sumon Mia</td>
              <td class="num">৳150</td>
              <td><span class="badge green"><i class="dot"></i>Paid</span></td>
            </tr>
            <tr>
              <td class="num">21 Jul</td>
              <td>B‑C / 5A</td>
              <td>Ruma Chowdhury</td>
              <td>Subscription</td>
              <td>Nagad</td>
              <td>Sumon Mia</td>
              <td class="num">৳2,200</td>
              <td><span class="badge gold"><i class="dot"></i>Partial</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div style="display:flex; flex-direction:column; gap:18px;">
      <div class="card">
        <div class="card-head">
          <h3>Upcoming Events</h3><span class="hint">Life member notified</span>
        </div>
        <div class="list-item">
          <div class="list-date">
            <div class="d">02</div>
            <div class="m">Aug</div>
          </div>
          <div class="list-body">
            <div class="t">Free Medical Camp</div>
            <div class="s">Community Hall · 9:00 AM</div>
          </div>
        </div>
        <div class="list-item">
          <div class="list-date">
            <div class="d">10</div>
            <div class="m">Aug</div>
          </div>
          <div class="list-body">
            <div class="t">Annual Picnic — Bandarban</div>
            <div class="s">Paid event · ৳1,200 / member</div>
          </div>
        </div>
        <div class="list-item">
          <div class="list-date">
            <div class="d">15</div>
            <div class="m">Aug</div>
          </div>
          <div class="list-body">
            <div class="t">General Committee Meeting</div>
            <div class="s">Society Office · 7:30 PM</div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-head">
          <h3>Recent Notices</h3>
        </div>
        <div class="list-item">
          <div class="list-body">
            <div class="t">Water line maintenance — 25 Jul</div>
            <div class="s">Building C, 10 AM–1 PM</div>
          </div>
        </div>
        <div class="list-item">
          <div class="list-body">
            <div class="t">Subscription due reminder — July</div>
            <div class="s">Sent to 41 units</div>
          </div>
        </div>
        <div class="list-item">
          <div class="list-body">
            <div class="t">New collector assigned — Building D</div>
            <div class="s">Sumon Mia, effective 20 Jul</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section-row grid grid-2-even">
    <div class="card">
      <div class="card-head">
        <h3>Collector Performance</h3><span class="hint">This month</span>
      </div>
      <table class="ledger">
        <thead>
          <tr>
            <th>Collector</th>
            <th>Area</th>
            <th class="num">Collected</th>
            <th class="num">Submitted</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><span class="avatar-sm">MA</span>Md. Anwar</td>
            <td>Building A, B</td>
            <td class="num">৳1,42,000</td>
            <td class="num">৳1,42,000</td>
            <td><span class="badge green">Reconciled</span></td>
          </tr>
          <tr>
            <td><span class="avatar-sm">SM</span>Sumon Mia</td>
            <td>Building C, D</td>
            <td class="num">৳98,600</td>
            <td class="num">৳91,000</td>
            <td><span class="badge gold">Pending drop</span></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card">
      <div class="card-head">
        <h3>Complaints Snapshot</h3>
      </div>
      <div style="display:flex; gap:12px;">
        <div style="flex:1; text-align:center; padding:12px 0; background:var(--brick-50); border-radius:10px;">
          <div style="font-family:var(--font-ledger); font-size:22px; font-weight:600; color:var(--brick-700);">2</div>
          <div style="font-size:11px; color:var(--ink-500);">Open</div>
        </div>
        <div style="flex:1; text-align:center; padding:12px 0; background:var(--gold-100); border-radius:10px;">
          <div style="font-family:var(--font-ledger); font-size:22px; font-weight:600; color:var(--gold-600);">2</div>
          <div style="font-size:11px; color:var(--ink-500);">In Progress</div>
        </div>
        <div style="flex:1; text-align:center; padding:12px 0; background:var(--forest-100); border-radius:10px;">
          <div style="font-family:var(--font-ledger); font-size:22px; font-weight:600; color:var(--forest-700);">11</div>
          <div style="font-size:11px; color:var(--ink-500);">Resolved</div>
        </div>
      </div>
    </div>
  </div>
</section>

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
      <div class="s hint">Holding no. UTS3‑A · Subscription ৳2,500/unit</div>
    </div>
    <div class="card">
      <div class="card-head">
        <h3>Building B</h3><span class="badge green">28 units</span>
      </div>
      <div class="s hint">Holding no. UTS3‑B · Subscription ৳2,300/unit</div>
    </div>
    <div class="card">
      <div class="card-head">
        <h3>Building C</h3><span class="badge green">36 units</span>
      </div>
      <div class="s hint">Holding no. UTS3‑C · Subscription ৳2,500/unit</div>
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
          <td>UTS3‑A‑04B</td>
          <td>Building A</td>
          <td>4B</td>
          <td>Apartment</td>
          <td>Kamal Hossain</td>
          <td class="num">৳2,500</td>
          <td><span class="badge green">Occupied</span></td>
          <td><button class="btn btn-ghost btn-sm">Edit</button></td>
        </tr>
        <tr>
          <td>UTS3‑A‑01A</td>
          <td>Building A</td>
          <td>1A</td>
          <td>Apartment</td>
          <td>Fahmida Begum</td>
          <td class="num">৳2,500</td>
          <td><span class="badge red">Due</span></td>
          <td><button class="btn btn-ghost btn-sm">Edit</button></td>
        </tr>
        <tr>
          <td>UTS3‑B‑06C</td>
          <td>Building B</td>
          <td>6C</td>
          <td>Apartment</td>
          <td>Shahidul Islam</td>
          <td class="num">৳2,300</td>
          <td><span class="badge green">Occupied</span></td>
          <td><button class="btn btn-ghost btn-sm">Edit</button></td>
        </tr>
        <tr>
          <td>UTS3‑D‑03B</td>
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

<!-- ============ OWNERS ============ -->
<section class="panel" id="panel-owners">
  <div class="filter-bar">
    <div class="search"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
        <circle cx="11" cy="11" r="7" />
        <path d="m21 21-4.3-4.3" />
      </svg><input class="input" placeholder="Search owner by name / phone"></div>
    <select class="select">
      <option>All buildings</option>
    </select>
    <button class="btn btn-primary" style="margin-left:auto;">+ Register Owner</button>
  </div>
  <div class="card">
    <table class="ledger">
      <thead>
        <tr>
          <th>Owner</th>
          <th>Units Owned</th>
          <th>Contact</th>
          <th>Documents</th>
          <th>Life Member</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><span class="avatar-sm">KH</span>Kamal Hossain</td>
          <td>A‑04B</td>
          <td>01711‑223344</td>
          <td><span class="badge neutral">3 files</span></td>
          <td><span class="badge gold">Yes</span></td>
          <td><span class="badge green">Active</span></td>
          <td><button class="btn btn-ghost btn-sm">View</button></td>
        </tr>
        <tr>
          <td><span class="avatar-sm">FB</span>Fahmida Begum</td>
          <td>A‑01A</td>
          <td>01822‑556677</td>
          <td><span class="badge neutral">2 files</span></td>
          <td><span class="badge neutral">No</span></td>
          <td><span class="badge green">Active</span></td>
          <td><button class="btn btn-ghost btn-sm">View</button></td>
        </tr>
        <tr>
          <td><span class="avatar-sm">SI</span>Shahidul Islam</td>
          <td>B‑06C, B‑07C</td>
          <td>01933‑889900</td>
          <td><span class="badge neutral">4 files</span></td>
          <td><span class="badge gold">Yes</span></td>
          <td><span class="badge green">Active</span></td>
          <td><button class="btn btn-ghost btn-sm">View</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- ============ TENANTS ============ -->
<section class="panel" id="panel-tenants">
  <div class="filter-bar">
    <div class="search"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
        <circle cx="11" cy="11" r="7" />
        <path d="m21 21-4.3-4.3" />
      </svg><input class="input" placeholder="Search tenant"></div>
    <select class="select">
      <option>All statuses</option>
      <option>Current</option>
      <option>Moved out</option>
    </select>
    <button class="btn btn-primary" style="margin-left:auto;">+ Register Tenant</button>
  </div>
  <div class="card">
    <table class="ledger">
      <thead>
        <tr>
          <th>Tenant</th>
          <th>Unit</th>
          <th>Owner</th>
          <th>Move‑in</th>
          <th>Move‑out</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><span class="avatar-sm">TR</span>Tariqul Rahman</td>
          <td>C‑05A</td>
          <td>Ruma Chowdhury</td>
          <td>01 Jan 2025</td>
          <td>—</td>
          <td><span class="badge green">Current</span></td>
        </tr>
        <tr>
          <td><span class="avatar-sm">NA</span>Nadia Ahmed</td>
          <td>B‑02B</td>
          <td>Shahidul Islam</td>
          <td>15 Mar 2024</td>
          <td>30 Jun 2026</td>
          <td><span class="badge neutral">Moved out</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- ============ LIFE MEMBERS ============ -->
<section class="panel" id="panel-lifemembers">
  <div class="grid grid-3 section-row">
    <div class="stat-card gold">
      <div class="label">Approved Members</div>
      <div class="value">248</div>
    </div>
    <div class="stat-card">
      <div class="label">Pending Applications</div>
      <div class="value">5</div>
    </div>
    <div class="stat-card">
      <div class="label">Life Member Fee (one‑time)</div>
      <div class="value"><span class="sym">৳</span>15,000</div>
    </div>
  </div>

  <div class="card-head" style="margin-bottom:10px;">
    <h3>Membership Pipeline</h3>
  </div>
  <div class="kanban section-row">
    <div class="kanban-col">
      <h4>New Applications <span>3</span></h4>
      <div class="kanban-card">
        <div class="t">Jamal Uddin — Unit A‑11B</div>
        <div class="m"><span>Submitted 20 Jul</span><span class="badge neutral">Docs pending</span></div>
      </div>
      <div class="kanban-card">
        <div class="t">Selina Parvin — Unit C‑09A</div>
        <div class="m"><span>Submitted 21 Jul</span><span class="badge neutral">Docs pending</span></div>
      </div>
    </div>
    <div class="kanban-col">
      <h4>Under Review <span>2</span></h4>
      <div class="kanban-card">
        <div class="t">Habibur Rahman — Unit D‑02C</div>
        <div class="m"><span>Committee review</span><span class="badge gold">In progress</span></div>
      </div>
    </div>
    <div class="kanban-col">
      <h4>Approved <span>2</span></h4>
      <div class="kanban-card">
        <div class="t">Kamal Hossain — Unit A‑04B</div>
        <div class="m"><span>Fee collected</span><span class="badge green">Approved</span></div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Fee Collection Log</h3>
    </div>
    <table class="ledger">
      <thead>
        <tr>
          <th>Member</th>
          <th>Unit</th>
          <th class="num">Fee</th>
          <th>Method</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Kamal Hossain</td>
          <td>A‑04B</td>
          <td class="num">৳15,000</td>
          <td>Bank</td>
          <td>05 Jul 2026</td>
          <td><span class="badge green">Paid</span></td>
        </tr>
        <tr>
          <td>Shahidul Islam</td>
          <td>B‑06C</td>
          <td class="num">৳15,000</td>
          <td>Cash</td>
          <td>18 Jun 2026</td>
          <td><span class="badge green">Paid</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- ============ SUBSCRIPTIONS & BILLING ============ -->
<section class="panel" id="panel-subscriptions">
  <div class="tabs-inline section-row">
    <button class="active">Subscription Rates</button>
    <button>Late Fee &amp; Discounts</button>
    <button>Invoices</button>
  </div>
  <div class="card section-row">
    <div class="card-head">
      <h3>Rate Configuration by Building</h3><button class="btn btn-primary btn-sm">+ Add Rate Rule</button>
    </div>
    <table class="ledger">
      <thead>
        <tr>
          <th>Building</th>
          <th>Unit Type</th>
          <th class="num">Monthly Rate</th>
          <th class="num">Late Fee</th>
          <th>Discount</th>
          <th>Effective From</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Building A</td>
          <td>Apartment</td>
          <td class="num">৳2,500</td>
          <td class="num">৳150 / 10 days</td>
          <td>—</td>
          <td>Jan 2026</td>
        </tr>
        <tr>
          <td>Building B</td>
          <td>Apartment</td>
          <td class="num">৳2,300</td>
          <td class="num">৳150 / 10 days</td>
          <td>Senior citizen 10%</td>
          <td>Jan 2026</td>
        </tr>
        <tr>
          <td>Building D</td>
          <td>Plot</td>
          <td class="num">৳1,800</td>
          <td class="num">৳100 / 10 days</td>
          <td>—</td>
          <td>Mar 2026</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="card">
    <div class="card-head">
      <h3>Recent Invoices</h3><span class="hint">Auto‑generated on the 1st of each month</span>
    </div>
    <table class="ledger">
      <thead>
        <tr>
          <th>Invoice No.</th>
          <th>Unit</th>
          <th>Period</th>
          <th class="num">Amount</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>INV‑2607‑041</td>
          <td>A‑04B</td>
          <td>Jul 2026</td>
          <td class="num">৳2,500</td>
          <td><span class="badge green">Paid</span></td>
          <td><button class="btn btn-ghost btn-sm">Download</button></td>
        </tr>
        <tr>
          <td>INV‑2607‑012</td>
          <td>A‑01A</td>
          <td>Jul 2026</td>
          <td class="num">৳2,500</td>
          <td><span class="badge red">Due</span></td>
          <td><button class="btn btn-ghost btn-sm">Download</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- ============ PAYMENTS & COLLECTORS ============ -->
<section class="panel" id="panel-payments">
  <div class="tabs-inline section-row">
    <button class="active">Payment Records</button>
    <button>Collector Assignments</button>
    <button>Daily Submission Log</button>
  </div>
  <div class="filter-bar">
    <select class="select">
      <option>All methods</option>
      <option>Cash</option>
      <option>Bank</option>
      <option>bKash</option>
      <option>Nagad</option>
    </select>
    <select class="select">
      <option>All collectors</option>
      <option>Md. Anwar</option>
      <option>Sumon Mia</option>
    </select>
    <button class="btn btn-primary" style="margin-left:auto;">+ Record Payment</button>
  </div>
  <div class="card">
    <table class="ledger">
      <thead>
        <tr>
          <th>Date</th>
          <th>Unit</th>
          <th>Owner</th>
          <th>Method</th>
          <th>Collector</th>
          <th class="num">Amount</th>
          <th>Paid/Due</th>
          <th>Receipt</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="num">23 Jul</td>
          <td>A‑04B</td>
          <td>Kamal Hossain</td>
          <td>bKash</td>
          <td>Md. Anwar</td>
          <td class="num">৳2,500</td>
          <td><span class="badge green">Full</span></td>
          <td><button class="btn btn-ghost btn-sm">Print</button></td>
        </tr>
        <tr>
          <td class="num">21 Jul</td>
          <td>C‑05A</td>
          <td>Ruma Chowdhury</td>
          <td>Nagad</td>
          <td>Sumon Mia</td>
          <td class="num">৳2,200</td>
          <td><span class="badge gold">Partial</span></td>
          <td><button class="btn btn-ghost btn-sm">Print</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- ============ EXPENSE & INVENTORY ============ -->
<section class="panel" id="panel-expense">
  <div class="tabs-inline section-row">
    <button class="active">Expenses</button>
    <button>Inventory List</button>
    <button>In / Out Register</button>
  </div>
  <div class="grid grid-2 section-row">
    <div class="card">
      <div class="card-head">
        <h3>Monthly Expense Report</h3><span class="hint">Jul 2026</span>
      </div>
      <table class="ledger">
        <thead>
          <tr>
            <th>Category</th>
            <th class="num">Amount</th>
            <th>Share</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Utility (electricity/water)</td>
            <td class="num">৳48,200</td>
            <td>
              <div class="progress"><span style="width:38%"></span></div>
            </td>
          </tr>
          <tr>
            <td>Maintenance</td>
            <td class="num">৳32,000</td>
            <td>
              <div class="progress"><span style="width:25%"></span></div>
            </td>
          </tr>
          <tr>
            <td>Security staff</td>
            <td class="num">৳40,000</td>
            <td>
              <div class="progress"><span style="width:31%"></span></div>
            </td>
          </tr>
          <tr>
            <td>Office supplies</td>
            <td class="num">৳7,500</td>
            <td>
              <div class="progress"><span style="width:6%"></span></div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card">
      <div class="card-head">
        <h3>Add Expense</h3>
      </div>
      <div style="display:flex; flex-direction:column; gap:10px;">
        <input class="input" placeholder="Description">
        <select class="select">
          <option>Utility</option>
          <option>Maintenance</option>
          <option>Security</option>
          <option>Office supplies</option>
        </select>
        <input class="input" placeholder="Amount (৳)">
        <button class="btn btn-primary">Save Expense</button>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-head">
      <h3>Inventory Summary</h3>
    </div>
    <table class="ledger">
      <thead>
        <tr>
          <th>Item</th>
          <th class="num">In Stock</th>
          <th class="num">Last In</th>
          <th class="num">Last Out</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Plastic chairs</td>
          <td class="num">120</td>
          <td class="num">+50</td>
          <td class="num">‑10</td>
          <td><span class="badge green">Sufficient</span></td>
        </tr>
        <tr>
          <td>Tube lights</td>
          <td class="num">8</td>
          <td class="num">+20</td>
          <td class="num">‑24</td>
          <td><span class="badge red">Low stock</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- ============ NOTICES ============ -->
<section class="panel" id="panel-notices">
  <div class="filter-bar">
    <button class="btn btn-primary" style="margin-left:auto;">+ New Notice</button>
  </div>
  <div class="grid grid-3">
    <div class="card"><span class="badge red" style="margin-bottom:8px;">Urgent</span>
      <h3 style="font-family:var(--font-display);margin:6px 0;">Water line maintenance</h3>
      <p class="hint">Building C water supply will be off 25 Jul, 10 AM–1 PM.</p>
    </div>
    <div class="card"><span class="badge gold" style="margin-bottom:8px;">Reminder</span>
      <h3 style="font-family:var(--font-display);margin:6px 0;">July subscription due</h3>
      <p class="hint">Sent via SMS/Email to 41 units with pending dues.</p>
    </div>
    <div class="card"><span class="badge green" style="margin-bottom:8px;">Announcement</span>
      <h3 style="font-family:var(--font-display);margin:6px 0;">New collector — Building D</h3>
      <p class="hint">Sumon Mia is now assigned to Building D, effective 20 Jul.</p>
    </div>
  </div>
</section>

<!-- ============ COMPLAINTS ============ -->
<section class="panel" id="panel-complaints">
  <div class="filter-bar">
    <button class="btn btn-primary" style="margin-left:auto;">+ Log Complaint</button>
  </div>
  <div class="kanban">
    <div class="kanban-col">
      <h4>Open <span>2</span></h4>
      <div class="kanban-card">
        <div class="t">Lift not working — Building B</div>
        <div class="m"><span>Shahidul Islam</span><span class="badge red">Open</span></div>
      </div>
      <div class="kanban-card">
        <div class="t">Water leakage — 4th floor A</div>
        <div class="m"><span>Kamal Hossain</span><span class="badge red">Open</span></div>
      </div>
    </div>
    <div class="kanban-col">
      <h4>In Progress <span>2</span></h4>
      <div class="kanban-card">
        <div class="t">Parking dispute — Building C</div>
        <div class="m"><span>Ruma Chowdhury</span><span class="badge gold">In progress</span></div>
      </div>
      <div class="kanban-card">
        <div class="t">Gate light not working</div>
        <div class="m"><span>Security desk</span><span class="badge gold">In progress</span></div>
      </div>
    </div>
    <div class="kanban-col">
      <h4>Resolved <span>11</span></h4>
      <div class="kanban-card">
        <div class="t">Garbage collection delay</div>
        <div class="m"><span>Building D</span><span class="badge green">Resolved</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ EVENTS ============ -->
<section class="panel" id="panel-events">
  <div class="filter-bar">
    <button class="btn btn-primary" style="margin-left:auto;">+ Create Event</button>
  </div>
  <div class="grid grid-3">
    <div class="card">
      <span class="badge gold">Paid</span>
      <h3 style="font-family:var(--font-display);margin:8px 0 4px;">Annual Picnic — Bandarban</h3>
      <p class="hint">10 Aug 2026 · ৳1,200 / member · 86 seats booked</p>
      <button class="btn btn-sm" style="margin-top:8px;">Notify Life Members</button>
    </div>
    <div class="card">
      <span class="badge green">Free</span>
      <h3 style="font-family:var(--font-display);margin:8px 0 4px;">Free Medical Camp</h3>
      <p class="hint">2 Aug 2026 · Community Hall · Open to all members</p>
      <button class="btn btn-sm" style="margin-top:8px;">Notify Life Members</button>
    </div>
    <div class="card">
      <span class="badge neutral">Meeting</span>
      <h3 style="font-family:var(--font-display);margin:8px 0 4px;">General Committee Meeting</h3>
      <p class="hint">15 Aug 2026 · Society Office · 7:30 PM</p>
      <button class="btn btn-sm" style="margin-top:8px;">Notify Life Members</button>
    </div>
  </div>
</section>

<!-- ============ REPORTS ============ -->
<section class="panel" id="panel-reports">
  <div class="grid grid-2-even">
    <div class="card">
      <h3 style="font-family:var(--font-display);">Collection Report</h3>
      <p class="hint">Unit‑wise, by date range</p><button class="btn btn-primary btn-sm">Generate</button>
    </div>
    <div class="card">
      <h3 style="font-family:var(--font-display);">Due Report</h3>
      <p class="hint">Outstanding by building / unit</p><button class="btn btn-primary btn-sm">Generate</button>
    </div>
    <div class="card">
      <h3 style="font-family:var(--font-display);">Expense Report</h3>
      <p class="hint">By category, by month</p><button class="btn btn-primary btn-sm">Generate</button>
    </div>
    <div class="card">
      <h3 style="font-family:var(--font-display);">Collector Performance</h3>
      <p class="hint">Collected vs. submitted</p><button class="btn btn-primary btn-sm">Generate</button>
    </div>
  </div>
</section>

<!-- ============ USERS & ROLES ============ -->
<section class="panel" id="panel-users">
  <div class="card">
    <div class="card-head">
      <h3>Roles &amp; Permissions</h3><button class="btn btn-primary btn-sm">+ Invite User</button>
    </div>
    <table class="ledger">
      <thead>
        <tr>
          <th>Role</th>
          <th>Dashboard</th>
          <th>Payments</th>
          <th>Reports</th>
          <th>Users</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Admin</td>
          <td>✓</td>
          <td>✓</td>
          <td>✓</td>
          <td>✓</td>
        </tr>
        <tr>
          <td>Committee Member</td>
          <td>✓</td>
          <td>✓</td>
          <td>✓</td>
          <td>—</td>
        </tr>
        <tr>
          <td>Collector</td>
          <td>—</td>
          <td>✓ (own)</td>
          <td>—</td>
          <td>—</td>
        </tr>
        <tr>
          <td>Owner</td>
          <td>—</td>
          <td>✓ (own unit)</td>
          <td>—</td>
          <td>—</td>
        </tr>
        <tr>
          <td>Tenant</td>
          <td>—</td>
          <td>✓ (own unit)</td>
          <td>—</td>
          <td>—</td>
        </tr>
        <tr>
          <td>Life Member</td>
          <td>—</td>
          <td>✓ (own)</td>
          <td>—</td>
          <td>—</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- ============ SECURITY ============ -->
<section class="panel" id="panel-security">
  <div class="card">
    <div class="card-head">
      <h3>Recent Activity Log</h3>
    </div>
    <table class="ledger">
      <thead>
        <tr>
          <th>Time</th>
          <th>User</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="num">23 Jul, 3:12 PM</td>
          <td>Rafiqul Sarker</td>
          <td>Recorded payment for A-04B</td>
        </tr>
        <tr>
          <td class="num">23 Jul, 1:04 PM</td>
          <td>Md. Anwar</td>
          <td>Logged in from mobile</td>
        </tr>
        <tr>
          <td class="num">22 Jul, 6:40 PM</td>
          <td>System</td>
          <td>Auto-generated 148 monthly invoices</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
@endsection