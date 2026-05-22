@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <a href="{{ route('directory') }}" style="color: #0047ab; text-decoration: none; font-size: 0.9rem; font-weight: 600;"><i class="fa-solid fa-arrow-left"></i> Back to Directory</a>
</div>

<div class="card" style="padding: 3rem; text-align: center; max-width: 800px; margin: 0 auto;">
    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=150" alt="{{ $user->name }}" style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 1.5rem; object-fit: cover; border: 4px solid #e2e8f0;">
    
    <h2 style="font-size: 2rem; margin-bottom: 0.5rem; color: #061a3d;">{{ $user->name }}</h2>
    <p style="font-size: 1.1rem; color: #718096; margin-bottom: 1rem;">
        <i class="fa-solid fa-graduation-cap"></i> Batch of {{ $user->graduation_year ?? 'N/A' }} • 
        <i class="fa-solid fa-building"></i> {{ $user->department ?? 'Engineering' }}
    </p>

    <div style="display: flex; gap: 15px; justify-content: center; margin-top: 2rem; margin-bottom: 3rem;">
        @if($connection && $connection->status == 'accepted')
            <a href="#" class="hero-btn" style="padding: 0.8rem 2rem; border-radius: 20px;">
                <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i> Send Message
            </a>
            <button disabled style="padding: 0.8rem 2rem; border-radius: 20px; border: 1px solid #e2e8f0; background: #e2e8f0; color: #4a5568; font-weight: 600;">
                <i class="fa-solid fa-check" style="margin-right: 8px;"></i> Connected
            </button>
        @elseif($connection && $connection->status == 'pending')
            <button disabled style="padding: 0.8rem 2rem; border-radius: 20px; border: 1px solid #bee3f8; background: #bee3f8; color: #2b6cb0; font-weight: 600;">
                <i class="fa-solid fa-clock" style="margin-right: 8px;"></i> Request Pending
            </button>
        @elseif(Auth::id() != $user->_id)
            <form action="{{ route('connect.request', $user->_id) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="padding: 0.8rem 2rem; border-radius: 20px; border: 1px solid #0047ab; background: white; color: #0047ab; font-weight: 600; cursor: pointer;">
                    <i class="fa-solid fa-user-plus" style="margin-right: 8px;"></i> Connect
                </button>
            </form>
        @endif
    </div>

    <div style="text-align: left; background: #f8fafc; padding: 2rem; border-radius: 16px;">
        <h4 style="font-size: 1.2rem; color: #061a3d; margin-bottom: 1rem;">About</h4>
        <p style="color: #4a5568; line-height: 1.6; font-size: 0.95rem;">
            {{ $user->name }} is a proud alumnus of GEC from the batch of {{ $user->graduation_year ?? 'N/A' }}. 
            Graduating with a degree in {{ $user->department ?? 'Engineering' }}, they are an active member of the alumni network.
        </p>
        
        <h4 style="font-size: 1.2rem; color: #061a3d; margin-top: 2rem; margin-bottom: 1rem;">Contact Information</h4>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 10px; color: #4a5568; font-size: 0.95rem;">
                <i class="fa-solid fa-envelope" style="color: #a0aec0; width: 20px;"></i>
                <a href="mailto:{{ $user->email }}" style="color: #0047ab; text-decoration: none;">{{ $user->email }}</a>
            </div>
            <div style="display: flex; align-items: center; gap: 10px; color: #4a5568; font-size: 0.95rem;">
                <i class="fa-solid fa-location-dot" style="color: #a0aec0; width: 20px;"></i>
                <span>Location Not Specified</span>
            </div>
        </div>
    </div>
</div>
@endsection
