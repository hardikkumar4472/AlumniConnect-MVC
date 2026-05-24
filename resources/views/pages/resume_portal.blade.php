@extends('layouts.app')

@section('styles')
<style>
.resume-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    margin-bottom: 1.5rem;
    transition: all 0.25s ease;
}
.resume-card:hover {
    box-shadow: 0 10px 24px rgba(0,71,171,0.06);
    border-color: #dbeafe;
}
.score-badge {
    width: 48px; height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    font-weight: 800;
    line-height: 1;
}
.score-badge-high { background: #dcfce7; color: #15803d; }
.score-badge-med  { background: #fffbeb; color: #b45309; }
.score-badge-low  { background: #fef2f2; color: #b91c1c; }

.grade-slider {
    -webkit-appearance: none;
    width: 100%; height: 8px;
    border-radius: 5px;
    background: #cbd5e1;
    outline: none;
    transition: background 0.2s;
}
.grade-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px; height: 20px;
    border-radius: 50%;
    background: #0047ab;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
</style>
@endsection

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h2>Resume Evaluation Workspace</h2>
    <p>Get professional resume reviews, constructive assessments, and grade evaluations from industry-leading GEC alumni.</p>
</div>

@if(session('success'))
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; font-weight: 600;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; font-weight: 600;">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 2rem;">

    {{-- Main Column: Evaluation Lists --}}
    <div>
        <h3 style="margin-bottom: 1.25rem; color: #0f172a; display: flex; align-items: center; gap: 8px; font-weight: 800;"><i class="fa-solid fa-file-circle-check" style="color: #0047ab;"></i> Review History & Requests</h3>
        
        @forelse($reviews as $r)
        <div class="resume-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    @php
                        $targetUser = Auth::user()->role === 'student' ? $r->alumni : $r->student;
                    @endphp
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($targetUser->name ?? 'User') }}&background=random" style="width: 44px; height: 44px; border-radius: 50%;">
                    <div>
                        <h4 style="font-size: 0.95rem; margin: 0; font-weight: 800; color: #1e293b;">
                            {{ Auth::user()->role === 'student' ? 'Evaluator: ' : 'Candidate: ' }} {{ $targetUser->name ?? 'GEC Colleague' }}
                        </h4>
                        <span style="font-size: 0.75rem; color: #64748b;">
                            {{ $r->resume_filename }} · Requested {{ $r->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>

                @if($r->status === 'reviewed')
                    @php
                        $scoreClass = $r->grade >= 8 ? 'score-badge-high' : ($r->grade >= 5 ? 'score-badge-med' : 'score-badge-low');
                    @endphp
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 700;">Score:</span>
                        <div class="score-badge {{ $scoreClass }}">{{ $r->grade }}</div>
                    </div>
                @else
                    <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; background: #fffbeb; color: #b45309; text-transform: uppercase; letter-spacing: 0.5px;">
                        Pending Review
                    </span>
                @endif
            </div>

            @if($r->status === 'reviewed')
                <div style="background: #f8fafc; border-radius: 12px; padding: 1rem; border: 1px solid #f1f5f9; margin-top: 0.75rem;">
                    <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; display: block; margin-bottom: 0.4rem;"><i class="fa-solid fa-comments"></i> Alumni Feedback Summary</span>
                    <p style="font-size: 0.85rem; color: #374151; line-height: 1.6; margin: 0; white-space: pre-line;">{{ $r->feedback }}</p>
                </div>
            @else
                @if(Auth::user()->role === 'alumni')
                {{-- Alumni Actions: Evaluate Form --}}
                <div style="border-top: 1px solid #f1f5f9; padding-top: 1rem; margin-top: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <a href="{{ $r->resume_url }}" target="_blank" class="btn-outline" style="padding: 0.45rem 1rem; font-size: 0.78rem; border-radius: 8px;">
                            <i class="fa-solid fa-file-pdf"></i> Download & Read Resume
                        </a>
                    </div>

                    <form action="{{ route('resumes.review', $r->_id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                                <label style="font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase;">Professional Grade Evaluation</label>
                                <span style="font-size: 0.9rem; font-weight: 800; color: #0047ab;" id="gradeVal-{{ $r->_id }}">8/10</span>
                            </div>
                            <input type="range" name="grade" min="1" max="10" value="8" class="grade-slider" oninput="document.getElementById('gradeVal-{{ $r->_id }}').textContent = this.value + '/10'">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="font-size: 0.75rem; font-weight: 700; color: #374151; display: block; margin-bottom: 0.4rem; text-transform: uppercase;">Constructive Assessment Details</label>
                            <textarea name="feedback" rows="3" placeholder="Provide detailed pointers regarding layout, formatting, impact metrics, and project details..." required
                                      style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.88rem; outline: none; background: #f8fafc; color: #1e293b; font-family: inherit; box-sizing: border-box; resize: vertical;"></textarea>
                        </div>

                        <button type="submit" class="btn-primary" style="padding: 0.5rem 1.25rem; font-size: 0.8rem; box-shadow: 0 4px 10px rgba(0,71,171,0.2);">
                            <i class="fa-solid fa-check-double"></i> Submit Review Report
                        </button>
                    </form>
                </div>
                @else
                <p style="font-size: 0.78rem; color: #94a3b8; font-style: italic; margin: 0.75rem 0 0;"><i class="fa-solid fa-hourglass-half"></i> Alumnus is currently evaluating your resume. You will receive an alert once graded!</p>
                @endif
            @endif
        </div>
        @empty
        <div style="text-align: center; padding: 4rem 1.5rem; color: #94a3b8; background: white; border-radius: 20px; border: 1px solid #f1f5f9;">
            <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
            <p style="font-size: 1rem; font-weight: 600; margin: 0 0 4px;">No evaluation documents here</p>
            <p style="font-size: 0.85rem; margin: 0;">{{ Auth::user()->role === 'student' ? 'Start a review request from the portal sidebar!' : 'Pending request roster is empty.' }}</p>
        </div>
        @endforelse
    </div>

    {{-- Side Column: Workspace Controller --}}
    <div>
        @if(Auth::user()->role === 'student')
        <div class="resume-card" style="background: linear-gradient(135deg, #f8fbff 0%, #eff6ff 100%); border-color: #bfdbfe; position: sticky; top: 1.5rem;">
            <h3 style="margin-top: 0; margin-bottom: 1rem; color: #1e3a8a; display: flex; align-items: center; gap: 6px; font-weight: 800;"><i class="fa-solid fa-upload"></i> Request Evaluation</h3>
            <p style="font-size: 0.85rem; color: #64748b; line-height: 1.6; margin-bottom: 1.25rem;">
                Select a verified, connected GEC alumnus from your professional circle to conduct an industry review of your resume.
            </p>

            @if($connectedAlumni->count() > 0)
            <form action="{{ route('resumes.request') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: #1e3a8a; display: block; margin-bottom: 0.4rem; text-transform: uppercase;">Select Alumni Evaluator</label>
                    <select name="alumni_id" required style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #bfdbfe; border-radius: 10px; font-size: 0.88rem; outline: none; background: white; color: #1e293b; box-sizing: border-box; font-family: inherit;">
                        @foreach($connectedAlumni as $alm)
                        <option value="{{ $alm->_id }}">{{ $alm->name }} · {{ $alm->industry ?? 'Engineering Specialist' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: #1e3a8a; display: block; margin-bottom: 0.4rem; text-transform: uppercase;">Upload PDF Resume</label>
                    <input type="file" name="resume" accept=".pdf,.doc,.docx" required
                           style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px dashed #bfdbfe; border-radius: 10px; font-size: 0.82rem; outline: none; background: white; color: #475569; box-sizing: border-box; cursor: pointer;">
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 4px 12px rgba(59,130,246,0.25);">
                    <i class="fa-solid fa-paper-plane"></i> Submit For Evaluation
                </button>
            </form>
            @else
            <div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px; padding: 1rem; color: #b45309; text-align: center; font-size: 0.8rem; line-height: 1.5;">
                <i class="fa-solid fa-circle-info" style="font-size: 1.25rem; margin-bottom: 0.5rem; display: block;"></i>
                No connected alumni found in your network workspace.<br>
                <a href="{{ route('directory') }}" style="color: #0047ab; font-weight: 700; text-decoration: none; display: inline-block; margin-top: 4px;">Explore GEC Directory <i class="fa-solid fa-chevron-right" style="font-size: 0.68rem;"></i></a>
            </div>
            @endif
        </div>
        @else
        <div class="resume-card" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border-color: #a7f3d0; position: sticky; top: 1.5rem; text-align: center; padding: 2rem 1.5rem;">
            <div style="width: 56px; height: 56px; background: #d1fae5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #059669; margin: 0 auto 1.25rem;">
                <i class="fa-solid fa-award"></i>
            </div>
            <h3 style="margin-top: 0; margin-bottom: 0.5rem; color: #065f46; font-weight: 800;">Evaluator Dashboard</h3>
            <p style="font-size: 0.82rem; color: #047857; line-height: 1.6; margin: 0;">
                Students upload draft resumes seeking reviews. Connect with them, grade their work, and offer suggestions to help them land top jobs!
            </p>
        </div>
        @endif
    </div>

</div>
@endsection
