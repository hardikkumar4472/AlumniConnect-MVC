@extends('layouts.app')

@section('styles')
<style>
.forum-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    margin-bottom: 1.25rem;
    transition: all 0.25s ease;
    display: flex;
    gap: 1.5rem;
}
.forum-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(0,71,171,0.06);
    border-color: #dbeafe;
}
.forum-stats {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    min-width: 64px;
    text-align: center;
}
.forum-stat {
    width: 100%;
    padding: 0.5rem;
    border-radius: 10px;
}
.forum-stat-count {
    font-size: 1.15rem;
    font-weight: 800;
    display: block;
    line-height: 1;
}
.forum-stat-lbl {
    font-size: 0.65rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 2px;
    display: block;
}
.forum-tab {
    padding: 0.5rem 1.1rem;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
}
.forum-tab-active {
    background: #0047ab;
    color: white !important;
}
.forum-tab-inactive {
    color: #64748b;
}
.forum-tab-inactive:hover {
    background: #eff6ff;
    color: #0047ab;
}
.tag-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 600;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    text-decoration: none;
    transition: all 0.2s;
}
.tag-badge:hover {
    border-color: #0047ab;
    color: #0047ab;
    background: #eff6ff;
}
</style>
@endsection

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h2>Peer Q&A Discussion Forum</h2>
        <p>Connect with your community, clear technical doubts, and get expert career insights.</p>
    </div>
    <a href="{{ route('forum.create') }}" class="btn-primary" style="text-decoration: none; box-shadow: 0 4px 12px rgba(0,71,171,0.25);">
        <i class="fa-solid fa-pen-nib"></i> Ask a Question
    </a>
</div>

@if(session('success'))
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; font-weight: 600;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

{{-- Search & Tabs Controller --}}
<div style="background: white; border-radius: 16px; padding: 1rem; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.01); display: flex; justify-content: space-between; align-items: center; gap: 1.5rem; margin-bottom: 2rem; flex-wrap: wrap;">
    <div style="display: flex; gap: 4px; background: #f8fafc; padding: 4px; border-radius: 12px; border: 1px solid #f1f5f9;">
        <a href="{{ route('forum.index', ['tab' => 'latest', 'search' => request('search')]) }}" class="forum-tab {{ $tab === 'latest' ? 'forum-tab-active' : 'forum-tab-inactive' }}">Latest</a>
        <a href="{{ route('forum.index', ['tab' => 'unanswered', 'search' => request('search')]) }}" class="forum-tab {{ $tab === 'unanswered' ? 'forum-tab-active' : 'forum-tab-inactive' }}">Unanswered</a>
        <a href="{{ route('forum.index', ['tab' => 'popular', 'search' => request('search')]) }}" class="forum-tab {{ $tab === 'popular' ? 'forum-tab-active' : 'forum-tab-inactive' }}">Most Viewed</a>
    </div>

    <form action="{{ route('forum.index') }}" method="GET" style="margin: 0; display: flex; gap: 8px; max-width: 320px; width: 100%;">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search questions or tags..."
               style="flex: 1; padding: 0.55rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.85rem; outline: none; background: #f8fafc; color: #1e293b; font-family: inherit; box-sizing: border-box;">
        <button type="submit" class="btn-primary" style="padding: 0.55rem 1rem; font-size: 0.85rem;"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</div>

{{-- Questions Feed --}}
<div style="display: flex; flex-direction: column;">
    @forelse($questions as $q)
    @php
        $ansCount = $q->answers()->count();
        $hasAccepted = $q->accepted_answer_id ? true : false;
    @endphp
    <div class="forum-card">
        {{-- Stats indicators --}}
        <div class="forum-stats">
            <div class="forum-stat" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                <span class="forum-stat-count" style="color: #475569;">{{ $q->views }}</span>
                <span class="forum-stat-lbl">Views</span>
            </div>
            <div class="forum-stat" style="background: {{ $hasAccepted ? '#dcfce7' : ($ansCount > 0 ? '#eff6ff' : '#f8fafc') }}; border: 1px solid {{ $hasAccepted ? '#bbf7d0' : ($ansCount > 0 ? '#bfdbfe' : '#f1f5f9') }};">
                <span class="forum-stat-count" style="color: {{ $hasAccepted ? '#15803d' : ($ansCount > 0 ? '#1d4ed8' : '#64748b') }};">
                    {{ $ansCount }}
                </span>
                <span class="forum-stat-lbl" style="color: {{ $hasAccepted ? '#15803d' : ($ansCount > 0 ? '#1d4ed8' : '#64748b') }};">
                    {{ $hasAccepted ? 'Solved' : 'Answers' }}
                </span>
            </div>
        </div>

        {{-- Details --}}
        <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="margin: 0 0 0.5rem; font-size: 1.1rem; line-height: 1.4;">
                    <a href="{{ route('forum.show', $q->_id) }}" style="color: #0f172a; text-decoration: none; font-weight: 800; transition: color 0.2s;" onmouseover="this.style.color='#0047ab'" onmouseout="this.style.color='#0f172a'">{{ $q->title }}</a>
                </h3>
                <p style="font-size: 0.88rem; color: #475569; margin: 0 0 1rem; line-height: 1.6;">
                    {{ Str::limit(strip_tags($q->body), 180) }}
                </p>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                    @foreach($q->tags ?? [] as $t)
                    <a href="{{ route('forum.index', ['search' => $t, 'tab' => $tab]) }}" class="tag-badge">{{ $t }}</a>
                    @endforeach
                </div>
                <span style="font-size: 0.75rem; color: #94a3b8;">
                    Asked by <strong style="color: #64748b;">{{ $q->user_name }}</strong> · {{ $q->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 5rem 1rem; background: white; border-radius: 20px; border: 1px solid #f1f5f9; color: #94a3b8;">
        <i class="fa-solid fa-comments-question" style="font-size: 3rem; margin-bottom: 1rem; display: block; color: #cbd5e1;"></i>
        <p style="font-size: 1.05rem; font-weight: 600; margin: 0 0 4px;">No discussion topics found</p>
        <p style="font-size: 0.85rem; margin: 0;">Be the first in the GEC Alumni Network community to start a discussion thread!</p>
    </div>
    @endforelse

    <div style="margin-top: 1.5rem;">
        {{ $questions->appends(request()->all())->links() }}
    </div>
</div>
@endsection
