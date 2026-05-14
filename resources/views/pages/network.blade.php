@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Networking Hub</h2>
    <p>Find mentors, collaborators, and build lifelong professional relationships.</p>
</div>

<div class="mentors-section" style="margin-top: 2rem;">
    <h3 style="margin-bottom: 1.5rem;">Recommended Mentors</h3>
    <div class="mentors-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        @forelse($mentors as $mentor)
        <div class="card" style="padding: 2rem; border-left: 4px solid var(--accent);">
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($mentor->name) }}&background=random" alt="{{ $mentor->name }}" style="width: 50px; height: 50px; border-radius: 50%;">
                <div>
                    <h4 style="font-size: 1rem;">{{ $mentor->name }}</h4>
                    <p style="font-size: 0.8rem; color: #718096;">Senior Engineer • Tech Corp</p>
                </div>
            </div>
            <p style="font-size: 0.85rem; color: #4a5568; margin-bottom: 1.5rem;">Expert in Cloud Architecture and System Design. Happy to mentor juniors.</p>
            <a href="#" class="hero-btn" style="width: 100%; text-align: center; font-size: 0.85rem;">Request Mentorship</a>
        </div>
        @empty
        <p>No mentors available yet.</p>
        @endforelse
    </div>
</div>
@endsection
