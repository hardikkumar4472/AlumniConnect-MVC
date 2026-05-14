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
                <td style="padding: 1.5rem; font-weight: 700;">{{ $event->title }}</td>
                <td style="padding: 1.5rem;">
                    <span style="font-weight: 600;">{{ $event->date }} {{ $event->month }}</span><br>
                    <span style="font-size: 0.8rem; color: #a0aec0;">{{ $event->time }}</span>
                </td>
                <td style="padding: 1.5rem; color: #718096;">{{ $event->location }}</td>
                <td style="padding: 1.5rem;">
                    <form action="{{ route('admin.events.delete', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#e53e3e; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
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
