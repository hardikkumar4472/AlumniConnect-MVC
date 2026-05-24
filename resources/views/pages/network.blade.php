@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2.5rem;">
    <h2 style="font-size: 2rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-network-wired" style="color: #6366f1;"></i> Networking Hub
    </h2>
    <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Manage your connections, find mentors, and build professional relationships.</p>
</div>

@if(session('success'))
    <div style="background: rgba(34, 197, 94, 0.08); color: #16a34a; border: 1.5px solid rgba(34, 197, 94, 0.2); padding: 1rem 1.25rem; border-radius: 16px; margin-bottom: 2rem; font-weight: 600; display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.08); color: #dc2626; border: 1.5px solid rgba(239, 68, 68, 0.2); padding: 1rem 1.25rem; border-radius: 16px; margin-bottom: 2rem; font-weight: 600; display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
    </div>
@endif

{{-- Pending Connection Requests Section --}}
@if($pending_requests->count() > 0)
<div class="requests-section" style="margin-top: 2rem; margin-bottom: 3rem;">
    <h3 class="net-section-title" style="margin-top: 0;">
        <i class="fa-solid fa-user-clock" style="color: #f59e0b;"></i> Pending Invitations ({{ $pending_requests->count() }})
    </h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
        @foreach($pending_requests as $request)
        <div class="net-request-card">
            <div style="display: flex; gap: 1rem; align-items: center;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($request->requester->name) }}&background=random&size=96" style="width: 48px; height: 48px; border-radius: 14px; object-fit: cover; border: 2px solid #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.05);" alt="">
                <div>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin: 0;">
                        <a href="{{ route('profile', $request->requester->_id) }}" style="color: inherit; text-decoration: none;">{{ $request->requester->name }}</a>
                    </h4>
                    <span style="font-size: 0.72rem; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 8px; text-transform: uppercase; margin-top: 4px; display: inline-block;">
                        {{ ucfirst($request->requester->role) }}
                    </span>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <form action="{{ route('connect.accept', $request->_id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-premium-action connect" style="padding: 0.5rem 1rem; font-size: 0.78rem; border-radius: 10px; min-width: 75px; height: 36px; box-shadow: none;">
                        Accept
                    </button>
                </form>
                <form action="{{ route('connect.reject', $request->_id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-premium-action profile" style="padding: 0.5rem 1rem; font-size: 0.78rem; border-radius: 10px; min-width: 75px; height: 36px; background: rgba(239, 68, 68, 0.08); color: #dc2626; border-color: rgba(239, 68, 68, 0.15);">
                        Reject
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Connections list --}}
<div class="connections-section" style="margin-top: 3rem; margin-bottom: 3rem;">
    <h3 class="net-section-title" style="margin-top: 0;">
        <i class="fa-solid fa-users" style="color: #6366f1;"></i> My Network ({{ $connected_users->count() }})
    </h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
        @forelse($connected_users as $user)
        <div class="dir-card">
            <div class="dir-avatar-wrap" style="width: 80px; height: 80px;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=128" style="border-radius: 20px;" class="dir-avatar" alt="">
            </div>
            <h4 class="dir-name" style="font-size: 1.15rem;">{{ $user->name }}</h4>
            <p class="dir-meta" style="margin-bottom: 1.25rem;">{{ $user->company ?? 'GEC Network' }}</p>
            
            <div class="tag-pill-container" style="margin-bottom: 1.5rem;">
                <span class="tag-pill department" style="padding: 0.35rem 0.75rem; font-size: 0.7rem;">
                    {{ $user->department ?? 'Engineering' }}
                </span>
                <span class="tag-pill batch" style="padding: 0.35rem 0.75rem; font-size: 0.7rem;">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            
            <div class="dir-actions">
                <a href="{{ route('profile', $user->_id) }}" class="btn-premium-action profile" style="padding: 0.65rem 1rem; border-radius: 12px; font-size: 0.8rem;">
                    <i class="fa-solid fa-user"></i> Profile
                </a>
                <a href="{{ route('chat', $user->_id) }}" class="btn-premium-action connect" style="padding: 0.65rem 1rem; border-radius: 12px; font-size: 0.8rem; box-shadow: none;">
                    <i class="fa-solid fa-comments"></i> Chat
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: #ffffff; border-radius: 24px; border: 1px dashed #cbd5e1;">
            <i class="fa-solid fa-users-rectangle" style="font-size: 3rem; color: #94a3b8; margin-bottom: 1.5rem; display: block; opacity: 0.5;"></i>
            <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; font-weight: 700;">No Connections Yet</h4>
            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">Expand your directory search to connect with alumni and grow your networking space.</p>
            <a href="{{ route('directory') }}" class="btn-premium-action connect" style="display: inline-flex; max-width: 200px; padding: 0.8rem 1.5rem; border-radius: 12px; margin: 0 auto;">
                Explore Directory
            </a>
        </div>
        @endforelse
    </div>
</div>

{{-- Incoming Mentorship Requests (Alumni Only) --}}
@if(Auth::user()->role === 'alumni' && $incoming_mentorships->count() > 0)
<div class="mentorship-incoming-section" style="margin-top: 3rem; margin-bottom: 3rem;">
    <h3 class="net-section-title">
        <i class="fa-solid fa-graduation-cap" style="color: #10b981;"></i> Mentorship Applications ({{ $incoming_mentorships->count() }})
    </h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
        @foreach($incoming_mentorships as $session)
        <div class="mentor-session-card" style="border-left: 5px solid #10b981;">
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.25rem;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($session->mentee->name ?? 'Student') }}&background=random&size=96" style="width: 44px; height: 44px; border-radius: 12px; border: 2px solid #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.05);" alt="">
                <div>
                    <h4 style="font-size: 0.95rem; margin: 0; font-weight: 700;">
                        <a href="{{ route('profile', $session->mentee_id) }}" style="color: inherit; text-decoration: none;">{{ $session->mentee->name ?? 'Student' }}</a>
                    </h4>
                    <p style="font-size: 0.72rem; color: #64748b; margin-top: 2px; font-weight: 600;">Class of {{ $session->mentee->graduation_year ?? 'N/A' }} · {{ $session->mentee->department ?? 'Engineering' }}</p>
                </div>
            </div>
            <p style="font-size: 0.82rem; color: #475569; line-height: 1.5; background: #f8fafc; padding: 1rem; border-radius: 12px; margin: 0 0 1.25rem; font-style: italic; border: 1px solid #f1f5f9;">
                "{{ $session->message }}"
            </p>
            <div style="display: flex; gap: 10px;">
                <form action="{{ route('mentorship.accept', $session->_id) }}" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    <button type="submit" class="btn-premium-action connect" style="width: 100%; padding: 0.65rem; border-radius: 10px; font-size: 0.8rem; box-shadow: none;">
                        Accept Request
                    </button>
                </form>
                <form action="{{ route('mentorship.reject', $session->_id) }}" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    <button type="submit" class="btn-premium-action profile" style="width: 100%; padding: 0.65rem; border-radius: 10px; font-size: 0.8rem; background: rgba(239, 68, 68, 0.08); color: #dc2626; border-color: rgba(239, 68, 68, 0.15);">
                        Decline
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Mentorship Sessions Tracker --}}
@if($my_mentorships->count() > 0)
<div class="mentorship-active-section" style="margin-top: 4rem; margin-bottom: 3rem;">
    <h3 class="net-section-title">
        <i class="fa-solid fa-chalkboard-user" style="color: #6366f1;"></i> Mentorship Programs
    </h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 2rem;">
        @foreach($my_mentorships as $session)
        @php
            $partner = Auth::user()->role === 'alumni' ? ($session->mentee ?? null) : ($session->mentor ?? null);
            if (!$partner) continue;
            $statusColors = [
                'active'    => ['bg' => 'rgba(99, 102, 241, 0.08)', 'text' => '#4f46e5', 'border' => '#6366f1'],
                'completed' => ['bg' => 'rgba(34, 197, 94, 0.08)', 'text' => '#16a34a', 'border' => '#22c55e'],
                'rejected'  => ['bg' => 'rgba(239, 68, 68, 0.08)', 'text' => '#dc2626', 'border' => '#ef4444'],
                'pending'   => ['bg' => 'rgba(245, 158, 11, 0.08)', 'text' => '#d97706', 'border' => '#f59e0b'],
            ];
            $meta = $statusColors[$session->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'];
        @endphp
        <div class="mentor-session-card" style="border-top: 5px solid {{ $meta['border'] }}; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem;">
                    <div style="display: flex; gap: 0.75rem; align-items: center;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($partner->name) }}&background=random&size=96" style="width: 42px; height: 42px; border-radius: 12px; border: 2px solid #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.05);" alt="">
                        <div>
                            <h4 style="font-size: 0.95rem; margin: 0; font-weight: 700;">
                                <a href="{{ route('profile', $partner->_id) }}" style="color: inherit; text-decoration: none;">{{ $partner->name }}</a>
                            </h4>
                            <span style="font-size: 0.72rem; color: #64748b; font-weight: 600;">
                                {{ Auth::user()->role === 'alumni' ? 'Mentee' : 'Mentor' }} · {{ $partner->department ?? 'Engineering' }}
                            </span>
                        </div>
                    </div>
                    <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.65rem; font-weight: 800; background: {{ $meta['bg'] }}; color: {{ $meta['text'] }}; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid rgba(0,0,0,0.02);">
                        {{ $session->status }}
                    </span>
                </div>

                {{-- Milestones progress bar --}}
                <div class="mentor-milestone-panel">
                    <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #475569; letter-spacing: 0.5px; display: block; margin-bottom: 0.75rem;">
                        <i class="fa-solid fa-list-check" style="color: #6366f1;"></i> Milestones Progress
                    </span>
                    <ul class="mentor-milestone-list">
                        @foreach($session->milestones ?? [] as $m)
                        <li class="mentor-milestone-item">
                            <i class="fa-solid {{ $session->status === 'completed' || ($m['completed'] ?? false) ? 'fa-circle-check mentor-milestone-icon' : 'fa-circle mentor-milestone-icon' }}" style="color: {{ $session->status === 'completed' || ($m['completed'] ?? false) ? '#22c55e' : '#cbd5e1' }}; font-size: 0.9rem;"></i>
                            <span style="{{ $session->status === 'completed' || ($m['completed'] ?? false) ? 'text-decoration: line-through; opacity: 0.65;' : '' }} font-size: 0.8rem; font-weight: 600;">{{ $m['title'] }}</span>
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
                        <textarea name="feedback" rows="2" placeholder="Write dynamic feedback for your mentor..." class="net-feedback-textarea"></textarea>
                        <button type="submit" class="btn-premium-action connect" style="width: 100%; padding: 0.7rem; border-radius: 10px; font-size: 0.8rem; box-shadow: none;">
                            Complete Program
                        </button>
                    </form>
                    @else
                    <div style="font-size: 0.75rem; color: #4f46e5; background: rgba(99, 102, 241, 0.08); padding: 0.75rem; border-radius: 10px; text-align: center; font-weight: 600; border: 1px solid rgba(99, 102, 241, 0.15);">
                        <i class="fa-solid fa-spinner fa-spin" style="margin-right: 4px;"></i> Mentorship Active (Ongoing Program)
                    </div>
                    @endif
                @elseif($session->status === 'completed')
                    <div style="font-size: 0.78rem; color: #16a34a; background: rgba(34, 197, 94, 0.08); padding: 0.75rem; border-radius: 10px; text-align: center; font-weight: 700; border: 1.5px solid rgba(34, 197, 94, 0.15); display: flex; align-items: center; justify-content: center; gap: 6px;">
                        🏆 Program Graduated (Rating: {{ $session->rating ?? 5 }}/5)
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Discover Alumni section --}}
<div class="mentors-section" style="margin-top: 4rem; margin-bottom: 2rem;">
    <h3 class="net-section-title">
        <i class="fa-solid fa-wand-magic-sparkles" style="color: #6366f1;"></i> Discover GEC Alumni
    </h3>
    <div class="mentors-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
        @forelse($mentors as $mentor)
        <div class="dir-card" style="text-align: center; padding: 2.5rem 1.5rem;">
            <div class="dir-avatar-wrap" style="width: 80px; height: 80px;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($mentor->name) }}&background=random&size=128" style="border-radius: 20px;" class="dir-avatar" alt="{{ $mentor->name }}">
            </div>
            
            <h4 class="dir-name" style="font-size: 1.15rem;"><a href="{{ route('profile', $mentor->_id) }}" style="color: inherit; text-decoration: none;">{{ $mentor->name }}</a></h4>
            <p class="dir-meta" style="margin-bottom: 1.25rem;">Class of {{ $mentor->graduation_year ?? 'N/A' }} · {{ $mentor->department ?? 'Engineering' }}</p>
            
            <div style="margin-top: auto;">
                @if(in_array((string)$mentor->_id, $connected_user_ids))
                    <button class="btn-premium-action connected" style="width: 100%; border-radius: 12px; padding: 0.75rem;" disabled>
                        <i class="fa-solid fa-circle-check"></i> Connected
                    </button>
                @elseif(in_array((string)$mentor->_id, $sent_request_ids))
                    <button class="btn-premium-action pending" style="width: 100%; border-radius: 12px; padding: 0.75rem;" disabled>
                        <i class="fa-solid fa-clock-rotate-left"></i> Pending Request
                    </button>
                @else
                    <form action="{{ route('connect.request', $mentor->_id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-premium-action connect" style="width: 100%; border-radius: 12px; padding: 0.75rem; box-shadow: none;">
                            <i class="fa-solid fa-user-plus"></i> Connect
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @empty
        <p style="color: #64748b; font-size: 0.9rem; grid-column: 1 / -1; text-align: center; padding: 2rem;">No other alumni profiles available at the moment.</p>
        @endforelse
    </div>
</div>
@endsection
