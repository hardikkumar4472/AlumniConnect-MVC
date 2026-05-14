@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Events & Reunions</h2>
    <p>Stay updated with the latest gatherings and professional workshops.</p>
</div>

<div class="events-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    @forelse($events as $event)
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="height: 150px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white;">
            <div style="text-align: center;">
                <h1 style="font-size: 3rem; font-weight: 700; line-height: 1;">{{ $event->date }}</h1>
                <p style="text-transform: uppercase; letter-spacing: 2px;">{{ $event->month }}</p>
            </div>
        </div>
        <div style="padding: 1.5rem;">
            <h3 style="margin-bottom: 0.5rem;">{{ $event->title }}</h3>
            <p style="font-size: 0.9rem; color: #718096; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-clock" style="margin-right: 5px;"></i> {{ $event->time }}<br>
                <i class="fa-solid fa-location-dot" style="margin-right: 5px;"></i> {{ $event->location }}
            </p>
            <a href="#" class="hero-btn" style="width: 100%; text-align: center;">Register Now</a>
        </div>
    </div>
    @empty
    <p>No events scheduled.</p>
    @endforelse
</div>
@endsection
