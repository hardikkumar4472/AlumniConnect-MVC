@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h2 style="font-size: 2rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-gauge-high" style="color: #6366f1;"></i> Admin Command Center
    </h2>
    <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Comprehensive overview of system health, user growth, and platform engagement.</p>
</div>

<div class="adm-stats-grid">
    <div class="adm-stat-card gradient">
        <p class="adm-stat-title">Total Users Registered</p>
        <h3 class="adm-stat-value">{{ number_format($stats['total_users']) }}</h3>
        <p class="adm-stat-desc"><i class="fa-solid fa-arrow-trend-up"></i> 12% increase this month</p>
    </div>
    
    <div class="adm-stat-card">
        <p class="adm-stat-title">Total Contributions</p>
        <h3 class="adm-stat-value" style="color: #4f46e5;">₹{{ number_format($stats['total_donations'] / 10000000, 1) }} Cr</h3>
        <p class="adm-stat-desc up"><i class="fa-solid fa-heart-pulse"></i> Supporting 12 active projects</p>
    </div>
    
    <div class="adm-stat-card">
        <p class="adm-stat-title">Active Opportunities</p>
        <h3 class="adm-stat-value" style="color: #2563eb;">{{ $stats['active_jobs'] }}</h3>
        <p class="adm-stat-desc info"><i class="fa-solid fa-briefcase"></i> {{ $stats['active_events'] }} Live events scheduled</p>
    </div>
    
    <div class="adm-stat-card">
        <p class="adm-stat-title">Pending Feedbacks</p>
        <h3 class="adm-stat-value" style="color: #dc2626;">{{ $stats['pending_feedback'] }}</h3>
        <p class="adm-stat-desc down"><i class="fa-solid fa-clock-rotate-left"></i> Action required by support</p>
    </div>
</div>

<div class="adm-grid">
    <section class="adm-table-wrap">
        <div class="db-section-header" style="margin-bottom: 1.25rem;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-user-shield" style="color: #6366f1;"></i> User Registry Management
            </h3>
            <a href="{{ route('admin.users') }}" class="view-all">Manage All</a>
        </div>
        
        <div class="adm-table-container">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>System Role</th>
                        <th>Joined Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_users as $user)
                    <tr>
                        <td style="font-weight: 700; color: #0f172a;">{{ $user->name }}</td>
                        <td style="color: #64748b; font-weight: 500;">{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'alumni')
                                <span class="role-badge alumni">Alumni</span>
                            @elseif($user->role == 'student')
                                <span class="role-badge student">Student</span>
                            @else
                                <span class="role-badge admin">Admin</span>
                            @endif
                        </td>
                        <td style="color: #94a3b8; font-weight: 500;">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="adm-donations-wrap">
        <div class="db-section-header" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-hand-holding-dollar" style="color: #4f46e5;"></i> Recent Activity
            </h3>
            <a href="{{ route('admin.donations') }}" class="view-all">Tracker</a>
        </div>
        
        @if(count($recent_donations) > 0)
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($recent_donations as $d)
            <div class="adm-donation-row">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($d->user_name ?? 'A') }}&background=random&size=96"
                     class="adm-donation-avatar" alt="">
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 0.88rem; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $d->user_name ?? 'Anonymous' }}</div>
                    <div style="font-size: 0.73rem; color: #64748b; font-weight: 500; margin-top: 2px;">{{ $d->purpose }} • {{ $d->created_at->diffForHumans() }}</div>
                </div>
                <div class="adm-donation-amt">₹{{ number_format($d->amount) }}</div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8; border: 1px dashed #cbd5e1; border-radius: 16px;">
            <i class="fa-solid fa-wallet" style="font-size: 2rem; margin-bottom: 0.75rem; display: block; opacity: 0.4;"></i>
            <span style="font-size: 0.85rem; font-weight: 500;">No transactions recorded.</span>
        </div>
        @endif
    </section>
</div>
@endsection
