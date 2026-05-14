<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GEC Alumni Association</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=3">
    @yield('styles')
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
            @if(Auth::user()->role == 'alumni')
            <a href="{{ route('donations') }}" class="nav-item {{ request()->routeIs('donations') ? 'active' : '' }}">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <span>Donations & Impact</span>
            </a>
            @endif

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
            <a href="{{ route('admin.feedback') }}" class="nav-item {{ request()->routeIs('admin.feedback') ? 'active' : '' }}" style="padding-left: 2rem; font-size: 0.8rem;">
                <i class="fa-solid fa-message"></i>
                <span>View Feedback</span>
            </a>
            @endif
        </nav>
    </aside>

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
                <div class="notification-btn">
                    <i class="fa-solid fa-bell"></i>
                    <span class="badge">3</span>
                </div>
                
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="Avatar" class="user-avatar">
                    <div class="user-info">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>Alumnus '{{ Auth::user()->graduation_year ?? '15' }}</p>
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

        <div class="content-body" style="min-height: 80vh; padding: 2rem 0;">
            @yield('content')
        </div>

        <footer class="footer" style="margin-left: 0; padding: 4rem 0;">
            <div class="footer-main">
                <div class="footer-col">
                    <div class="logo-container" style="margin-bottom: 1.5rem;">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 40px;">
                        <div class="logo-text">
                            <h1 style="font-size: 1rem; color: #061a3d;">GEC ALUMNI</h1>
                            <p style="font-size: 0.6rem; color: #718096;">ASSOCIATION PLATFORM</p>
                        </div>
                    </div>
                    <p style="color: #a0aec0; font-size: 0.85rem; line-height: 1.6;">
                        Uniting graduates, fostering meaningful connections and empowering each other to build a better future together.
                    </p>
                </div>

                <div class="footer-col">
                    <h4>Explore</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('directory') }}">Directory</a></li>
                        <li><a href="{{ route('jobs') }}">Jobs</a></li>
                        <li><a href="{{ route('events') }}">Events</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Support</h4>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms</a></li>
                        <li><a href="{{ route('feedback') }}">Feedback</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Get in Touch</h4>
                    <p style="font-size: 0.85rem; color: #a0aec0; margin-bottom: 1rem;">alumni@gec.edu.in</p>
                    <div style="display: flex; gap: 15px;">
                        <a href="#" style="color: #a0aec0;"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" style="color: #a0aec0;"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="#" style="color: #a0aec0;"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ date('Y') }} GEC Alumni Association. All rights reserved.</p>
            </div>
        </footer>
    </main>

    @yield('scripts')
    <script>
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.getElementById('main-content');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    </script>
</body>
</html>
