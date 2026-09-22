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
  </style>
@endpush

@section('content')
<section class="panel active" id="panel-units">

  {{-- 1. Filter Bar & Actions Header --}}
  <div class="row align-items-center g-2 mb-4">
    
    {{-- Search & Filters Column (col-12 on mobile, col-md-8 on desktop) --}}
    <div class="col-12 col-md-8">
      <form action="{{ route('admin.plot-and-units.index') }}" method="GET" autocomplete="off" id="filterForm">
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
              placeholder="Search holding, resident, phone..."
            >
          </div>

          {{-- Active Filter Counter --}}
          @php
            $activeAdvancedFiltersCount = collect(['road_number', 'plot_type_id', 'collection_type', 'status'])
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

            {{-- Responsive Vertical Popup Panel --}}
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
                <span class="fw-bold small" style="color: var(--ink-900); font-size: 13px;">Filter Attributes</span>
                <button type="button" class="btn btn-ghost p-0 border-0 text-muted" id="closeFilterPopupBtn" style="font-size: 18px; line-height: 1;">
                  &times;
                </button>
              </div>

              <div class="d-flex flex-column gap-3">
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

                {{-- Plot Type --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Plot Type</label>
                  <select class="select w-100" name="plot_type_id" style="font-size: 12.5px;">
                    <option value="">All Plot Types</option>
                    @foreach ($plotTypes as $type)
                      <option value="{{ $type->id }}" {{ (string) request('plot_type_id') === (string) $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- Collection Mode --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Collection Mode</label>
                  <select class="select w-100" name="collection_type" style="font-size: 12.5px;">
                    <option value="">All Modes</option>
                    <option value="Group" {{ request('collection_type') === 'Group' ? 'selected' : '' }}>Group</option>
                    <option value="Individual" {{ request('collection_type') === 'Individual' ? 'selected' : '' }}>Individual</option>
                  </select>
                </div>

                {{-- Status --}}
                <div>
                  <label class="form-label fw-semibold small mb-1" style="font-size: 11.5px; color: var(--ink-800);">Status</label>
                  <select class="select w-100" name="status" style="font-size: 12.5px;">
                    <option value="">All Statuses</option>
                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>

                {{-- Apply Inside Popup --}}
                <div class="pt-2 border-top">
                  <button type="submit" class="btn btn-primary w-100 justify-content-center py-2 small" style="font-size: 13px;">
                    Apply Filters
                  </button>
                </div>
              </div>
            </div>
          </div>

          {{-- Action Buttons --}}
          <div class="d-flex align-items-center gap-1 flex-shrink-0">
            <button type="submit" class="btn btn-primary px-3" style="height: 38px;">Search</button>

            @if(request()->hasAny(['search', 'road_number', 'plot_type_id', 'collection_type', 'status']))
              <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-ghost px-2 text-danger" title="Clear all filters" style="height: 38px; line-height: 24px;">Reset</a>
            @endif
          </div>

        </div>
      </form>
    </div>

    {{-- Add Building Button (Full-width on mobile, right-aligned on desktop) --}}
    <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
      @if (hasPermission('plot_and_units', 'create'))
        {{-- After: 100% width on mobile, natural shrink-to-fit on desktop --}}
        <a href="{{ route('admin.plot-and-units.create') }}" class="btn btn-primary d-flex d-md-inline-flex justify-content-center align-items-center gap-2 text-nowrap" style="height: 38px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          <span>Add Building</span>
        </a>
      @endif
    </div>

  </div>

  {{-- 2. Compact Overview Metric Row (5 Types) --}}
  @if($plotTypes->isNotEmpty())
  <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-5 g-2 mb-3">
    @foreach($plotTypes as $type)
    <div class="col">
      <div class="card p-2 h-100 d-flex flex-column justify-content-between" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-s);">
        
        {{-- Label & Unit Count --}}
        <div class="d-flex align-items-center justify-content-between mb-1">
          <span class="fw-bold text-truncate" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-700);" title="{{ $type->name }}">
            {{ $type->name }}
          </span>
          <span class="badge green px-1 py-0" style="font-size: 10px; font-weight: 600; line-height: 1.4;">
            {{ $type->plot_and_units_count ?? 0 }}
          </span>
        </div>

        {{-- Fee Value --}}
        <div class="d-flex align-items-baseline gap-1" style="font-family: var(--font-ledger);">
          ৳
          <span class="fw-bold" style="font-size: 16px; color: var(--forest-800);">
            {{ number_format((float)($type->fees ?? $type->amount ?? 0)) }}
          </span>
          <span class="hint small" style="font-size: 10px; color: var(--ink-500);">/ unit</span>
        </div>

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
              <span class="hint small">Road - {{ $unit->road->number ?? 'N/A' }}</span>
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
              <span class="fw-medium text-dark">{{ number_format($unit->total_amount ?? 0) }} ৳</span>
              <div class="text-muted small" style="font-size: 10.5px;">{{ number_format($unit->collection_rate ?? 0) }} ৳</div>
            </td>

            {{-- Status --}}
            <td>
              @if($unit->status === 'Active')
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
      {{ $plotAndUnits->links('pagination::bootstrap-5') }}
    </div>
    @endif
  </div>

</section>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn   = document.getElementById('toggleFilterPopupBtn');
      const closeBtn    = document.getElementById('closeFilterPopupBtn');
      const popupPanel  = document.getElementById('filterPopupPanel');
      const wrapper     = document.getElementById('filterPopoverWrapper');

      // Toggle filter popup
      if (toggleBtn && popupPanel) {
        toggleBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          const isVisible = popupPanel.style.display === 'block';
          popupPanel.style.display = isVisible ? 'none' : 'block';
        });
      }

      // Close button inside popup
      if (closeBtn && popupPanel) {
        closeBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          popupPanel.style.display = 'none';
        });
      }

      // Close popup when clicking anywhere outside
      document.addEventListener('click', function (e) {
        if (popupPanel && !popupPanel.contains(e.target) && !toggleBtn.contains(e.target)) {
          popupPanel.style.display = 'none';
        }
      });

      // Close popup with Escape key
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && popupPanel) {
          popupPanel.style.display = 'none';
        }
      });

      // --- Road Picker Logic Inside Popup ---
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
  </script>
@endpush