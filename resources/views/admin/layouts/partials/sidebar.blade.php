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
        <!-- Collection -->
        @if(hasPermission('plot_and_units') || hasPermission('upload_members'))
        <div class="nav-group">
            <div class="nav-group-label">People</div>
            @if (hasPermission('plot_and_units'))
            @php $plot_activity = request()->routeIs('admin.plot-and-units.index') || request()->routeIs('admin.plot-and-units.create') || request()->routeIs('admin.plot-and-units.edit') @endphp
            <a class="nav-item {{ $plot_activity ? 'active' : '' }}" href="{{ route('admin.plot-and-units.index') }}" data-panel="units">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 21V9l9-6 9 6v12" />
                    <path d="M9 21v-8h6v8" />
                </svg>
                Plot &amp; Units
            </a>
            @endif
            @if (hasPermission('upload_members'))
            <a class="nav-item {{ request()->routeIs('admin.plot-and-units.bulk-upload*') ? 'active' : '' }}" href="{{ route('admin.plot-and-units.bulk-upload') }}" data-panel="members">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="6" width="20" height="13" rx="2" />
                    <path d="M2 10h20" />
                    <path d="M6 15h4" />
                </svg>
                Upload Members
            </a>
            @endif

        </div>
        @endif

        <!-- Member Payment Managaments -->
        @if(hasPermission('my_payments') || hasPermission('payments_report'))
        <div class="nav-group">
            <div class="nav-group-label">Payment Management</div>

            @if (hasPermission('my_payments'))
            <a class="nav-item {{ request()->routeIs('member.mypayment') ? 'active' : '' }}" href="{{ route('member.mypayment') }}" data-panel="units">
                <i class="bi bi-wallet2"></i>
                My Payments
            </a>
            @endif

            @if (hasPermission('payments_report'))
            <a class="nav-item {{ request()->routeIs('member.paymentreport') ? 'active' : '' }}" href="{{ route('member.paymentreport') }}" data-panel="members">
                <i class="bi bi-file-earmark-bar-graph"></i>
                Payment Report
            </a>
            @endif
        </div>
        @endif

        <!-- Collection Management -->
        @if(hasPermission('collections') || hasPermission('Collectors'))
        <div class="nav-group">
            <div class="nav-group-label">Collection Management</div>
            @if(hasPermission('collections'))
            <a class="nav-item {{ request()->routeIs('admin.collection.*') ? 'active' : '' }}" href="{{ route('admin.collection.index') }}" data-panel="payments">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="6" width="20" height="13" rx="2" />
                    <path d="M2 10h20" />
                    <path d="M6 15h4" />
                </svg>
                Collections
            </a>
            @endif
            @if(hasPermission('collectors'))
            <a class="nav-item {{ request()->routeIs('admin.collectors.*') ? 'active' : '' }}" href="{{ route('admin.collectors.index') }}" data-panel="owners">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 21c1-4 5-6 8-6s7 2 8 6" />
                </svg>
                Collectors
            </a>
            @endif
        </div>
        @endif

        @if (hasPermission('activities') || hasPermission('roles') || hasPermission('permissions'))
        <div class="nav-group">
            <div class="nav-group-label">Administration</div>
            @if (hasPermission('activities'))
            <a class="nav-item {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}" href="{{ route('admin.activities.index') }}"><i class="bi bi-activity"></i> Activities</a>
            @endif
            @if (hasPermission('roles'))
            <a class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}"><i class="bi bi-person-badge"></i> Roles</a>
            @endif
            @if (hasPermission('roads'))
            <a class="nav-item {{ request()->routeIs('admin.roads.*') ? 'active' : '' }}" href="{{ route('admin.roads.index') }}"><i class="bi bi-signpost-2"></i> Roads</a>
            @endif
            @if (hasPermission('users'))
            <a class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-person"></i> Users</a>
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

        @if(hasPermission('plot_types') || hasPermission('site_settings'))
        <div class="nav-group">
            <div class="nav-group-label">Settings</div>
            @if(hasPermission('plot_types'))
            <a class="nav-item {{ request()->routeIs('admin.type.*') ? 'active' : '' }}" href="{{ route('admin.type.index') }}"><i class="bi bi-person-circle"></i> Plot Types</a>
            @endif
            @if(hasPermission('site_settings'))
            <a class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}"><i class="bi bi-person-circle"></i> Site Settings</a>
            @endif
        </div>
        @endif
    </nav>

    <div class="sidebar-foot">
        <span class="role-pill"><span class="dot"></span> Signed in — {{ auth()->user()?->name ?? 'Admin' }}</span>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="nav-item w-100 border-0 text-start bg-transparent"><i class="bi bi-box-arrow-right"></i> Sign out</button>
        </form>
    </div>
</aside>