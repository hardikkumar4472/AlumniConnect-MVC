@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Success Stories</h2>
    <p>Inspirational journeys of our alumni who made a mark in the world.</p>
</div>

<div class="stories-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    @forelse($stories as $story)
    <div class="card" style="padding: 2rem;">
        <div style="display: flex; gap: 1.5rem; align-items: flex-start; margin-bottom: 1.5rem;">
            <img src="{{ Str::startsWith($story->image, 'http') ? $story->image : asset('images/' . ($story->image ?? 'alumni2.png')) }}" alt="{{ $story->author }}" style="width: 80px; height: 80px; border-radius: 20px; object-fit: cover;">
            <div>
                <h3 style="font-size: 1.2rem;">{{ $story->author }}</h3>
                <p style="font-size: 0.85rem; color: #718096;">{{ $story->title }}</p>
            </div>
        </div>
        <div style="position: relative;">
            <p style="font-size: 0.95rem; line-height: 1.7; color: #4a5568; font-style: italic;">
                "{{ $story->content }}"
            </p>
        </div>
    </div>
    @empty
    <p>No success stories found.</p>
    @endforelse
</div>
@endsection
