@extends('layouts.app')

@section('styles')
<style>
/* ===== Admin Donations Page ===== */
.don-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}
.don-stat-card {
    background: white;
    border-radius: 18px;
    padding: 1.5rem 1.75rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s;
}
.don-stat-card:hover { transform: translateY(-2px); }
.don-stat-card .stat-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    margin-bottom: 1rem;
}
.don-stat-card .stat-val {
    font-size: 1.8rem;
    font-weight: 800;
    color: #0f172a;
    display: block;
    line-height: 1;
    margin-bottom: 0.3rem;
}
.don-stat-card .stat-label {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #94a3b8;
    font-weight: 700;
}
.don-stat-card .stat-sub {
    font-size: 0.78rem;
    color: #64748b;
    margin-top: 0.4rem;
}

/* Main two-col layout */
.don-admin-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.5rem;
}

/* Filters */
.filter-bar {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}
.filter-bar input,
.filter-bar select {
    padding: 0.6rem 1rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.85rem;
    outline: none;
    font-family: 'Outfit', sans-serif;
    color: #374151;
    background: white;
    transition: border-color 0.2s;
}
.filter-bar input:focus,
.filter-bar select:focus { border-color: #3b82f6; }
.filter-bar input { flex: 1; min-width: 200px; }
.filter-btn {
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #0047ab, #1d4ed8);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Outfit', sans-serif;
}
.filter-btn:hover { box-shadow: 0 4px 12px rgba(0,71,171,0.3); }

/* Table */
.don-table-wrap {
    background: white;
    border-radius: 18px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    overflow: hidden;
}
.don-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}
.don-table thead tr {
    background: #f8fafc;
    border-bottom: 1px solid #f1f5f9;
}
.don-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #94a3b8;
    white-space: nowrap;
}
.don-table td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f8fafc;
    vertical-align: middle;
    color: #374151;
}
.don-table tbody tr:hover { background: #fafbff; }
.don-table tbody tr:last-child td { border-bottom: none; }

.donor-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    flex-shrink: 0;
}
.donor-info { display: flex; align-items: center; gap: 0.6rem; }
.donor-name  { font-weight: 700; color: #0f172a; font-size: 0.88rem; }
.donor-email { font-size: 0.73rem; color: #94a3b8; }

.badge-purpose {
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    white-space: nowrap;
}
.bp-scholarship    { background: #eff6ff; color: #3b82f6; }
.bp-campus         { background: #f0fdf4; color: #22c55e; }
.bp-innovation     { background: #fdf4ff; color: #a855f7; }
.bp-library        { background: #fff7ed; color: #f97316; }
.bp-general        { background: #f8fafc; color: #64748b; }

.amount-chip {
    font-weight: 800;
    font-size: 1rem;
    color: #0047ab;
}
.pay-id {
    font-size: 0.72rem;
    font-family: 'Courier New', monospace;
    color: #94a3b8;
    background: #f8fafc;
    padding: 2px 6px;
    border-radius: 6px;
}

/* Right sidebar */
.don-sidebar { display: flex; flex-direction: column; gap: 1.5rem; }
.side-card {
    background: white;
    border-radius: 18px;
    padding: 1.5rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}
.side-card h4 {
    font-size: 0.9rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 1.25rem;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.top-donor-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.6rem 0;
    border-bottom: 1px solid #f8fafc;
}
.top-donor-row:last-child { border-bottom: none; }
.rank-badge {
    width: 26px; height: 26px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem;
    font-weight: 800;
    flex-shrink: 0;
}
.rank-1 { background: #fef9c3; color: #854d0e; }
.rank-2 { background: #f1f5f9; color: #475569; }
.rank-3 { background: #fff7ed; color: #c2410c; }
.rank-other { background: #f8fafc; color: #94a3b8; }

.campaign-row {
    padding: 0.85rem 0;
    border-bottom: 1px solid #f8fafc;
}
.campaign-row:last-child { border-bottom: none; }
.camp-progress {
    background: #f1f5f9;
    border-radius: 99px;
    height: 5px;
    overflow: hidden;
    margin-top: 0.4rem;
}
.camp-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #0047ab);
    border-radius: 99px;
}

.pagination-wrap { padding: 1rem 1.25rem; border-top: 1px solid #f1f5f9; }

.no-data {
    display: flex; flex-direction: column; align-items: center;
    padding: 3rem 1rem; color: #94a3b8; text-align: center;
}
</style>
@endsection

@section('content')

<div class="page-header" style="margin-bottom: 2rem;">
    <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">
        <i class="fa-solid fa-hand-holding-heart" style="color: #0047ab; margin-right: 8px;"></i>Donation Management
    </h2>
    <p style="color: #64748b; font-size: 0.9rem;">Track all alumni contributions, campaign performance, and donor leaderboard.</p>
</div>

{{-- ===== Stats Row ===== --}}
<div class="don-stats-grid">
    <div class="don-stat-card" style="background: linear-gradient(135deg, #0047ab, #1e3a8a); color: white;">
        <div class="stat-icon" style="background: rgba(255,255,255,0.15); color: white;">
            <i class="fa-solid fa-indian-rupee-sign"></i>
        </div>
        <span class="stat-val" style="color: white;">₹{{ number_format($total_raised) }}</span>
        <span class="stat-label" style="color: rgba(255,255,255,0.7);">Total Raised</span>
    </div>
    <div class="don-stat-card">
        <div class="stat-icon" style="background: #dcfce7; color: #16a34a;">
            <i class="fa-solid fa-users"></i>
        </div>
        <span class="stat-val">{{ number_format($donor_count) }}</span>
        <span class="stat-label">Unique Donors</span>
        <p class="stat-sub"><i class="fa-solid fa-circle" style="color: #22c55e; font-size: 0.5rem; margin-right: 4px;"></i>All-time contributors</p>
    </div>
    <div class="don-stat-card">
        <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;">
            <i class="fa-solid fa-calendar-day"></i>
        </div>
        <span class="stat-val">₹{{ number_format($this_month) }}</span>
        <span class="stat-label">This Month</span>
        <p class="stat-sub"><i class="fa-regular fa-calendar"></i> {{ now()->format('F Y') }}</p>
    </div>
    <div class="don-stat-card">
        <div class="stat-icon" style="background: #fdf4ff; color: #a855f7;">
            <i class="fa-solid fa-bullhorn"></i>
        </div>
        <span class="stat-val">{{ $campaigns->count() }}</span>
        <span class="stat-label">Active Campaigns</span>
        <p class="stat-sub">Alumni-created initiatives</p>
    </div>
</div>

{{-- ===== Main Grid ===== --}}
<div class="don-admin-grid">

    {{-- Left: Transactions Table --}}
    <div>
        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.donations') }}" style="margin-bottom: 0;">
            <div class="filter-bar">
                <input type="text" name="search" placeholder="🔍  Search by donor name, purpose, payment ID…" value="{{ request('search') }}">
                <select name="purpose">
                    <option value="">All Purposes</option>
                    <option value="Scholarship Fund"    {{ request('purpose') == 'Scholarship Fund'   ? 'selected' : '' }}>Scholarship Fund</option>
                    <option value="Campus Development"  {{ request('purpose') == 'Campus Development' ? 'selected' : '' }}>Campus Development</option>
                    <option value="Innovation Lab"      {{ request('purpose') == 'Innovation Lab'     ? 'selected' : '' }}>Innovation Lab</option>
                    <option value="Library Expansion"   {{ request('purpose') == 'Library Expansion'  ? 'selected' : '' }}>Library Expansion</option>
                    <option value="General College Fund"{{ request('purpose') == 'General College Fund'? 'selected' : '' }}>General College Fund</option>
                </select>
                <button type="submit" class="filter-btn"><i class="fa-solid fa-filter" style="margin-right: 6px;"></i>Filter</button>
                @if(request('search') || request('purpose'))
                <a href="{{ route('admin.donations') }}" style="padding: 0.6rem 1rem; border-radius: 10px; border: 1px solid #e2e8f0; color: #64748b; font-size: 0.85rem; font-weight: 600; text-decoration: none; background: white;">Clear</a>
                @endif
            </div>
        </form>

        <div class="don-table-wrap">
            @if($donations->count() > 0)
            <table class="don-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Donor</th>
                        <th>Purpose</th>
                        <th>Amount</th>
                        <th>Payment ID</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $i => $d)
                    @php
                        $purposeMap = [
                            'Scholarship Fund'   => 'scholarship',
                            'Campus Development' => 'campus',
                            'Innovation Lab'     => 'innovation',
                            'Library Expansion'  => 'library',
                        ];
                        $pClass = $purposeMap[$d->purpose] ?? 'general';
                    @endphp
                    <tr>
                        <td style="color: #94a3b8; font-size: 0.8rem; width: 40px;">
                            {{ ($donations->currentPage() - 1) * $donations->perPage() + $i + 1 }}
                        </td>
                        <td>
                            <div class="donor-info">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($d->user_name ?? 'Anonymous') }}&background=random&size=64"
                                     class="donor-avatar" alt="{{ $d->user_name }}">
                                <div>
                                    <div class="donor-name">{{ $d->user_name ?? 'Anonymous' }}</div>
                                    @if($d->user_id)
                                    <a href="{{ route('profile', $d->user_id) }}" style="font-size: 0.7rem; color: #3b82f6; text-decoration: none;">
                                        View Profile →
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-purpose bp-{{ $pClass }}">{{ $d->purpose }}</span>
                        </td>
                        <td>
                            <span class="amount-chip">₹{{ number_format($d->amount) }}</span>
                        </td>
                        <td>
                            <span class="pay-id">{{ $d->payment_id ?? '—' }}</span>
                        </td>
                        <td style="color: #64748b; font-size: 0.82rem; white-space: nowrap;">
                            {{ $d->created_at->format('d M Y') }}<br>
                            <span style="color: #94a3b8; font-size: 0.72rem;">{{ $d->created_at->format('h:i A') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrap">
                {{ $donations->withQueryString()->links() }}
            </div>
            @else
            <div class="no-data">
                <i class="fa-solid fa-box-open" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
                <h4 style="margin-bottom: 0.5rem; color: #64748b;">No Donations Found</h4>
                <p style="font-size: 0.85rem;">Try changing your filters or wait for alumni to start donating.</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div class="don-sidebar">

        {{-- Top Donors Leaderboard --}}
        <div class="side-card">
            <h4><i class="fa-solid fa-trophy" style="color: #f59e0b;"></i> Top Donors</h4>
            @forelse($top_donors as $i => $donor)
            <div class="top-donor-row">
                <div class="rank-badge {{ $i == 0 ? 'rank-1' : ($i == 1 ? 'rank-2' : ($i == 2 ? 'rank-3' : 'rank-other')) }}">
                    {{ $i == 0 ? '🥇' : ($i == 1 ? '🥈' : ($i == 2 ? '🥉' : '#'.($i+1))) }}
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode($donor['user_name']) }}&background=random&size=64"
                     style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; flex-shrink: 0;" alt="">
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 0.83rem; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $donor['user_name'] }}
                    </div>
                    <div style="font-size: 0.7rem; color: #94a3b8;">{{ $donor['count'] }} donation{{ $donor['count'] > 1 ? 's' : '' }}</div>
                </div>
                <div style="font-size: 0.88rem; font-weight: 800; color: #0047ab; flex-shrink: 0;">
                    ₹{{ number_format($donor['total']) }}
                </div>
            </div>
            @empty
            <p style="font-size: 0.85rem; color: #94a3b8; text-align: center; padding: 1.5rem 0;">No donations yet.</p>
            @endforelse
        </div>

        {{-- Campaign Progress --}}
        <div class="side-card">
            <h4><i class="fa-solid fa-chart-pie" style="color: #8b5cf6;"></i> Campaigns</h4>
            @forelse($campaigns->take(6) as $c)
            @php $pct = $c->goal_amount > 0 ? min(100, round(($c->raised_amount / $c->goal_amount) * 100)) : 0; @endphp
            <div class="campaign-row">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.2rem;">
                    <span style="font-size: 0.82rem; font-weight: 700; color: #0f172a;">{{ Str::limit($c->title, 30) }}</span>
                    <span style="font-size: 0.72rem; color: #94a3b8;">{{ $pct }}%</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.7rem; color: #94a3b8; margin-bottom: 0.4rem;">
                    <span>₹{{ number_format($c->raised_amount) }} raised</span>
                    <span>Goal: ₹{{ number_format($c->goal_amount) }}</span>
                </div>
                <div class="camp-progress">
                    <div class="camp-progress-bar" style="width: {{ $pct }}%;"></div>
                </div>
            </div>
            @empty
            <p style="font-size: 0.85rem; color: #94a3b8; text-align: center; padding: 1.5rem 0;">No campaigns yet.</p>
            @endforelse
        </div>

        {{-- Quick Export Note --}}
        <div class="side-card" style="background: linear-gradient(135deg, #0047ab, #1e3a8a); color: white;">
            <h4 style="color: white;"><i class="fa-solid fa-file-export"></i> Summary</h4>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
                    <span style="opacity: 0.8;">Total Collected</span>
                    <span style="font-weight: 800;">₹{{ number_format($total_raised) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
                    <span style="opacity: 0.8;">This Month</span>
                    <span style="font-weight: 800;">₹{{ number_format($this_month) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
                    <span style="opacity: 0.8;">Avg. Donation</span>
                    <span style="font-weight: 800;">
                        @php $avgD = $donations->total() > 0 ? $total_raised / $donations->total() : 0; @endphp
                        ₹{{ number_format($avgD) }}
                    </span>
                </div>
                <div style="height: 1px; background: rgba(255,255,255,0.15); margin: 0.25rem 0;"></div>
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
                    <span style="opacity: 0.8;">Total Transactions</span>
                    <span style="font-weight: 800;">{{ $donations->total() }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
