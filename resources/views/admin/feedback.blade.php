@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2.5rem;">
    <a href="{{ route('admin.dashboard') }}" class="btn-premium-action profile" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.5rem 1rem; border-radius: 10px; font-size: 0.8rem; margin-bottom: 1.25rem;">
        <i class="fa-solid fa-arrow-left"></i> Back to Control Panel
    </a>
    <h2 style="font-size: 2rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px; margin-top: 0.5rem;">
        <i class="fa-solid fa-user-shield" style="color: #6366f1;"></i> Feedback Management
    </h2>
    <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Review and analyze suggestions, bug reports, and survey responses submitted by platform users.</p>
</div>

<div class="adm-table-wrap" style="padding: 2.25rem;">
    <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 2rem; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-clipboard-list" style="color: #6366f1;"></i> User Submissions ({{ $feedback->count() }})
    </h3>
    
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        @forelse($feedback as $item)
            @php
                $user = \App\Models\User::find($item->user_id);
            @endphp
            <div class="fb-admin-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.4rem; font-weight: 800;">
                            {{ $item->subject }}
                        </h4>
                        <p style="font-size: 0.85rem; color: #64748b; font-weight: 500;">
                            Submitted by <strong style="color: #334155;">{{ $user ? $user->name : 'Anonymous' }}</strong> 
                            on <span style="color: #475569; font-weight: 600;">{{ $item->created_at->format('M d, Y \a\t g:i A') }}</span>
                        </p>
                    </div>
                    @if($user)
                        @if($user->role == 'alumni')
                            <span class="role-badge alumni">Alumni</span>
                        @elseif($user->role == 'student')
                            <span class="role-badge student">Student</span>
                        @else
                            <span class="role-badge admin">Admin</span>
                        @endif
                    @else
                        <span class="role-badge student" style="background:#f1f5f9; color:#64748b; border-color:#cbd5e1;">N/A</span>
                    @endif
                </div>
                
                <div class="fb-admin-quote">
                    <p>{{ $item->message }}</p>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 5rem 2rem; border: 1px dashed #cbd5e1; border-radius: 20px;">
                <i class="fa-solid fa-inbox" style="font-size: 3rem; color: #94a3b8; margin-bottom: 1.5rem; display: block; opacity: 0.5;"></i>
                <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; font-weight: 700;">No Submissions Yet</h4>
                <p style="color: #64748b; font-size: 0.9rem;">No feedback or surveys have been filed by users. Once submitted, they will appear here.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
