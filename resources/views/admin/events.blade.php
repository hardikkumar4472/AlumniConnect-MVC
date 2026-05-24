@extends('layouts.app')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Event Management</h2>
        <p>Organize reunions, workshops, and seminars for the alumni community.</p>
    </div>
    <button onclick="document.getElementById('addEventModal').style.display='block'" class="hero-btn">Create Event</button>
</div>

<div class="card" style="margin-top: 2rem;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #f1f5f9; color: #718096; font-size: 0.85rem; background: #f8fafc;">
                <th style="padding: 1.5rem;">EVENT</th>
                <th style="padding: 1.5rem;">DATE / TIME</th>
                <th style="padding: 1.5rem;">LOCATION</th>
                <th style="padding: 1.5rem;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr style="border-bottom: 1px solid #f8fafc;">
                <td style="padding: 1.5rem; font-weight: 700;">
                    {{ $event->title }}<br>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #10b981; margin-top: 4px; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fa-solid fa-users"></i> {{ $event->rsvps_count }} registered
                    </span>
                </td>
                <td style="padding: 1.5rem;">
                    <span style="font-weight: 600;">{{ $event->date }} {{ $event->month }}</span><br>
                    <span style="font-size: 0.8rem; color: #a0aec0;">{{ $event->time }}</span>
                </td>
                <td style="padding: 1.5rem; color: #718096;">{{ $event->location }}</td>
                <td style="padding: 1.5rem; display: flex; gap: 10px; align-items: center;">
                    <button onclick="document.getElementById('rsvpsModal-{{ $event->id }}').style.display='flex'" style="background: #eff6ff; color: #1e4ed8; border: none; padding: 0.4rem 0.85rem; border-radius: 8px; font-size: 0.78rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                        <i class="fa-solid fa-users-rectangle"></i> Roster
                    </button>
                    <button onclick="document.getElementById('editEventModal-{{ $event->id }}').style.display='flex'" style="background:none; border:none; color:#3182ce; cursor:pointer;"><i class="fa-solid fa-pen"></i></button>
                    <form action="{{ route('admin.events.delete', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?')" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#e53e3e; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>

            <!-- Rsvps Roster Modal -->
            <div id="rsvpsModal-{{ $event->id }}" style="display:none; position:fixed; inset:0; background:rgba(6,26,61,0.6); z-index:2000; align-items:center; justify-content:center; backdrop-filter: blur(4px);">
                <div class="card" style="width: 600px; max-width: 90%; padding: 2rem; max-height: 80vh; overflow-y: auto; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); text-align: left;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;">
                        <div>
                            <h3 style="margin: 0; font-size: 1.25rem; color: #0f172a;">Attendee Roster</h3>
                            <p style="margin: 4px 0 0; font-size: 0.85rem; color: #64748b;">{{ $event->title }} · {{ $event->rsvps_count }} registered users</p>
                        </div>
                        <button onclick="document.getElementById('rsvpsModal-{{ $event->id }}').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #94a3b8; transition: color 0.2s;" onmouseover="this.style.color='#64748b'" onmouseout="this.style.color='#94a3b8'">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    @if($event->rsvps->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @foreach($event->rsvps as $rsvp)
                            @if($rsvp->user)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.85rem 1.25rem; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($rsvp->user->name) }}&background=random" style="width: 40px; height: 40px; border-radius: 50%;">
                                    <div>
                                        <span style="font-size: 0.95rem; font-weight: 700; color: #1e293b; display: block;">{{ $rsvp->user->name }}</span>
                                        <span style="font-size: 0.78rem; color: #64748b;">{{ $rsvp->user->email }} · {{ ucfirst($rsvp->user->role) }}</span>
                                        <span style="font-size: 0.72rem; color: #94a3b8; display: block; margin-top: 2px;">
                                            Batch of {{ $rsvp->user->graduation_year ?? 'N/A' }} · {{ $rsvp->user->department ?? 'Engineering' }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    @php
                                        $statusColors = [
                                            'going'      => ['bg' => '#dcfce7', 'text' => '#15803d'],
                                            'interested' => ['bg' => '#eff6ff', 'text' => '#1d4ed8'],
                                            'not_going'  => ['bg' => '#fef2f2', 'text' => '#b91c1c'],
                                        ];
                                        $badge = $statusColors[$rsvp->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
                                    @endphp
                                    <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; background: {{ $badge['bg'] }}; color: {{ $badge['text'] }}; text-transform: uppercase;">
                                        {{ str_replace('_', ' ', $rsvp->status) }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    @else
                    <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                        <i class="fa-solid fa-users-slash" style="font-size: 2.5rem; margin-bottom: 1rem; display: block;"></i>
                        <p style="font-size: 0.95rem; margin: 0;">No registrations logged for this event yet.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Edit Modal -->
            <div id="editEventModal-{{ $event->id }}" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:2000; align-items:center; justify-content:center;">
                <div class="card" style="width: 500px; padding: 2rem;">
                    <h3>Edit Event</h3>
                    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" style="margin-top: 1.5rem;">
                        @csrf
                        @method('PUT')
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label>Event Title</label>
                            <input type="text" name="title" value="{{ $event->title }}" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                        <div style="display: flex; gap: 15px; margin-bottom: 1rem;">
                            <div class="form-group" style="flex: 1;">
                                <label>Day (Number)</label>
                                <input type="text" name="date" value="{{ $event->date }}" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label>Month (Short)</label>
                                <input type="text" name="month" value="{{ $event->month }}" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label>Location</label>
                            <input type="text" name="location" value="{{ $event->location }}" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label>Time</label>
                            <input type="text" name="time" value="{{ $event->time }}" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="hero-btn" style="flex: 1;">Save Changes</button>
                            <button type="button" onclick="document.getElementById('editEventModal-{{ $event->id }}').style.display='none'" class="social-btn" style="flex: 1; padding:0.8rem; border:1px solid #cbd5e0; border-radius:8px; background:white; cursor:pointer;">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Simple Modal -->
<div id="addEventModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:2000; display:flex; align-items:center; justify-content:center;">
    <div class="card" style="width: 500px; padding: 2rem;">
        <h3>Create New Event</h3>
        <form action="{{ route('admin.events.store') }}" method="POST" style="margin-top: 1.5rem;">
            @csrf
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Event Title</label>
                <input type="text" name="title" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div style="display: flex; gap: 15px; margin-bottom: 1rem;">
                <div class="form-group" style="flex: 1;">
                    <label>Day (Number)</label>
                    <input type="number" name="date" placeholder="15" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Month (Short)</label>
                    <input type="text" name="month" placeholder="JUN" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Location</label>
                <input type="text" name="location" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div class="form-group" style="margin-bottom: 2rem;">
                <label>Time</label>
                <input type="text" name="time" placeholder="10:00 AM - 4:00 PM" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="hero-btn" style="flex: 1;">Create Event</button>
                <button type="button" onclick="document.getElementById('addEventModal').style.display='none'" class="social-btn" style="flex: 1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    window.onclick = function(event) {
        if (event.target == document.getElementById('addEventModal')) {
            document.getElementById('addEventModal').style.display = "none";
        }
    }
</script>
@endsection
