@extends('layouts.app')

@section('styles')
<style>
.event-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
}
.event-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,71,171,0.08);
}
.event-banner {
    height: 140px;
    background: linear-gradient(135deg, #0047ab 0%, #1e3a8a 60%, #061a3d 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    position: relative;
}
.event-banner-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px);
    background-size: 15px 15px;
}
.event-date-badge {
    text-align: center;
    position: relative;
    z-index: 1;
}
.event-date-badge h1 {
    font-size: 3rem;
    font-weight: 800;
    line-height: 1;
    margin: 0;
}
.event-date-badge p {
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 0.8rem;
    margin: 4px 0 0;
    font-weight: 700;
    opacity: 0.9;
}
.rsvp-btn {
    flex: 1;
    padding: 0.5rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
    border: 1.5px solid transparent;
}
.rsvp-btn-going { border-color: #10b981; color: #10b981; background: white; }
.rsvp-btn-going.active { background: #10b981; color: white; }
.rsvp-btn-going:hover { background: #10b981; color: white; }

.rsvp-btn-interested { border-color: #3b82f6; color: #3b82f6; background: white; }
.rsvp-btn-interested.active { background: #3b82f6; color: white; }
.rsvp-btn-interested:hover { background: #3b82f6; color: white; }

.rsvp-btn-notgoing { border-color: #ef4444; color: #ef4444; background: white; }
.rsvp-btn-notgoing.active { background: #ef4444; color: white; }
.rsvp-btn-notgoing:hover { background: #ef4444; color: white; }

/* Attendee Avatar Pile */
.avatar-pile {
    display: flex;
    align-items: center;
}
.avatar-pile img {
    width: 28px; height: 28px;
    border-radius: 50%;
    border: 2px solid white;
    margin-left: -8px;
    object-fit: cover;
}
.avatar-pile img:first-child { margin-left: 0; }
.avatar-pile-more {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #475569;
    font-size: 0.7rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
    margin-left: -8px;
    cursor: pointer;
}

/* Jitsi Modal overlay */
.meetup-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(6,26,61,0.8);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(8px);
}
.meetup-modal {
    background: white;
    border-radius: 24px;
    width: 95%;
    max-width: 1000px;
    height: 85vh;
    overflow: hidden;
    box-shadow: 0 40px 80px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
}
</style>
@endsection

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h2>Events & Reunions</h2>
    <p>Stay updated with the latest campus gatherings, professional workshops, and networking meetups.</p>
</div>

@if(session('success'))
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; font-weight: 600;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div class="events-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.5rem;">
    @forelse($events as $event)
    @php
        $isVirtual = Str::contains(strtolower($event->location), ['online', 'virtual', 'zoom', 'jitsi']);
        $goingCount = $event->rsvps->where('status', 'going')->count();
        $interestedCount = $event->rsvps->where('status', 'interested')->count();
        $goingList = $event->rsvps->where('status', 'going')->take(5);
        $myRsvpStatus = $event->my_rsvp ? $event->my_rsvp->status : null;
    @endphp
    <div class="event-card">
        <div class="event-banner">
            <div class="event-banner-dots"></div>
            <div class="event-date-badge">
                <h1>{{ $event->date }}</h1>
                <p>{{ $event->month }}</p>
            </div>
        </div>
        <div style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1; justify-content: space-between;">
            <div>
                <h3 style="margin: 0 0 0.75rem; font-size: 1.15rem; color: #0f172a; font-weight: 800; line-height: 1.3;">{{ $event->title }}</h3>
                
                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.6; margin: 0 0 1rem;">
                    <span style="display: block; margin-bottom: 4px;"><i class="fa-solid fa-clock" style="margin-right: 6px; width: 14px; color: #94a3b8;"></i> {{ $event->time }}</span>
                    <span style="display: block;"><i class="fa-solid fa-location-dot" style="margin-right: 6px; width: 14px; color: #94a3b8;"></i> {{ $event->location }}</span>
                </p>

                {{-- Interactive Virtual Room card if online --}}
                @if($isVirtual)
                <div style="background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1px solid #bfdbfe; border-radius: 12px; padding: 0.75rem 1rem; margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                    <div>
                        <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #1e4ed8; letter-spacing: 0.5px; display: block;">Virtual Room Setup</span>
                        <span style="font-size: 0.78rem; color: #1e3a8a; font-weight: 600;">Jitsi Meet Video Active</span>
                    </div>
                    <button onclick="openMeetup('{{ md5($event->_id) }}', '{{ addslashes($event->title) }}')" style="padding: 0.4rem 0.85rem; border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 700; background: #0047ab; color: white; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa-solid fa-video"></i> Join Room
                    </button>
                </div>
                @endif

                {{-- Roster avatar list --}}
                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.75rem; border-top: 1px solid #f1f5f9; margin-bottom: 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        @if($goingList->count() > 0)
                        <div class="avatar-pile">
                            @foreach($goingList as $r)
                                @if($r->user)
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($r->user->name) }}&background=random" title="{{ $r->user->name }}">
                                @endif
                            @endforeach
                            @if($goingCount > 5)
                            <div class="avatar-pile-more" onclick="document.getElementById('attendeesModal-{{ $event->_id }}').style.display='flex'">+{{ $goingCount - 5 }}</div>
                            @endif
                        </div>
                        <span style="font-size: 0.75rem; color: #64748b; font-weight: 600; margin-left: 4px;" onclick="document.getElementById('attendeesModal-{{ $event->_id }}').style.display='flex'">{{ $goingCount }} attending</span>
                        @else
                        <span style="font-size: 0.75rem; color: #94a3b8; font-style: italic;"><i class="fa-solid fa-users"></i> No attendees registered yet</span>
                        @endif
                    </div>
                    @if($goingCount > 0)
                    <button onclick="document.getElementById('attendeesModal-{{ $event->_id }}').style.display='flex'" style="background: none; border: none; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #0047ab; cursor: pointer; letter-spacing: 0.5px;">View List</button>
                    @endif
                </div>
            </div>

            {{-- RSVP Actions --}}
            <div style="background: #f8fafc; border-radius: 12px; padding: 0.75rem; border: 1px solid #f1f5f9;">
                <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem; text-align: center;">My RSVP Status</span>
                <form action="{{ route('events.rsvp', $event->_id) }}" method="POST" id="rsvpForm-{{ $event->_id }}">
                    @csrf
                    <input type="hidden" name="status" id="rsvpInput-{{ $event->_id }}">
                    <div style="display: flex; gap: 6px;">
                        <button type="button" onclick="submitRsvp('{{ $event->_id }}', 'going')" class="rsvp-btn rsvp-btn-going {{ $myRsvpStatus === 'going' ? 'active' : '' }}">
                            <i class="fa-solid fa-circle-check"></i> Going
                        </button>
                        <button type="button" onclick="submitRsvp('{{ $event->_id }}', 'interested')" class="rsvp-btn rsvp-btn-interested {{ $myRsvpStatus === 'interested' ? 'active' : '' }}">
                            <i class="fa-solid fa-star"></i> Interested
                        </button>
                        <button type="button" onclick="submitRsvp('{{ $event->_id }}', 'not_going')" class="rsvp-btn rsvp-btn-notgoing {{ $myRsvpStatus === 'not_going' ? 'active' : '' }}">
                            <i class="fa-solid fa-circle-xmark"></i> No
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Attendees Roster List Overlay Modal --}}
    <div id="attendeesModal-{{ $event->_id }}" style="display:none; position:fixed; inset:0; background:rgba(6,26,61,0.6); z-index:9000; align-items:center; justify-content:center; backdrop-filter: blur(4px);">
        <div class="card" style="width: 500px; max-width: 90%; padding: 2rem; max-height: 75vh; overflow-y: auto; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;">
                <div>
                    <h3 style="margin: 0; font-size: 1.15rem; color: #0f172a; font-weight: 800;">Attendees List</h3>
                    <p style="margin: 4px 0 0; font-size: 0.8rem; color: #64748b;">Roster for: {{ $event->title }}</p>
                </div>
                <button onclick="document.getElementById('attendeesModal-{{ $event->_id }}').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #94a3b8; transition: color 0.2s;" onmouseover="this.style.color='#64748b'" onmouseout="this.style.color='#94a3b8'">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @foreach($event->rsvps as $r)
                    @if($r->user)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($r->user->name) }}&background=random" style="width: 38px; height: 38px; border-radius: 50%;">
                            <div>
                                <span style="font-size: 0.88rem; font-weight: 700; color: #1e293b; display: block; text-align: left;">{{ $r->user->name }}</span>
                                <span style="font-size: 0.75rem; color: #64748b; display: block; text-align: left;">Batch of {{ $r->user->graduation_year ?? 'N/A' }} · {{ ucfirst($r->user->role) }}</span>
                            </div>
                        </div>
                        <div>
                            @php
                                $bColors = [
                                    'going'      => ['bg' => '#dcfce7', 'text' => '#15803d'],
                                    'interested' => ['bg' => '#eff6ff', 'text' => '#1d4ed8'],
                                    'not_going'  => ['bg' => '#fef2f2', 'text' => '#b91c1c'],
                                ];
                                $bMeta = $bColors[$r->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
                            @endphp
                            <span style="padding: 3px 8px; border-radius: 20px; font-size: 0.68rem; font-weight: 800; background: {{ $bMeta['bg'] }}; color: {{ $bMeta['text'] }}; text-transform: uppercase;">
                                {{ str_replace('_', ' ', $r->status) }}
                            </span>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 4rem 1rem;">
        <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
        <p style="font-size: 1.1rem; font-weight: 600; margin: 0 0 4px;">No upcoming events scheduled</p>
        <p style="font-size: 0.88rem; margin: 0;">Stay tuned for invitations and reuniouns soon!</p>
    </div>
    @endforelse
</div>

{{-- Jitsi Video Networking Overlay --}}
<div class="meetup-overlay" id="meetupOverlay">
    <div class="meetup-modal">
        <div style="background: linear-gradient(135deg, #072b5b, #0f4c9b); padding: 1.25rem 2rem; color: white; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-video-camera" style="font-size: 1.4rem; color: #60a5fa;"></i>
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; color: white;" id="meetupTitle">Virtual Networking Workspace</h3>
                    <p style="margin: 2px 0 0; font-size: 0.75rem; opacity: 0.8;">Integrated live video, audio, & screen sharing room</p>
                </div>
            </div>
            <button onclick="closeMeetup()" style="background: none; border: none; color: rgba(255,255,255,0.7); font-size: 1.4rem; cursor: pointer; padding: 0;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="flex: 1; background: #111; position: relative;" id="meetupIframeContainer">
            {{-- Meetup Iframe will load here --}}
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function submitRsvp(eventId, status) {
    const input = document.getElementById('rsvpInput-' + eventId);
    const form = document.getElementById('rsvpForm-' + eventId);
    if (input && form) {
        input.value = status;
        form.submit();
    }
}

function openMeetup(roomHash, eventTitle) {
    const overlay = document.getElementById('meetupOverlay');
    const title = document.getElementById('meetupTitle');
    const container = document.getElementById('meetupIframeContainer');

    title.textContent = 'Virtual Room: ' + eventTitle;

    // Load dynamic embedded Jitsi room using md5 event hash
    const roomName = 'GEC-Alumni-Reunion-' + roomHash;
    const userName = encodeURIComponent('{{ Auth::user()->name }}');
    container.innerHTML = `<iframe src="https://meet.jit.si/${roomName}#userInfo.displayName=%22${userName}%22" style="border:0; width:100%; height:100%;" allow="camera; microphone; fullscreen; display-capture; autoplay"></iframe>`;

    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeMeetup() {
    const overlay = document.getElementById('meetupOverlay');
    const container = document.getElementById('meetupIframeContainer');

    container.innerHTML = '';
    overlay.style.display = 'none';
    document.body.style.overflow = '';
}

// Close modal on click outside modal card
window.onclick = function(e) {
    const overlays = document.querySelectorAll('[id^="attendeesModal-"], #meetupOverlay');
    overlays.forEach(o => {
        if (e.target === o) {
            o.style.display = 'none';
            if (o.id === 'meetupOverlay') {
                document.getElementById('meetupIframeContainer').innerHTML = '';
            }
            document.body.style.overflow = '';
        }
    });
}
</script>
@endsection
