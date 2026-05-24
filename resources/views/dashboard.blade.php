@extends('layouts.app')

@section('styles')
<style>
/* ===================================================
   DASHBOARD – Enhanced, Responsive, Role-Aware
   =================================================== */

/* ── Welcome Banner ─────────────────────────────── */
.db-banner {
    background: linear-gradient(135deg, #0a192f 0%, #0f2e5c 55%, #0047ab 100%);
    border-radius: 20px;
    padding: 2rem 2.25rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}
.db-banner::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 260px; height: 260px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
    pointer-events: none;
}
.db-banner::after {
    content: '';
    position: absolute;
    bottom: -80px; right: 80px;
    width: 180px; height: 180px;
    background: rgba(255,255,255,0.03);
    border-radius: 50%;
    pointer-events: none;
}
.db-banner-left { position: relative; z-index: 1; }
.db-banner-left .greeting {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    opacity: 0.75;
    margin-bottom: 0.4rem;
}
.db-banner-left h2 {
    font-size: 1.65rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 0.5rem;
}
.db-banner-left p {
    font-size: 0.85rem;
    opacity: 0.72;
}
.db-banner-right {
    display: flex;
    gap: 1rem;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}
.banner-stat {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 14px;
    padding: 0.8rem 1.2rem;
    text-align: center;
    backdrop-filter: blur(8px);
    min-width: 90px;
}
.banner-stat .bsv {
    font-size: 1.5rem;
    font-weight: 800;
    display: block;
    line-height: 1;
    margin-bottom: 0.15rem;
}
.banner-stat .bsl {
    font-size: 0.65rem;
    opacity: 0.7;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ── Message Alert ───────────────────────────────── */
.msg-alert {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-left: 4px solid #3b82f6;
    border-radius: 12px;
    padding: 0.85rem 1.25rem;
    margin-bottom: 1.5rem;
    font-size: 0.88rem;
    font-weight: 600;
    color: #1e40af;
}
.msg-alert a {
    background: #3b82f6;
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
    transition: background 0.2s;
}
.msg-alert a:hover { background: #2563eb; }

/* ── Quick Action Cards ──────────────────────────── */
.db-quick-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.1rem;
    margin-bottom: 1.5rem;
}
.db-quick-card {
    background: white;
    border-radius: 16px;
    padding: 1.4rem 1.25rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    text-decoration: none;
    color: inherit;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.22s ease;
}
.db-quick-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    border-color: #e0e7ff;
}
.db-qc-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.db-qc-text h4 {
    font-size: 0.88rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.15rem;
}
.db-qc-text p {
    font-size: 0.73rem;
    color: #94a3b8;
    line-height: 1.3;
}

/* ── Main Content Grid ───────────────────────────── */
.db-main-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    margin-bottom: 1.25rem;
}
.db-main-grid.three-col {
    grid-template-columns: 1fr 1fr 1fr;
}
.db-section-card {
    background: white;
    border-radius: 18px;
    padding: 1.5rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}
.db-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
}
.db-section-header h3 {
    font-size: 0.95rem;
    font-weight: 800;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.db-section-header a {
    font-size: 0.75rem;
    color: #3b82f6;
    font-weight: 700;
    text-decoration: none;
}
.db-section-header a:hover { text-decoration: underline; }

/* ── Event Card ──────────────────────────────────── */
.db-event-item {
    display: flex;
    align-items: flex-start;
    gap: 0.9rem;
    padding: 0.85rem 0;
    border-bottom: 1px solid #f8fafc;
}
.db-event-item:last-child { border-bottom: none; padding-bottom: 0; }
.db-event-date {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: #eff6ff;
    color: #3b82f6;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    text-align: center;
}
.db-event-date .em { font-size: 0.55rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.3px; line-height: 1.1; }
.db-event-date .ed { font-size: 1rem; font-weight: 800; line-height: 1.1; }
.db-event-info h4 { font-size: 0.85rem; font-weight: 700; color: #1e293b; margin-bottom: 0.2rem; line-height: 1.3; }
.db-event-info p  { font-size: 0.73rem; color: #94a3b8; display: flex; align-items: center; gap: 4px; }

/* ── Story Card ──────────────────────────────────── */
.db-story-item {
    display: flex;
    gap: 0.8rem;
    padding: 0.85rem 0;
    border-bottom: 1px solid #f8fafc;
}
.db-story-item:last-child { border-bottom: none; padding-bottom: 0; }
.db-story-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
    border: 2px solid #f1f5f9;
}
.db-story-body h4 { font-size: 0.83rem; font-weight: 700; color: #0f172a; margin-bottom: 0.15rem; }
.db-story-body p  { font-size: 0.75rem; color: #64748b; line-height: 1.4; }

/* ── Donation Row ─────────────────────────────────── */
.db-donation-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8fafc;
}
.db-donation-row:last-child { border-bottom: none; padding-bottom: 0; }
.db-donation-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}
.db-donation-info { flex: 1; min-width: 0; }
.db-donation-info h4 { font-size: 0.82rem; font-weight: 700; color: #0f172a; }
.db-donation-info p  { font-size: 0.7rem; color: #94a3b8; }
.db-donation-amt { font-size: 0.92rem; font-weight: 800; color: #0047ab; flex-shrink: 0; }

/* ── News Item ───────────────────────────────────── */
.db-news-item {
    display: flex;
    gap: 0.8rem;
    padding: 0.85rem 0;
    border-bottom: 1px solid #f8fafc;
    position: relative;
}
.db-news-item:last-child { border-bottom: none; padding-bottom: 0; }
.db-news-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: #fffbeb;
    color: #f59e0b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    flex-shrink: 0;
}
.db-news-body h4 { font-size: 0.83rem; font-weight: 700; color: #0f172a; margin-bottom: 0.15rem; line-height: 1.3; }
.db-news-body p  { font-size: 0.72rem; color: #94a3b8; }
.db-new-badge {
    position: absolute;
    top: 0.85rem; right: 0;
    background: #fffbeb;
    color: #d97706;
    font-size: 0.6rem;
    font-weight: 800;
    padding: 2px 6px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ── Donation Highlight (Alumni) ─────────────────── */
.db-give-card {
    background: linear-gradient(135deg, #0047ab, #1e3a8a);
    border-radius: 18px;
    padding: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.25rem;
}
.db-give-card::before {
    content: '₹';
    position: absolute;
    right: -5px; bottom: -15px;
    font-size: 6rem;
    font-weight: 900;
    opacity: 0.07;
    color: white;
    line-height: 1;
}
.db-give-card h3 { font-size: 0.95rem; font-weight: 800; margin-bottom: 0.4rem; }
.db-give-card p  { font-size: 0.8rem; opacity: 0.78; margin-bottom: 1rem; line-height: 1.4; }
.db-give-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    padding: 0.55rem 1.25rem;
    border-radius: 10px;
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 700;
    transition: background 0.2s;
    backdrop-filter: blur(6px);
}
.db-give-btn:hover { background: rgba(255,255,255,0.28); }

/* ── Empty States ─────────────────────────────────── */
.db-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    text-align: center;
    color: #94a3b8;
}
.db-empty i { font-size: 1.75rem; margin-bottom: 0.6rem; }
.db-empty p { font-size: 0.82rem; }

/* ── Responsive ──────────────────────────────────── */
@media (max-width: 1100px) {
    .db-quick-grid { grid-template-columns: repeat(2, 1fr); }
    .db-main-grid.three-col { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
    .db-banner { flex-direction: column; align-items: flex-start; gap: 1rem; }
    .db-banner-right { flex-wrap: wrap; }
    .banner-stat { min-width: 80px; }
    .db-quick-grid { grid-template-columns: repeat(2, 1fr); }
    .db-main-grid,
    .db-main-grid.three-col { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
    .db-quick-grid { grid-template-columns: 1fr 1fr; gap: 0.75rem; }
    .db-banner-left h2 { font-size: 1.3rem; }
}
</style>
@endsection

@section('content')

{{-- ── Message Alert ─────────────────────────────── --}}
@if(isset($unread_messages_count) && $unread_messages_count > 0)
<div class="msg-alert">
    <div style="display:flex; align-items:center; gap:8px;">
        <i class="fa-solid fa-envelope"></i>
        You have <strong>{{ $unread_messages_count }}</strong> unread message{{ $unread_messages_count > 1 ? 's' : '' }}
    </div>
    <a href="{{ route('network') }}">Open Messages</a>
</div>
@endif

{{-- ── Welcome Banner ────────────────────────────── --}}
<div class="db-banner">
    <div class="db-banner-left">
        <p class="greeting">
            @if(Auth::user()->role === 'student')
                <i class="fa-solid fa-graduation-cap" style="margin-right:5px;"></i> Student Dashboard
            @elseif(Auth::user()->role === 'alumni')
                <i class="fa-solid fa-star" style="margin-right:5px;"></i> Alumni Dashboard
            @else
                <i class="fa-solid fa-gauge-high" style="margin-right:5px;"></i> Admin Overview
            @endif
        </p>
        <h2>
            Welcome back, {{ Auth::user()->name }}! 👋
        </h2>
        <p>
            @if(Auth::user()->role === 'student')
                Connect with alumni, explore opportunities and grow your career.
            @else
                Stay connected with your network, give back and inspire the next generation.
            @endif
        </p>
    </div>
    <div class="db-banner-right">
        <div class="banner-stat">
            <span class="bsv">{{ number_format($alumni_count ?? 0) }}</span>
            <span class="bsl">Alumni</span>
        </div>
        <div class="banner-stat">
            <span class="bsv">{{ $events->count() }}</span>
            <span class="bsl">Events</span>
        </div>
        @if(isset($recent_donations))
        <div class="banner-stat">
            <span class="bsv">₹{{ number_format(\App\Models\Donation::where('status','success')->sum('amount') / 1000, 0) }}K</span>
            <span class="bsl">Donated</span>
        </div>
        @endif
    </div>
</div>

{{-- ── Quick Action Cards ─────────────────────────── --}}
<div class="db-quick-grid">
    <a href="{{ route('directory') }}" class="db-quick-card">
        <div class="db-qc-icon" style="background:#eff6ff; color:#3b82f6;">
            <i class="fa-solid fa-address-book"></i>
        </div>
        <div class="db-qc-text">
            <h4>Alumni Directory</h4>
            <p>Find & connect with alumni</p>
        </div>
    </a>

    <a href="{{ route('network') }}" class="db-quick-card">
        <div class="db-qc-icon" style="background:#f0fdf4; color:#22c55e;">
            <i class="fa-solid fa-people-arrows"></i>
        </div>
        <div class="db-qc-text">
            <h4>Networking Hub</h4>
            <p>Collaborate & grow together</p>
        </div>
    </a>

    <a href="{{ route('jobs') }}" class="db-quick-card">
        <div class="db-qc-icon" style="background:#fffbeb; color:#f59e0b;">
            <i class="fa-solid fa-briefcase"></i>
        </div>
        <div class="db-qc-text">
            <h4>Job Portal</h4>
            <p>Discover opportunities</p>
        </div>
    </a>

    @if(Auth::user()->role === 'student')
    <a href="{{ route('feedback') }}" class="db-quick-card">
        <div class="db-qc-icon" style="background:#fdf4ff; color:#a855f7;">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div class="db-qc-text">
            <h4>Student Support</h4>
            <p>Get guidance from alumni</p>
        </div>
    </a>
    @else
    <a href="{{ route('donations') }}" class="db-quick-card">
        <div class="db-qc-icon" style="background:#fff1f2; color:#f43f5e;">
            <i class="fa-solid fa-hand-holding-heart"></i>
        </div>
        <div class="db-qc-text">
            <h4>Donations</h4>
            <p>Give back to your alma mater</p>
        </div>
    </a>
    @endif
</div>

{{-- ── Alumni-exclusive Donation Highlight ─────────── --}}
@if(Auth::user()->role === 'alumni')
<div class="db-give-card">
    <h3><i class="fa-solid fa-heart-pulse" style="margin-right:6px;"></i> Support GEC Alumni Giving</h3>
    <p>Your contribution funds scholarships, labs, and innovation at GEC. Every rupee counts.</p>
    <a href="{{ route('donations') }}" class="db-give-btn">
        <i class="fa-solid fa-arrow-right"></i> Donate or Start a Campaign
    </a>
</div>
@endif

{{-- ── Main Content Grid ──────────────────────────── --}}
@php
    $cols = Auth::user()->role === 'student' ? 'three-col' : '';
@endphp
<div class="db-main-grid {{ $cols }}">

    {{-- Upcoming Events --}}
    <div class="db-section-card">
        <div class="db-section-header">
            <h3><i class="fa-solid fa-calendar-days" style="color:#3b82f6;"></i> Upcoming Events</h3>
            <a href="{{ route('events') }}">View All</a>
        </div>
        @forelse($events->take(3) as $event)
        <div class="db-event-item">
            <div class="db-event-date">
                <span class="em">{{ substr($event->month ?? 'JAN', 0, 3) }}</span>
                <span class="ed">{{ $event->date ?? '--' }}</span>
            </div>
            <div class="db-event-info">
                <h4>{{ $event->title }}</h4>
                <p><i class="fa-regular fa-clock"></i> {{ $event->time ?? '' }}</p>
                <p style="margin-top:2px;"><i class="fa-solid fa-location-dot" style="color:#3b82f6;"></i> {{ $event->location ?? '' }}</p>
            </div>
        </div>
        @empty
        <div class="db-empty">
            <i class="fa-regular fa-calendar-xmark"></i>
            <p>No upcoming events scheduled.</p>
        </div>
        @endforelse
    </div>

    {{-- Success Stories --}}
    <div class="db-section-card">
        <div class="db-section-header">
            <h3><i class="fa-solid fa-star" style="color:#f59e0b;"></i> Success Stories</h3>
            <a href="{{ route('stories') }}">View All</a>
        </div>
        @if($featured_story)
        <div class="db-story-item">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($featured_story->author) }}&background=random&size=64"
                 class="db-story-avatar" alt="{{ $featured_story->author }}">
            <div class="db-story-body">
                <h4>{{ $featured_story->author }}</h4>
                <p style="font-weight:600; color:#374151; margin-bottom:0.3rem;">{{ $featured_story->title }}</p>
                <p>"{{ Str::limit($featured_story->content, 120) }}"</p>
            </div>
        </div>
        @else
        <div class="db-empty">
            <i class="fa-regular fa-face-smile"></i>
            <p>No stories featured yet.</p>
        </div>
        @endif
    </div>

    {{-- Student: Campus News | Alumni: Recent Donations --}}
    @if(Auth::user()->role === 'student')
    <div class="db-section-card">
        <div class="db-section-header">
            <h3><i class="fa-solid fa-newspaper" style="color:#f59e0b;"></i> Campus News</h3>
        </div>
        @forelse($campus_news->take(3) as $news)
        <div class="db-news-item">
            <div class="db-news-icon"><i class="fa-solid fa-newspaper"></i></div>
            <div class="db-news-body" style="padding-right: 2.5rem;">
                <h4>{{ $news->title }}</h4>
                <p><i class="fa-regular fa-calendar" style="margin-right:3px;"></i> {{ $news->date }}</p>
                <p style="margin-top:2px; color:#64748b; font-size:0.72rem; line-height:1.4;">{{ Str::limit($news->content, 80) }}</p>
            </div>
            @if($loop->first)<span class="db-new-badge">NEW</span>@endif
        </div>
        @empty
        <div class="db-empty">
            <i class="fa-solid fa-newspaper"></i>
            <p>No campus news available.</p>
        </div>
        @endforelse
    </div>
    @else
    {{-- Alumni sees Recent Donations --}}
    <div class="db-section-card">
        <div class="db-section-header">
            <h3><i class="fa-solid fa-hand-holding-heart" style="color:#f43f5e;"></i> Recent Donations</h3>
            <a href="{{ route('donations') }}">Give Now</a>
        </div>
        @forelse($recent_donations->take(5) as $d)
        <div class="db-donation-row">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($d->user_name ?? 'A') }}&background=random&size=64"
                 class="db-donation-avatar" alt="">
            <div class="db-donation-info">
                <h4>{{ $d->user_name ?? 'Anonymous' }}</h4>
                <p>{{ $d->purpose }} · {{ $d->created_at->diffForHumans() }}</p>
            </div>
            <div class="db-donation-amt">₹{{ number_format($d->amount) }}</div>
        </div>
        @empty
        <div class="db-empty">
            <i class="fa-solid fa-hand-holding-heart"></i>
            <p>No donations yet. Be the first!</p>
        </div>
        @endforelse
    </div>
    @endif

</div>

@endsection

@section('scripts')
@endsection
