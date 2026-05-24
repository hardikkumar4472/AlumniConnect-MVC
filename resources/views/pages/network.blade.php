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

    {{-- ===== MENTORSHIP MODULE ===== --}}
    @if(Auth::user()->role === 'alumni' && $incoming_mentorships->count() > 0)
    <div class="mentorship-incoming-section" style="margin-top: 2.5rem; margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1.25rem; color: #061a3d; display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-graduation-cap" style="color: #10b981;"></i> Mentorship Requests ({{ $incoming_mentorships->count() }})</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach($incoming_mentorships as $session)
            <div class="card" style="padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; border-left: 4px solid #10b981; border-radius: 12px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($session->mentee->name ?? 'Student') }}&background=random" style="width: 45px; height: 45px; border-radius: 50%;">
                    <div>
                        <h4 style="font-size: 0.95rem; margin: 0;"><a href="{{ route('profile', $session->mentee_id) }}" style="color: inherit; text-decoration: none; font-weight: 700;">{{ $session->mentee->name ?? 'Student' }}</a></h4>
                        <p style="font-size: 0.75rem; color: #718096; margin: 2px 0 0;">Batch of {{ $session->mentee->graduation_year ?? 'N/A' }} · {{ $session->mentee->department ?? 'Engineering' }}</p>
                    </div>
                </div>
                <p style="font-size: 0.8rem; color: #4a5568; line-height: 1.5; background: #f8fafc; padding: 0.75rem; border-radius: 8px; margin: 0 0 1rem; font-style: italic;">
                    "{{ $session->message }}"
                </p>
                <div style="display: flex; gap: 10px; margin-top: auto;">
                    <form action="{{ route('mentorship.accept', $session->_id) }}" method="POST" style="flex: 1; margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; background: #10b981; color: white; border: none; padding: 0.5rem; border-radius: 8px; cursor: pointer; font-size: 0.8rem; font-weight: 600; text-align: center; transition: all 0.2s;">Accept</button>
                    </form>
                    <form action="{{ route('mentorship.reject', $session->_id) }}" method="POST" style="flex: 1; margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; background: #e53e3e; color: white; border: none; padding: 0.5rem; border-radius: 8px; cursor: pointer; font-size: 0.8rem; font-weight: 600; text-align: center; transition: all 0.2s;">Reject</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($my_mentorships->count() > 0)
    <div class="mentorship-active-section" style="margin-top: 3rem; margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1.25rem; color: #061a3d; display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-chalkboard-user" style="color: #3b82f6;"></i> Mentorship Sessions</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
            @foreach($my_mentorships as $session)
            @php
                $partner = Auth::user()->role === 'alumni' ? ($session->mentee ?? null) : ($session->mentor ?? null);
                if (!$partner) continue;
                $statusColors = [
                    'active'    => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#3b82f6'],
                    'completed' => ['bg' => '#f0fdf4', 'text' => '#15803d', 'border' => '#22c55e'],
                    'rejected'  => ['bg' => '#fef2f2', 'text' => '#b91c1c', 'border' => '#ef4444'],
                    'pending'   => ['bg' => '#fffbeb', 'text' => '#b45309', 'border' => '#f59e0b'],
                ];
                $meta = $statusColors[$session->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'];
            @endphp
            <div class="card" style="padding: 1.75rem; border-top: 4px solid {{ $meta['border'] }}; border-radius: 12px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <div style="display: flex; gap: 0.75rem; align-items: center;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($partner->name) }}&background=random" style="width: 40px; height: 40px; border-radius: 50%;">
                            <div>
                                <h4 style="font-size: 0.95rem; margin: 0;"><a href="{{ route('profile', $partner->_id) }}" style="color: inherit; text-decoration: none; font-weight: 700;">{{ $partner->name }}</a></h4>
                                <span style="font-size: 0.72rem; color: #718096;">{{ Auth::user()->role === 'alumni' ? 'Mentee' : 'Mentor' }} · {{ $partner->department ?? 'Engineering' }}</span>
                            </div>
                        </div>
                        <span style="padding: 3px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 800; background: {{ $meta['bg'] }}; color: {{ $meta['text'] }}; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ $session->status }}
                        </span>
                    </div>

                    {{-- Milestones checklist --}}
                    <div style="margin: 1rem 0; padding: 0.85rem; background: #f8fafc; border-radius: 8px;">
                        <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;"><i class="fa-solid fa-list-check"></i> Milestones Progress</span>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px;">
                            @foreach($session->milestones ?? [] as $m)
                            <li style="display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: #475569;">
                                <i class="fa-solid {{ $session->status === 'completed' || ($m['completed'] ?? false) ? 'fa-circle-check text-success' : 'fa-circle' }}" style="color: {{ $session->status === 'completed' || ($m['completed'] ?? false) ? '#22c55e' : '#cbd5e1' }}; font-size: 0.85rem;"></i>
                                <span style="{{ $session->status === 'completed' || ($m['completed'] ?? false) ? 'text-decoration: line-through; opacity: 0.6;' : '' }}">{{ $m['title'] }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    @if($session->status === 'active')
                        @if(Auth::user()->role === 'student')
                        <form action="{{ route('mentorship.complete', $session->_id) }}" method="POST" style="display: flex; flex-direction: column; gap: 8px;">
                            @csrf
                            <input type="hidden" name="rating" value="5">
                            <textarea name="feedback" rows="1" placeholder="Write feedback for your mentor..." style="width:100%; padding:0.5rem; border-radius:6px; border:1px solid #cbd5e0; font-size:0.75rem; box-sizing:border-box; outline: none;"></textarea>
                            <button type="submit" style="width: 100%; background: #3b82f6; color: white; border: none; padding: 0.5rem; border-radius: 8px; cursor: pointer; font-size: 0.8rem; font-weight: 600; text-align: center; transition: all 0.2s;">Mark as Completed</button>
                        </form>
                        @else
                        <p style="font-size: 0.75rem; color: #64748b; font-style: italic; text-align: center; margin: 0;">Ongoing guidance program. Encourage your mentee to complete program milestones.</p>
                        @endif
                    @elseif($session->status === 'completed')
                        <div style="font-size: 0.75rem; color: #16a34a; background: #f0fdf4; padding: 0.5rem; border-radius: 6px; text-align: center; font-weight: 700; border: 1px solid #bbf7d0;">
                            🏆 Program Graduated (Rating: {{ $session->rating ?? 5 }}/5)
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

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
