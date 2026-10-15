@php
$pageTitle = isset($pageTitle) ? $pageTitle : \Illuminate\Support\Str::headline($current_request ?: 'dashboard');
$user = auth()->user();
@endphp
<style>
    .notification-dropdown {
        width: 380px;
        max-width: 90vw;
        padding: 0;
        border: 1px solid var(--line);
        border-radius: 12px;
        overflow: hidden;
        background: var(--card);
    }

    .notification-header {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 14px 16px;
        color: var(--ink-900);
        font-size: 14px;
    }

    .notification-item {
        display: flex;
        gap: 11px;
        align-items: center;
        padding: 12px 15px;
        white-space: normal;
        color: var(--ink-800);
        border-bottom: 1px solid var(--line);
        transition: background-color .15s ease;
    }

    .notification-item:hover,
    .notification-item:focus {
        background: var(--forest-50);
        color: var(--ink-900);
    }

    .notification-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        font-size: 14px;
    }

    .notification-copy {
        flex: 1;
        min-width: 0;
    }

    .notification-title {
        color: var(--ink-900);
        font-size: 12.5px;
        font-weight: 600;
        line-height: 1.35;
    }

    .notification-item.unseen .notification-title {
        display: flex !important;
        align-items: center;
        gap: 7px;
    }

    .notification-item.unseen .notification-title::before {
        content: '';
        width: 7px;
        height: 7px;
        flex: 0 0 7px;
        border-radius: 50%;
        background: var(--forest-700);
    }

    .notification-details {
        display: block;
        margin-top: 3px;
        color: var(--ink-500);
        font-size: 11px;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .notification-time {
        margin-top: 4px;
        color: var(--ink-500);
        font-size: 10px;
    }

    .notification-list {
        max-height: min(420px, 65vh);
        overflow-y: auto;
    }

    .notification-empty {
        padding: 24px 16px;
        color: var(--ink-500);
        text-align: center;
        font-size: 12px;
    }
    .icon-btn .badge {
        width: auto;
        min-width: 18px;
        height: 18px;
        padding: 0 4px;
        white-space: nowrap;
    }
</style>
<header class="topbar">
    <button class="navbar-toggler mobile-menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Open navigation">
        <i class="bi bi-list fs-4" aria-hidden="true"></i>
    </button>

    <div class="page-heading">
        <div class="page-title">{{ $pageTitle }}</div>
    </div>

    <div class="dropdown">
        <button class="icon-btn position-relative" title="Notifications" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
            <i class="bi bi-bell"></i>
            <span class="badge d-none" id="notificationCount">0</span>
        </button>

        <div class="dropdown-menu dropdown-menu-end shadow notification-dropdown" aria-labelledby="notificationDropdown">
            <div class="notification-header"><i class="bi bi-bell" aria-hidden="true"></i><strong>Notifications</strong></div>
            <hr class="dropdown-divider my-0">
            <ul id="notificationList" class="notification-list list-unstyled mb-0" aria-live="polite">
                <li class="notification-empty">Loading notifications…</li>
            </ul>
        </div>
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

<script>
    (() => {
        const list = document.getElementById('notificationList');
        const badge = document.getElementById('notificationCount');
        if (!list || !badge) return;
        let lastRenderedItems = '';
        let unseenCount = 0;
        const iconByType = {
            bill: ['bi-receipt', 'bg-success-subtle', 'text-success'],
            collection: ['bi-cash-coin', 'bg-primary-subtle', 'text-primary'],
            plot: ['bi-building', 'bg-warning-subtle', 'text-warning-emphasis']
        };

        function showNotifications(notifications) {
            const renderKey = JSON.stringify(notifications);
            if (renderKey === lastRenderedItems) return;
            lastRenderedItems = renderKey;
            list.replaceChildren();

            if (!notifications.length) {
                const empty = document.createElement('li');
                empty.className = 'notification-empty';
                empty.textContent = 'No recent activity.';
                list.appendChild(empty);
                return;
            }

            notifications.forEach((notification) => {
                const item = document.createElement('li');
                const link = document.createElement('a');
                link.className = 'dropdown-item notification-item';
                link.classList.toggle('unseen', notification.unseen);
                link.href = notification.url;

                const icon = document.createElement('span');
                icon.className = 'notification-icon';
                const glyph = document.createElement('i');
                const style = iconByType[notification.type] || iconByType.bill;
                icon.classList.add(style[1], style[2]);
                glyph.className = 'bi ' + style[0];
                icon.appendChild(glyph);

                const copy = document.createElement('span');
                copy.className = 'notification-copy';
                const title = document.createElement('span');
                title.className = 'notification-title d-block';
                title.textContent = notification.title;
                const details = document.createElement('span');
                details.className = 'notification-details';
                details.textContent = notification.details;
                const time = document.createElement('span');
                time.className = 'notification-time d-block';
                time.textContent = notification.time;

                copy.append(title, details, time);
                const arrow = document.createElement('i');
                arrow.className = 'bi bi-chevron-right text-muted small';
                link.append(icon, copy, arrow);
                if (notification.unseen) {
                    link.addEventListener('click', async (event) => {
                        event.preventDefault();
                        const destination = link.href;

                        try {
                            const response = await fetch("{{ route('admin.notifications.read') }}", {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                                },
                                body: JSON.stringify({ type: notification.type, id: notification.record_id })
                            });

                            if (response.ok) {
                                notification.unseen = false;
                                unseenCount = Math.max(0, unseenCount - 1);
                                badge.textContent = unseenCount > 9 ? '9+' : String(unseenCount);
                                badge.classList.toggle('d-none', unseenCount === 0);
                            }
                        } catch (error) {
                            // Continue to the notification's page if marking it read fails.
                        }

                        window.location.assign(destination);
                    });
                }
                item.appendChild(link);
                list.appendChild(item);
            });
        }

        async function loadNotifications() {
            try {
                const response = await fetch("{{ route('admin.notifications') }}", {
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store'
                });
                if (!response.ok) return;

                const data = await response.json();
                const notifications = data.notifications || [];
                showNotifications(notifications);
                unseenCount = Number(data.unseen_count || 0);
                badge.textContent = unseenCount > 9 ? '9+' : String(unseenCount);
                badge.classList.toggle('d-none', unseenCount === 0);
            } catch (error) {
                // Keep the header usable if a temporary network error occurs.
            }
        }

        loadNotifications();
        window.setInterval(loadNotifications, 15000);
    })();
</script>
