@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Networking Hub</h2>
    <p>Manage your connections, find mentors, and build professional relationships.</p>
</div>

@if(session('success'))
    <div style="background: #c6f6d5; color: #2f855a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background: #fed7d7; color: #c53030; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        {{ session('error') }}
    </div>
@endif

@if($pending_requests->count() > 0)
<div class="requests-section" style="margin-top: 2rem;">
    <h3 style="margin-bottom: 1.5rem; color: #061a3d;"><i class="fa-solid fa-user-clock"></i> Pending Requests</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        @foreach($pending_requests as $request)
        <div class="card" style="padding: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; gap: 1rem; align-items: center;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($request->requester->name) }}&background=random" style="width: 50px; height: 50px; border-radius: 50%;">
                <div>
                    <h4 style="font-size: 1rem;"><a href="{{ route('profile', $request->requester->_id) }}" style="color: inherit; text-decoration: none;">{{ $request->requester->name }}</a></h4>
                    <p style="font-size: 0.8rem; color: #718096;">{{ ucfirst($request->requester->role) }}</p>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <form action="{{ route('connect.accept', $request->_id) }}" method="POST">
                    @csrf
                    <button type="submit" style="background: #38a169; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer; font-size: 0.8rem; font-weight: 600;">Accept</button>
                </form>
                <form action="{{ route('connect.reject', $request->_id) }}" method="POST">
                    @csrf
                    <button type="submit" style="background: #e53e3e; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer; font-size: 0.8rem; font-weight: 600;">Reject</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="connections-section" style="margin-top: 3rem;">
    <h3 style="margin-bottom: 1.5rem; color: #061a3d;"><i class="fa-solid fa-users"></i> My Connections ({{ $connected_users->count() }})</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @forelse($connected_users as $user)
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" style="width: 70px; height: 70px; border-radius: 50%; margin-bottom: 1rem;">
            <h4 style="font-size: 1.1rem;">{{ $user->name }}</h4>
            <p style="font-size: 0.85rem; color: #718096; margin-bottom: 1.5rem;">{{ ucfirst($user->role) }} • {{ $user->department ?? 'Engineering' }}</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <a href="{{ route('profile', $user->_id) }}" style="display: inline-block; padding: 0.5rem 1rem; border: 1px solid #0047ab; color: #0047ab; border-radius: 20px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">View Profile</a>
                <a href="{{ route('chat', $user->_id) }}" style="display: inline-block; padding: 0.5rem 1rem; background: #0047ab; color: white; border-radius: 20px; text-decoration: none; font-size: 0.85rem; font-weight: 600;"><i class="fa-solid fa-message"></i> Message</a>
            </div>
        </div>
        @empty
        <p style="color: #718096; grid-column: 1 / -1;">You haven't made any connections yet. Search the directory to find people!</p>
        @endforelse
    </div>
</div>

<div class="mentors-section" style="margin-top: 4rem;">
    <h3 style="margin-bottom: 1.5rem; color: #061a3d;"><i class="fa-solid fa-star"></i> Discover Alumni</h3>
    <div class="mentors-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        @forelse($mentors as $mentor)
        <div class="card" style="padding: 2rem; border-left: 4px solid var(--accent);">
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($mentor->name) }}&background=random" alt="{{ $mentor->name }}" style="width: 50px; height: 50px; border-radius: 50%;">
                <div>
                    <h4 style="font-size: 1rem;"><a href="{{ route('profile', $mentor->_id) }}" style="color: inherit; text-decoration: none;">{{ $mentor->name }}</a></h4>
                    <p style="font-size: 0.8rem; color: #718096;">Batch of {{ $mentor->graduation_year ?? 'N/A' }}</p>
                </div>
            </div>
            
            @if(in_array((string)$mentor->_id, $connected_user_ids))
                <button disabled style="width: 100%; padding: 0.8rem; background: #e2e8f0; color: #4a5568; border: none; border-radius: 12px; font-weight: 600;">Connected</button>
            @elseif(in_array((string)$mentor->_id, $sent_request_ids))
                <button disabled style="width: 100%; padding: 0.8rem; background: #bee3f8; color: #2b6cb0; border: none; border-radius: 12px; font-weight: 600;">Request Pending</button>
            @else
                <form action="{{ route('connect.request', $mentor->_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="hero-btn" style="width: 100%; text-align: center; font-size: 0.85rem;">Connect</button>
                </form>
            @endif
        </div>
        @empty
        <p>No alumni available yet.</p>
        @endforelse
    </div>
</div>
@endsection
