@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-units">

  {{-- Top Filter & Action Bar --}}
  <div class="filter-bar">
    <form action="" method="GET" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;" autocomplete="off">
      <div class="search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
          <circle cx="11" cy="11" r="7" />
          <path d="m21 21-4.3-4.3" />
        </svg>
        <input class="input" name="name" value="{{ request('name') }}" placeholder="Search plot type...">
      </div>

      <select class="select" name="filter_status">
        <option value="" selected>- All Status -</option>
        <option value="Active" {{ request('filter_status') == 'Active' ? 'selected' : '' }}>Active</option>
        <option value="Inactive" {{ request('filter_status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
      </select>

      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('admin.plot_type.index') }}" class="btn btn-ghost">Reset</a>
    </form>

    @if (hasPermission('plot_types', 'create'))
    <a href="{{ route('admin.plot_type.create') }}" class="btn btn-primary" style="margin-left:auto;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      Add Plot Type
    </a>
    @endif
  </div>

  {{-- Vertically Long Cards Grid --}}
  <div class="grid grid-3 section-row">
    @forelse($plot_types as $type)
    <div class="stat-card {{ $type->status == 'Active' ? '' : 'due' }}" 
         style="display: flex; flex-direction: column; justify-content: space-between; min-height: 350px; padding: 24px 22px;">
      
      {{-- Top Block: Icon, Status, Title, Description --}}
      <div>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
          <div style="width: 44px; height: 44px; border-radius: var(--radius-m); background: {{ $type->status == 'Active' ? 'var(--forest-100)' : 'var(--paper-100)' }}; color: {{ $type->status == 'Active' ? 'var(--forest-800)' : 'var(--ink-500)' }}; display: flex; align-items: center; justify-content: center;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="7" height="9" rx="1.5"/>
              <rect x="14" y="3" width="7" height="5" rx="1.5"/>
              <rect x="14" y="12" width="7" height="9" rx="1.5"/>
              <rect x="3" y="16" width="7" height="5" rx="1.5"/>
            </svg>
          </div>

          @if($type->status == 'Active')
            <span class="badge green"><i class="dot"></i>Active</span>
          @else
            <span class="badge neutral"><i class="dot"></i>Inactive</span>
          @endif
        </div>

        <h3 style="font-family: var(--font-display); font-size: 20px; font-weight: 600; color: var(--ink-900); margin: 0 0 6px 0; line-height: 1.3;">
          {{ $type->name }}
        </h3>
        
        <p class="hint" style="font-size: 12.5px; line-height: 1.5; margin: 0; color: var(--ink-500);">
          {{ $type->description ?? 'Standard plot category configuration.' }}
        </p>
      </div>

      {{-- Center Block: Prominent Rate Panel --}}
      <div style="background: var(--paper-100); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 18px; margin: 20px 0 0 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
          <span class="hint" style="text-transform: uppercase; font-size: 11px; font-weight: 600; letter-spacing: .05em;">
            Plot Fee
          </span>
          
        </div>
        <div class="value" style="margin-top: 0; color: {{ $type->status == 'Active' ? 'var(--forest-700)' : 'var(--ink-300)' }}; font-size: 28px;">
          <span class="sym" style="font-size: 18px;  color: {{ $type->status == 'Active' ? 'var(--forest-700)' : 'var(--ink-300)' }};">৳</span>{{ number_format((float)$type->fees, 2) }}
        </div>
      </div>

      {{-- Bottom Block: Actions Toolbar --}}
      <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 14px; border-top: 1px solid var(--line); margin-top: 18px;">
        
        @if (hasPermission('plot_types', 'edit'))
        <a href="{{ route('admin.plot_type.edit', $type->id) }}" class="btn btn-ghost btn-sm" title="Edit Plot Type">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
          </svg>
          Edit
        </a>
        @endif

        <div style="display: flex; align-items: center; gap: 4px;">
          @if (hasPermission('plot_types', 'change_status'))
          <form id="change-status-{{ $type->id }}" action="{{ route('admin.plot_type.change.status', $type->id) }}" method="POST" style="display:inline;" autocomplete="off">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-ghost btn-sm" title="Toggle Status" style="padding: 5px 8px;">
              @if($type->status == 'Active')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--forest-700)" stroke-width="2">
                  <rect x="1" y="5" width="22" height="14" rx="7" fill="var(--forest-100)"/>
                  <circle cx="16" cy="12" r="4" fill="var(--forest-700)"/>
                </svg>
              @else
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--ink-300)" stroke-width="2">
                  <rect x="1" y="5" width="22" height="14" rx="7" fill="var(--paper-100)"/>
                  <circle cx="8" cy="12" r="4" fill="var(--ink-500)"/>
                </svg>
              @endif
            </button>
          </form>
          @endif

          @if (hasPermission('plot_types', 'delete'))
          <form action="{{ route('admin.plot_type.destroy', $type->id) }}" method="POST" id="delete-form-{{ $type->id }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-ghost btn-sm" style="color: var(--brick-600); padding: 5px 8px;" title="Delete" onclick="return confirm('Are you sure you want to delete this plot type?')">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              </svg>
            </button>
          </form>
          @endif
        </div>

      </div>

    </div>
    @empty
    <div class="card" style="grid-column: 1 / -1; text-align:center; padding: 48px 20px;">
      <div class="empty-note">No plot types found matching your criteria.</div>
    </div>
    @endforelse
  </div>

</section>
@endsection