@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Donations</h2>
    <p>Your contribution helps us build a better future for the institution.</p>
</div>

<div class="donation-grid" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem; margin-top: 2rem;">
    <div class="card" style="padding: 2.5rem;">
        <h3 style="margin-bottom: 1.5rem;">Make a Contribution</h3>
        @if(session('success'))
            <div style="background: #f0fff4; color: #38a169; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">{{ session('success') }}</div>
        @endif
        <form action="{{ url('/donations') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Amount (INR)</label>
                <input type="number" name="amount" placeholder="Enter amount" required>
            </div>
            <div class="form-group">
                <label>Purpose</label>
                <select name="purpose" style="width: 100%; padding: 0.8rem 1rem; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: white;">
                    <option value="Scholarship Fund">Scholarship Fund</option>
                    <option value="Campus Development">Campus Development</option>
                    <option value="Innovation Lab">Innovation Lab</option>
                    <option value="Library Expansion">Library Expansion</option>
                </select>
            </div>
            <button type="submit" class="hero-btn" style="width: 100%; margin-top: 1rem;">Contribute Now</button>
        </form>
    </div>

    <div class="card" style="padding: 2rem;">
        <h3 style="margin-bottom: 1.5rem;">My Contributions</h3>
        <div class="contribution-list">
            @forelse($my_donations as $donation)
            <div class="contribution-item" style="border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem; margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="font-size: 0.95rem;">{{ $donation->purpose }}</h4>
                        <p style="font-size: 0.75rem; color: #718096;">{{ $donation->created_at->format('d M, Y') }}</p>
                    </div>
                    <span style="font-weight: 700;">₹{{ number_format($donation->amount) }}</span>
                </div>
            </div>
            @empty
            <p style="color: #718096; text-align: center;">You haven't made any contributions yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
