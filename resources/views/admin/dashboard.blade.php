@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Admin Command Center</h2>
    <p>Comprehensive overview of system health, user growth, and platform engagement.</p>
</div>

<div class="hero-stats" style="margin-top: 2rem; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
    <div class="card" style="background: linear-gradient(135deg, #0047ab, #061a3d); color: white;">
        <p style="opacity: 0.8; font-size: 0.8rem;">TOTAL USERS</p>
        <h3 style="font-size: 2rem; margin: 10px 0;">{{ number_format($stats['total_users']) }}</h3>
        <p style="font-size: 0.75rem;"><i class="fa-solid fa-arrow-up"></i> 12% increase this month</p>
    </div>
    <div class="card">
        <p style="color: #718096; font-size: 0.8rem;">TOTAL DONATIONS</p>
        <h3 style="font-size: 2rem; margin: 10px 0; color: #0047ab;">₹{{ number_format($stats['total_donations'] / 10000000, 1) }} Cr</h3>
        <p style="font-size: 0.75rem; color: #38a169;"><i class="fa-solid fa-heart"></i> Supporting 12 projects</p>
    </div>
    <div class="card">
        <p style="color: #718096; font-size: 0.8rem;">ACTIVE OPPORTUNITIES</p>
        <h3 style="font-size: 2rem; margin: 10px 0; color: #0047ab;">{{ $stats['active_jobs'] }}</h3>
        <p style="font-size: 0.75rem; color: #3182ce;"><i class="fa-solid fa-briefcase"></i> {{ $stats['active_events'] }} Live events</p>
    </div>
    <div class="card">
        <p style="color: #718096; font-size: 0.8rem;">PENDING FEEDBACK</p>
        <h3 style="font-size: 2rem; margin: 10px 0; color: #e53e3e;">{{ $stats['pending_feedback'] }}</h3>
        <p style="font-size: 0.75rem; color: #e53e3e;"><i class="fa-solid fa-clock"></i> Requires attention</p>
    </div>
</div>

<div class="bottom-grid" style="margin-top: 2rem; grid-template-columns: 2fr 1fr;">
    <section class="card">
        <div class="section-title">
            <h3>User Management</h3>
            <a href="{{ route('admin.users') }}" class="view-all">Manage All</a>
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid #f1f5f9; color: #718096; font-size: 0.85rem;">
                    <th style="padding: 1rem;">NAME</th>
                    <th style="padding: 1rem;">EMAIL</th>
                    <th style="padding: 1rem;">ROLE</th>
                    <th style="padding: 1rem;">JOINED</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_users as $user)
                <tr style="border-bottom: 1px solid #f8fafc; font-size: 0.9rem;">
                    <td style="padding: 1rem; font-weight: 600;">{{ $user->name }}</td>
                    <td style="padding: 1rem; color: #718096;">{{ $user->email }}</td>
                    <td style="padding: 1rem;">
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; background: {{ $user->role == 'alumni' ? '#ebf8ff; color: #3182ce;' : '#f0fff4; color: #38a169;' }}">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td style="padding: 1rem; color: #a0aec0;">{{ $user->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section class="card">
        <div class="section-title">
            <h3>Recent Donations</h3>
            <a href="{{ route('admin.donations') }}" class="view-all">View All</a>
        </div>
        @if(count($recent_donations) > 0)
        <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1rem;">
            @foreach($recent_donations as $d)
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: 12px; background: #f8fafc;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($d->user_name ?? 'A') }}&background=random&size=64"
                     style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; flex-shrink: 0;" alt="">
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">{{ $d->user_name ?? 'Anonymous' }}</div>
                    <div style="font-size: 0.72rem; color: #94a3b8;">{{ $d->purpose }} • {{ $d->created_at->diffForHumans() }}</div>
                </div>
                <div style="font-size: 1rem; font-weight: 800; color: #0047ab; flex-shrink: 0;">₹{{ number_format($d->amount) }}</div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 2rem; color: #94a3b8; font-size: 0.88rem;">
            <i class="fa-solid fa-hand-holding-heart" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
            No donations yet.
        </div>
        @endif
    </section>

</div>
@endsection
