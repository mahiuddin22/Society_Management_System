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

    /* Print styling for Money Receipt */
    @media print {
      body * {
        visibility: hidden;
      }
      #receiptModal .modal-content, #receiptModal .modal-content * {
        visibility: visible;
      }
      #receiptModal .modal-content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        border: none !important;
        box-shadow: none !important;
      }
      #receiptModal .modal-footer, #receiptModal .btn-close {
        display: none !important;
      }
    }
  </style>
@endpush

@section('content')
<section class="panel active" id="panel-payments">

  {{-- 1. Filter Bar & Header (70/30 Split) --}}
  <div class="row align-items-center g-2 mb-4">
    
    {{-- Search & Advanced Filter Popover (70% on desktop) --}}
    <div class="col-12 col-md-8">
      <form action="{{ route('admin.payments.index') }}" method="GET" autocomplete="off" id="filterForm">
        <div class="d-flex align-items-center gap-2 flex-wrap flex-sm-nowrap">
          
          {{-- Search Input --}}
          <div class="search flex-grow-1" style="min-width: 0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
              <circle cx="11" cy="11" r="7" />
              <path d="m21 21-4.3-4.3" />
            </svg>
            <input 
              class="input w-100" 
              name="search" 
              value="{{ request('search') }}" 
              placeholder="Search receipt #, trx, holding, resident..."
            >
          </div>

          {{-- Filter Counter --}}
          @php
            $activeFiltersCount = collect(['method', 'date_from', 'date_to', 'road_number'])
                ->filter(fn($key) => request()->filled($key))
                ->count();
          @endphp

          {{-- Filter Toggle Button --}}
          <div class="position-relative flex-shrink-0" id="filterPopoverWrapper">
            <button 
              type="button" 
              class="btn {{ $activeFiltersCount > 0 ? 'btn-primary' : 'btn-ghost' }} d-inline-flex align-items-center gap-1 px-2" 
              id="toggleFilterPopupBtn"
              title="Filter Payments"
              style="border: 1px solid {{ $activeFiltersCount > 0 ? 'transparent' : 'var(--line)' }}; height: 38px;"
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

              @if($activeFiltersCount > 0)
                <span class="badge rounded-pill bg-white text-dark ms-1" style="font-size: 10px; padding: 2px 5px;">
                  {{ $activeFiltersCount }}
                </span>
              @endif
            </button>

            {{-- Filter Popup Panel --}}
            <div 
              id="filterPopupPanel" 
              class="shadow-lg p-3 rounded-2"
              style="
                display: none;
                position: absolute;
                top: calc(100% + 8px);
                right: 0;
                width: 285px;
                max-width: 90vw;
                background: var(--card);
                border: 1px solid var(--line-strong);
                box-shadow: 0 10px 25px -5px rgba(23, 56, 34, 0.18);
                z-index: 1060;
              "
            >
              <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                <span class="fw-bold small" style="color: var(--ink-900); font-size: 13px;">Filter Transactions</span>
                <button type="button" class="btn btn-ghost p-0 border-0 text-muted" id="closeFilterPopupBtn" style="font-size: 18px; line-height: 1;">
                  &times;
                </button>
              </div>

              <div class="d-flex flex-column gap-3">
                {{-- Payment Method --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Method</label>
                  <select class="select w-100" name="method" style="font-size: 12.5px;">
                    <option value="">All Methods</option>
                    @foreach(['Cash', 'bKash', 'Nagad', 'Bank Transfer', 'Cheque'] as $m)
                      <option value="{{ $m }}" {{ request('method') === $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                  </select>
                </div>

                {{-- Date From --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Date From</label>
                  <input type="date" name="date_from" class="input w-100" value="{{ request('date_from') }}" style="font-size: 12.5px;">
                </div>

                {{-- Date To --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Date To</label>
                  <input type="date" name="date_to" class="input w-100" value="{{ request('date_to') }}" style="font-size: 12.5px;">
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
                      @foreach ($roads as $road)
                        <div 
                          class="road-opt {{ (string)request('road_number') === (string)$road->number ? 'active-road' : '' }}" 
                          data-val="{{ $road->number }}"
                          data-label="Road {{ $road->number }}"
                        >
                          Road {{ $road->number }}
                        </div>
                      @endforeach
                    </div>

                    <input type="hidden" name="road_number" id="roadHiddenValue" value="{{ request('road_number') }}">
                  </div>
                </div>

                {{-- Apply Filter Button --}}
                <div class="pt-2 border-top">
                  <button type="submit" class="btn btn-primary w-100 justify-content-center py-2 small" style="font-size: 13px;">
                    Apply Filters
                  </button>
                </div>
              </div>
            </div>
          </div>

          {{-- Search & Reset Buttons --}}
          <div class="d-flex align-items-center gap-1 flex-shrink-0">
            <button type="submit" class="btn btn-primary px-3" style="height: 38px;">Search</button>

            @if(request()->hasAny(['search', 'method', 'date_from', 'date_to', 'road_number']))
              <a href="{{ route('admin.payments.index') }}" class="btn btn-ghost px-2 text-danger" title="Clear all filters" style="height: 38px; line-height: 24px;">Reset</a>
            @endif
          </div>

        </div>
      </form>
    </div>

    {{-- Right: View Bills Quick Link --}}
    <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
      <a href="{{ route('admin.bills.index') }}" class="btn btn-primary d-flex d-md-inline-flex justify-content-center align-items-center gap-2 text-nowrap" style="height: 38px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="2" y="4" width="20" height="16" rx="2"></rect>
          <line x1="2" y1="10" x2="22" y2="10"></line>
        </svg>
        <span>Open Bills Register</span>
      </a>
    </div>

  </div>

  {{-- 2. Compact 5-Column Financial Overview Cards --}}
  <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-5 g-2 mb-3">
    
    {{-- Card 1: Total Realized --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Total Receipts
          </span>
          <span class="badge green px-1 py-0" style="font-size: 10px; line-height: 1.4;">Lifetime</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold" style="font-size: 16px; color: var(--forest-800);">
            ৳{{ number_format($stats['total_collected']) }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">collected</span>
        </div>
      </div>
    </div>

    {{-- Card 2: Today's Collection --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Today's Inflow
          </span>
          <span class="badge green px-1 py-0" style="font-size: 10px; line-height: 1.4;">Today</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold text-success" style="font-size: 16px;">
            ৳{{ number_format($stats['today_collected']) }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">24h</span>
        </div>
      </div>
    </div>

    {{-- Card 3: Cash In Hand --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Cash
          </span>
          <span class="badge gray px-1 py-0" style="font-size: 10px; line-height: 1.4;">In Hand</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold" style="font-size: 16px; color: var(--forest-800);">
            ৳{{ number_format($stats['cash_collected']) }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">counter</span>
        </div>
      </div>
    </div>

    {{-- Card 4: Digital MFS (bKash/Nagad) --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Digital MFS
          </span>
          <span class="badge green px-1 py-0" style="font-size: 10px; line-height: 1.4;">bKash/Nagad</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold" style="font-size: 16px; color: var(--forest-800);">
            ৳{{ number_format($stats['mfs_collected']) }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">gateway</span>
        </div>
      </div>
    </div>

    {{-- Card 5: Total Receipts Issued --}}
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);">
            Transactions
          </span>
          <span class="badge gray px-1 py-0" style="font-size: 10px; line-height: 1.4;">Slips</span>
        </div>
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          <span class="fw-bold" style="font-size: 16px; color: var(--ink-900);">
            {{ number_format($stats['total_count']) }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">slips issued</span>
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
            <th>Receipt &amp; Date</th>
            <th>Resident / Contact</th>
            <th>Bill Ref</th>
            <th>Method &amp; Trx</th>
            <th class="num">Amount</th>
            <th>Received By</th>
            <th class="text-end pe-3">Slip</th>
          </tr>
        </thead>
        <tbody>
          @forelse($payments as $payment)
          <tr>
            {{-- 1. Receipt & Date --}}
            <td>
              <div class="fw-bold font-monospace" style="color: var(--forest-900);">{{ $payment->payment_number }}</div>
              <span class="hint small" style="font-size: 11px;">{{ $payment->payment_date->format('d M Y') }} &bull; {{$payment->created_at->format('h:i A') }}</span>
            </td>

            {{-- 2. Holding & Resident --}}
            <td>
              <div class="fw-medium text-dark">{{ $payment->bill->plotAndUnit->name ?? '—' }}</div>
              <span class="hint small">{{ $payment->bill->plotAndUnit->phone ?? '—' }}</span>
            </td>

            {{-- 3. Bill Ref --}}
            <td>
              <div class="font-monospace small">{{ $payment->bill->bill_number ?? '—' }}</div>
              <span class="hint small" style="font-size: 10.5px;">Month: {{ $payment->bill->billing_month ?? '—' }}</span>
            </td>

            {{-- 4. Method & Trx --}}
            <td>
              <span class="fw-medium text-dark}">{{ $payment->method }}</span>
              <div class="font-monospace text-muted" style="font-size: 10.5px;">{{ $payment->transaction_ref ?: '—' }}</div>
            </td>

            {{-- 5. Amount --}}
            <td class="num">
              <span class="fw-bold text-success" style="font-size: 14px;">৳{{ number_format($payment->amount, 2) }}</span>
            </td>

            {{-- 6. Received By --}}
            <td>
              <div class="small fw-medium text-dark">{{ $payment->collector->name ?? 'System/Admin' }}</div>
              <span class="hint small" style="font-size: 10.5px;">Counter Officer</span>
            </td>

            {{-- 7. Action: Print / View Slip --}}
            <td class="text-end pe-3">
              <button 
                type="button" 
                class="btn btn-ghost btn-sm px-2 text-primary" 
                title="Print Money Receipt"
                onclick="showReceiptModal({
                  number: '{{ $payment->payment_number }}',
                  date: '{{ $payment->payment_date->format('d M Y') }}',
                  holding: '{{ $payment->bill->plotAndUnit->holding_no ?? '' }}',
                  road: '{{ $payment->bill->plotAndUnit->road->number ?? '' }}',
                  resident: '{{ $payment->bill->plotAndUnit->name ?? '' }}',
                  bill: '{{ $payment->bill->bill_number ?? '' }}',
                  month: '{{ $payment->bill->billing_month ?? '' }}',
                  method: '{{ $payment->method }}',
                  trx: '{{ $payment->transaction_ref ?? '-' }}',
                  amount: '{{ number_format($payment->amount, 2) }}',
                  collector: '{{ $payment->collector->name ?? 'Admin' }}'
                })"
              >
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="6 9 6 2 18 2 18 9"></polyline>
                  <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                  <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
              </button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              <div class="empty-note">No payment transactions found matching your filter criteria.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Clean Compact Pagination --}}
    @if($payments->hasPages())
    <div class="pagination-footer px-3 py-2 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
      <div class="hint small text-muted" style="font-size: 12px;">
        Showing <span class="fw-semibold text-dark">{{ $payments->firstItem() }}</span> to <span class="fw-semibold text-dark">{{ $payments->lastItem() }}</span> of <span class="fw-semibold text-dark">{{ $payments->total() }}</span> results
      </div>

      <div class="d-flex align-items-center gap-2">
        <span class="small text-muted" style="font-size: 12px;">
          Page <span class="fw-semibold text-dark">{{ $payments->currentPage() }}</span> of <span class="fw-semibold text-dark">{{ $payments->lastPage() }}</span>
        </span>

        <div class="btn-group">
          @if ($payments->onFirstPage())
            <button class="btn btn-ghost btn-sm px-2 py-1 border" disabled style="opacity: 0.5; font-size: 12px;">
              &lsaquo; Prev
            </button>
          @else
            <a href="{{ $payments->previousPageUrl() }}" class="btn btn-ghost btn-sm px-2 py-1 border text-dark" style="font-size: 12px;">
              &lsaquo; Prev
            </a>
          @endif

          @if ($payments->hasMorePages())
            <a href="{{ $payments->nextPageUrl() }}" class="btn btn-ghost btn-sm px-2 py-1 border text-dark" style="font-size: 12px;">
              Next &rsaquo;
            </a>
          @else
            <button class="btn btn-ghost btn-sm px-2 py-1 border" disabled style="opacity: 0.5; font-size: 12px;">
              Next &rsaquo;
            </button>
          @endif
        </div>
      </div>
    </div>
    @endif

  </div>

</section>

{{-- Printable Money Receipt Modal --}}
<div class="modal fade" id="receiptModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
    <div class="modal-content border shadow">
      <div class="modal-header py-2 px-3 border-bottom" style="background: var(--paper-100);">
        <h6 class="modal-title fw-bold" style="color: var(--forest-900);">Money Receipt / Slip</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4" id="printableSlip">
        {{-- Society Letterhead --}}
        <div class="text-center pb-3 border-bottom mb-3">
          <h5 class="fw-bold mb-0" style="color: var(--forest-900); font-family: var(--font-ledger);">Uttara Sector 3 Welfare Society</h5>
          <p class="hint small mb-1" style="font-size: 11px;">Sector-3, Uttara Model Town, Dhaka-1230</p>
          <span class="badge green px-2 py-1" style="font-size: 10px; text-transform: uppercase;">Official Money Receipt</span>
        </div>

        {{-- Meta Row --}}
        <div class="d-flex justify-content-between mb-2 small">
          <span class="text-muted">Receipt No: <strong class="text-dark font-monospace" id="slipNumber"></strong></span>
          <span class="text-muted">Date: <strong class="text-dark" id="slipDate"></strong></span>
        </div>

        <div class="card p-3 my-3" style="background: var(--paper-50); border: 1px dashed var(--line-strong);">
          <div class="d-flex justify-content-between mb-1 small">
            <span class="text-muted">Holding & Road:</span>
            <span class="fw-bold text-dark" id="slipHolding"></span>
          </div>
          <div class="d-flex justify-content-between mb-1 small">
            <span class="text-muted">Resident Name:</span>
            <span class="fw-medium text-dark" id="slipResident"></span>
          </div>
          <div class="d-flex justify-content-between mb-1 small">
            <span class="text-muted">Billing Cycle:</span>
            <span class="fw-medium text-dark" id="slipCycle"></span>
          </div>
          <div class="d-flex justify-content-between small">
            <span class="text-muted">Method / Trx:</span>
            <span class="font-monospace text-dark" id="slipMethodTrx"></span>
          </div>
        </div>

        {{-- Big Total Amount --}}
        <div class="d-flex justify-content-between align-items-center py-2 px-3 border rounded-2" style="background: var(--forest-50); border-color: var(--forest-100) !important;">
          <span class="fw-bold text-uppercase small" style="color: var(--forest-800);">Amount Paid:</span>
          <span class="fs-5 fw-bold" style="color: var(--forest-900);" id="slipAmount"></span>
        </div>

        {{-- Collector Footer --}}
        <div class="d-flex justify-content-between align-items-end mt-4 pt-3 border-top small text-muted">
          <div>
            <div>Collected By: <span class="fw-medium text-dark" id="slipCollector"></span></div>
            <div style="font-size: 9.5px;">This is a computer generated receipt.</div>
          </div>
          <div class="text-center">
            <div style="border-top: 1px dotted #888; width: 80px; padding-top: 2px; font-size: 10px;">Signature</div>
          </div>
        </div>
      </div>

      <div class="modal-footer py-2 px-3 border-top d-flex justify-content-between">
        <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="window.print()">
          <i class="bi bi-printer me-1"></i> Print Slip
        </button>
      </div>
    </div>
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

      // Road picker
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
    });

    // Populate and open money receipt
    function showReceiptModal(data) {
      document.getElementById('slipNumber').innerText = data.number;
      document.getElementById('slipDate').innerText = data.date;
      document.getElementById('slipHolding').innerText = `${data.holding} (Road ${data.road})`;
      document.getElementById('slipResident').innerText = data.resident;
      document.getElementById('slipCycle').innerText = `${data.month} (${data.bill})`;
      document.getElementById('slipMethodTrx').innerText = `${data.method} - ${data.trx}`;
      document.getElementById('slipAmount').innerText = `৳${data.amount}`;
      document.getElementById('slipCollector').innerText = data.collector;

      new bootstrap.Modal(document.getElementById('receiptModal')).show();
    }
  </script>
@endpush