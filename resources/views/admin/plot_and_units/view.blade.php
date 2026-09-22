@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-units">

  {{-- Centered Responsive Container --}}
  <div class="row justify-content-center py-2">
    <div class="col-12 col-xl-10">

      {{-- Header & Quick Actions --}}
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
          <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="m-0" style="font-family: var(--font-display); font-size: 24px; color: var(--ink-900);">
              {{ $plotAndUnit->building_name ?: 'Holding ' . $plotAndUnit->holding_no }}
            </h3>
            <span class="badge {{ $plotAndUnit->status === 'Active' ? 'green' : 'neutral' }}">
              <span class="dot"></span>
              {{ $plotAndUnit->status }}
            </span>
          </div>
          <span class="hint">
            UID: <code>{{ $plotAndUnit->unique_id }}</code> &bull; 
            Registered: {{ $plotAndUnit->created_at ? $plotAndUnit->created_at->format('d M, Y') : 'N/A' }}
          </span>
        </div>

        <div class="d-flex align-items-center gap-2">
          <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-ghost">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="19" y1="12" x2="5" y2="12"></line>
              <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to List
          </a>
          <a href="{{ route('admin.plot-and-units.edit', $plotAndUnit->id) }}" class="btn btn-primary px-3">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            Edit Record
          </a>
        </div>
      </div>

      {{-- ================= SECTION 1: PROPERTY IDENTITY ================= --}}
      <div class="card p-4 mb-4">
        <div class="card-head pb-2 mb-3 border-bottom">
          <div>
            <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">1. Property Identity &amp; Location</h4>
            <span class="hint small">Basic classification and address holding info</span>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-6 col-md-3">
            <span class="d-block hint small mb-1">Plot Type</span>
            <span class="badge neutral" style="font-size: 12.5px; font-weight: 500; color: var(--ink-900);">
              {{ $plotAndUnit->plotType?->name ?? 'N/A' }}
            </span>
          </div>

          <div class="col-6 col-md-3">
            <span class="d-block hint small mb-1">Road No.</span>
            <span class="fw-semibold" style="font-size: 13.5px; color: var(--ink-900);">
              Road {{ $plotAndUnit->road?->number ?? 'N/A' }}
            </span>
          </div>

          <div class="col-6 col-md-3">
            <span class="d-block hint small mb-1">Holding Number</span>
            <span class="fw-bold" style="font-family: var(--font-ledger); font-size: 14px; color: var(--ink-900);">
              {{ $plotAndUnit->holding_no }}
            </span>
          </div>

          <div class="col-6 col-md-3">
            <span class="d-block hint small mb-1">Building Name</span>
            <span class="fw-semibold" style="font-size: 13.5px; color: var(--ink-900);">
              {{ $plotAndUnit->building_name ?: '—' }}
            </span>
          </div>
        </div>
      </div>

      {{-- ================= SECTION 2: FLATS & OCCUPANCY ================= --}}
      <div class="card p-4 mb-4">
        <div class="card-head pb-2 mb-3 border-bottom">
          <div>
            <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">2. Flats &amp; Occupancy Configuration</h4>
            <span class="hint small">Capacity, active residents, and flat identifier tags</span>
          </div>
        </div>

        <div class="row g-4 align-items-start">
          <div class="col-12 col-md-8">
            <div class="row g-3">
              <div class="col-6 col-sm-4">
                <span class="d-block hint small mb-1">Total Flats</span>
                <span class="fw-bold" style="font-family: var(--font-ledger); font-size: 16px; color: var(--ink-900);">
                  {{ $plotAndUnit->total_flat }}
                </span>
              </div>

              <div class="col-6 col-sm-4">
                <span class="d-block hint small mb-1">Occupied Flats</span>
                <span class="fw-bold" style="font-family: var(--font-ledger); font-size: 16px; color: var(--forest-700);">
                  {{ $plotAndUnit->occupied_flat }}
                </span>
              </div>

              <div class="col-12 col-sm-4">
                <span class="d-block hint small mb-1">Collection Mode</span>
                <span class="badge neutral" style="font-size: 12px;">
                  {{ $plotAndUnit->collection_type ?? 'N/A' }}
                </span>
              </div>
            </div>

            {{-- Flat Tags List --}}
            <div class="mt-3 pt-3 border-top">
              <span class="d-block hint small mb-2">Registered Flat Units:</span>
              @if($plotAndUnit->flat_numbers)
                <div class="d-flex flex-wrap gap-1">
                  @foreach(explode(',', $plotAndUnit->flat_numbers) as $flat)
                    <span class="badge green" style="font-family: var(--font-ledger); font-size: 11px; padding: 3px 8px;">
                      {{ trim($flat) }}
                    </span>
                  @endforeach
                </div>
              @else
                <span class="text-muted small fst-italic">No individual flat tags registered.</span>
              @endif
            </div>
          </div>

          {{-- Occupancy Progress Ring / Bar --}}
          <div class="col-12 col-md-4">
            @php
              $total = (int) $plotAndUnit->total_flat;
              $occupied = (int) $plotAndUnit->occupied_flat;
              $percentage = $total > 0 ? min(round(($occupied / $total) * 100), 100) : 0;
            @endphp
            <div class="p-3 rounded-2" style="background: var(--paper-50); border: 1px solid var(--line);">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-semibold small" style="color: var(--ink-700);">Occupancy Ratio</span>
                <span class="fw-bold small" style="font-family: var(--font-ledger); color: var(--forest-800);">{{ $percentage }}%</span>
              </div>
              <div class="progress" style="height: 7px; background: var(--line);">
                <div class="progress-bar" style="width: {{ $percentage }}%; background: var(--forest-700);"></div>
              </div>
              <span class="d-block hint small mt-2" style="font-size: 11px;">
                {{ $occupied }} occupied out of {{ $total }} registered units
              </span>
            </div>
          </div>
        </div>
      </div>

      {{-- ================= SECTION 3: REPRESENTATIVE & BILLING ================= --}}
      <div class="row g-4 mb-4">

        {{-- Left: Contact Person Details --}}
        <div class="col-12 col-lg-6">
          <div class="card p-4 h-100">
            <div class="card-head pb-2 mb-3 border-bottom">
              <div>
                <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">3. Contact Representative</h4>
                <span class="hint small">Primary contact for society communication</span>
              </div>
            </div>

            <div class="d-flex flex-column gap-3">
              <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
                <span class="hint small">Full Name</span>
                <span class="fw-semibold text-end" style="color: var(--ink-900);">{{ $plotAndUnit->name }}</span>
              </div>

              <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
                <span class="hint small">Flat No.</span>
                <span class="fw-semibold text-end" style="font-family: var(--font-ledger); color: var(--ink-900);">
                  {{ $plotAndUnit->flat_no ?: '—' }}
                </span>
              </div>

              {{-- Phone with Copy Button --}}
                <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
                <span class="hint small">Phone</span>
                <div class="d-inline-flex align-items-center gap-2">
                    <a href="tel:{{ $plotAndUnit->phone }}" 
                    id="phoneValue" 
                    class="fw-semibold" 
                    style="font-family: var(--font-ledger); color: var(--forest-800); text-decoration: none;">
                    {{ $plotAndUnit->phone }}
                    </a>

                    <button type="button" 
                            class="btn btn-ghost p-0 border-0 text-muted" 
                            id="copyPhoneBtn" 
                            title="Copy phone number" 
                            onclick="copyPhoneNumber('{{ $plotAndUnit->phone }}')"
                            style="line-height: 1; cursor: pointer; transition: color 0.15s ease;">
                    {{-- Clipboard Icon --}}
                    <svg id="copyIcon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    {{-- Check Icon (Hidden by default) --}}
                    <svg id="checkIcon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--forest-700)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    </button>
                </div>
                </div>

              <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
                <span class="hint small">Email Address</span>
                <span class="fw-semibold text-end" style="color: var(--ink-900);">
                  {{ $plotAndUnit->email ?: '—' }}
                </span>
              </div>

              <div class="d-flex align-items-center justify-content-between py-1">
                <span class="hint small">Account Status</span>
                <span class="badge {{ $plotAndUnit->status === 'Active' ? 'green' : 'neutral' }}">
                  {{ $plotAndUnit->status }}
                </span>
              </div>
            </div>
          </div>
        </div>

        {{-- Right: Financial Ledger Card --}}
        <div class="col-12 col-lg-6">
          <div class="card p-4 h-100" style="background: var(--paper-100); border: 1px solid var(--line-strong);">
            <div class="card-head pb-2 mb-3 border-bottom">
              <div>
                <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">Fee Computation Breakdown</h4>
                <span class="hint small">Monthly society assessment charges</span>
              </div>
            </div>

            <div class="d-flex flex-column gap-3">
              <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
                <span class="hint small">Rate per Unit / Base Fee</span>
                <span class="fw-bold" style="font-family: var(--font-ledger); color: var(--ink-900);">
                  ৳{{ number_format($plotAndUnit->collection_rate, 2) }}
                </span>
              </div>

              <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
                <span class="hint small">Billed Units (Occupied / Fallback)</span>
                <span class="fw-bold" style="font-family: var(--font-ledger); color: var(--ink-900);">
                  &times; {{ (int) $plotAndUnit->occupied_flat > 0 ? (int) $plotAndUnit->occupied_flat : 1 }}
                </span>
              </div>

              <div class="d-flex align-items-center justify-content-between py-1 border-bottom">
                <span class="hint small">Special Discount</span>
                <span class="fw-bold" style="font-family: var(--font-ledger); color: var(--brick-600);">
                  - ৳{{ number_format($plotAndUnit->discount, 2) }}
                </span>
              </div>

              {{-- Total Collection Highlight --}}
              <div class="p-3 rounded-2 mt-2" style="background: var(--card); border: 1px solid var(--line);">
                <span class="d-block hint small text-uppercase mb-1" style="letter-spacing: .04em;">Total Collection Amount</span>
                <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger); font-size: 26px; font-weight: 700; color: var(--forest-800);">
                  <span>৳</span>
                  <span>{{ number_format($plotAndUnit->total_amount, 2) }}</span>
                </div>
                <span class="hint small" style="font-size: 11px;">Calculated recurring monthly assessment</span>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

</section>
@endsection

@push('scripts')
<script>
  function copyPhoneNumber(phone) {
    if (!navigator.clipboard) {
      // Fallback for non-HTTPS or older browsers
      const tempInput = document.createElement('textarea');
      tempInput.value = phone;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand('copy');
      document.body.removeChild(tempInput);
      showCopyFeedback();
      return;
    }

    navigator.clipboard.writeText(phone).then(() => {
      showCopyFeedback();
    }).catch(err => {
      console.error('Failed to copy: ', err);
    });
  }

  function showCopyFeedback() {
    const copyIcon = document.getElementById('copyIcon');
    const checkIcon = document.getElementById('checkIcon');
    const btn = document.getElementById('copyPhoneBtn');

    copyIcon.style.display = 'none';
    checkIcon.style.display = 'inline-block';
    btn.classList.add('text-success');

    setTimeout(() => {
      copyIcon.style.display = 'inline-block';
      checkIcon.style.display = 'none';
      btn.classList.remove('text-success');
    }, 1800);
  }
</script>
@endpush