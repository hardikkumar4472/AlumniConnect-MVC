@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h2 style="font-size: 2rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-comments" style="color: #6366f1;"></i> Feedback & Surveys
    </h2>
    <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Help us improve our GEC community portal by sharing your thoughts, ideas, and experiences.</p>
</div>

<div class="fb-submit-card">
    @if(session('success'))
        <div style="background: rgba(34, 197, 94, 0.08); color: #16a34a; border: 1.5px solid rgba(34, 197, 94, 0.2); padding: 1rem 1.25rem; border-radius: 16px; margin-bottom: 2rem; font-weight: 600; display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    
    <form action="{{ url('/feedback') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf
        <div class="form-group" style="margin: 0;">
            <label class="form-label-premium">Subject Reference</label>
            <input type="text" name="subject" placeholder="What is this regarding? (e.g. Careers page, Donation feature)" class="form-control-premium" required>
        </div>
        <div class="form-group" style="margin: 0;">
            <label class="form-label-premium">Detailed Message</label>
            <textarea name="message" rows="6" class="form-control-premium" style="resize: vertical; min-height: 120px;" placeholder="Share your suggestions, feature requests, or report general bugs..." required></textarea>
        </div>
        <button type="submit" class="btn-premium-action connect" style="width: 100%; padding: 1rem; border-radius: 16px; font-size: 1rem; height: 52px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; margin-top: 0.5rem;">
            <i class="fa-solid fa-paper-plane"></i> Submit Feedback
        </button>
    </form>
</div>
@endsection
