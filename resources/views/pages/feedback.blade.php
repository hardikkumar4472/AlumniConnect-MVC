@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Feedback & Surveys</h2>
    <p>Help us improve by sharing your thoughts and experiences.</p>
</div>

<div class="card" style="max-width: 700px; margin: 2rem auto; padding: 3rem;">
    @if(session('success'))
        <div style="background: #f0fff4; color: #38a169; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">{{ session('success') }}</div>
    @endif
    
    <form action="{{ url('/feedback') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" placeholder="What is this regarding?" required>
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea name="message" rows="6" style="width: 100%; padding: 0.8rem 1rem; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: white;" placeholder="Share your feedback here..."></textarea>
        </div>
        <button type="submit" class="hero-btn" style="width: 100%; margin-top: 1rem;">Submit Feedback</button>
    </form>
</div>
@endsection
