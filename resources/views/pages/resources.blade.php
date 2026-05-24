@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h2 style="font-size: 2rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-folder-open" style="color: #6366f1;"></i> Digital Resources
    </h2>
    <p style="color: #64748b; font-size: 0.95rem; font-weight: 500;">Helpful documents, career links, and templates shared by our alumni network.</p>
</div>

<div class="res-grid">
    @forelse($resources as $resource)
        @php
            $typeLower = strtolower($resource->type);
            $typeClass = 'generic';
            $icon = 'fa-file-lines';
            
            if (str_contains($typeLower, 'guide') || str_contains($typeLower, 'book') || str_contains($typeLower, 'pdf')) {
                $typeClass = 'guide';
                $icon = 'fa-book-open';
            } elseif (str_contains($typeLower, 'template') || str_contains($typeLower, 'doc') || str_contains($typeLower, 'sheet')) {
                $typeClass = 'template';
                $icon = 'fa-file-signature';
            } elseif (str_contains($typeLower, 'video') || str_contains($typeLower, 'tutorial') || str_contains($typeLower, 'media')) {
                $typeClass = 'video';
                $icon = 'fa-circle-play';
            }
        @endphp
        
        <a href="{{ $resource->link }}" target="_blank" class="res-card">
            <div class="res-icon-container {{ $typeClass }}">
                <i class="fa-solid {{ $icon }}"></i>
            </div>
            <div style="flex: 1; min-width: 0;">
                <span class="res-type-tag {{ $typeClass }}">{{ $resource->type }}</span>
                <h4 class="res-title">{{ $resource->title }}</h4>
                <p class="res-desc">{{ $resource->description }}</p>
            </div>
        </a>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem; background: #ffffff; border-radius: 24px; border: 1px dashed #cbd5e1;">
            <i class="fa-solid fa-box-open" style="font-size: 3rem; color: #94a3b8; margin-bottom: 1.5rem; display: block; opacity: 0.5;"></i>
            <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.5rem; font-weight: 700;">No Resources Yet</h4>
            <p style="color: #64748b; font-size: 0.9rem;">We don't have any shared files or guidelines available at this time. Please check back later.</p>
        </div>
    @endforelse
</div>
@endsection
