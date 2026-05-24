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

        <div style="display: flex; gap: 8px; flex-direction: column;">
            <a href="{{ route('jobs.resume', $application->_id) }}" target="_blank" class="hero-btn" style="display: block; text-align: center; text-decoration: none; font-size: 0.85rem;"><i class="fa-solid fa-download"></i> Download Resume</a>
            
            <form action="{{ route('jobs.status', $application->_id) }}" method="POST" style="margin: 0; width: 100%;">
                @csrf
                <div style="display: flex; align-items: center; gap: 8px; background: #f8fafc; border: 1px solid #cbd5e0; padding: 0.35rem 0.75rem; border-radius: 8px;">
                    <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #64748b; white-space: nowrap;">Update Pipeline:</span>
                    <select name="status" onchange="this.form.submit()" style="flex: 1; border: none; background: transparent; font-size: 0.78rem; font-weight: 700; color: #1e3a8a; outline: none; cursor: pointer;">
                        <option value="applied" {{ $application->status === 'applied' || $application->status === 'pending' ? 'selected' : '' }}>Applied</option>
                        <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="interviewing" {{ $application->status === 'interviewing' ? 'selected' : '' }}>Interviewing</option>
                        <option value="offered" {{ $application->status === 'offered' ? 'selected' : '' }}>Offered</option>
                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    @empty
    <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
        <p>No applications have been submitted for this job yet.</p>
    </div>
    @endforelse
</div>
@endsection
