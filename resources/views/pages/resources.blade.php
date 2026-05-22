@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Resources</h2>
    <p>Helpful documents, links, and materials for our alumni community.</p>
</div>

<div class="resources-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    @forelse($resources as $resource)
    <a href="{{ $resource->link }}" target="_blank" style="text-decoration: none; color: inherit;">
        <div class="card" style="display: flex; gap: 1rem; align-items: flex-start; transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">
            @php
                $icon = 'fa-file-lines';
                $color = '#3182ce';
                if(str_contains(strtolower($resource->type), 'guide')) { $icon = 'fa-book'; $color = '#38a169'; }
                elseif(str_contains(strtolower($resource->type), 'template')) { $icon = 'fa-file-word'; $color = '#805ad5'; }
                elseif(str_contains(strtolower($resource->type), 'video')) { $icon = 'fa-video'; $color = '#e53e3e'; }
            @endphp
            <i class="fa-solid {{ $icon }}" style="font-size: 2rem; color: {{ $color }}; margin-top: 5px;"></i>
            <div>
                <h4 style="font-size: 1.1rem; margin-bottom: 5px;">{{ $resource->title }}</h4>
                <p style="font-size: 0.8rem; color: #718096; margin-bottom: 5px; font-weight: 600;">{{ strtoupper($resource->type) }}</p>
                <p style="font-size: 0.85rem; color: #4a5568;">{{ $resource->description }}</p>
            </div>
        </div>
    </a>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e0;">
        <p style="color: #718096;">No resources have been published yet. Please check back later!</p>
    </div>
    @endforelse
</div>
@endsection
