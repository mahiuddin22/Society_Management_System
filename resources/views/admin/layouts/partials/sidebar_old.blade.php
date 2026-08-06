<!-- ========== Sidebar Navigation ========== -->
<section id="sidebar-section">
    <nav class="sidebar d-flex flex-column p-2" id="sidebar">

        <!-- Dashboard Menu -->
        <a href="{{url('/admin/dashboard')}}" class="nav-link mb-2 {{$current_request == 'dashboard' ? 'active' : ''}} glow-icon"> <i class="bi bi-house"></i><span> Dashboard</span> </a>

        <!-- Users Menu -->
        <a href="javascript:;" class="nav-link mb-2 glow-icon"> <i class="bi bi-person"></i><span> Administrative Users</span> </a>

        <!-- Settings Menu -->
        @if(hasPermission('site_settings') || hasPermission('forms'))
        <a href="javascript:;" class="nav-link mb-2 toggle-submenu collapsed glow-icon" data-bs-toggle="submenu">
            <i class="bi bi-gear"></i><span> Settings Managements</span>
            <i class="fa fa-angle-up submenu-arrow up-icon" style="display: none"></i>
        </a>
        <ul class="submenu">
            @if(hasPermission('site_settings'))
            <li><a href="javascript:;" class="nav-link active">Datatable</a></li>
            @endif
            @if(hasPermission('forms'))
            <li><a href="javascript:;" class="nav-link">Forms</a></li>
            @endif
        </ul>
        @endif

        @if(hasPermission('posts'))
        <!-- Preferences Menu -->
        <a href="javascript:;" class="nav-link mb-2 toggle-submenu collapsed glow-icon" data-bs-toggle="submenu">
            <i class="bi bi-sliders"></i><span> Preferences</span>
            <i class="fa fa-angle-up submenu-arrow up-icon" style="display: none"></i>
        </a>
        <ul class="submenu">
            <li><a href="javascript:;" class="nav-link">Themes</a></li>
            <li><a href="javascript:;" class="nav-link">Notifications</a></li>
        </ul>
        @endif

        @if(hasPermission('reports'))
        <!-- Reports Menu -->
        <a href="javascript:;" class="nav-link mb-2 glow-icon"> <i class="bi bi-bar-chart"></i><span> Reports</span> </a>
        @endif

        <?php $isActive = in_array($current_request, ['permissions', 'role-permissions', 'user-permissions', 'activities', 'roles']); ?>

        <!-- Access Control Menu -->
        <a href="javascript:;" class="nav-link mb-2 toggle-submenu {{ $isActive ? 'active' : 'collapsed' }} glow-icon" data-bs-toggle="submenu">
            <i class="bi bi-tools"></i><span> Access Control Managements</span>
            <i class="fa fa-angle-up submenu-arrow up-icon" style="display: none"></i>
        </a>

        <ul class="submenu {{ $isActive ? 'show' : '' }}" data-menu-key="access_control">
            @if(hasPermission('permissions'))
            <li>
                <a href="{{ route('permissions.index') }}" class="nav-link {{ $current_request == 'permissions' ? 'active' : '' }}">
                    Permissions
                </a>
            </li>
            @endif
            <li>
                <a href="{{ route('activities.index') }}" class="nav-link {{ $current_request == 'activities' ? 'active' : '' }}">
                    Activities
                </a>
            </li>

            <li>
                <a href="{{ route('roles.index') }}" class="nav-link {{ $current_request == 'roles' ? 'active' : '' }}">
                    Roles
                </a>
            </li>

            <li>
                <a href="{{ route('role-permissions.index') }}" class="nav-link {{ $current_request == 'role-permissions' ? 'active' : '' }}">
                    Role wise Permission
                </a>
            </li>

            <li>
                <a href="{{ route('user-permissions.index') }}" class="nav-link {{ $current_request == 'user-permissions' ? 'active' : '' }}">
                    User Wise Permission
                </a>
            </li>

        </ul>

        <!-- <a href="#" class="nav-link mt-auto glow-icon"> <i class="bi bi-box-arrow-right"></i><span> Logout</span> </a> -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a type="submit" onclick="event.preventDefault();
                    this.closest('form').submit();" class="nav-link mb-2 glow-icon">
                <i class="bi bi-box-arrow-right"></i>
                <span> Logout</span>
            </a>
        </form>
    </nav>
</section>