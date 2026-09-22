@extends('admin.layouts.app')

@push('styles')
<style>
    .form-check-input:checked {
        background-color: var(--forest-800) !important;
        border-color: var(--forest-800) !important;
    }

    .form-check-input:focus {
        border-color: var(--forest-700);
        box-shadow: 0 0 0 0.25rem rgba(27, 67, 50, 0.2);
    }
</style>
@endpush

@section('content')
<section class="panel active" id="panel-units">

  {{-- Centered Responsive Form Shell --}}
  <div class="row justify-content-center py-2">
    <div class="col-12 col-xl-10">

      <form action="{{ route('admin.plot-and-units.update', $plotAndUnit->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        {{-- Top Title & Actions Bar --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
          <div>
            <h3 class="mb-1" style="font-family: var(--font-display); font-size: 22px; color: var(--ink-900);">
              Edit Building / Unit
            </h3>
            <span class="hint">Holding: <strong>{{ $plotAndUnit->holding_no }}</strong> &bull; UID: <code>{{ $plotAndUnit->unique_id }}</code></span>
          </div>

          {{-- Desktop Only Top Action Buttons --}}
          <div class="d-none d-md-flex align-items-center gap-2">
            <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary px-4">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
              </svg>
              Update Building
            </button>
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
            {{-- Plot Type --}}
            <div class="col-12 col-md-6 col-lg-3">
              <label for="plot_type" class="form-label fw-semibold small mb-1">
                Plot Type <span class="text-danger">*</span>
              </label>
              <select class="select w-100" id="plot_type" name="plot_type" required>
                <option value="" disabled>Select Type</option>
                @foreach($plotTypes as $type)
                  <option 
                    value="{{ $type->id }}" 
                    data-fee="{{ $type->fees }}" 
                    data-slug="{{ $type->slug }}"
                    {{ (string) old('plot_type', $plotAndUnit->plot_type_id) === (string)$type->id ? 'selected' : '' }}
                  >
                    {{ $type->name }} (৳{{ $type->fees }})
                  </option>
                @endforeach
              </select>
            </div>

            {{-- Road --}}
            <div class="col-12 col-md-6 col-lg-3">
              <label for="road" class="form-label fw-semibold small mb-1">
                Road <span class="text-danger">*</span>
              </label>
              <select class="select w-100" id="road" name="road" required>
                <option value="" disabled>Select Road</option>
                @foreach($roads as $road)
                  <option 
                    value="{{ $road->id }}" 
                    {{ (string) old('road', $plotAndUnit->road_id) === (string)$road->id ? 'selected' : '' }}
                  >
                    Road {{ $road->number }}
                  </option>
                @endforeach
              </select>
            </div>

            {{-- Holding No --}}
            <div class="col-12 col-md-6 col-lg-3">
              <label for="holding_no" class="form-label fw-semibold small mb-1">
                Holding No. <span class="text-danger">*</span>
              </label>
              <input type="text" class="input w-100" id="holding_no" name="holding_no" value="{{ old('holding_no', $plotAndUnit->holding_no) }}" placeholder="e.g. 2/A" required>
            </div>

            {{-- Building Name --}}
            <div class="col-12 col-md-6 col-lg-3" id="BuildingNameGroup">
              <label for="building_name" class="form-label fw-semibold small mb-1">
                Building Name
              </label>
              <input type="text" class="input w-100" id="building_name" name="building_name" value="{{ old('building_name', $plotAndUnit->building_name) }}" placeholder="e.g. Sunrise Villa">
            </div>
          </div>
        </div>

        {{-- ================= SECTION 2: FLATS & OCCUPANCY ================= --}}
        <div class="card p-4 mb-4">
          <div class="card-head pb-2 mb-3 border-bottom">
            <div>
              <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">2. Flats &amp; Occupancy</h4>
              <span class="hint small">Unit configuration, flat identifiers, and billing model</span>
            </div>
          </div>

          <div class="row g-3">
            {{-- Total Flat --}}
            <div class="col-12 col-md-4" id="totalFlatGroup">
              <label for="total_flat" class="form-label fw-semibold small mb-1">
                Total Flats <span class="text-danger flat-required-star">*</span>
              </label>
              <input type="number" class="input w-100" id="total_flat" name="total_flat" min="0" value="{{ old('total_flat', $plotAndUnit->total_flat) }}" placeholder="e.g. 12" required>
            </div>

            {{-- Occupied Flat --}}
            <div class="col-12 col-md-4" id="occupiedFlatGroup">
              <label for="occupied_flat" class="form-label fw-semibold small mb-1">
                Occupied Flats <span class="text-danger flat-required-star">*</span>
              </label>
              <input type="number" class="input w-100" id="occupied_flat" name="occupied_flat" min="0" value="{{ old('occupied_flat', $plotAndUnit->occupied_flat) }}" placeholder="e.g. 10" required>
            </div>

            {{-- Collection Type --}}
            <div class="col-12 col-md-4" id="collectionTypeGroup">
              <label for="collection_type" class="form-label fw-semibold small mb-1">
                Collection Mode <span class="text-danger">*</span>
              </label>
              <select class="select w-100" id="collection_type" name="collection_type" required>
                <option value="">Select Mode</option>
                <option value="Group" {{ old('collection_type', $plotAndUnit->collection_type) == 'Group' ? 'selected' : '' }}>Group</option>
                <option value="Individual" {{ old('collection_type', $plotAndUnit->collection_type) == 'Individual' ? 'selected' : '' }}>Individual</option>
              </select>
            </div>

            {{-- Multiple Flat Numbers Tag Input (Standard 38px height) --}}
            <div class="col-12" id="flatNumbersGroup">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label fw-semibold small mb-0">
                  Flat Numbers / Units
                </label>
              </div>

              <div class="input w-100 d-flex align-items-center gap-1 overflow-x-auto" 
                   id="flatBadgeContainer"
                   style="height: 38px; padding: 3px 8px; cursor: text; white-space: nowrap;">
                
                {{-- Tags will render here --}}

                <input 
                  type="text" 
                  id="flatInput" 
                  class="border-0 p-0 flex-grow-1" 
                  placeholder="e.g. 1A, 2B, 3C..." 
                  style="outline: none; font-family: var(--font-ledger); font-size: 12.5px; min-width: 120px; height: 100%; background: transparent; color: var(--ink-900);"
                >
              </div>

              <input type="hidden" name="flat_numbers" id="hiddenFlatNumbers" value="{{ old('flat_numbers', $plotAndUnit->flat_numbers) }}">
              
              @error('flat_numbers')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        {{-- ================= SECTION 3: CONTACT & BILLING CALCULATOR ================= --}}
        <div class="row g-4 mb-4">

          {{-- Left: Contact Person --}}
          <div class="col-12 col-lg-7">
            <div class="card p-4 h-100">
              <div class="card-head pb-2 mb-3 border-bottom">
                <div>
                  <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">3. Contact Representative</h4>
                  <span class="hint small">Primary contact for notices &amp; billing</span>
                </div>
              </div>

              <div class="row g-3">
                {{-- Contact Person Flat No --}}
                <div class="col-12 col-sm-6" id="personFlatNo">
                  <label for="person_flat_no" class="form-label fw-semibold small mb-1">Flat No</label>
                  <input type="text" class="input w-100 flat-no" name="flat_no" id="person_flat_no" value="{{ old('flat_no', $plotAndUnit->flat_no) }}" placeholder="e.g. 4B">
                </div>

                {{-- Contact Name --}}
                <div class="col-12 col-sm-6" id="personName">
                  <label for="person_name" class="form-label fw-semibold small mb-1">Contact Name <span class="text-danger">*</span></label>
                  <input type="text" class="input w-100" name="name" id="person_name" value="{{ old('name', $plotAndUnit->name) }}" placeholder="Full Name" required>
                </div>

                {{-- Phone --}}
                <div class="col-12 col-sm-6" id="personNumber">
                  <label for="phone" class="form-label fw-semibold small mb-1">Phone <span class="text-danger">*</span></label>
                  <input type="text" class="input w-100" name="phone" id="phone" value="{{ old('phone', $plotAndUnit->phone) }}" placeholder="01XXXXXXXXX" required>
                </div>

                {{-- Email --}}
                <div class="col-12 col-sm-6" id="personEmail">
                  <label for="person_email" class="form-label fw-semibold small mb-1">Email</label>
                  <input type="email" class="input w-100" name="email" id="person_email" value="{{ old('email', $plotAndUnit->email) }}" placeholder="email@domain.com">
                </div>

                {{-- Status --}}
                <div class="col-12 pt-2">
                  <label for="status" class="form-label fw-semibold small mb-1">Status <span class="text-danger">*</span></label>
                  <select class="select w-100" id="status" name="status" required>
                    <option value="Active" {{ old('status', $plotAndUnit->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', $plotAndUnit->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          {{-- Right: Financial Calculation Ledger Panel --}}
          @php
            $currentPlotFee = $rates[$plotAndUnit->plot_type_id] ?? 0;
            $hasCustomRate  = old('custom_rate_toggle') || ((float) $plotAndUnit->collection_rate != (float)$currentPlotFee);
          @endphp

          <div class="col-12 col-lg-5">
            <div class="card p-4 h-100" style="background: var(--paper-100); border: 1px solid var(--line-strong);">
              <div class="card-head pb-2 mb-3 border-bottom">
                <div>
                  <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">Fee Computation</h4>
                  <span class="hint small">Default plot rate or custom override</span>
                </div>
              </div>

              <div class="d-flex flex-column gap-3">
                {{-- Collection Rate --}}
                <div id="collectionRateGroup">
                  <div class="d-flex align-items-center justify-content-between mb-1">
                    <label for="collection_rate" class="form-label fw-semibold small mb-0">
                      Rate per Unit (৳) <span class="text-danger">*</span>
                    </label>
                    
                    {{-- Custom Rate Toggle Checkbox --}}
                    <label class="d-inline-flex align-items-center gap-1 small text-muted" style="cursor: pointer; font-size: 11px;">
                      <input 
                        type="checkbox" 
                        id="custom_rate_toggle" 
                        name="custom_rate_toggle"
                        value="1"
                        style="accent-color: var(--forest-800); width: 14px; height: 14px; cursor: pointer;"
                        {{ $hasCustomRate ? 'checked' : '' }}
                      >
                      <span class="user-select-none">Custom Rate</span>
                    </label>
                  </div>

                  <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted fw-bold">৳</span>
                    <input 
                      type="number" 
                      class="input w-100 ps-5" 
                      id="collection_rate" 
                      name="collection_rate" 
                      min="0" 
                      step="0.01" 
                      value="{{ old('collection_rate', $plotAndUnit->collection_rate) }}" 
                      placeholder="0.00" 
                      {{ $hasCustomRate ? '' : 'readonly' }}
                      style="{{ $hasCustomRate ? 'background: var(--card);' : 'background: var(--paper-50); cursor: not-allowed;' }}"
                      required
                    >
                  </div>
                  <span class="hint small" id="rateHint" style="font-size: 10.5px;">
                    {{ $hasCustomRate ? 'Custom rate active — overrides Plot Type fee' : 'Auto-applied from selected Plot Type' }}
                  </span>
                </div>

                {{-- Discount --}}
                <div id="discountGroup">
                  <label for="discount" class="form-label fw-semibold small mb-1">
                    Special Discount
                  </label>
                  <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted fw-bold">৳</span>
                    <input type="number" class="input w-100 ps-5" id="discount" name="discount" min="0" step="0.01" value="{{ old('discount', $plotAndUnit->discount) }}" placeholder="0.00">
                  </div>
                </div>

                {{-- Final Collection Amount Highlight --}}
                <div id="collectionAmountGroup" class="pt-2">
                  <label for="collection_amount" class="form-label fw-semibold small mb-1 text-uppercase" style="letter-spacing: .04em;">
                    Total Collection Amount <span class="text-danger">*</span>
                  </label>
                  <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 fw-bold" style="color: var(--forest-800); font-size: 18px;">৳</span>
                    <input type="number" class="input w-100 ps-5 fw-bold" id="collection_amount" name="collection_amount" min="0" step="0.01" value="{{ old('collection_amount', $plotAndUnit->total_amount) }}" placeholder="0.00" style="font-family: var(--font-ledger); font-size: 20px; color: var(--forest-800); background: var(--card);" required>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        {{-- Mobile Actions Bar (Mobile Only) --}}
        <div class="d-flex d-md-none flex-column gap-2 mt-4 pt-2">
          <button type="submit" class="btn btn-primary w-100 justify-content-center py-2" style="font-size: 14px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
              <polyline points="17 21 17 13 7 13 7 21"></polyline>
              <polyline points="7 3 7 8 15 8"></polyline>
            </svg>
            Update Building
          </button>
          
          <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-ghost w-100 justify-content-center py-2 text-muted">
            Cancel
          </a>
        </div>

      </form>

    </div>
  </div>

</section>
@endsection

@push('scripts')
{{-- 1. Flat Numbers Tag Manager --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('flatBadgeContainer');
    const input = document.getElementById('flatInput');
    const hiddenInput = document.getElementById('hiddenFlatNumbers');

    let flats = hiddenInput.value ? hiddenInput.value.split(',').filter(Boolean) : [];

    function renderTags() {
      container.querySelectorAll('.flat-tag').forEach(tag => tag.remove());

      if (flats.length > 0) {
        input.placeholder = '';
      } else {
        input.placeholder = 'e.g. 1A, 2B, 3C...';
      }

      flats.forEach((flat, index) => {
        const tag = document.createElement('span');
        tag.className = 'flat-tag badge green d-inline-flex align-items-center gap-1';
        tag.style.fontSize = '11px';
        tag.style.fontFamily = 'var(--font-ledger)';
        tag.style.padding = '2px 6px';
        tag.style.lineHeight = '1.2';
        tag.style.flexShrink = '0';
        tag.innerHTML = `
          <span>${flat}</span>
          <button type="button" class="btn btn-ghost p-0 border-0 text-danger ms-1" style="line-height:1; font-size:12px;" data-index="${index}">
            &times;
          </button>
        `;

        tag.querySelector('button').addEventListener('click', (e) => {
          e.stopPropagation();
          flats.splice(index, 1);
          syncAndRender();
          input.focus();
        });

        container.insertBefore(tag, input);
      });
    }

    function syncAndRender() {
      hiddenInput.value = flats.join(',');
      renderTags();
    }

    function addFlat(val) {
      const cleaned = val.trim().replace(/,/g, '').toUpperCase();
      if (cleaned && !flats.includes(cleaned)) {
        flats.push(cleaned);
        syncAndRender();
      }
      input.value = '';
    }

    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();
        addFlat(this.value);
      } else if (e.key === 'Backspace' && !this.value && flats.length > 0) {
        flats.pop();
        syncAndRender();
      }
    });

    input.addEventListener('blur', function () {
      if (this.value) {
        addFlat(this.value);
      }
    });

    container.addEventListener('click', () => input.focus());
    renderTags();
  });
</script>

{{-- 2. Calculation Engine & Dynamic Validation Toggle (by Slug) --}}
<script>
  const rates = @json($rates);

  const plotTypeSelect     = document.getElementById('plot_type');
  const collectionRate     = document.getElementById('collection_rate');
  const customRateToggle   = document.getElementById('custom_rate_toggle');
  const rateHint           = document.getElementById('rateHint');
  const totalFlat          = document.getElementById('total_flat');
  const occupiedFlat       = document.getElementById('occupied_flat');
  const discount           = document.getElementById('discount');
  const collectionAmount   = document.getElementById('collection_amount');
  const flatRequiredStars  = document.querySelectorAll('.flat-required-star');

  const exemptSlugs = ['under-construction', 'land'];

  function updateFlatRequirements() {
    const selectedOption = plotTypeSelect.options[plotTypeSelect.selectedIndex];
    const slug = selectedOption ? selectedOption.getAttribute('data-slug') : '';
    const isExempt = exemptSlugs.includes(slug);

    if (isExempt) {
      totalFlat.removeAttribute('required');
      occupiedFlat.removeAttribute('required');
      flatRequiredStars.forEach(el => el.style.display = 'none');
    } else {
      totalFlat.setAttribute('required', 'required');
      occupiedFlat.setAttribute('required', 'required');
      flatRequiredStars.forEach(el => el.style.display = 'inline');
    }
  }

  function getEffectiveRate() {
    if (customRateToggle.checked) {
      return parseFloat(collectionRate.value) || 0;
    }
    const selectedOption = plotTypeSelect.options[plotTypeSelect.selectedIndex];
    const defaultFee = selectedOption ? selectedOption.getAttribute('data-fee') : null;
    return parseFloat(defaultFee !== null ? defaultFee : (rates[plotTypeSelect.value] || 0));
  }

  function calculateCollectionAmount() {
    const rate          = getEffectiveRate();
    const occupiedCount = parseInt(occupiedFlat.value, 10) || 0;
    const discountVal   = parseFloat(discount.value) || 0;

    // Fallback to 1 unit if vacant or under construction (0 occupied flats)
    const billingUnits = occupiedCount > 0 ? occupiedCount : 1;

    const grossTotal = rate * billingUnits;
    const netTotal   = Math.max(grossTotal - discountVal, 0);

    collectionAmount.value = netTotal.toFixed(2);
  }

  customRateToggle.addEventListener('change', function() {
    if (this.checked) {
      collectionRate.removeAttribute('readonly');
      collectionRate.style.background = 'var(--card)';
      collectionRate.style.cursor = 'text';
      rateHint.textContent = 'Custom rate active — overrides Plot Type fee';
      collectionRate.focus();
    } else {
      collectionRate.setAttribute('readonly', true);
      collectionRate.style.background = 'var(--paper-50)';
      collectionRate.style.cursor = 'not-allowed';
      rateHint.textContent = 'Auto-applied from selected Plot Type';

      const defaultFee = rates[plotTypeSelect.value] || 0;
      collectionRate.value = defaultFee;
    }
    calculateCollectionAmount();
  });

  plotTypeSelect.addEventListener('change', function() {
    updateFlatRequirements();

    if (!customRateToggle.checked) {
      const selectedOption = this.options[this.selectedIndex];
      const fee = selectedOption ? selectedOption.getAttribute('data-fee') : (rates[this.value] || 0);
      collectionRate.value = fee || 0;
    }

    calculateCollectionAmount();
  });

  occupiedFlat.addEventListener('input', calculateCollectionAmount);
  discount.addEventListener('input', calculateCollectionAmount);
  collectionRate.addEventListener('input', function() {
    if (customRateToggle.checked) {
      calculateCollectionAmount();
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    if (plotTypeSelect.value) {
      updateFlatRequirements();
    }
  });
</script>
@endpush