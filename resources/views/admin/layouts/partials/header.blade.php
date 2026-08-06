@php
    $pageTitle = \Illuminate\Support\Str::headline($current_request ?: 'dashboard');
    $user = auth()->user();
@endphp

<header class="topbar">
    <button class="navbar-toggler mobile-menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Open navigation">
        <i class="bi bi-list fs-4" aria-hidden="true"></i>
    </button>

    <div class="page-heading">
        <div class="page-eyebrow">Administration</div>
        <div class="page-title">{{ $pageTitle }}</div>
    </div>

    <div class="daterange" id="dateRangeControl">
        <select class="select" id="rangePreset" style="border:none;">
            <option>Today</option>
            <option>This Week</option>
            <option selected>This Month</option>
            <option>This Year</option>
            <option value="custom">Custom range</option>
        </select>
        <div class="divider"></div>
        <input type="date" value="{{ now()->startOfMonth()->toDateString() }}" id="rangeFrom">
        <span class="sep">–</span>
        <input type="date" value="{{ now()->toDateString() }}" id="rangeTo">
        <button class="btn btn-primary btn-sm" id="applyRange" type="button">Apply</button>
    </div>

    <button class="btn btn-sm" type="button"><i class="bi bi-download"></i> Export</button>
    <button class="icon-btn" title="Notifications" type="button"><i class="bi bi-bell"></i><span class="badge">3</span></button>
    <div class="user-chip">
        <div class="avatar">{{ strtoupper(substr($user?->name ?? 'A', 0, 1)) }}</div>
        <div class="user-meta">
            <div class="name">{{ $user?->name ?? 'Administrator' }}</div>
            <div class="role">{{ $user?->role ?? 'Administrator' }}</div>
        </div>
    </div>
</header>
