@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <a href="{{ route('admin.dashboard') }}" style="color: #0047ab; text-decoration: none; font-size: 0.9rem; font-weight: 600;"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
    <h2 style="margin-top: 1rem;">Feedback Management</h2>
    <p>Review and analyze feedback and surveys submitted by users. Visible only to administrators.</p>
</div>

<div class="card" style="padding: 2rem;">
    <h3 style="margin-bottom: 1.5rem;">User Feedback Responses</h3>
    
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        @forelse($feedback as $item)
            @php
                $user = \App\Models\User::find($item->user_id);
            @endphp
            <div style="padding: 1.5rem; border: 1px solid #e2e8f0; border-radius: 12px; background: #f8fafc;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <h4 style="font-size: 1.2rem; color: #061a3d; margin-bottom: 0.3rem;">{{ $item->subject }}</h4>
                        <p style="font-size: 0.85rem; color: #718096;">
                            Submitted by <strong>{{ $user ? $user->name : 'Anonymous' }}</strong> ({{ $user ? ucfirst($user->role) : 'N/A' }}) on {{ $item->created_at->format('M d, Y g:i A') }}
                        </p>
                    </div>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #0047ab;">
                    <p style="color: #4a5568; line-height: 1.6; white-space: pre-wrap;">{{ $item->message }}</p>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 3rem; color: #718096;">
                <i class="fa-solid fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>No feedback or survey responses have been submitted yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
