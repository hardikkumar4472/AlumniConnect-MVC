@extends('layouts.app')

@section('content')

@if(isset($unread_messages_count) && $unread_messages_count > 0)
<div style="background: #ebf8ff; border-left: 4px solid #3182ce; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-envelope" style="color: #3182ce; font-size: 1.2rem;"></i>
        <span style="color: #2b6cb0; font-weight: 600;">You have {{ $unread_messages_count }} unread message(s)!</span>
    </div>
    <a href="{{ route('network') }}" style="background: #3182ce; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: background 0.2s;">Go to Networking Hub</a>
</div>
@endif

<div class="hero">
    <div class="hero-text">
        <p style="color: var(--accent); font-weight: 600; margin-bottom: 0.5rem;">WELCOME BACK, {{ strtoupper(Auth::user()->name) }}! 👋</p>
        <h2>Stay Connected.<br>Make an Impact.</h2>
        <p>Engage. Network. Contribute. Inspire.</p>
        <a href="#" class="hero-btn">Explore More <i class="fa-solid fa-arrow-right" style="margin-left: 10px;"></i></a>
    </div>
    
    <div class="hero-stats">
        <div class="stat-item">
            <div class="stat-icon"><i class="fa-solid fa-users-line"></i></div>
            <div class="stat-info">
                <span>Total Alumni</span>
                <h3>{{ number_format($alumni_count ?? 0) }}</h3>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><i class="fa-solid fa-bolt"></i></div>
            <div class="stat-info">
                <span>Active Members</span>
                <h3>{{ number_format($alumni_count ? ($alumni_count * 0.6) : 0) }}</h3>
            </div>
        </div>

    </div>
</div>

<div class="quick-cards">
    <div class="card">
        <div class="card-icon" style="background: #ebf8ff; color: #3182ce;"><i class="fa-solid fa-address-book"></i></div>
        <h3>Alumni Directory</h3>
        <p>Find and connect with fellow alumni.</p>
        <a href="{{ route('directory') }}" class="card-link" style="color: #3182ce;">Search Now <i class="fa-solid fa-chevron-right"></i></a>
    </div>
    
    <div class="card">
        <div class="card-icon" style="background: #f0fff4; color: #38a169;"><i class="fa-solid fa-people-arrows"></i></div>
        <h3>Networking Hub</h3>
        <p>Connect, collaborate and grow together.</p>
        <a href="{{ route('network') }}" class="card-link" style="color: #38a169;">Explore <i class="fa-solid fa-chevron-right"></i></a>
    </div>
    
    <div class="card">
        <div class="card-icon" style="background: #fffaf0; color: #dd6b20;"><i class="fa-solid fa-briefcase"></i></div>
        <h3>Job Portal</h3>
        <p>Discover jobs or post opportunities.</p>
        <a href="{{ route('jobs') }}" class="card-link" style="color: #dd6b20;">Explore Jobs <i class="fa-solid fa-chevron-right"></i></a>
    </div>
    

</div>

<div class="bottom-grid">
    <section class="upcoming-events" style="min-width: 0; display: flex; flex-direction: column; height: 100%;">
        <div class="section-title">
            <h3 style="font-size: 1.25rem; color: #0f172a; font-weight: 700;">Upcoming Events</h3>
            <a href="{{ route('events') }}" class="view-all" style="color: #3b82f6; font-weight: 600;">View All</a>
        </div>
        @if(count($events) > 0)
        @php $event = $events[0]; @endphp
        <div class="card event-item" style="flex: 1; padding: 1.5rem; border-radius: 16px; border: 1px solid #f1f5f9; background: white; display: flex; flex-direction: column; justify-content: center; height: 100%;">
            <div class="story-header" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                <div class="event-date" style="min-width: 50px; height: 50px; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #eff6ff; color: #3b82f6; flex-shrink: 0; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <span style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; line-height: 1.1;">{{ substr($event->month, 0, 3) }}</span>
                    <span style="font-size: 1.1rem; font-weight: 800; line-height: 1.1;">{{ $event->date }}</span>
                </div>
                <div style="flex: 1;">
                    <h4 style="font-size: 1rem; color: #1e293b; font-weight: 700; margin: 0; line-height: 1.4; margin-bottom: 0.25rem; word-break: break-word;">{{ $event->title }}</h4>
                    <p style="font-size: 0.8rem; color: #64748b; margin: 0; font-weight: 500; line-height: 1.4;"><i class="fa-regular fa-clock" style="margin-right: 4px;"></i>{{ $event->time }}</p>
                </div>
            </div>
            <div class="story-content" style="flex: 1;">
                <p style="font-size: 0.95rem; color: #475569; line-height: 1.6; font-style: italic;"><i class="fa-solid fa-location-dot" style="margin-right: 4px; color: #3b82f6;"></i> {{ $event->location }}</p>
            </div>
        </div>
        @else
        <div class="card" style="flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 2rem; text-align: center; color: #94a3b8; border-radius: 16px; border: 1px solid #f1f5f9; background: white; height: 100%;">
            <i class="fa-regular fa-calendar-xmark" style="font-size: 2rem; margin-bottom: 1rem;"></i>
            <p>No upcoming events.</p>
        </div>
        @endif
    </section>
    
    <section class="success-stories" style="min-width: 0; display: flex; flex-direction: column; height: 100%;">
        <div class="section-title">
            <h3 style="font-size: 1.25rem; color: #0f172a; font-weight: 700;">Success Stories</h3>
            <a href="{{ route('stories') }}" class="view-all" style="color: #3b82f6; font-weight: 600;">View All</a>
        </div>
        @if($featured_story)
        <div class="card success-story-card" style="flex: 1; padding: 1.5rem; border-radius: 16px; border: 1px solid #f1f5f9; background: white; display: flex; flex-direction: column; justify-content: center; height: 100%;">
            <div class="story-header" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($featured_story->author) }}&background=random&size=64" alt="{{ $featured_story->author }}" class="story-avatar" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; box-shadow: 0 4px 6px rgba(0,0,0,0.05); flex-shrink: 0;">
                <div style="flex: 1;">
                    <h4 style="font-size: 1rem; color: #1e293b; font-weight: 700; margin: 0; line-height: 1.4; margin-bottom: 0.25rem; word-break: break-word;">{{ $featured_story->author }}</h4>
                    <p style="font-size: 0.8rem; color: #64748b; margin: 0; font-weight: 500; line-height: 1.4;">{{ $featured_story->title }}</p>
                </div>
            </div>
            <div class="story-content" style="flex: 1;">
                <p style="font-size: 0.95rem; color: #475569; line-height: 1.6; font-style: italic;">"{{ $featured_story->content }}"</p>
            </div>
        </div>
        @else
        <div class="card" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem; text-align: center; color: #94a3b8; border-radius: 16px; border: 1px solid #f1f5f9; background: white; height: 100%;">
            <p>No success stories featured.</p>
        </div>
        @endif
    </section>
    
    @if(Auth::user()->role == 'student')
    <section class="student-news" style="min-width: 0; display: flex; flex-direction: column; height: 100%;">
        <div class="section-title">
            <h3 style="font-size: 1.25rem; color: #0f172a; font-weight: 700;">Campus News</h3>
        </div>
        @if(count($campus_news) > 0)
        @php $news = $campus_news[0]; @endphp
        <div class="card" style="flex: 1; padding: 1.5rem; border-radius: 16px; border: 1px solid #f1f5f9; background: white; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; height: 100%;">
            <div style="position: absolute; top: 0; right: 0; padding: 0.4rem 0.8rem; background: #fffbeb; color: #d97706; font-size: 0.65rem; font-weight: 700; border-bottom-left-radius: 8px; z-index: 10;">NEW</div>
            <div class="story-header" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                <div class="news-icon" style="min-width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #fffbeb; color: #f59e0b; flex-shrink: 0; box-shadow: 0 4px 6px rgba(0,0,0,0.05); font-size: 1.2rem;">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
                <div style="flex: 1; padding-right: 2.5rem;">
                    <h4 style="font-size: 1rem; color: #1e293b; font-weight: 700; margin: 0; line-height: 1.4; margin-bottom: 0.25rem; word-break: break-word;">{{ $news->title }}</h4>
                    <p style="font-size: 0.8rem; color: #64748b; margin: 0; font-weight: 500; line-height: 1.4;"><i class="fa-regular fa-calendar" style="margin-right: 4px;"></i>{{ $news->date }}</p>
                </div>
            </div>
            <div class="story-content" style="flex: 1;">
                <p style="font-size: 0.95rem; color: #475569; line-height: 1.6; font-style: italic;">"{{ $news->content }}"</p>
            </div>
        </div>
        @else
        <div class="card" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem; text-align: center; color: #94a3b8; border-radius: 16px; border: 1px solid #f1f5f9; background: white; height: 100%;">
            <p>No campus news available.</p>
        </div>
        @endif
    </section>
    @endif
</div>
@endsection

@section('scripts')
@endsection
