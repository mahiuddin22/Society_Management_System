@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-roads">

  {{-- Filter & Add Road Header --}}
  <div class="filter-bar d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <form action="" method="GET" class="d-flex align-items-center flex-wrap gap-2 m-0" autocomplete="off">
      <div class="search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
          <circle cx="11" cy="11" r="7" />
          <path d="m21 21-4.3-4.3" />
        </svg>
        <input class="input" name="search" value="{{ request('search') }}" placeholder="Search road...">
      </div>

      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('admin.roads.index') }}" class="btn btn-ghost">Reset</a>
    </form>

    @if(hasPermission('roads', 'create'))
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      Add Road
    </button>
    @endif
  </div>

  {{-- 3-Column Road Grid --}}
  <div class="grid grid-3 section-row">
    @forelse ($roads as $road)
    <div class="card p-3 d-flex flex-row align-items-center justify-content-between shadow-sm">
      
      {{-- Road Info & Serial --}}
      <div class="d-flex align-items-center gap-3">
        <div style="width: 38px; height: 38px; border-radius: var(--radius-m); background: var(--forest-100); color: var(--forest-800); display: flex; align-items: center; justify-content: center; font-family: var(--font-ledger); font-weight: 600; font-size: 13px;">
          {{ str_pad($roads->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}
        </div>
        <div>
          <h4 class="m-0 fw-bold text-dark" style="font-size: 15px;">Road - {{ $road->number ?? $road->name }}</h4>
          <span class="hint small">Sector 3</span>
        </div>
      </div>

      {{-- Action Buttons --}}
      @if(hasPermission('roads', 'edit') || hasPermission('roads', 'delete'))
      <div class="d-inline-flex align-items-center gap-1">
        @if(hasPermission('roads', 'edit'))
        <a href="{{ route('admin.roads.edit', $road->id) }}" class="btn btn-ghost btn-sm px-2" title="Edit Road">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
          </svg>
        </a>
        @endif

        @if(hasPermission('roads', 'delete') && $road->name != 'admin')
        <form action="{{ route('admin.roads.destroy', $road->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this road?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-ghost btn-sm px-2 text-danger" title="Delete Road">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
          </button>
        </form>
        @endif
      </div>
      @endif

    </div>
    @empty
    <div class="card p-4 text-center text-muted" style="grid-column: 1 / -1;">
      <div class="empty-note">No roads found matching your query.</div>
    </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  @if(method_exists($roads, 'hasPages') && $roads->hasPages())
  <div class="d-flex justify-content-end mt-3">
    {{ $roads->withQueryString()->links('pagination::bootstrap-5') }}
  </div>
  @endif

</section>

{{-- Modal --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
    <div class="modal-content" style="border-radius: var(--radius-l); border: 1px solid var(--line); box-shadow: var(--shadow-2); background: var(--card);">
      
      <div class="modal-header border-bottom py-3 px-4" style="background: var(--paper-100); border-radius: var(--radius-l) var(--radius-l) 0 0;">
        <h5 class="modal-title m-0" id="createModalLabel" style="font-family: var(--font-display); font-size: 18px; color: var(--ink-900);">
          Add New Road
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="createUserForm" action="{{ route('admin.roads.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="modal-body p-4">
          <div>
            <label for="name" class="form-label fw-semibold small mb-1">
              Road Number <span class="text-danger">*</span>
            </label>
            <input 
              type="text" 
              id="name" 
              name="name" 
              class="input w-100" 
              placeholder="e.g. 05 or 12/A" 
              required 
            />
          </div>
        </div>

        <div class="modal-footer border-top px-4 py-3 d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary px-3">Save Road</button>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection