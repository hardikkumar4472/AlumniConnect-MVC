@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <a href="{{ route('jobs') }}" style="color: #0047ab; text-decoration: none; font-size: 0.9rem; font-weight: 600;"><i class="fa-solid fa-arrow-left"></i> Back to Jobs</a>
    <h2 style="margin-top: 1rem;">Applications for: {{ $job->title }}</h2>
    <p>Company: {{ $job->company }} • Type: {{ $job->type }}</p>
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

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
    @forelse($applications as $application)
    <div class="card" style="padding: 1.5rem;">
        <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($application->applicant->name) }}&background=random" style="width: 50px; height: 50px; border-radius: 50%;">
            <div>
                <h4 style="font-size: 1.1rem;"><a href="{{ route('profile', $application->applicant->_id) }}" style="color: inherit; text-decoration: none;">{{ $application->applicant->name }}</a></h4>
                <p style="font-size: 0.85rem; color: #718096;">Batch of {{ $application->applicant->graduation_year ?? 'N/A' }} • {{ $application->applicant->department ?? 'Engineering' }}</p>
            </div>
        </div>
        
        <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <p style="font-size: 0.9rem; color: #4a5568;"><i class="fa-solid fa-envelope"></i> <a href="mailto:{{ $application->applicant->email }}">{{ $application->applicant->email }}</a></p>
            <p style="font-size: 0.9rem; color: #4a5568; margin-top: 0.5rem;"><i class="fa-solid fa-calendar"></i> Applied on {{ $application->created_at->format('M d, Y') }}</p>
        </div>

        <a href="{{ route('jobs.resume', $application->_id) }}" target="_blank" class="hero-btn" style="display: block; text-align: center; text-decoration: none;"><i class="fa-solid fa-download"></i> Download Resume</a>
    </div>
    @empty
    <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
        <p>No applications have been submitted for this job yet.</p>
    </div>
    @endforelse
</div>
@endsection
