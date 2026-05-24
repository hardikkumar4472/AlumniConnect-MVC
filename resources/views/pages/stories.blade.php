@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h2 style="font-size: 2rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-trophy" style="color: #6366f1;"></i> Success Stories
    </h2>
    <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Inspirational professional journeys and achievements of our global alumni community.</p>
</div>

<div class="story-grid">
    @forelse($stories as $story)
    <div class="story-card">
        <div>
            <div class="story-header">
                <img src="{{ Str::startsWith($story->image, 'http') ? $story->image : asset('images/' . ($story->image ?? 'alumni2.png')) }}" alt="{{ $story->author }}" class="story-avatar">
                <div>
                    <h3 class="story-author">{{ $story->author }}</h3>
                    <p class="story-title">{{ $story->title }}</p>
                </div>
            </div>
            
            <div class="story-body">
                <p class="story-content">
                    "{{ $story->content }}"
                </p>
            </div>
        </div>
        
        <div class="story-quote-mark">“</div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem; background: #ffffff; border-radius: 24px; border: 1px dashed #cbd5e1;">
        <i class="fa-solid fa-face-smile" style="font-size: 3rem; color: #94a3b8; margin-bottom: 1.5rem; display: block; opacity: 0.5;"></i>
        <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; font-weight: 700;">No Success Stories</h4>
        <p style="color: #64748b; font-size: 0.9rem;">No inspiration stories have been shared yet. Connect with us to tell your journey!</p>
    </div>
    @endforelse
</div>
@endsection
