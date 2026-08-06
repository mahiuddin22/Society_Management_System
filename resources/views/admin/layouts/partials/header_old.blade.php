<section id="header-section">
    <header id="header" class="header" style="display: flex; align-items: center; gap: 1rem">
        <!-- Left side: sidebar toggle + logo + welcome -->
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle"><i class="bi bi-list"></i></button>
            <div class="logo">Madrasah</div>
        </div>

        <!-- Center-right: notification + other icons group -->
        <div class="d-flex align-items-center gap-2" style="margin-left: auto; margin-right: 1rem">
            <!-- Welcome message next to toggle -->
            <span style="width: 800px" class="glow-icon text-start">Welcome, {{ auth()->user()->name }}</span>
            <!-- Notification dropdown -->
            <div class="dropdown">
                <button
                    class="btn btn-sm btn-outline-secondary position-relative glow-icon"
                    id="notificationToggle"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                </button>

                <ul class="dropdown-menu p-2" style="width: 250px">
                    <li><span class="dropdown-item-text">🔔 New student registered</span></li>
                    <li><span class="dropdown-item-text">📢 Exam schedule updated</span></li>
                    <li><span class="dropdown-item-text">📬 Message from admin</span></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item text-center" href="javascript:;">View All</a></li>
                </ul>
            </div>

            <!-- Other icons -->
            <a href="javascript:;" class="btn btn-sm btn-outline-secondary position-relative glow-icon" title="Messages">
                <i class="bi bi-envelope"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">5</span>
            </a>
            <a href="javascript:;" class="btn btn-sm btn-outline-secondary position-relative glow-icon" title="Tasks">
                <i class="bi bi-list-check"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span>
            </a>
            <a href="javascript:;" class="btn btn-sm btn-outline-secondary position-relative glow-icon" title="Alerts">
                <i class="bi bi-exclamation-triangle"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">1</span>
            </a>
        </div>

        <!-- Right side: dark mode toggle + profile -->
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-outline-secondary glow-icon" id="darkModeToggle" title="Toggle Dark Mode">
                <i class="bi bi-moon" id="darkIcon"></i>
            </button>
            <div class="profile-dropdown dropdown">
                <img src="{{asset('assets/images/noyon.jpg')}}" alt="Profile" data-bs-toggle="dropdown" aria-expanded="false" />
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item">Hi, {{ auth()->user()->name }}</span></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ route('profile') }}">My Account</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <span> Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</section>