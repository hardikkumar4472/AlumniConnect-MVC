@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Alumni Directory</h2>
    <p>Search and connect with thousands of graduates from your alma mater.</p>
</div>

<div class="card" style="margin-top: 2rem; padding: 2rem;">
    <form action="{{ route('directory') }}" method="GET" style="display: flex; gap: 15px;">
        <div style="flex: 1; position: relative;">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 1rem; top: 1.1rem; color: #a0aec0;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, batch, or company..." style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.8rem; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;">
        </div>
        <button type="submit" class="hero-btn">Search</button>
    </form>
</div>

<div class="directory-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    @forelse($alumni as $person)
    <div class="card" style="text-align: center; padding: 2.5rem 1.5rem;">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($person->name) }}&background=random" alt="{{ $person->name }}" style="width: 80px; height: 80px; border-radius: 24px; margin-bottom: 1.5rem; object-fit: cover;">
        <h3 style="font-size: 1.1rem; margin-bottom: 0.3rem;">{{ $person->name }}</h3>
        <p style="font-size: 0.85rem; color: #718096; margin-bottom: 1.5rem;">Batch of {{ $person->graduation_year ?? 'N/A' }} • {{ $person->department ?? 'Engineering' }}</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <a href="{{ route('profile', $person->id) }}" class="social-btn" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Profile</a>
            @if(in_array((string)$person->_id, $connected_user_ids))
                <button disabled style="padding: 0.5rem 1rem; font-size: 0.8rem; background: #e2e8f0; color: #4a5568; border: none; border-radius: 8px; font-weight: 600;">Connected</button>
            @elseif(in_array((string)$person->_id, $sent_request_ids))
                <button disabled style="padding: 0.5rem 1rem; font-size: 0.8rem; background: #bee3f8; color: #2b6cb0; border: none; border-radius: 8px; font-weight: 600;">Pending</button>
            @else
                <form action="{{ route('connect.request', $person->_id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="social-btn" style="padding: 0.5rem 1rem; font-size: 0.8rem; background: #0047ab; color: white; border: none; cursor: pointer;">Connect</button>
                </form>
            @endif
        </div>
    </div>
    @empty
    <p style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: #718096;">No alumni found matching your criteria.</p>
    @endforelse
</div>

<div style="margin-top: 3rem;">
    {{ $alumni->links() }}
</div>
@endsection
