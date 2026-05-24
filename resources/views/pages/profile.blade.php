@extends('layouts.app')

@section('styles')
<style>
.profile-wrapper {
    max-width: 820px;
    margin: 0 auto;
}
.profile-hero-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    margin-bottom: 1.5rem;
}
.profile-cover {
    height: 130px;
    background: linear-gradient(135deg, #0047ab 0%, #1e3a8a 60%, #061a3d 100%);
    position: relative;
}
.profile-cover-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px);
    background-size: 20px 20px;
}
.profile-avatar-wrap {
    position: absolute;
    bottom: -45px;
    left: 2.5rem;
}
.profile-avatar {
    width: 90px; height: 90px;
    border-radius: 50%;
    border: 4px solid white;
    object-fit: cover;
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}
.profile-body {
    padding: 3.5rem 2.5rem 2rem;
}
.profile-name {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.3rem;
}
.profile-meta {
    font-size: 0.88rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.profile-meta span { display: flex; align-items: center; gap: 5px; }
.profile-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.btn-primary {
    padding: 0.65rem 1.5rem;
    background: linear-gradient(135deg, #0047ab, #1d4ed8);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(0,71,171,0.3); }
.btn-outline {
    padding: 0.65rem 1.5rem;
    background: white;
    color: #374151;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}
.btn-outline:hover { border-color: #0047ab; color: #0047ab; background: #eff6ff; }

/* Info Sections */
.info-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    margin-bottom: 1.25rem;
}
.info-card-title {
    font-size: 0.82rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #94a3b8;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.info-row {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    padding: 0.65rem 0;
    border-bottom: 1px solid #f8fafc;
    font-size: 0.88rem;
    color: #374151;
}
.info-row:last-child { border-bottom: none; }
.info-row i { width: 18px; color: #94a3b8; text-align: center; flex-shrink: 0; }

/* Donation Contribution Panel */
.donation-panel {
    background: linear-gradient(135deg, #0047ab 0%, #1e3a8a 100%);
    border-radius: 20px;
    padding: 1.75rem;
    color: white;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
}
.donation-panel::before {
    content: '₹';
    position: absolute;
    right: -10px; bottom: -20px;
    font-size: 8rem;
    font-weight: 900;
    opacity: 0.06;
    color: white;
    line-height: 1;
}
.donation-panel-title {
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.75;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.donation-panel-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    position: relative;
    z-index: 1;
}
.don-panel-stat .val {
    font-size: 1.8rem;
    font-weight: 800;
    display: block;
    line-height: 1;
    margin-bottom: 0.2rem;
}
.don-panel-stat .lbl {
    font-size: 0.72rem;
    opacity: 0.75;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.donor-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 99px;
    padding: 0.35rem 0.85rem;
    font-size: 0.75rem;
    font-weight: 700;
    margin-top: 1rem;
    backdrop-filter: blur(4px);
}
</style>
@endsection

@section('content')
<div class="profile-wrapper">

    {{-- Back link --}}
    <div style="margin-bottom: 1.25rem;">
        <a href="{{ route('directory') }}" style="color: #0047ab; text-decoration: none; font-size: 0.88rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Directory
        </a>
    </div>

    {{-- Profile Hero --}}
    <div class="profile-hero-card">
        <div class="profile-cover">
            <div class="profile-cover-dots"></div>
            <div class="profile-avatar-wrap">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=200"
                     class="profile-avatar" alt="{{ $user->name }}">
            </div>
        </div>
        <div class="profile-body">
            <h2 class="profile-name">{{ $user->name }}</h2>
            <div class="profile-meta">
                <span><i class="fa-solid fa-graduation-cap" style="color: #0047ab;"></i> Batch of {{ $user->graduation_year ?? 'N/A' }}</span>
                <span><i class="fa-solid fa-building-columns" style="color: #0047ab;"></i> {{ $user->department ?? 'Engineering' }}</span>
                <span>
                    @php
                        $roleColors = ['alumni' => '#3b82f6', 'student' => '#22c55e', 'admin' => '#a855f7'];
                        $roleColor  = $roleColors[$user->role] ?? '#64748b';
                    @endphp
                    <span style="padding: 3px 10px; border-radius: 20px; background: {{ $roleColor }}18; color: {{ $roleColor }}; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ ucfirst($user->role) }}
                    </span>
                </span>
            </div>
            <div class="profile-actions">
                @if($connection && $connection->status == 'accepted')
                    <a href="#" class="btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Send Message
                    </a>
                    <button disabled class="btn-outline" style="opacity: 0.6; cursor: not-allowed;">
                        <i class="fa-solid fa-check"></i> Connected
                    </button>
                @elseif($connection && $connection->status == 'pending')
                    <button disabled class="btn-outline" style="border-color: #93c5fd; color: #3b82f6; background: #eff6ff; cursor: not-allowed;">
                        <i class="fa-solid fa-clock"></i> Request Pending
                    </button>
                @elseif(Auth::id() != $user->_id)
                    <form action="{{ route('connect.request', $user->_id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-outline">
                            <i class="fa-solid fa-user-plus"></i> Connect
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Donation Contribution Panel (visible if user has donated) --}}
    @if($profile_donation_total > 0)
    <div class="donation-panel">
        <div class="donation-panel-title">
            <i class="fa-solid fa-heart-pulse"></i> Alumni Contribution
        </div>
        <div class="donation-panel-stats">
            <div class="don-panel-stat">
                <span class="val">₹{{ number_format($profile_donation_total) }}</span>
                <span class="lbl">Total Donated</span>
            </div>
            <div class="don-panel-stat">
                <span class="val">{{ number_format($profile_donation_count) }}</span>
                <span class="lbl">Transactions</span>
            </div>
        </div>
        <div class="donor-badge">
            @if($profile_donation_total >= 100000)
                🏆 Platinum Donor
            @elseif($profile_donation_total >= 25000)
                🥇 Gold Donor
            @elseif($profile_donation_total >= 5000)
                🥈 Silver Donor
            @else
                💙 Contributor
            @endif
        </div>
    </div>
    @endif

    {{-- About --}}
    <div class="info-card">
        <div class="info-card-title"><i class="fa-solid fa-circle-info"></i> About</div>
        <p style="font-size: 0.9rem; color: #475569; line-height: 1.7;">
            {{ $user->name }} is a proud {{ $user->role === 'alumni' ? 'alumnus' : 'member' }} of GEC from the batch of {{ $user->graduation_year ?? 'N/A' }},
            graduating with a degree in {{ $user->department ?? 'Engineering' }}.
            They are an active member of the GEC Alumni Connect platform.
        </p>
    </div>

    {{-- Contact Information --}}
    <div class="info-card">
        <div class="info-card-title"><i class="fa-solid fa-address-card"></i> Contact Information</div>
        <div class="info-row">
            <i class="fa-solid fa-envelope"></i>
            <a href="mailto:{{ $user->email }}" style="color: #0047ab; text-decoration: none; font-weight: 600;">{{ $user->email }}</a>
        </div>
        <div class="info-row">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Joined {{ $user->created_at ? $user->created_at->format('F Y') : 'N/A' }}</span>
        </div>
        <div class="info-row">
            <i class="fa-solid fa-location-dot"></i>
            <span style="color: #94a3b8;">Location not specified</span>
        </div>
    </div>

</div>
@endsection
