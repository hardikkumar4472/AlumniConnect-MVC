@extends('layouts.app')

@section('styles')
<style>
/* ====== Donations Page ====== */
.donations-hero {
    background: linear-gradient(135deg, #0047ab 0%, #061a3d 100%);
    border-radius: 24px;
    padding: 3rem 2.5rem;
    color: white;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 2rem;
    align-items: center;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}
.donations-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 300px; height: 300px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}
.donations-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; right: 80px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
}
.hero-stat-pills {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}
.hero-pill {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 50px;
    padding: 0.6rem 1.2rem;
    text-align: center;
    backdrop-filter: blur(10px);
}
.hero-pill .pill-val {
    font-size: 1.4rem;
    font-weight: 800;
    display: block;
    color: #fff;
}
.hero-pill .pill-label {
    font-size: 0.68rem;
    opacity: 0.75;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Campaign Grid */
.campaign-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}
.campaign-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}
.campaign-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,71,171,0.12);
    border-color: #dbeafe;
}
.campaign-badge {
    display: inline-block;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
}
.badge-scholarship  { background: #eff6ff; color: #3b82f6; }
.badge-infrastructure { background: #f0fdf4; color: #22c55e; }
.badge-innovation   { background: #fdf4ff; color: #a855f7; }
.badge-library      { background: #fff7ed; color: #f97316; }
.badge-other        { background: #f8fafc; color: #64748b; }

.progress-wrap {
    background: #f1f5f9;
    border-radius: 99px;
    height: 8px;
    margin: 1rem 0 0.5rem;
    overflow: hidden;
}
.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #0047ab);
    border-radius: 99px;
    transition: width 0.6s ease;
}
.campaign-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.78rem;
    color: #64748b;
    margin-top: 0.25rem;
}
.donate-btn {
    width: 100%;
    margin-top: 1.25rem;
    padding: 0.75rem;
    background: linear-gradient(135deg, #0047ab, #1d4ed8);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    letter-spacing: 0.3px;
}
.donate-btn:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 20px rgba(0,71,171,0.3);
}

/* Bottom Two-col Layout */
.donations-bottom {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

/* History Table */
.history-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}
.history-table th {
    text-align: left;
    padding: 0.75rem 1rem;
    color: #94a3b8;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #f1f5f9;
}
.history-table td {
    padding: 1rem;
    border-bottom: 1px solid #f8fafc;
    color: #374151;
    vertical-align: middle;
}
.status-badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
}
.status-success { background: #dcfce7; color: #16a34a; }
.status-pending { background: #fef9c3; color: #ca8a04; }

/* Create Campaign Form Card */
.create-campaign-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.form-group { margin-bottom: 1.1rem; }
.form-group label {
    display: block;
    font-size: 0.8rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.4rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9rem;
    color: #374151;
    background: #f8fafc;
    outline: none;
    transition: border-color 0.2s;
    font-family: 'Outfit', sans-serif;
    box-sizing: border-box;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #3b82f6;
    background: white;
}

/* ====== Razorpay Modal ====== */
.rzp-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(6,26,61,0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(6px);
    animation: fadeIn 0.2s ease;
}
.rzp-modal-overlay.active { display: flex; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.rzp-modal {
    background: white;
    border-radius: 24px;
    width: 100%;
    max-width: 480px;
    overflow: hidden;
    box-shadow: 0 40px 80px rgba(0,0,0,0.25);
    animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes slideUp {
    from { transform: translateY(40px) scale(0.95); opacity: 0; }
    to   { transform: translateY(0) scale(1); opacity: 1; }
}
.rzp-header {
    background: linear-gradient(135deg, #072b5b, #0f4c9b);
    padding: 1.75rem 2rem;
    color: white;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.rzp-logo {
    background: white;
    border-radius: 10px;
    padding: 6px 10px;
    font-size: 1rem;
    font-weight: 900;
    color: #2D64B2;
    letter-spacing: -0.5px;
}
.rzp-title { font-size: 1.1rem; font-weight: 700; }
.rzp-subtitle { font-size: 0.8rem; opacity: 0.75; margin-top: 2px; }

.rzp-body { padding: 1.75rem 2rem; }
.rzp-amount-display {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    text-align: center;
    margin-bottom: 1.5rem;
}
.rzp-amount-display .amount-label { font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
.rzp-amount-display .amount-value { font-size: 2.2rem; font-weight: 800; color: #0047ab; margin: 0.25rem 0; }

.rzp-tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
.rzp-tab {
    flex: 1; padding: 0.6rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    color: #64748b;
    transition: all 0.2s;
    background: white;
}
.rzp-tab.active {
    border-color: #0047ab;
    background: #eff6ff;
    color: #0047ab;
}
.rzp-tab i { display: block; font-size: 1.1rem; margin-bottom: 2px; }

.rzp-card-form { display: none; }
.rzp-card-form.active { display: block; }

.rzp-input-group { margin-bottom: 1rem; }
.rzp-input-group label { font-size: 0.75rem; font-weight: 700; color: #374151; margin-bottom: 0.35rem; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
.rzp-input-group input {
    width: 100%;
    padding: 0.7rem 1rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9rem;
    outline: none;
    font-family: 'Outfit', sans-serif;
    box-sizing: border-box;
    transition: border-color 0.2s;
}
.rzp-input-group input:focus { border-color: #3b82f6; }
.rzp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }

.rzp-pay-btn {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #0047ab, #1d4ed8);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    margin-top: 0.5rem;
    transition: all 0.2s;
    letter-spacing: 0.3px;
}
.rzp-pay-btn:hover { transform: scale(1.01); box-shadow: 0 6px 20px rgba(0,71,171,0.35); }
.rzp-pay-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

.rzp-secure {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 0.72rem;
    color: #94a3b8;
    margin-top: 1rem;
}

/* Processing overlay */
.rzp-processing {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 2rem;
    text-align: center;
}
.rzp-processing.active { display: flex; }
.spinner {
    width: 52px; height: 52px;
    border: 4px solid #e2e8f0;
    border-top-color: #0047ab;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin-bottom: 1.5rem;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Success state */
.rzp-success {
    display: none;
    flex-direction: column;
    align-items: center;
    padding: 2.5rem 2rem;
    text-align: center;
}
.rzp-success.active { display: flex; }
.success-check {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin-bottom: 1.5rem;
    animation: popIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes popIn {
    from { transform: scale(0); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

/* Alert messages */
.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; font-weight: 600; }
.alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; }

.section-heading {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.section-heading::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #f1f5f9;
    margin-left: 0.5rem;
}
</style>
@endsection

@section('content')

{{-- ===== Hero Banner ===== --}}
<div class="donations-hero">
    <div style="position: relative; z-index: 1;">
        <p style="font-size: 0.78rem; font-weight: 700; opacity: 0.7; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 0.5rem;">
            <i class="fa-solid fa-heart-pulse" style="margin-right: 6px;"></i> Alumni Giving Programme
        </p>
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.75rem; line-height: 1.2;">
            Give Back. <span style="color: #93c5fd;">Inspire Change.</span>
        </h2>
        <p style="opacity: 0.8; font-size: 0.95rem; max-width: 480px; line-height: 1.6;">
            Your contribution helps fund scholarships, build state-of-the-art labs, and shape the next generation of engineers at GEC.
        </p>
    </div>
    <div class="hero-stat-pills" style="position: relative; z-index: 1;">
        <div class="hero-pill">
            <span class="pill-val">₹{{ number_format($total_raised / 1000, 1) }}K</span>
            <span class="pill-label">Total Raised</span>
        </div>
        <div class="hero-pill">
            <span class="pill-val">{{ number_format($donor_count) }}</span>
            <span class="pill-label">Donors</span>
        </div>
        @if($my_total > 0)
        <div class="hero-pill" style="background: rgba(34,197,94,0.2); border-color: rgba(34,197,94,0.4);">
            <span class="pill-val" style="color: #86efac;">₹{{ number_format($my_total) }}</span>
            <span class="pill-label">My Contribution</span>
        </div>
        @endif
    </div>
</div>

@if(session('campaign_success'))
<div class="alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('campaign_success') }}</div>
@endif

{{-- ===== Analytics Dashboard & Leaderboards ===== --}}
<div class="analytics-leaderboards">
    {{-- Chart Container --}}
    <div style="background: white; border-radius: 20px; padding: 1.75rem; border: 1px solid #f1f5f9; box-shadow: 0 4px 20px rgba(0,0,0,0.02); display: flex; flex-direction: column;">
        <h3 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-chart-line" style="color: #3b82f6;"></i> Giving Analytics & Trends
        </h3>
        <div style="flex: 1; min-height: 220px; position: relative;">
            <canvas id="givingChart"></canvas>
        </div>
    </div>

    {{-- Leaderboard Tabs --}}
    <div style="background: white; border-radius: 20px; padding: 1.75rem; border: 1px solid #f1f5f9; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin: 0;">
                <i class="fa-solid fa-trophy" style="color: #f59e0b;"></i> Contribution Leaderboards
            </h3>
            <div style="display: flex; gap: 4px; background: #f1f5f9; padding: 4px; border-radius: 10px;">
                <button onclick="toggleLeaderboard('donors')" id="btn-lead-donors" style="padding: 0.35rem 0.75rem; border: none; border-radius: 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s; background: white; color: #0047ab; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">Donors</button>
                <button onclick="toggleLeaderboard('batches')" id="btn-lead-batches" style="padding: 0.35rem 0.75rem; border: none; border-radius: 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s; background: transparent; color: #64748b;">Batches</button>
            </div>
        </div>

        {{-- Donors List --}}
        <div id="leaderboard-donors" style="display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($individual_leaderboard as $idx => $item)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9; transition: all 0.2s;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $idx == 0 ? '#fef3c7' : ($idx == 1 ? '#e2e8f0' : ($idx == 2 ? '#ffedd5' : '#f1f5f9')) }}; color: {{ $idx == 0 ? '#d97706' : ($idx == 1 ? '#475569' : ($idx == 2 ? '#c2410c' : '#64748b')) }}; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800;">
                        {{ $idx + 1 }}
                    </div>
                    <div>
                        <span style="font-size: 0.88rem; font-weight: 700; color: #1e293b; display: block;">{{ $item['name'] }}</span>
                        <span style="font-size: 0.72rem; color: #94a3b8;">{{ $item['count'] }} donation(s)</span>
                    </div>
                </div>
                <span style="font-size: 0.9rem; font-weight: 800; color: #0047ab;">₹{{ number_format($item['total']) }}</span>
            </div>
            @empty
            <div style="text-align: center; color: #94a3b8; padding: 2rem 0; font-size: 0.85rem;">No contributions registered yet.</div>
            @endforelse
        </div>

        {{-- Batches List --}}
        <div id="leaderboard-batches" style="display: none; flex-direction: column; gap: 0.75rem;">
            @forelse($batch_leaderboard as $idx => $item)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $idx == 0 ? '#fef3c7' : ($idx == 1 ? '#e2e8f0' : ($idx == 2 ? '#ffedd5' : '#f1f5f9')) }}; color: {{ $idx == 0 ? '#d97706' : ($idx == 1 ? '#475569' : ($idx == 2 ? '#c2410c' : '#64748b')) }}; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800;">
                        {{ $idx + 1 }}
                    </div>
                    <div>
                        <span style="font-size: 0.88rem; font-weight: 700; color: #1e293b; display: block;">{{ $item['year'] }}</span>
                        <span style="font-size: 0.72rem; color: #94a3b8;">{{ $item['count'] }} contributor(s)</span>
                    </div>
                </div>
                <span style="font-size: 0.9rem; font-weight: 800; color: #22c55e;">₹{{ number_format($item['total']) }}</span>
            </div>
            @empty
            <div style="text-align: center; color: #94a3b8; padding: 2rem 0; font-size: 0.85rem;">No batch statistics available.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- CSS style override to make analytics visual layout side-by-side grid --}}
<style>
.analytics-leaderboards {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 2rem;
    margin-bottom: 2.5rem;
}
@media (max-width: 768px) {
    .analytics-leaderboards {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}
</style>

{{-- ===== Active Campaigns ===== --}}
<div class="section-heading"><i class="fa-solid fa-bullhorn" style="color: #0047ab;"></i> Active Campaigns</div>

@php
$categoryColors = [
    'Scholarship Fund'    => 'scholarship',
    'Campus Development'  => 'infrastructure',
    'Innovation Lab'      => 'innovation',
    'Library Expansion'   => 'library',
];
@endphp

<div class="campaign-grid">
    {{-- General / Quick Donate card --}}
    <div class="campaign-card" style="border: 2px dashed #bfdbfe; background: #f8fbff;">
        <span class="campaign-badge" style="background: #eff6ff; color: #0047ab;">Quick Donate</span>
        <h3 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem;">General College Fund</h3>
        <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin-bottom: 1rem;">
            Support any initiative — the college allocates funds where they're needed most.
        </p>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
            @foreach(['500','1000','2500','5000'] as $amt)
            <button onclick="openDonateModal('General College Fund', null, {{ $amt }})"
                style="padding: 0.4rem 0.85rem; border: 1.5px solid #bfdbfe; border-radius: 8px; font-size: 0.8rem; font-weight: 700; color: #0047ab; background: white; cursor: pointer; transition: all 0.2s;"
                onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='white'">
                ₹{{ $amt }}
            </button>
            @endforeach
        </div>
        <button class="donate-btn" onclick="openDonateModal('General College Fund', null, 1000)">
            <i class="fa-solid fa-heart" style="margin-right: 6px;"></i> Donate Now
        </button>
    </div>

    @forelse($campaigns as $campaign)
    @php
        $pct   = min(100, $campaign->goal_amount > 0 ? round(($campaign->raised_amount / $campaign->goal_amount) * 100) : 0);
        $color = $categoryColors[$campaign->category] ?? 'other';
    @endphp
    <div class="campaign-card">
        <span class="campaign-badge badge-{{ $color }}">{{ $campaign->category }}</span>
        <h3 style="font-size: 1.05rem; color: #0f172a; margin-bottom: 0.4rem;">{{ $campaign->title }}</h3>
        <p style="font-size: 0.83rem; color: #64748b; line-height: 1.5; margin-bottom: 0.75rem;">{{ Str::limit($campaign->description, 100) }}</p>
        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.25rem;">
            <span style="font-size: 0.85rem; color: #374151; font-weight: 700;">₹{{ number_format($campaign->raised_amount) }}</span>
            <span style="font-size: 0.75rem; color: #94a3b8;">of ₹{{ number_format($campaign->goal_amount) }} goal</span>
        </div>
        <div class="progress-wrap">
            <div class="progress-bar" style="width: {{ $pct }}%;"></div>
        </div>
        <div class="campaign-meta">
            <span><i class="fa-solid fa-chart-line" style="margin-right: 3px;"></i> {{ $pct }}% funded</span>
            <span><i class="fa-solid fa-user" style="margin-right: 3px;"></i> by {{ $campaign->creator_name }}</span>
        </div>
        <button class="donate-btn" onclick="openDonateModal('{{ addslashes($campaign->title) }}', '{{ $campaign->_id }}', 500)">
            <i class="fa-solid fa-hand-holding-heart" style="margin-right: 6px;"></i> Support This Campaign
        </button>
    </div>
    @empty
    <div style="grid-column: 1/-1; text-align: center; color: #94a3b8; padding: 2rem;">
        <i class="fa-solid fa-box-open" style="font-size: 2rem; margin-bottom: 0.75rem; display: block;"></i>
        No campaigns yet. Be the first to create one!
    </div>
    @endforelse
</div>

{{-- ===== Bottom Grid: History + Create Campaign ===== --}}
<div class="donations-bottom">

    {{-- My Donation History --}}
    <div class="create-campaign-card">
        <div class="section-heading" style="margin-bottom: 1.5rem;">
            <i class="fa-solid fa-clock-rotate-left" style="color: #0047ab;"></i> My Donation History
        </div>
        @if($my_donations->count() > 0)
        <table class="history-table">
            <thead>
                <tr>
                    <th>Purpose</th>
                    <th>Amount</th>
                    <th>Payment ID</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($my_donations as $d)
                <tr>
                    <td><strong>{{ $d->purpose }}</strong></td>
                    <td style="font-weight: 700; color: #0047ab;">₹{{ number_format($d->amount) }}</td>
                    <td style="font-size: 0.75rem; color: #94a3b8; font-family: monospace;">{{ Str::limit($d->payment_id, 20) }}</td>
                    <td style="color: #64748b;">{{ $d->created_at->format('d M, Y') }}</td>
                    <td><span class="status-badge status-{{ $d->status }}">{{ strtoupper($d->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
            <i class="fa-regular fa-credit-card" style="font-size: 2.5rem; margin-bottom: 1rem; display: block;"></i>
            <p style="font-size: 0.95rem;">You haven't made any donations yet.</p>
            <p style="font-size: 0.82rem; margin-top: 0.25rem;">Use the campaigns above to make your first contribution!</p>
        </div>
        @endif
    </div>

    {{-- Create Campaign (Alumni) --}}
    @if(Auth::user()->role === 'alumni' || Auth::user()->role === 'admin')
    <div class="create-campaign-card">
        <div class="section-heading" style="margin-bottom: 1.5rem;">
            <i class="fa-solid fa-plus-circle" style="color: #22c55e;"></i> Start a Campaign
        </div>
        <form action="{{ route('donations.campaign') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Campaign Title</label>
                <input type="text" name="title" placeholder="e.g. Robotics Lab Fund 2025" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category" required>
                    <option value="Scholarship Fund">Scholarship Fund</option>
                    <option value="Campus Development">Campus Development</option>
                    <option value="Innovation Lab">Innovation Lab</option>
                    <option value="Library Expansion">Library Expansion</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Goal Amount (₹)</label>
                <input type="number" name="goal_amount" placeholder="e.g. 100000" min="1000" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Describe your campaign purpose..." required style="resize: vertical;"></textarea>
            </div>
            <button type="submit" class="donate-btn" style="background: linear-gradient(135deg, #16a34a, #15803d);">
                <i class="fa-solid fa-bullhorn" style="margin-right: 6px;"></i> Launch Campaign
            </button>
        </form>
    </div>
    @else
    <div class="create-campaign-card" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; background: linear-gradient(135deg, #f8fbff, #eff6ff);">
        <div style="width: 64px; height: 64px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #3b82f6; margin-bottom: 1.25rem;">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <h4 style="color: #1e3a8a; margin-bottom: 0.5rem;">Thank You for Your Support!</h4>
        <p style="color: #64748b; font-size: 0.88rem; line-height: 1.6; max-width: 240px;">
            Alumni members can create fundraising campaigns. Keep giving back to your alma mater!
        </p>
    </div>
    @endif
</div>

{{-- ====== Razorpay Dummy Payment Modal ====== --}}
<div class="rzp-modal-overlay" id="rzpOverlay">
    <div class="rzp-modal">

        {{-- Header --}}
        <div class="rzp-header">
            <div class="rzp-logo">razorpay</div>
            <div>
                <div class="rzp-title" id="rzpModalTitle">Donate to GEC Alumni</div>
                <div class="rzp-subtitle">Secure Payment Gateway</div>
            </div>
            <button onclick="closeModal()" style="margin-left: auto; background: none; border: none; color: rgba(255,255,255,0.7); font-size: 1.2rem; cursor: pointer; padding: 0;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Body: Payment form --}}
        <div class="rzp-body" id="rzpBody">
            <div class="rzp-amount-display">
                <div class="amount-label">You are donating</div>
                <div class="amount-value">₹<span id="rzpDisplayAmount">0</span></div>
                <div style="font-size: 0.78rem; color: #64748b;" id="rzpDisplayPurpose"></div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; font-weight: 700; color: #374151; display: block; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">Custom Amount (₹)</label>
                <input type="number" id="rzpCustomAmount" placeholder="Or enter custom amount" min="1"
                    style="width: 100%; padding: 0.7rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; outline: none; font-family: 'Outfit', sans-serif; box-sizing: border-box;"
                    oninput="updateAmount(this.value)">
            </div>

            {{-- Payment Method Tabs --}}
            <div class="rzp-tabs">
                <div class="rzp-tab active" onclick="switchTab('card')" id="tab-card">
                    <i class="fa-solid fa-credit-card"></i> Card
                </div>
                <div class="rzp-tab" onclick="switchTab('upi')" id="tab-upi">
                    <i class="fa-solid fa-mobile-screen"></i> UPI
                </div>
                <div class="rzp-tab" onclick="switchTab('netbanking')" id="tab-netbanking">
                    <i class="fa-solid fa-building-columns"></i> Net Banking
                </div>
            </div>

            {{-- Card Form --}}
            <div class="rzp-card-form active" id="form-card">
                <div class="rzp-input-group">
                    <label>Card Number</label>
                    <input type="text" placeholder="4111 1111 1111 1111" maxlength="19" id="cardNumber"
                        oninput="formatCard(this)" value="4111 1111 1111 1111">
                </div>
                <div class="rzp-row">
                    <div class="rzp-input-group">
                        <label>Expiry</label>
                        <input type="text" placeholder="MM / YY" maxlength="7" value="12 / 29">
                    </div>
                    <div class="rzp-input-group">
                        <label>CVV</label>
                        <input type="password" placeholder="•••" maxlength="3" value="123">
                    </div>
                </div>
                <div class="rzp-input-group">
                    <label>Cardholder Name</label>
                    <input type="text" placeholder="Name on card" value="{{ Auth::user()->name }}">
                </div>
            </div>

            {{-- UPI Form --}}
            <div class="rzp-card-form" id="form-upi">
                <div class="rzp-input-group">
                    <label>UPI ID</label>
                    <input type="text" placeholder="yourname@upi" value="alumni@upi">
                </div>
                <p style="font-size: 0.78rem; color: #64748b; margin-top: 0.5rem; background: #f8fafc; padding: 0.75rem; border-radius: 8px;">
                    <i class="fa-solid fa-circle-info" style="color: #3b82f6; margin-right: 4px;"></i>
                    Demo mode: No actual UPI request will be sent.
                </p>
            </div>

            {{-- Net Banking Form --}}
            <div class="rzp-card-form" id="form-netbanking">
                <div class="rzp-input-group">
                    <label>Select Bank</label>
                    <select style="width: 100%; padding: 0.7rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; outline: none; font-family: 'Outfit', sans-serif; box-sizing: border-box;">
                        <option>State Bank of India</option>
                        <option>HDFC Bank</option>
                        <option>ICICI Bank</option>
                        <option>Axis Bank</option>
                        <option>Kotak Mahindra Bank</option>
                    </select>
                </div>
                <p style="font-size: 0.78rem; color: #64748b; margin-top: 0.5rem; background: #f8fafc; padding: 0.75rem; border-radius: 8px;">
                    <i class="fa-solid fa-circle-info" style="color: #3b82f6; margin-right: 4px;"></i>
                    Demo mode: Net banking redirect is simulated.
                </p>
            </div>

            <button class="rzp-pay-btn" id="rzpPayBtn" onclick="processPayment()">
                <i class="fa-solid fa-lock" style="margin-right: 8px;"></i>
                Pay ₹<span id="rzpBtnAmount">0</span> Securely
            </button>
            <div class="rzp-secure">
                <i class="fa-solid fa-shield-halved" style="color: #22c55e;"></i>
                256-bit SSL Encrypted • Powered by Razorpay
            </div>
        </div>

        {{-- Processing State --}}
        <div class="rzp-processing" id="rzpProcessing">
            <div class="spinner"></div>
            <h4 style="color: #1e293b; margin-bottom: 0.5rem;">Processing Payment...</h4>
            <p style="color: #64748b; font-size: 0.88rem;">Please wait while we verify your transaction.</p>
        </div>

        {{-- Success State --}}
        <div class="rzp-success" id="rzpSuccess">
            <div class="success-check"><i class="fa-solid fa-check"></i></div>
            <h3 style="color: #15803d; font-size: 1.4rem; margin-bottom: 0.5rem;">Payment Successful!</h3>
            <p style="color: #374151; margin-bottom: 0.25rem; font-size: 0.95rem;">Thank you for your generous contribution!</p>
            <p style="color: #94a3b8; font-size: 0.8rem; margin-bottom: 1.5rem;" id="rzpSuccessPayId"></p>
            <div style="background: #f0fdf4; border-radius: 12px; padding: 1rem 1.5rem; width: 100%; text-align: center; margin-bottom: 1.5rem;">
                <span style="font-size: 0.75rem; color: #16a34a; text-transform: uppercase; font-weight: 700;">Amount Donated</span>
                <div style="font-size: 2rem; font-weight: 800; color: #15803d;">₹<span id="rzpSuccessAmount"></span></div>
            </div>
            <button onclick="window.location.reload()" class="rzp-pay-btn" style="background: linear-gradient(135deg, #16a34a, #15803d);">
                <i class="fa-solid fa-rotate" style="margin-right: 8px;"></i> View My Donations
            </button>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('givingChart').getContext('2d');
    const labelData = {!! json_encode($trends->keys()) !!};
    const valueData = {!! json_encode($trends->values()) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labelData.length ? labelData : [new Date().toLocaleDateString('en-US', {month: 'short', year: 'numeric'})],
            datasets: [{
                label: 'Monthly Giving (₹)',
                data: valueData.length ? valueData : [0],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.05)',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#0047ab',
                pointBorderColor: '#ffffff',
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    padding: 12,
                    backgroundColor: '#1e293b',
                    titleFont: { family: 'Outfit', size: 13, weight: 'bold' },
                    bodyFont: { family: 'Outfit', size: 12 },
                    callbacks: {
                        label: function(context) {
                            return ' ₹' + context.parsed.y.toLocaleString('en-IN');
                        }
                    }
                }
            },
            scales: {
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { family: 'Outfit', size: 10 },
                        callback: function(value) { return '₹' + value; }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Outfit', size: 10 } }
                }
            }
        }
    });
});

function toggleLeaderboard(type) {
    const listDonors = document.getElementById('leaderboard-donors');
    const listBatches = document.getElementById('leaderboard-batches');
    const btnDonors = document.getElementById('btn-lead-donors');
    const btnBatches = document.getElementById('btn-lead-batches');

    if (type === 'donors') {
        listDonors.style.display = 'flex';
        listBatches.style.display = 'none';
        btnDonors.style.background = 'white';
        btnDonors.style.color = '#0047ab';
        btnDonors.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';
        btnBatches.style.background = 'transparent';
        btnBatches.style.color = '#64748b';
        btnBatches.style.boxShadow = 'none';
    } else {
        listDonors.style.display = 'none';
        listBatches.style.display = 'flex';
        btnBatches.style.background = 'white';
        btnBatches.style.color = '#0047ab';
        btnBatches.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';
        btnDonors.style.background = 'transparent';
        btnDonors.style.color = '#64748b';
        btnDonors.style.boxShadow = 'none';
    }
}

// Modal state
let currentCampaignId = null;
let currentPurpose    = null;
let currentDonationId = null;
let currentAmount     = 500;

function openDonateModal(purpose, campaignId, amount) {
    currentPurpose    = purpose;
    currentCampaignId = campaignId;
    currentAmount     = parseInt(amount) || 500;

    document.getElementById('rzpModalTitle').textContent  = purpose;
    document.getElementById('rzpDisplayPurpose').textContent = '🎯 ' + purpose;
    document.getElementById('rzpDisplayAmount').textContent  = currentAmount.toLocaleString('en-IN');
    document.getElementById('rzpBtnAmount').textContent      = currentAmount.toLocaleString('en-IN');
    document.getElementById('rzpCustomAmount').value         = currentAmount;

    // Reset modal to initial state
    document.getElementById('rzpBody').style.display       = '';
    document.getElementById('rzpProcessing').classList.remove('active');
    document.getElementById('rzpSuccess').classList.remove('active');
    document.getElementById('rzpPayBtn').disabled = false;

    document.getElementById('rzpOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('rzpOverlay').classList.remove('active');
    document.body.style.overflow = '';
}

function updateAmount(val) {
    const amt = parseInt(val) || currentAmount;
    currentAmount = amt;
    document.getElementById('rzpDisplayAmount').textContent = amt.toLocaleString('en-IN');
    document.getElementById('rzpBtnAmount').textContent     = amt.toLocaleString('en-IN');
}

function switchTab(tab) {
    document.querySelectorAll('.rzp-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.rzp-card-form').forEach(f => f.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    document.getElementById('form-' + tab).classList.add('active');
}

function formatCard(input) {
    let v = input.value.replace(/\D/g, '').substring(0, 16);
    input.value = v.replace(/(.{4})/g, '$1 ').trim();
}

async function processPayment() {
    const btn = document.getElementById('rzpPayBtn');
    btn.disabled = true;

    // Step 1: Show processing
    document.getElementById('rzpBody').style.display = 'none';
    document.getElementById('rzpProcessing').classList.add('active');

    try {
        // Step 2: Create order
        const orderRes = await fetch('{{ route("donations.order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                amount:      currentAmount,
                purpose:     currentPurpose,
                campaign_id: currentCampaignId,
            }),
        });

        const orderData = await orderRes.json();
        if (!orderRes.ok) throw new Error(orderData.message || 'Order creation failed');

        currentDonationId = orderData.donation_id;

        // Step 3: Simulate payment processing (1.5s delay for realism)
        await new Promise(r => setTimeout(r, 1800));

        // Step 4: Generate dummy payment ID
        const dummyPaymentId = 'pay_' + Math.random().toString(36).substring(2, 18).toUpperCase();

        // Step 5: Verify payment
        const verifyRes = await fetch('{{ route("donations.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                donation_id:          currentDonationId,
                razorpay_order_id:    orderData.order.id,
                razorpay_payment_id:  dummyPaymentId,
            }),
        });

        const verifyData = await verifyRes.json();
        if (!verifyRes.ok || !verifyData.success) throw new Error('Payment verification failed');

        // Step 6: Show success
        document.getElementById('rzpProcessing').classList.remove('active');
        document.getElementById('rzpSuccess').classList.add('active');
        document.getElementById('rzpSuccessAmount').textContent = currentAmount.toLocaleString('en-IN');
        document.getElementById('rzpSuccessPayId').textContent  = 'Transaction ID: ' + dummyPaymentId;

    } catch (err) {
        document.getElementById('rzpProcessing').classList.remove('active');
        document.getElementById('rzpBody').style.display = '';
        btn.disabled = false;
        alert('Payment failed: ' + err.message);
    }
}

// Close on overlay click
document.getElementById('rzpOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection
