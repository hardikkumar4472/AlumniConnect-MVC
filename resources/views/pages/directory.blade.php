@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h2 style="font-size: 2rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-address-book" style="color: #6366f1;"></i> Alumni Directory
    </h2>
    <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Search and connect with thousands of graduates from your alma mater.</p>
</div>

<div class="dir-search-card">
    <form action="{{ route('directory') }}" method="GET" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <div class="dir-search-input-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, batch, or company..." class="dir-search-input">
            <i class="fa-solid fa-magnifying-glass dir-search-icon"></i>
        </div>
        <button type="submit" class="btn-premium-action connect" style="padding: 1.1rem 2rem; border-radius: 16px; font-size: 0.95rem; height: 56px; min-width: 140px;">
            <i class="fa-solid fa-filter"></i> Search
        </button>
    </form>
</div>

<div class="dir-grid">
    @forelse($alumni as $person)
    <div class="dir-card">
        <div class="dir-avatar-wrap">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($person->name) }}&background=random&size=128" alt="{{ $person->name }}" class="dir-avatar">
        </div>
        
        <h3 class="dir-name">{{ $person->name }}</h3>
        <p class="dir-meta">{{ $person->company ?? 'GEC Alumni' }}</p>
        
        <div class="tag-pill-container">
            <span class="tag-pill department">
                <i class="fa-solid fa-graduation-cap" style="margin-right: 4px;"></i> {{ $person->department ?? 'Engineering' }}
            </span>
            <span class="tag-pill batch">
                <i class="fa-solid fa-calendar-days" style="margin-right: 4px;"></i> Class of {{ $person->graduation_year ?? 'N/A' }}
            </span>
        </div>

        <div class="dir-actions">
            <a href="{{ route('profile', $person->id) }}" class="btn-premium-action profile">
                <i class="fa-solid fa-user"></i> Profile
            </a>
            @if(in_array((string)$person->_id, $connected_user_ids))
                <button class="btn-premium-action connected" disabled>
                    <i class="fa-solid fa-circle-check"></i> Connected
                </button>
            @elseif(in_array((string)$person->_id, $sent_request_ids))
                <button class="btn-premium-action pending" disabled>
                    <i class="fa-solid fa-clock-rotate-left"></i> Pending
                </button>
            @else
                <form action="{{ route('connect.request', $person->_id) }}" method="POST" style="margin: 0; flex: 1; display: flex;">
                    @csrf
                    <button type="submit" class="btn-premium-action connect" style="width: 100%;">
                        <i class="fa-solid fa-user-plus"></i> Connect
                    </button>
                </form>
            @endif
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem; background: #ffffff; border-radius: 24px; border: 1px dashed #cbd5e1;">
        <i class="fa-solid fa-users-slash" style="font-size: 3rem; color: #94a3b8; margin-bottom: 1.5rem; display: block; opacity: 0.5;"></i>
        <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; font-weight: 700;">No Alumni Found</h4>
        <p style="color: #64748b; font-size: 0.9rem;">We couldn't find any alumni matching your search parameters. Try adjusting your query.</p>
    </div>
    @endforelse
</div>

<div style="margin-top: 3rem; display: flex; justify-content: center;">
    {{ $alumni->links() }}
</div>
@endsection
