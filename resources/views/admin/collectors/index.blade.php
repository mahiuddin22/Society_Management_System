@extends('admin.layouts.app')

@section('content')
<!-- Filter Form -->
<form action="" method="GET" class="d-flex align-items-center gap-2 mb-3">

    <div class="search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
            <circle cx="11" cy="11" r="7" />
            <path d="m21 21-4.3-4.3" />
        </svg>
        <input class="input" name="search" value="{{ request('search') }}" placeholder="Search by name / email ">
    </div>

    <button type="submit" class="btn btn-primary">Filter</button>
    <a href="{{ route('admin.collectors.index') }}" class="btn btn-secondary">Reset</a>

</form>

<div class="section-row">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="hint">{{ $collectors->count() }} of {{ $collectors->total() }} collectors shown</span>
    </div>
    <div class="grid grid-3">
        @forelse($collectors as $user)
        <article class="stat-card" style="display:flex; flex-direction:column; justify-content:space-between; min-height:310px; padding:24px 22px;">
            <div>
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;">
                    <div style="width:46px; height:46px; border-radius:var(--radius-m); background:var(--forest-100); color:var(--forest-800); display:flex; align-items:center; justify-content:center; font-size:20px;">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <span class="badge green"><i class="dot"></i>{{ ucfirst($user->role) }}</span>
                </div>
                <h3 style="font-family:var(--font-display); font-size:20px; font-weight:600; color:var(--ink-900); margin:0 0 6px; line-height:1.3;">{{ $user->name }}</h3>
                <p class="hint" style="font-size:13px; margin:0;">{{ $user->email }}</p>

                <div style="background:var(--paper-100); border:1px solid var(--line); border-radius:var(--radius-m); padding:16px; margin-top:20px;">
                    <div class="hint" style="text-transform:uppercase; font-size:11px; font-weight:600; letter-spacing:.05em; margin-bottom:9px;">Assigned Roads</div>
                    @if($user->assignedRoads->isNotEmpty())
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($user->assignedRoads as $road)
                        <span class="badge neutral">{{ ctype_digit((string) $road->number) ? str_pad((string) $road->number, 2, '0', STR_PAD_LEFT) : $road->number }}</span>
                        @endforeach
                    </div>
                    @else
                    <span class="hint">No roads assigned</span>
                    @endif
                </div>
            </div>

            <footer style="display:flex; align-items:center; gap:8px; padding-top:16px; border-top:1px solid var(--line); margin-top:20px;">
                @if(hasPermission('collectors', 'assign'))
                <a href="{{ route('admin.collectors.assign.road', $user->id) }}" target="_blank" class="btn btn-primary btn-sm flex-fill">
                    <i class="bi bi-signpost-2 me-1"></i>Assign Road
                </a>
                @endif
                <a href="{{ route('admin.collectors.payment-history', $user->id) }}" class="btn btn-ghost btn-sm flex-fill" style="padding:10px 14px; border:1px solid var(--forest-200); border-radius:var(--radius-m); color:var(--forest-800); font-weight:600; background:var(--paper-50, #fff); box-shadow:0 2px 5px rgba(30,50,35,.06);">
                    <i class="bi bi-receipt me-1"></i>Details &amp; Payments
                </a>
            </footer>
        </article>
        @empty
        <div class="card" style="grid-column:1 / -1; text-align:center; padding:48px 20px;">
            <div class="empty-note">No collector data available.</div>
        </div>
        @endforelse
    </div>
    <div class="mt-3">{{ $collectors->links('pagination::bootstrap-5') }}</div>
</div>

@endsection
