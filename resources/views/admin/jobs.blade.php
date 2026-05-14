@extends('layouts.app')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Job Management</h2>
        <p>Post new career opportunities and manage existing listings.</p>
    </div>
    <button onclick="document.getElementById('addJobModal').style.display='block'" class="hero-btn">Add New Job</button>
</div>

<div class="card" style="margin-top: 2rem;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #f1f5f9; color: #718096; font-size: 0.85rem; background: #f8fafc;">
                <th style="padding: 1.5rem;">TITLE</th>
                <th style="padding: 1.5rem;">COMPANY</th>
                <th style="padding: 1.5rem;">TYPE</th>
                <th style="padding: 1.5rem;">POSTED ON</th>
                <th style="padding: 1.5rem;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr style="border-bottom: 1px solid #f8fafc;">
                <td style="padding: 1.5rem; font-weight: 700;">{{ $job->title }}</td>
                <td style="padding: 1.5rem;">{{ $job->company }}</td>
                <td style="padding: 1.5rem;">
                    <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; background: #ebf8ff; color: #3182ce;">
                        {{ strtoupper($job->type ?? 'Full-time') }}
                    </span>
                </td>
                <td style="padding: 1.5rem; color: #a0aec0;">{{ $job->created_at->format('M d, Y') }}</td>
                <td style="padding: 1.5rem;">
                    <form action="{{ route('admin.jobs.delete', $job->id) }}" method="POST" onsubmit="return confirm('Delete this job?')">
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
<div id="addJobModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:2000; display:flex; align-items:center; justify-content:center;">
    <div class="card" style="width: 500px; padding: 2rem;">
        <h3>Post New Job</h3>
        <form action="{{ route('admin.jobs.store') }}" method="POST" style="margin-top: 1.5rem;">
            @csrf
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Job Title</label>
                <input type="text" name="title" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Company Name</label>
                <input type="text" name="company" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Location</label>
                <input type="text" name="location" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div class="form-group" style="margin-bottom: 2rem;">
                <label>Application Link</label>
                <input type="url" name="link" placeholder="https://..." required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="hero-btn" style="flex: 1;">Post Job</button>
                <button type="button" onclick="document.getElementById('addJobModal').style.display='none'" class="social-btn" style="flex: 1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    window.onclick = function(event) {
        if (event.target == document.getElementById('addJobModal')) {
            document.getElementById('addJobModal').style.display = "none";
        }
    }
</script>
@endsection
