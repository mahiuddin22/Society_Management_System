@php
$pageTitle = \Illuminate\Support\Str::headline($current_request ?: 'dashboard');
$user = auth()->user();
@endphp
<header class="topbar">
    <button class="navbar-toggler mobile-menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Open navigation">
        <i class="bi bi-list fs-4" aria-hidden="true"></i>
    </button>

    <div class="page-heading">
        <!-- <div class="page-eyebrow">Administration</div> -->
        <div class="page-title">{{ $pageTitle }}</div>
    </div>

    <button class="icon-btn" title="Notifications" type="button"><i class="bi bi-bell"></i><span class="badge">3</span></button>

    <div class="dropdown user-dropdown">
        <div class="user-chip" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar">
                {{ strtoupper(substr($user?->username ?? 'A', 0, 1)) }}
            </div>

            <div class="user-meta">
                <div class="name">
                    {{ $user?->username ?? 'Administrator' }}
                </div>

                <div class="role">
                    {{ $user?->role ?? 'Administrator' }}
                </div>
            </div>
        </div>

        <ul class="dropdown-menu shadow">
            <li>
                <a class="nav-item text-dark py-2" href="{{ route('admin.profile') }}">
                    <i class="bi bi-person-circle me-2"></i>
                    Profile
                </a>
            </li>

            <li>
                <hr class="dropdown-divider" style="margin: 0 !important;">
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-danger py-2" style="background:none; border:none; cursor:pointer;">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>

    </div>
</header>