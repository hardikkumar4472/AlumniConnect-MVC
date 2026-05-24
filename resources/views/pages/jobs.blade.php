@extends('layouts.app')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Job Portal</h2>
        <p>Explore career opportunities shared by our alumni network.</p>
    </div>
    @if(Auth::user()->role === 'alumni')
        <button onclick="document.getElementById('postJobModal').style.display='block'" class="hero-btn" style="border:none; cursor:pointer;">Post a Job</button>
    @endif
</div>

@if(session('success'))
    <div style="background: #c6f6d5; color: #2f855a; padding: 1rem; border-radius: 8px; margin-top: 1.5rem;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background: #fed7d7; color: #c53030; padding: 1rem; border-radius: 8px; margin-top: 1.5rem;">
        {{ session('error') }}
    </div>
@endif

<!-- Post Job Modal (Hidden by default) -->
<div id="postJobModal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="background: white; max-width: 500px; margin: 10% auto; padding: 2rem; border-radius: 12px;">
        <h3 style="margin-bottom: 1.5rem;">Post a New Job</h3>
        <form action="{{ route('jobs.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label>Job Title</label>
                <input type="text" name="title" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label>Company</label>
                <input type="text" name="company" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label>Type</label>
                <select name="type" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px;">
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Internship">Internship</option>
                    <option value="Contract">Contract</option>
                </select>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label>Description</label>
                <textarea name="description" required rows="4" style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px;"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('postJobModal').style.display='none'" style="padding: 0.8rem 1.5rem; border: 1px solid #cbd5e0; background: white; border-radius: 8px; cursor: pointer;">Cancel</button>
                <button type="submit" class="hero-btn" style="border: none; cursor: pointer;">Post Job</button>
            </div>
        </form>
    </div>
</div>

<div class="jobs-list" style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1rem;">
    @forelse($jobs as $job)
    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem;">
        <div style="display: flex; gap: 1.5rem; align-items: center;">
            <div style="width: 60px; height: 60px; background: #edf2f7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--primary);">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <div>
                <h3 style="font-size: 1.1rem; margin-bottom: 0.3rem;">{{ $job->title }}</h3>
                <p style="font-size: 0.9rem; color: #718096; margin-bottom: 0.5rem;">{{ $job->company }} • {{ $job->type ?? 'Full-time' }}</p>
                <p style="font-size: 0.85rem; color: #4a5568; max-width: 600px;">{{ Str::limit($job->description, 100) }}</p>
            </div>
        </div>
        
        <div>
            @if(Auth::id() == $job->posted_by)
                <a href="{{ route('jobs.applications', $job->_id) }}" class="hero-btn" style="padding: 0.6rem 1.5rem; background: #2b6cb0; text-decoration: none;">View Applications ({{ $job->applications ? $job->applications->count() : 0 }})</a>
            @elseif(Auth::user()->role === 'student')
                @if(isset($applied_jobs_status[(string)$job->_id]))
                    @php
                        $status = $applied_jobs_status[(string)$job->_id];
                        $stColors = [
                            'pending'      => ['bg' => '#edf2f7', 'text' => '#4a5568', 'lbl' => 'Applied'],
                            'applied'      => ['bg' => '#edf2f7', 'text' => '#4a5568', 'lbl' => 'Applied'],
                            'shortlisted'  => ['bg' => '#e0f2fe', 'text' => '#0369a1', 'lbl' => 'Shortlisted'],
                            'interviewing' => ['bg' => '#fef3c7', 'text' => '#d97706', 'lbl' => 'Interviewing'],
                            'offered'      => ['bg' => '#dcfce7', 'text' => '#15803d', 'lbl' => 'Offered 🎉'],
                            'rejected'     => ['bg' => '#fef2f2', 'text' => '#991b1b', 'lbl' => 'Rejected'],
                        ];
                        $meta = $stColors[$status] ?? ['bg' => '#edf2f7', 'text' => '#4a5568', 'lbl' => 'Applied'];
                    @endphp
                    <span style="display: inline-block; padding: 0.6rem 1.5rem; background: {{ $meta['bg'] }}; color: {{ $meta['text'] }}; border-radius: 8px; font-weight: 800; text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px; border: 1px solid {{ $meta['text'] }}30; text-align: center; min-width: 100px;">
                        {{ $meta['lbl'] }}
                    </span>
                @else
                    <button onclick="openApplyModal('{{ $job->_id }}')" class="hero-btn" style="padding: 0.6rem 1.5rem; border: none; cursor: pointer;">Apply Now</button>
                @endif
            @endif
        </div>
    </div>
    @empty
    <div class="card" style="text-align: center; padding: 3rem;">
        <p>No job opportunities available at the moment.</p>
    </div>
    @endforelse
</div>

<!-- Apply Modal (Hidden by default) -->
<div id="applyModal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="background: white; max-width: 400px; margin: 15% auto; padding: 2rem; border-radius: 12px;">
        <h3 style="margin-bottom: 1.5rem;">Apply for Job</h3>
        <form id="applyForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Upload Resume (PDF, DOCX)</label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e0; border-radius: 8px;">
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('applyModal').style.display='none'" style="padding: 0.8rem 1.5rem; border: 1px solid #cbd5e0; background: white; border-radius: 8px; cursor: pointer;">Cancel</button>
                <button type="submit" class="hero-btn" style="border: none; cursor: pointer;">Submit Application</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openApplyModal(jobId) {
        document.getElementById('applyForm').action = "/jobs/" + jobId + "/apply";
        document.getElementById('applyModal').style.display = 'block';
    }
</script>
@endsection
