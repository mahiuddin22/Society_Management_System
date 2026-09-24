@extends('admin.layouts.app')

@push('styles')
  <style>
    .road-custom-popup {
      scrollbar-width: thin;
      scrollbar-color: var(--line-strong) transparent;
    }
    .road-custom-popup::-webkit-scrollbar {
      width: 5px;
    }
    .road-custom-popup::-webkit-scrollbar-thumb {
      background: var(--line-strong);
      border-radius: 4px;
    }
    .road-opt {
      padding: 6px 11px;
      font-size: 12.5px;
      color: var(--ink-700);
      cursor: pointer;
      line-height: 1.4;
      white-space: nowrap;
      transition: background .12s ease, color .12s ease;
    }
    .road-opt:hover {
      background-color: var(--forest-50);
      color: var(--forest-800);
    }
    .road-opt.active-road {
      background-color: var(--forest-100) !important;
      color: var(--forest-900) !important;
      font-weight: 600;
    }

    /* Forest Green Custom Pagination */
    .pagination {
      margin-bottom: 0;
      gap: 3px;
    }
    .pagination .page-item .page-link {
      font-size: 12px;
      font-weight: 500;
      color: var(--ink-700);
      background-color: var(--card);
      border: 1px solid var(--line);
      border-radius: var(--radius-s, 6px) !important;
      padding: 4px 9px;
      min-width: 28px;
      height: 28px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      line-height: 1;
      transition: all 0.15s ease;
      box-shadow: none !important;
    }
    .pagination .page-item .page-link:hover {
      background-color: var(--forest-50);
      border-color: var(--forest-100);
      color: var(--forest-900);
    }
    .pagination .page-item.active .page-link {
      background-color: var(--forest-800) !important;
      border-color: var(--forest-900) !important;
      color: #ffffff !important;
      font-weight: 600;
    }
    .pagination .page-item.disabled .page-link {
      color: var(--ink-500);
      background-color: var(--paper-50);
      border-color: var(--line);
      opacity: 0.6;
    }

    #regenerateTrxBtn:hover {
      color: var(--forest-800) !important;
      background-color: var(--forest-50) !important;
    }

    /* Mobile Responsive Modal Dialog Fix */
    @media (max-width: 576px) {
      #payModal .modal-dialog,
      #generateModal .modal-dialog {
        margin: 0.75rem auto !important;
        max-width: calc(100% - 1.25rem) !important;
      }
      #payModal .modal-footer,
      #generateModal .modal-footer {
        padding-right: 1rem !important;
      }
      #payModal .modal-footer .btn-primary,
      #generateModal .modal-footer .btn-primary {
        margin-right: 0 !important;
      }
    }
  </style>
@endpush

@section('content')
<section class="panel active" id="panel-bills">

  {{-- 1. Filter Bar & Action Header (70/30 Split) --}}
  <div class="row align-items-center g-2 mb-4">
    
    {{-- Left: Search & Filter Popover (70% on desktop) --}}
    <div class="col-12 col-md-8">
      <form action="{{ route('admin.bills.index') }}" method="GET" autocomplete="off" id="filterForm">
        <div class="d-flex align-items-center gap-2 flex-wrap flex-sm-nowrap">
          
          {{-- Primary Search Input --}}
          <div class="search flex-grow-1" style="min-width: 0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
              <circle cx="11" cy="11" r="7" />
              <path d="m21 21-4.3-4.3" />
            </svg>
            <input 
              class="input w-100" 
              name="search" 
              value="{{ request('search') }}" 
              placeholder="Search bill #, holding, phone..."
            >
          </div>

          {{-- Active Filter Counter --}}
          @php
            $activeAdvancedFiltersCount = collect(['month', 'status', 'road_number', 'plot_type_id'])
                ->filter(fn($key) => request()->filled($key))
                ->count();
          @endphp

          {{-- Filter Toggle Button with Popover Anchor --}}
          <div class="position-relative flex-shrink-0" id="filterPopoverWrapper">
            <button 
              type="button" 
              class="btn {{ $activeAdvancedFiltersCount > 0 ? 'btn-primary' : 'btn-ghost' }} d-inline-flex align-items-center gap-1 px-2" 
              id="toggleFilterPopupBtn"
              title="Toggle filters"
              style="border: 1px solid {{ $activeAdvancedFiltersCount > 0 ? 'transparent' : 'var(--line)' }}; height: 38px;"
            >
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="4" y1="21" x2="4" y2="14"></line>
                <line x1="4" y1="10" x2="4" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12" y2="3"></line>
                <line x1="20" y1="21" x2="20" y2="16"></line>
                <line x1="20" y1="12" x2="20" y2="3"></line>
                <line x1="1" y1="14" x2="7" y2="14"></line>
                <line x1="9" y1="8" x2="15" y2="8"></line>
                <line x1="17" y1="16" x2="23" y2="16"></line>
              </svg>
              <span class="d-none d-sm-inline">Filters</span>

              @if($activeAdvancedFiltersCount > 0)
                <span class="badge rounded-pill bg-white text-dark ms-1" style="font-size: 10px; padding: 2px 5px;">
                  {{ $activeAdvancedFiltersCount }}
                </span>
              @endif
            </button>

            {{-- Floating Filter Popover Panel --}}
            <div 
              id="filterPopupPanel" 
              class="shadow-lg p-3 rounded-2"
              style="
                display: none;
                position: absolute;
                top: calc(100% + 8px);
                right: 0;
                left: auto;
                width: 280px;
                max-width: 90vw;
                background: var(--card);
                border: 1px solid var(--line-strong);
                box-shadow: 0 10px 25px -5px rgba(23, 56, 34, 0.18);
                z-index: 1060;
              "
            >
              <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                <span class="fw-bold small" style="color: var(--ink-900); font-size: 13px;">Filter Ledger</span>
                <button type="button" class="btn btn-ghost p-0 border-0 text-muted" id="closeFilterPopupBtn" style="font-size: 18px; line-height: 1;">
                  &times;
                </button>
              </div>

              <div class="d-flex flex-column gap-3">
                {{-- Billing Month --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Billing Month</label>
                  <input type="month" name="month" class="input w-100" value="{{ request('month', $currentMonth) }}" style="font-size: 12.5px;">
                </div>

                {{-- Payment Status --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Payment Status</label>
                  <select class="select w-100" name="status" style="font-size: 12.5px;">
                    <option value="">All Statuses</option>
                    <option value="Unpaid" {{ request('status') === 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="Partial" {{ request('status') === 'Partial' ? 'selected' : '' }}>Partial</option>
                    <option value="Paid" {{ request('status') === 'Paid' ? 'selected' : '' }}>Paid</option>
                  </select>
                </div>

                {{-- Road Picker --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Road</label>
                  <div class="position-relative road-picker-container w-100">
                    <input 
                      type="text" 
                      id="roadSearchInput"
                      class="input w-100" 
                      placeholder="All Roads" 
                      value="{{ request('road_number') ? 'Road ' . request('road_number') : '' }}"
                      autocomplete="off"
                      readonly
                      style="cursor: pointer; padding-right: 28px; background-color: var(--card); font-size: 12.5px; color: var(--ink-700); user-select: none;"
                    >
                    <span class="position-absolute top-50 end-0 translate-middle-y pe-2 text-muted" style="pointer-events: none; opacity: .65;">
                      <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="m6 9 6 6 6-6"/>
                      </svg>
                    </span>

                    <div 
                      id="roadDropdownMenu" 
                      class="road-custom-popup"
                      style="
                        display: none;
                        position: absolute;
                        top: calc(100% - 1px);
                        left: 0;
                        width: 100%;
                        max-height: 155px;
                        overflow-y: auto;
                        background: var(--card);
                        border: 1px solid var(--line);
                        border-top-left-radius: 0;
                        border-top-right-radius: 0;
                        border-bottom-left-radius: var(--radius-s);
                        border-bottom-right-radius: var(--radius-s);
                        box-shadow: 0 4px 14px rgba(23, 56, 34, 0.08);
                        z-index: 1070;
                        padding: 3px 0;
                      "
                    >
                      <div class="road-opt {{ !request('road_number') ? 'active-road' : '' }}" data-val="" data-label="All Roads">
                        All Roads
                      </div>
                      @if(isset($roads))
                        @foreach ($roads as $road)
                          <div 
                            class="road-opt {{ (string)request('road_number') === (string)$road->number ? 'active-road' : '' }}" 
                            data-val="{{ $road->number }}"
                            data-label="Road {{ $road->number }}"
                          >
                            Road {{ $road->number }}
                          </div>
                        @endforeach
                      @endif
                    </div>

                    <input type="hidden" name="road_number" id="roadHiddenValue" value="{{ request('road_number') }}">
                  </div>
                </div>

                {{-- Plot Type --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Plot Type</label>
                  <select class="select w-100" name="plot_type_id" style="font-size: 12.5px;">
                    <option value="">All Types</option>
                    @if(isset($plotTypes))
                      @foreach ($plotTypes as $type)
                        <option value="{{ $type->id }}" {{ (string) request('plot_type_id') === (string) $type->id ? 'selected' : '' }}>
                          {{ $type->name }}
                        </option>
                      @endforeach
                    @endif
                  </select>
                </div>

                {{-- Apply Button --}}
                <div class="pt-2 border-top">
                  <button type="submit" class="btn btn-primary w-100 justify-content-center py-2 small" style="font-size: 13px;">
                    Apply Filters
                  </button>
                </div>

              </div>
            </div>
          </div>

          {{-- Search & Reset Buttons --}}
          <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <button type="submit" class="btn btn-primary px-3" style="height: 38px;">Search</button>

            @if(request()->hasAny(['search', 'month', 'status', 'road_number', 'plot_type_id']))
              <a href="{{ route('admin.bills.index') }}" class="btn btn-secondary px-2" title="Clear all filters" style="height: 38px; line-height: 24px;">Reset</a>
            @endif
          </div>

        </div>
      </form>
    </div>

    {{-- Right: Run Cycle Action (30% on desktop) --}}
    <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
      <button type="button" class="btn btn-primary d-flex d-md-inline-flex justify-content-center align-items-center gap-2 text-nowrap" style="height: 38px;" data-bs-toggle="modal" data-bs-target="#generateModal">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
          <circle cx="12" cy="12" r="3"></circle>
          <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
        </svg>
        <span>Run Billing Cycle</span>
      </button>
    </div>

  </div>

  {{-- 2. Compact Overview Metric Row (5-Columns) --}}
  <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-5 g-2 mb-3">
    
    {{-- Metric 1: Total Invoiced --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Total Invoiced
          </span>
          <span class="badge green px-1 py-0" style="font-size: 10px; line-height: 1.4;">{{ $bills->total() }}</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold" style="font-size: 16px; color: var(--forest-800);">
            ৳{{ number_format($stats['total_billed'] ?? 0) }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">/ month</span>
        </div>
      </div>
    </div>

    {{-- Metric 2: Collected --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Collected
          </span>
          <span class="badge green px-1 py-0" style="font-size: 10px; line-height: 1.4;">Paid</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold" style="font-size: 16px; color: var(--forest-800);">
            ৳{{ number_format($stats['total_paid'] ?? 0) }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">received</span>
        </div>
      </div>
    </div>

    {{-- Metric 3: Pending Balance --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Pending Due
          </span>
          <span class="badge yellow px-1 py-0" style="font-size: 10px; line-height: 1.4;">Due</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold text-danger" style="font-size: 16px;">
            ৳{{ number_format(max(0, ($stats['total_billed'] ?? 0) - ($stats['total_paid'] ?? 0))) }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">to collect</span>
        </div>
      </div>
    </div>

    {{-- Metric 4: Unpaid Holdings --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Unpaid Units
          </span>
          <span class="badge red px-1 py-0" style="font-size: 10px; line-height: 1.4;">Attention</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold" style="font-size: 16px; color: var(--ink-900);">
            {{ $stats['unpaid_count'] ?? 0 }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">holdings</span>
        </div>
      </div>
    </div>

    {{-- Metric 5: Collection Rate --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        @php
          $collectionPercentage = ($stats['total_billed'] ?? 0) > 0 
            ? round((($stats['total_paid'] ?? 0) / $stats['total_billed']) * 100, 1) 
            : 0;
        @endphp
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Efficiency
          </span>
          <span class="badge green px-1 py-0" style="font-size: 10px; line-height: 1.4;">Target</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold" style="font-size: 16px; color: var(--forest-800);">
            {{ $collectionPercentage }}%
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">realized</span>
        </div>
      </div>
    </div>

  </div>

  {{-- 3. Register Ledger Table --}}
  <div class="card p-0 overflow-hidden">
    <div class="table-wrap">
      <table class="ledger text-nowrap w-100">
        <thead>
          <tr>
            <th>Bill / Date</th>
            <th>Resident / Contact</th>
            <th>Type</th>
            <th>Units &amp; Rate</th>
            <th class="num">Net Due</th>
            <th>Status</th>
            <th class="text-end pe-3">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bills as $bill)
          <tr>
            {{-- 1. Bill / Date --}}
            <td>
              <div class="fw-bold font-monospace" style="color: var(--forest-900);">{{ $bill->bill_number }}</div>
              <span class="hint small" style="font-size: 11px;">Month: {{ $bill->billing_month }} &bull; Due: {{ $bill->due_date->format('d M') }}</span>
            </td>

            {{-- 2. Holding & Resident --}}
            <td>
              <div class="fw-medium text-dark">{{ $bill->plotAndUnit->name ?? '—' }}</div>
              <span class="hint small">{{ $bill->plotAndUnit->phone ?? '—' }}</span>
            </td>

            {{-- 3. Type --}}
            <td>
              <div>{{ $bill->plot_type_name }}</div>
              <span class="hint small">{{ $bill->plotAndUnit->unique_id ?? '—' }}</span>
            </td>

            {{-- 4. Units & Rate --}}
            <td>
              <div>{{ $bill->billing_units }} unit(s) &times; {{ number_format($bill->rate_snapshot) }}৳</div>
              @if($bill->discount_snapshot > 0)
                <div class="text-muted" style="font-size: 10px;">Disc: -৳{{ number_format($bill->discount_snapshot) }}</div>
              @endif
            </td>

            {{-- 5. Net Due --}}
            <td class="num">
              <div><span class="fw-bold">{{ number_format($bill->due_balance, 2) }}</span>৳</div>
              <div class="hint" style="font-size: 10px;">Paid: {{ number_format($bill->paid_amount, 2) }}৳</div>
            </td>

            {{-- 6. Status --}}
            <td>
              @if($bill->status === 'Paid')
                <span class="badge green"><i class="dot"></i>Paid</span>
              @elseif($bill->status === 'Partial')
                <span class="badge yellow"><i class="dot"></i>Partial</span>
              @else
                <span class="badge red"><i class="dot"></i>Unpaid</span>
              @endif
            </td>

            {{-- 7. Action --}}
            <td class="text-end pe-3">
              @if($bill->due_balance > 0)
                <button type="button" 
                        class="btn btn-primary btn-sm py-1 px-2" 
                        style="font-size: 12px;"
                        onclick="openPaymentModal({{ $bill->id }}, '{{ $bill->bill_number }}', {{ $bill->due_balance }})">
                  Collect
                </button>
              @else
                <span class="text-muted small"><i class="bi bi-check-all text-success"></i> Settled</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              <div class="empty-note">No billing records found for this criteria.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($bills->hasPages())
    <div class="pagination-footer px-3 py-2 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
      <div class="hint small text-muted" style="font-size: 12px;">
        Showing <span class="fw-semibold text-dark">{{ $bills->firstItem() }}</span> to <span class="fw-semibold text-dark">{{ $bills->lastItem() }}</span> of <span class="fw-semibold text-dark">{{ $bills->total() }}</span> results
      </div>
      <div>
        {{ $bills->onEachSide(1)->links('pagination::bootstrap-4') }}
      </div>
    </div>
    @endif
  </div>

</section>

{{-- Modal 1: Generate Billing Run (With Formatted Displays) --}}
<div class="modal fade" id="generateModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
    <form action="{{ route('admin.bills.generate') }}" method="POST" class="modal-content border-0 shadow">
      @csrf
      <div class="modal-header py-2 px-3 border-bottom" style="background: var(--paper-100);">
        <h6 class="modal-title fw-bold" style="color: var(--forest-900);">Generate Monthly Cycle</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-3">
        
        {{-- Billing Month with Visible Human-Readable Formatting --}}
        <div class="mb-3">
          <label class="form-label small fw-semibold mb-1">Billing Month</label>
          <div class="position-relative w-100">
            <input 
              type="text" 
              id="displayBillingMonth" 
              class="input w-100" 
              style="padding-right: 34px; background-color: var(--card); cursor: pointer;" 
              readonly
            >
            <span class="position-absolute top-50 translate-middle-y text-muted" style="right: 11px; pointer-events: none; z-index: 1;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
            </span>
            {{-- Native Full-Width Hidden Overlay for clean touch triggers --}}
            <input 
              type="month" 
              name="billing_month" 
              id="nativeBillingMonth" 
              value="{{ now()->format('Y-m') }}" 
              style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;"
              required
            >
          </div>
        </div>

        {{-- Due Date with Visible Human-Readable Formatting --}}
        <div class="mb-3">
          <label class="form-label small fw-semibold mb-1">Due Date</label>
          <div class="position-relative w-100">
            <input 
              type="text" 
              id="displayDueDate" 
              class="input w-100" 
              style="padding-right: 34px; background-color: var(--card); cursor: pointer;" 
              readonly
            >
            <span class="position-absolute top-50 translate-middle-y text-muted" style="right: 11px; pointer-events: none; z-index: 1;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
            </span>
            {{-- Native Full-Width Hidden Overlay for clean touch triggers --}}
            <input 
              type="date" 
              name="due_date" 
              id="nativeDueDate" 
              value="{{ now()->addMonth()->startOfMonth()->addDays(9)->toDateString() }}" 
              style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;"
              required
            >
          </div>
        </div>

        <p class="hint small mb-0" style="font-size: 11.5px;">Existing holdings for this month are automatically skipped to avoid double invoicing.</p>
      </div>
      <div class="modal-footer py-2 px-3 border-top d-flex justify-content-end align-items-center gap-2">
        <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary m-0">Run Generation</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal 2: Collect Payment --}}
<div class="modal fade" id="payModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
    <form id="payForm" method="POST" class="modal-content border-0 shadow">
      @csrf
      <div class="modal-header py-2 px-3 border-bottom" style="background: var(--paper-100);">
        <h6 class="modal-title fw-bold" id="payModalTitle" style="color: var(--forest-900);">Record Payment</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      {{-- Modal Body --}}
      <div class="modal-body p-3">
        <div class="mb-2">
          <label class="form-label small fw-semibold">Payment Amount (৳)</label>
          <input type="number" step="0.01" name="amount" id="payAmountInput" class="input w-100" required>
        </div>

        {{-- Payment Date with Visible Human-Readable Formatting (DD/MM/YYYY) --}}
        <div class="mb-2">
          <label class="form-label small fw-semibold mb-1">Payment Date</label>
          <div class="position-relative w-100">
            <input 
              type="text" 
              id="displayPaymentDate" 
              class="input w-100" 
              placeholder="DD/MM/YYYY"
              style="padding-right: 34px; background-color: var(--card); cursor: pointer;" 
              readonly
            >
            <span class="position-absolute top-50 translate-middle-y text-muted" style="right: 11px; pointer-events: none; z-index: 1;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
            </span>
            {{-- Native Full-Width Hidden Overlay: Device native calendar centers automatically --}}
            <input 
              type="date" 
              name="payment_date" 
              id="nativePaymentDate" 
              value="{{ now()->toDateString() }}" 
              style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;"
              required
            >
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label small fw-semibold">Method</label>
          <select name="method" class="select w-100" required>
            <option value="Cash">Cash</option>
            <option value="bKash">bKash</option>
            <option value="Nagad">Nagad</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Cheque">Cheque</option>
          </select>
        </div>

        <div class="mb-1">
          <label class="form-label small fw-semibold mb-1">
            Transaction / Slip Ref
            <span class="text-muted fw-normal" style="font-size: 11px;">(Optional)</span>
          </label>
          <div class="position-relative w-100">
            <input 
              type="text" 
              name="transaction_ref" 
              id="payTrxRefInput" 
              class="input w-100 font-monospace" 
              placeholder="Auto-generated if left blank"
              style="padding-right: 32px;"
            >
            <button 
              type="button" 
              id="regenerateTrxBtn"
              onclick="generateTrxRef()" 
              title="Generate reference"
              tabindex="-1"
              style="
                position: absolute;
                right: 11px;
                top: 50%;
                transform: translateY(-50%);
                border: 0 !important;
                background: transparent !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 16px;
                height: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--ink-500, #6d7469);
                cursor: pointer;
                z-index: 5;
              "
            >
              <i class="bi bi-arrow-clockwise" style="font-size: 15px; line-height: 1;"></i>
            </button>
          </div>
          <span class="hint small text-muted" style="font-size: 10.5px;">Click the icon to generate, enter a reference, or leave blank to auto-generate.</span>
        </div>
      </div>

      {{-- Modal Footer: Flush right alignment with inputs --}}
      <div class="modal-footer py-2 px-3 border-top d-flex justify-content-end align-items-center gap-2" style="padding-right: 1rem !important;">
        <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary m-0" style="margin-right: 0 !important;">Save Payment</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn   = document.getElementById('toggleFilterPopupBtn');
      const closeBtn    = document.getElementById('closeFilterPopupBtn');
      const popupPanel  = document.getElementById('filterPopupPanel');

      if (toggleBtn && popupPanel) {
        toggleBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          const isVisible = popupPanel.style.display === 'block';
          popupPanel.style.display = isVisible ? 'none' : 'block';
        });
      }

      if (closeBtn && popupPanel) {
        closeBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          popupPanel.style.display = 'none';
        });
      }

      document.addEventListener('click', function (e) {
        if (popupPanel && !popupPanel.contains(e.target) && !toggleBtn.contains(e.target)) {
          popupPanel.style.display = 'none';
        }
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && popupPanel) {
          popupPanel.style.display = 'none';
        }
      });

      // Road picker dropdown logic
      const displayInput = document.getElementById('roadSearchInput');
      const hiddenInput  = document.getElementById('roadHiddenValue');
      const roadMenu     = document.getElementById('roadDropdownMenu');
      const roadItems    = roadMenu ? roadMenu.querySelectorAll('.road-opt') : [];

      if (displayInput && roadMenu) {
        function toggleRoadDropdown() {
          const isVisible = roadMenu.style.display === 'block';
          if (isVisible) {
            roadMenu.style.display = 'none';
            displayInput.style.borderBottomLeftRadius = '';
            displayInput.style.borderBottomRightRadius = '';
          } else {
            roadItems.forEach(item => item.style.display = 'block');
            roadMenu.style.display = 'block';
            displayInput.style.borderBottomLeftRadius = '0';
            displayInput.style.borderBottomRightRadius = '0';

            const activeItem = roadMenu.querySelector('.road-opt.active-road');
            if (activeItem) {
              roadMenu.scrollTop = activeItem.offsetTop - (roadMenu.clientHeight / 2) + (activeItem.clientHeight / 2);
            }
          }
        }

        displayInput.addEventListener('click', function (e) {
          e.stopPropagation();
          toggleRoadDropdown();
        });

        roadItems.forEach(item => {
          item.addEventListener('click', function (e) {
            e.stopPropagation();
            const val = this.getAttribute('data-val');
            const label = this.getAttribute('data-label');

            hiddenInput.value = val;
            displayInput.value = val ? label : '';

            roadItems.forEach(el => el.classList.remove('active-road'));
            this.classList.add('active-road');

            roadMenu.style.display = 'none';
            displayInput.style.borderBottomLeftRadius = '';
            displayInput.style.borderBottomRightRadius = '';
          });
        });

        document.addEventListener('click', function (e) {
          if (!e.target.closest('.road-picker-container')) {
            roadMenu.style.display = 'none';
            displayInput.style.borderBottomLeftRadius = '';
            displayInput.style.borderBottomRightRadius = '';
          }
        });
      }

      // Generate Modal Date & Month Formatters (Human-readable displays)
      const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
      ];

      const nativeMonth  = document.getElementById('nativeBillingMonth');
      const displayMonth = document.getElementById('displayBillingMonth');
      const nativeDate   = document.getElementById('nativeDueDate');
      const displayDate  = document.getElementById('displayDueDate');

      function formatMonthDisplay(val) {
        if (!val) return '';
        const [year, month] = val.split('-');
        const mIndex = parseInt(month, 10) - 1;
        return `${year}-${monthNames[mIndex] || month}`;
      }

      function formatDateDisplay(val) {
        if (!val) return '';
        const [year, month, day] = val.split('-');
        const mIndex = parseInt(month, 10) - 1;
        return `${parseInt(day, 10)} ${monthNames[mIndex] || month}, ${year}`;
      }

      function syncMonth() {
        if (nativeMonth && displayMonth) {
          displayMonth.value = formatMonthDisplay(nativeMonth.value);
        }
      }

      function syncDate() {
        if (nativeDate && displayDate) {
          displayDate.value = formatDateDisplay(nativeDate.value);
        }
      }

      if (nativeMonth) {
        nativeMonth.addEventListener('change', syncMonth);
      }

      if (nativeDate) {
        nativeDate.addEventListener('change', syncDate);
      }

      syncMonth();
      syncDate();

      const generateModal = document.getElementById('generateModal');
      if (generateModal) {
        generateModal.addEventListener('show.bs.modal', function () {
          syncMonth();
          syncDate();
        });
      }

      // Payment Modal Date Formatter (DD/MM/YYYY)
      const nativePayDate  = document.getElementById('nativePaymentDate');
      const displayPayDate = document.getElementById('displayPaymentDate');

      window.syncPaymentDateDisplay = function() {
        if (nativePayDate && displayPayDate && nativePayDate.value) {
          const [year, month, day] = nativePayDate.value.split('-');
          displayPayDate.value = `${day}/${month}/${year}`;
        }
      };

      if (nativePayDate) {
        nativePayDate.addEventListener('change', window.syncPaymentDateDisplay);
      }

      window.syncPaymentDateDisplay();
    });

    function openPaymentModal(billId, billNumber, dueBalance) {
      const form = document.getElementById('payForm');
      form.action = `/admin/bills/${billId}/pay`;
      document.getElementById('payModalTitle').innerText = `Pay: ${billNumber}`;
      
      const amountInput = document.getElementById('payAmountInput');
      amountInput.value = dueBalance.toFixed(2);
      amountInput.max = dueBalance;

      // Sync payment date to current date display
      const nativePayDate = document.getElementById('nativePaymentDate');
      if (nativePayDate) {
        nativePayDate.value = new Date().toISOString().slice(0, 10);
        if (typeof window.syncPaymentDateDisplay === 'function') {
          window.syncPaymentDateDisplay();
        }
      }

      // Start empty so operator is not obstructed
      const refInput = document.getElementById('payTrxRefInput');
      if (refInput) {
        refInput.value = '';
      }

      new bootstrap.Modal(document.getElementById('payModal')).show();
    }

    function generateTrxRef() {
      const dateStr = new Date().toISOString().slice(0, 10).replace(/-/g, '');
      const randomChars = Math.random().toString(36).substring(2, 7).toUpperCase();
      const refInput = document.getElementById('payTrxRefInput');
      const btn = document.getElementById('regenerateTrxBtn');

      if (refInput) {
        refInput.value = `TRX-${dateStr}-${randomChars}`;
      }

      if (btn) {
        const icon = btn.querySelector('i');
        if (icon) {
          icon.style.transition = 'transform 0.35s ease';
          icon.style.transform = 'rotate(360deg)';
          setTimeout(() => {
            icon.style.transition = 'none';
            icon.style.transform = 'rotate(0deg)';
          }, 350);
        }
      }
    }
  </script>
@endpush