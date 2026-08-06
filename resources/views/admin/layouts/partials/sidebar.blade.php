<aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title h5 mb-0" id="sidebarMenuLabel">Menu</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close menu"></button>
    </div>

    <div class="brand">
        <svg class="brand-mark" width="42" height="42" viewBox="0 0 42 42" aria-hidden="true">
            <circle cx="21" cy="21" r="20" fill="#2b6242" stroke="#0f2417" stroke-width="1" />
            <path d="M14 13 C 18 11, 24 12, 25 16 C 26 19, 22 20, 20 21 C 22 22, 26 23, 25 27 C 24 31, 18 32, 14 30" fill="none" stroke="#b8392c" stroke-width="3.2" stroke-linecap="round" />
            <text x="21" y="27" text-anchor="middle" font-family="Fraunces, serif" font-weight="600" font-size="13" fill="#ffffff">U3</text>
        </svg>
        <div class="brand-text">
            <div class="brand-title">Uttara Sector 3</div>
            <div class="brand-sub">Welfare Society · Office</div>
        </div>
    </div>

    <nav class="nav" aria-label="Main navigation">
        <div class="nav-group">
            <div class="nav-group-label">Overview</div>
            <a class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
        </div>

        <!-- <div class="nav-group">
            <div class="nav-group-label">People</div>
            <a class="nav-item" href="units.html" data-panel="units">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 21V9l9-6 9 6v12" /> <path d="M9 21v-8h6v8" />
                </svg>
                Buildings &amp; Units
            </a>
            <a class="nav-item" href="owners.html" data-panel="owners">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4" /> <path d="M4 21c1-4 5-6 8-6s7 2 8 6" />
                </svg>
                Owners
            </a>
            <a class="nav-item" href="tenants.html" data-panel="tenants">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="8" r="3.2" />
                    <circle cx="17" cy="9" r="2.6" />
                    <path d="M2.5 20c.7-3.3 3.6-5 6.5-5s5.8 1.7 6.5 5" />
                    <path d="M15 15.2c2.4.3 4.3 1.8 4.9 4.3" />
                </svg>
                Tenants
            </a>
            <a class="nav-item" href="lifemembers.html" data-panel="lifemembers">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 21s-7-4.4-9.5-8.8C.6 8.6 2.4 5 6 5c2 0 3.6 1.1 4.5 2.6C11.4 6.1 13 5 15 5c3.6 0 5.4 3.6 3.5 7.2C19 16.6 12 21 12 21z" />
                </svg>
                Life Members <span class="count">6</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-label">Finance</div>
            <a class="nav-item" href="subscriptions.html" data-panel="subscriptions">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="16" rx="2" />
                    <path d="M3 10h18M8 15h4" />
                </svg>
                Subscription &amp; Billing
            </a>
            <a class="nav-item" href="payments.html" data-panel="payments">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="6" width="20" height="13" rx="2" />
                    <path d="M2 10h20" />
                    <path d="M6 15h4" />
                </svg>
                Payments &amp; Collectors
            </a>
            <a class="nav-item" href="expense.html" data-panel="expense">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 21V8l9-5 9 5v13" />
                    <path d="M9 21v-6h6v6" />
                    <path d="M3 21h18" />
                </svg>
                Expense &amp; Inventory
            </a>
            <a class="nav-item" href="reports.html" data-panel="reports">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 20V10M12 20V4M20 20v-7" />
                </svg>
                Reports
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-label">Operations</div>
            <a class="nav-item" href="notices.html" data-panel="notices">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16v13H8l-4 4z" />
                    <path d="M8 9h8M8 13h5" />
                </svg>
                Notice Board
            </a>
            <a class="nav-item" href="complaints.html" data-panel="complaints">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 9v4M12 17h.01" />
                    <path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z" />
                </svg>
                Complaints <span class="count">4</span>
            </a>
            <a class="nav-item" href="events.html" data-panel="events">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="17" rx="2" />
                    <path d="M3 9h18M8 2v4M16 2v4" />
                </svg>
                Events
            </a>
        </div> -->

        @if (hasPermission('activities') || hasPermission('roles') || hasPermission('permissions'))
        <div class="nav-group">
            <div class="nav-group-label">Administration</div>
            @if (hasPermission('activities'))
            <a class="nav-item {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}" href="{{ route('admin.activities.index') }}"><i class="bi bi-activity"></i> Activities</a>
            @endif
            @if (hasPermission('roles'))
            <a class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}"><i class="bi bi-person-badge"></i> Roles</a>
            @endif
            @if (hasPermission('permissions'))
            <a class="nav-item {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}"><i class="bi bi-shield-check"></i> Permissions</a>
            @endif
        </div>
        @endif

        @if (auth()->user()?->role === 'admin')
        <div class="nav-group">
            <div class="nav-group-label">Access Control</div>
            <a class="nav-item {{ request()->routeIs('admin.role-permissions.*') ? 'active' : '' }}" href="{{ route('admin.role-permissions.index') }}"><i class="bi bi-diagram-3"></i> Role Permissions</a>
            <a class="nav-item {{ request()->routeIs('admin.user-permissions.*') ? 'active' : '' }}" href="{{ route('admin.user-permissions.index') }}"><i class="bi bi-person-gear"></i> User Permissions</a>
        </div>
        @endif

        <div class="nav-group">
            <div class="nav-group-label">Account</div>
            @if (hasPermission('my_profile'))
            <a class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}"><i class="bi bi-person-circle"></i> My Profile</a>
            @endif
        </div>
    </nav>

    <div class="sidebar-foot">
        <span class="role-pill"><span class="dot"></span> Signed in — {{ auth()->user()?->name ?? 'Admin' }}</span>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="nav-item w-100 border-0 text-start bg-transparent"><i class="bi bi-box-arrow-right"></i> Sign out</button>
        </form>
    </div>
</aside>