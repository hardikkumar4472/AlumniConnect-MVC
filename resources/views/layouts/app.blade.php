<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GEC Alumni Association</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=4">
    @yield('styles')
    <style>
    .notif-wrap {
        position: relative;
    }

    .notif-trigger {
        width: 40px; height: 40px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        color: #475569;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .notif-trigger:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #0047ab;
    }
    .notif-trigger.has-notif {
        animation: bellRing 2.5s ease infinite;
    }
    @keyframes bellRing {
        0%,100% { transform: rotate(0deg); }
        10%      { transform: rotate(12deg); }
        20%      { transform: rotate(-10deg); }
        30%      { transform: rotate(8deg); }
        40%      { transform: rotate(-6deg); }
        50%      { transform: rotate(0deg); }
    }

    .notif-badge {
        position: absolute;
        top: -4px; right: -4px;
        background: #f43f5e;
        color: white;
        font-size: 0.6rem;
        font-weight: 800;
        min-width: 18px; height: 18px;
        border-radius: 99px;
        display: flex; align-items: center; justify-content: center;
        padding: 0 4px;
        border: 2px solid white;
        display: none;
    }
    .notif-badge.visible { display: flex; }

    /* Dropdown */
    .notif-dropdown {
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        width: 380px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.05);
        z-index: 9999;
        display: none;
        overflow: hidden;
        animation: dropIn 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .notif-dropdown.open { display: block; }

    @keyframes dropIn {
        from { opacity: 0; transform: translateY(-10px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .notif-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.1rem 1.25rem 0.85rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .notif-header h4 {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .notif-count-pill {
        background: #f43f5e;
        color: white;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 99px;
    }
    .notif-mark-read {
        font-size: 0.72rem;
        color: #3b82f6;
        font-weight: 700;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        font-family: 'Outfit', sans-serif;
        transition: color 0.2s;
    }
    .notif-mark-read:hover { color: #0047ab; text-decoration: underline; }

    /* Tabs */
    .notif-tabs {
        display: flex;
        padding: 0.6rem 1.25rem 0;
        gap: 0.25rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .notif-tab {
        padding: 0.45rem 0.85rem;
        font-size: 0.73rem;
        font-weight: 700;
        color: #94a3b8;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        transition: all 0.15s;
        border-radius: 0;
        background: none;
        border-left: none; border-right: none; border-top: none;
        font-family: 'Outfit', sans-serif;
    }
    .notif-tab.active { color: #0047ab; border-bottom-color: #0047ab; }
    .notif-tab:hover  { color: #374151; }

    /* List */
    .notif-list {
        max-height: 360px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #e2e8f0 transparent;
    }
    .notif-list::-webkit-scrollbar { width: 4px; }
    .notif-list::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

    .notif-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.9rem 1.25rem;
        border-bottom: 1px solid #f8fafc;
        text-decoration: none;
        color: inherit;
        transition: background 0.15s;
        cursor: pointer;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: #f8fafc; }
    .notif-item.unread { background: #fafbff; }

    .notif-icon-wrap {
        width: 38px; height: 38px;
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .notif-text { flex: 1; min-width: 0; }
    .notif-text strong {
        display: block;
        font-size: 0.82rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.35;
        margin-bottom: 0.2rem;
    }
    .notif-text span {
        display: block;
        font-size: 0.72rem;
        color: #64748b;
        line-height: 1.4;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .notif-time {
        font-size: 0.65rem;
        color: #94a3b8;
        white-space: nowrap;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .notif-unread-dot {
        width: 7px; height: 7px;
        background: #f43f5e;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 6px;
    }

    /* Loading / Empty */
    .notif-loading {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; padding: 2.5rem 1rem;
        color: #94a3b8; text-align: center;
    }
    .notif-spinner {
        width: 28px; height: 28px;
        border: 3px solid #e2e8f0;
        border-top-color: #0047ab;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
        margin-bottom: 0.75rem;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .notif-footer {
        padding: 0.75rem 1.25rem;
        border-top: 1px solid #f1f5f9;
        text-align: center;
    }
    .notif-footer a {
        font-size: 0.78rem;
        font-weight: 700;
        color: #3b82f6;
        text-decoration: none;
    }
    .notif-footer a:hover { text-decoration: underline; }

    /* type chips for tabs */
    .notif-type-filter { display: flex; gap: 0.5rem; padding: 0.6rem 1.25rem; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap; }
    .type-chip {
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.68rem;
        font-weight: 700;
        cursor: pointer;
        border: 1.5px solid #e2e8f0;
        background: white;
        color: #64748b;
        transition: all 0.15s;
        font-family: 'Outfit', sans-serif;
    }
    .type-chip.active, .type-chip:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #0047ab;
    }

    @media (max-width: 480px) {
        .notif-dropdown { width: calc(100vw - 2rem); right: -80px; }
    }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="GEC Logo">
            <div class="logo-text">
                <h1>GEC ALUMNI</h1>
                <p>Association Platform</p>
            </div>
        </div>
        
        <nav class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('directory') }}" class="nav-item {{ request()->routeIs('directory') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Alumni Directory</span>
            </a>
            <a href="{{ route('network') }}" class="nav-item {{ request()->routeIs('network') ? 'active' : '' }}">
                <i class="fa-solid fa-network-wired"></i>
                <span>Networking Hub</span>
            </a>
            <a href="{{ route('jobs') }}" class="nav-item {{ request()->routeIs('jobs') ? 'active' : '' }}">
                <i class="fa-solid fa-briefcase"></i>
                <span>Job Portal</span>
            </a>
            <a href="{{ route('events') }}" class="nav-item {{ request()->routeIs('events') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Events & Reunions</span>
            </a>
            <a href="{{ route('donations') }}" class="nav-item {{ request()->routeIs('donations') ? 'active' : '' }}">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <span>Donations</span>
            </a>

            <a href="{{ route('stories') }}" class="nav-item {{ request()->routeIs('stories') ? 'active' : '' }}">
                <i class="fa-solid fa-star"></i>
                <span>Success Stories</span>
            </a>

            @if(Auth::user()->role == 'student')
            <a href="{{ route('feedback') }}" class="nav-item {{ request()->routeIs('feedback') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Student Support</span>
            </a>
            @else
            <a href="{{ route('feedback') }}" class="nav-item {{ request()->routeIs('feedback') ? 'active' : '' }}">
                <i class="fa-solid fa-comments"></i>
                <span>Feedback & Surveys</span>
            </a>
            @endif
            <a href="{{ route('resources') }}" class="nav-item {{ request()->routeIs('resources') ? 'active' : '' }}">
                <i class="fa-solid fa-book"></i>
                <span>Resources</span>
            </a>
            @if(Auth::user()->role == 'admin')
            <div style="margin: 2rem 0 1rem; padding-left: 1rem; font-size: 0.7rem; font-weight: 800; color: #718096; text-transform: uppercase; letter-spacing: 1.5px;">Administration</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" style="background: rgba(255,255,255,0.05);">
                <i class="fa-solid fa-gauge-high" style="color: var(--accent);"></i>
                <span style="color: var(--accent);">Admin Panel</span>
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}" style="padding-left: 2rem; font-size: 0.8rem;">
                <i class="fa-solid fa-user-gear"></i>
                <span>Manage Users</span>
            </a>
            <a href="{{ route('admin.jobs') }}" class="nav-item {{ request()->routeIs('admin.jobs') ? 'active' : '' }}" style="padding-left: 2rem; font-size: 0.8rem;">
                <i class="fa-solid fa-briefcase"></i>
                <span>Manage Jobs</span>
            </a>
            <a href="{{ route('admin.events') }}" class="nav-item {{ request()->routeIs('admin.events') ? 'active' : '' }}" style="padding-left: 2rem; font-size: 0.8rem;">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Manage Events</span>
            </a>
            <a href="{{ route('admin.news') }}" class="nav-item {{ request()->routeIs('admin.news') ? 'active' : '' }}" style="padding-left: 2rem; font-size: 0.8rem;">
                <i class="fa-solid fa-newspaper"></i>
                <span>Manage News</span>
            </a>
            <a href="{{ route('admin.feedback') }}" class="nav-item {{ request()->routeIs('admin.feedback') ? 'active' : '' }}" style="padding-left: 2rem; font-size: 0.8rem;">
                <i class="fa-solid fa-message"></i>
                <span>View Feedback</span>
            </a>
            <a href="{{ route('admin.donations') }}" class="nav-item {{ request()->routeIs('admin.donations') ? 'active' : '' }}" style="padding-left: 2rem; font-size: 0.8rem;">
                <i class="fa-solid fa-hand-holding-heart" style="{{ request()->routeIs('admin.donations') ? '' : 'color: #f59e0b;' }}"></i>
                <span>Donation Tracker</span>
            </a>
            @endif
        </nav>
    </aside>

    <!-- Sidebar Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <main class="main-content" id="main-content">
        <header class="main-header">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button class="toggle-sidebar" id="sidebar-toggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search alumni, jobs, events...">
                </div>
            </div>
            
            <div class="header-actions">

                {{-- ═══ NOTIFICATION BELL ═══ --}}
                <div class="notif-wrap" id="notifWrap">
                    <button class="notif-trigger" id="notifTrigger" aria-label="Notifications">
                        <i class="fa-solid fa-bell"></i>
                        <span class="notif-badge" id="notifBadge"></span>
                    </button>

                    <div class="notif-dropdown" id="notifDropdown">
                        {{-- Header --}}
                        <div class="notif-header">
                            <h4>
                                <i class="fa-solid fa-bell" style="color:#0047ab; font-size:0.85rem;"></i>
                                Notifications
                                <span class="notif-count-pill" id="notifCountPill" style="display:none;"></span>
                            </h4>
                            <button class="notif-mark-read" id="markReadBtn" onclick="markAllRead()">
                                Mark all read
                            </button>
                        </div>

                        {{-- Filter chips --}}
                        <div class="notif-type-filter" id="notifFilters">
                            <button class="type-chip active" data-filter="all" onclick="filterNotifs(this,'all')">All</button>
                            <button class="type-chip" data-filter="connection_request" onclick="filterNotifs(this,'connection_request')">
                                <i class="fa-solid fa-user-plus" style="margin-right:3px;"></i>Requests
                            </button>
                            <button class="type-chip" data-filter="message" onclick="filterNotifs(this,'message')">
                                <i class="fa-solid fa-envelope" style="margin-right:3px;"></i>Messages
                            </button>
                            <button class="type-chip" data-filter="event" onclick="filterNotifs(this,'event')">
                                <i class="fa-solid fa-calendar" style="margin-right:3px;"></i>Events
                            </button>
                            <button class="type-chip" data-filter="donation" onclick="filterNotifs(this,'donation')">
                                <i class="fa-solid fa-heart" style="margin-right:3px;"></i>Donations
                            </button>
                        </div>

                        {{-- List --}}
                        <div class="notif-list" id="notifList">
                            <div class="notif-loading" id="notifLoading">
                                <div class="notif-spinner"></div>
                                <p style="font-size:0.82rem;">Loading notifications…</p>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="notif-footer">
                            <a href="{{ route('network') }}">View connection requests →</a>
                        </div>
                    </div>
                </div>
                {{-- ═══ END NOTIFICATION BELL ═══ --}}
                
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="Avatar" class="user-avatar">
                    <div class="user-info">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>{{ ucfirst(Auth::user()->role) }} '{{ Auth::user()->graduation_year ?? '25' }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:#a0aec0; cursor:pointer; margin-left:10px;">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="content-body" style="min-height: 80vh; padding: 2rem;">
            @yield('content')
        </div>
    </main>

    @yield('scripts')
    <script>
    // ════════════════════════════════════════════
    //  Sidebar Toggle
    // ════════════════════════════════════════════
    const sidebarToggle  = document.getElementById('sidebar-toggle');
    const sidebar        = document.querySelector('.sidebar');
    const mainContent    = document.getElementById('main-content');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
        } else {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
    }
    sidebarToggle.addEventListener('click', toggleSidebar);
    sidebarOverlay.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
        }
    });
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
        }
    });

    // ════════════════════════════════════════════
    //  Notification System
    // ════════════════════════════════════════════
    const notifTrigger  = document.getElementById('notifTrigger');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifBadge    = document.getElementById('notifBadge');
    const notifCountPill= document.getElementById('notifCountPill');
    const notifList     = document.getElementById('notifList');
    const notifLoading  = document.getElementById('notifLoading');

    let allNotifications = [];
    let activeFilter     = 'all';
    let dropdownOpen     = false;

    // Type metadata
    const typeConfig = {
        connection_request: { label: 'Connection Request', icon: 'fa-user-plus',      color: '#3b82f6', bg: '#eff6ff' },
        message:            { label: 'Message',            icon: 'fa-envelope',        color: '#8b5cf6', bg: '#fdf4ff' },
        event:              { label: 'New Event',          icon: 'fa-calendar-days',   color: '#0047ab', bg: '#eff6ff' },
        donation:           { label: 'Donation',           icon: 'fa-heart',           color: '#f43f5e', bg: '#fff1f2' },
        news:               { label: 'Campus News',        icon: 'fa-newspaper',       color: '#f59e0b', bg: '#fffbeb' },
        job:                { label: 'New Job',            icon: 'fa-briefcase',       color: '#f97316', bg: '#fff7ed' },
    };

    // ── Toggle dropdown ──────────────────────────
    notifTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownOpen = !dropdownOpen;
        notifDropdown.classList.toggle('open', dropdownOpen);
        if (dropdownOpen) fetchNotifications();
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        if (!document.getElementById('notifWrap').contains(e.target)) {
            dropdownOpen = false;
            notifDropdown.classList.remove('open');
        }
    });

    // ── Fetch from API ────────────────────────────
    async function fetchNotifications() {
        notifLoading.style.display = 'flex';
        notifList.querySelectorAll('.notif-item').forEach(el => el.remove());

        try {
            const res  = await fetch('{{ route("notifications") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const data = await res.json();
            allNotifications = data.notifications || [];
            updateBadge(data.unread || 0);
            renderNotifications(allNotifications);
        } catch (err) {
            renderError();
        } finally {
            notifLoading.style.display = 'none';
        }
    }

    // ── Render list ───────────────────────────────
    function renderNotifications(items) {
        // Remove old items
        notifList.querySelectorAll('.notif-item, .notif-empty').forEach(el => el.remove());

        const filtered = activeFilter === 'all'
            ? items
            : items.filter(n => n.type === activeFilter);

        if (filtered.length === 0) {
            notifList.insertAdjacentHTML('beforeend', `
                <div class="notif-empty" style="text-align:center;padding:2.5rem 1rem;color:#94a3b8;">
                    <i class="fa-solid fa-bell-slash" style="font-size:2rem;margin-bottom:0.75rem;display:block;opacity:0.4;"></i>
                    <p style="font-size:0.82rem;">No notifications here yet.</p>
                </div>`);
            return;
        }

        filtered.forEach(n => {
            const cfg = typeConfig[n.type] || { icon: 'fa-bell', color: '#64748b', bg: '#f8fafc' };
            const html = `
            <a href="${n.link || '#'}" class="notif-item ${n.read ? '' : 'unread'}" data-type="${n.type}">
                <div class="notif-icon-wrap" style="background:${n.bg || cfg.bg}; color:${n.color || cfg.color};">
                    <i class="fa-solid ${n.icon || cfg.icon}"></i>
                </div>
                <div class="notif-text">
                    <strong>${escHtml(n.title)}</strong>
                    <span>${escHtml(n.body || '')}</span>
                </div>
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0;">
                    <span class="notif-time">${n.time_human || ''}</span>
                    ${!n.read ? '<span class="notif-unread-dot"></span>' : ''}
                </div>
            </a>`;
            notifList.insertAdjacentHTML('beforeend', html);
        });
    }

    // ── Filter by type ────────────────────────────
    function filterNotifs(el, type) {
        activeFilter = type;
        document.querySelectorAll('.type-chip').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
        renderNotifications(allNotifications);
    }

    // ── Update badge ──────────────────────────────
    function updateBadge(count) {
        if (count > 0) {
            notifBadge.textContent  = count > 99 ? '99+' : count;
            notifBadge.classList.add('visible');
            notifTrigger.classList.add('has-notif');
            notifCountPill.textContent = count;
            notifCountPill.style.display = 'inline-flex';
        } else {
            notifBadge.classList.remove('visible');
            notifTrigger.classList.remove('has-notif');
            notifCountPill.style.display = 'none';
        }
    }

    // ── Mark all read ─────────────────────────────
    async function markAllRead() {
        try {
            await fetch('{{ route("notifications.markRead") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            });
            allNotifications = allNotifications.map(n => ({ ...n, read: true }));
            renderNotifications(allNotifications);
            updateBadge(0);
        } catch(e) {}
    }

    // ── Error state ───────────────────────────────
    function renderError() {
        notifList.querySelectorAll('.notif-item, .notif-empty, .notif-error').forEach(el => el.remove());
        notifList.insertAdjacentHTML('beforeend', `
            <div class="notif-error" style="text-align:center;padding:2rem 1rem;color:#ef4444;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:1.5rem;margin-bottom:0.5rem;display:block;"></i>
                <p style="font-size:0.8rem;">Could not load notifications.</p>
            </div>`);
    }

    // ── HTML escape helper ────────────────────────
    function escHtml(str) {
        const d = document.createElement('div');
        d.appendChild(document.createTextNode(str || ''));
        return d.innerHTML;
    }

    // ── Auto-poll every 30 seconds ────────────────
    // (silent background refresh; updates badge without opening dropdown)
    async function silentPoll() {
        try {
            const res  = await fetch('{{ route("notifications") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const data = await res.json();
            allNotifications = data.notifications || [];
            updateBadge(data.unread || 0);
            if (dropdownOpen) renderNotifications(allNotifications);
        } catch(e) {}
    }

    // Initial load + poll
    silentPoll();
    setInterval(silentPoll, 30000);
    </script>
</body>
</html>
