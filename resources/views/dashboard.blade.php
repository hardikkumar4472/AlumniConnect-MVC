@extends('layouts.app')

@section('content')
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
        <div class="stat-item">
            <div class="stat-icon"><i class="fa-solid fa-globe"></i></div>
            <div class="stat-info">
                <span>Countries</span>
                <h3>32</h3>
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
    
    @if(Auth::user()->role == 'alumni')
    <div class="card">
        <div class="card-icon" style="background: #fff5f5; color: #e53e3e;"><i class="fa-solid fa-heart"></i></div>
        <h3>Donate Now</h3>
        <p>Support the growth of our alma mater.</p>
        <a href="{{ route('donations') }}" class="card-link" style="color: #e53e3e;">Make a Donation <i class="fa-solid fa-chevron-right"></i></a>
    </div>
    @else
    <div class="card">
        <div class="card-icon" style="background: #fff5f5; color: #e53e3e;"><i class="fa-solid fa-graduation-cap"></i></div>
        <h3>Scholarships</h3>
        <p>Apply for financial aid and awards.</p>
        <a href="#" class="card-link" style="color: #e53e3e;">View Available <i class="fa-solid fa-chevron-right"></i></a>
    </div>
    @endif
</div>

<div class="bottom-grid">
    <section class="upcoming-events">
        <div class="section-title">
            <h3>Upcoming Events</h3>
            <a href="{{ route('events') }}" class="view-all">View All</a>
        </div>
        <div class="event-list">
            @forelse($events as $event)
            <div class="event-item">
                <div class="event-date" style="{{ $loop->index > 0 ? 'background: #faf5ff; color: #805ad5;' : '' }}">
                    <span>{{ strtoupper($event->month) }}</span>
                    <span>{{ $event->date }}</span>
                </div>
                <div class="event-info">
                    <h4>{{ $event->title }}</h4>
                    <p><i class="fa-solid fa-clock"></i> {{ $event->time }} | {{ $event->location }}</p>
                </div>
            </div>
            @empty
            <p>No upcoming events.</p>
            @endforelse
        </div>
    </section>
    
    <section class="success-stories">
        <div class="section-title">
            <h3>Success Stories</h3>
            <a href="{{ route('stories') }}" class="view-all">View All</a>
        </div>
        @if($featured_story)
        <div class="success-story-card">
            <div class="story-header">
                <img src="{{ asset('images/' . ($featured_story->image ?? 'alumni2.png')) }}" alt="{{ $featured_story->name }}" class="story-avatar">
                <div>
                    <h4 style="font-size: 0.95rem;">{{ $featured_story->name }}</h4>
                    <p style="font-size: 0.75rem; color: #718096;">{{ $featured_story->designation }}</p>
                </div>
            </div>
            <div class="story-content">
                <p>{{ $featured_story->story }}</p>
            </div>
            <div style="display: flex; justify-content: center; gap: 5px; margin-top: 1.5rem;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--primary);"></span>
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #e2e8f0;"></span>
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #e2e8f0;"></span>
            </div>
        </div>
        @else
        <p>No success stories featured.</p>
        @endif
    </section>
    
    @if(Auth::user()->role == 'alumni')
    <section class="recent-contributions">
        <div class="section-title">
            <h3>Recent Contributions</h3>
            <a href="{{ route('donations') }}" class="view-all">View All</a>
        </div>
        <div class="contribution-list">
            @forelse($recent_donations as $donation)
            <div class="contribution-item">
                <div class="contributor">
                    <img src="{{ $donation->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($donation->contributor_name) . '&background=random' }}" alt="{{ $donation->contributor_name }}">
                    <div class="contributor-info">
                        <h5>{{ $donation->contributor_name }}</h5>
                        <p>{{ $donation->purpose }}</p>
                    </div>
                </div>
                <span class="amount">₹{{ number_format($donation->amount) }}</span>
            </div>
            @empty
            <p>No recent contributions.</p>
            @endforelse
        </div>
    </section>
    @else
    <section class="student-news">
        <div class="section-title">
            <h3>Campus News</h3>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="card" style="padding: 1rem;">
            <p style="font-size: 0.9rem; color: #4a5568;">Stay tuned for the upcoming annual technical fest and placement drive updates!</p>
        </div>
    </section>
    @endif
</div>
@endsection
