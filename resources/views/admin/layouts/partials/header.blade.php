@php
$pageTitle = isset($pageTitle) ? $pageTitle : \Illuminate\Support\Str::headline($current_request ?: 'dashboard');
$user = auth()->user();
@endphp
<style>
    .notification-dropdown {
        width: 350px;
        max-width: 90vw;
        padding: 0;
        border: 0;
        border-radius: 10px;
        overflow: hidden;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
    }

    .notification-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 12px 16px;
        white-space: normal;
    }

    .notification-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .notification-time {
        font-size: 11px;
        color: #999;
        margin-top: 3px;
    }
</style>
<header class="topbar">
    <button class="navbar-toggler mobile-menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Open navigation">
        <i class="bi bi-list fs-4" aria-hidden="true"></i>
    </button>

    <div class="page-heading">
        <div class="page-title">{{ $pageTitle }}</div>
    </div>

    <!-- <button class="icon-btn" title="Notifications" type="button"><i class="bi bi-bell"></i><span class="badge">3</span></button> -->

    <div class="dropdown">
        <button class="icon-btn position-relative" title="Notifications" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bell"></i>
            <span class="badge">3</span>
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow notification-dropdown"
            aria-labelledby="notificationDropdown">

            <li>
                <div class="notification-header">
                    <strong>New Connections</strong>
                </div>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a href="#" class="dropdown-item notification-item">
                    <div class="notification-icon bg-primary-subtle text-primary">
                        <i class="bi bi-person-plus"></i>
                    </div>

                    <div>
                        <div class="fw-semibold">New Connection Request</div>
                        <small class="text-muted">
                            John Doe wants to connect with you.
                        </small>
                        <div class="notification-time">5 minutes ago</div>
                    </div>
                </a>
            </li>

            <li>
                <a href="#" class="dropdown-item notification-item">
                    <div class="notification-icon bg-primary-subtle text-primary">
                        <i class="bi bi-person-plus"></i>
                    </div>

                    <div>
                        <div class="fw-semibold">New Connection Request</div>
                        <small class="text-muted">
                            Sarah Smith wants to connect with you.
                        </small>
                        <div class="notification-time">1 hour ago</div>
                    </div>
                </a>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a href="#" class="dropdown-item text-center text-primary small">
                    View All Connections
                </a>
            </li>

        </ul>
    </div>

    <div class="dropdown user-dropdown">
        <div class="user-chip" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar">
                {{ strtoupper(substr($user?->username ?? 'A', 0, 1)) }}
            </div>

            <div class="user-meta">
                <div class="name">
                    {{ $user?->name ?? 'Administrator' }}
                </div>

                <div class="role">
                    {{ $user?->role ?? 'Administrator' }}
                </div>
            </div>
        </div>

        <ul class="dropdown-menu shadow">
            <!-- <li>
                <a class="nav-item text-dark py-2" href="{{ route('admin.profile') }}">
                    <i class="bi bi-person-circle me-2"></i>
                    Profile
                </a>
            </li> -->

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