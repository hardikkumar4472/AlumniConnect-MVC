@extends('layouts.app')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Job Portal</h2>
        <p>Explore career opportunities shared by our alumni network.</p>
    </div>
    <a href="#" class="hero-btn">Post a Job</a>
</div>

<div class="jobs-list" style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1rem;">
    @forelse($jobs as $job)
    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem;">
        <div style="display: flex; gap: 1.5rem; align-items: center;">
            <div style="width: 60px; height: 60px; background: #edf2f7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--primary);">
                <i class="fa-solid fa-building"></i>
            </div>
            <div>
                <h3 style="font-size: 1.1rem; margin-bottom: 0.3rem;">{{ $job->title }}</h3>
                <p style="font-size: 0.9rem; color: #718096;">{{ $job->company }} • {{ $job->type ?? 'Full-time' }}</p>
            </div>
        </div>
        <a href="{{ $job->link ?? '#' }}" class="hero-btn" style="padding: 0.6rem 1.5rem;">Apply Now</a>
    </div>
    @empty
    <div class="card" style="text-align: center; padding: 3rem;">
        <p>No job opportunities available at the moment.</p>
    </div>
    @endforelse
</div>
@endsection
