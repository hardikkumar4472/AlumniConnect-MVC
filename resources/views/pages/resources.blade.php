@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>Resources</h2>
    <p>Helpful documents, links, and materials for our alumni community.</p>
</div>

<div class="resources-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    <div class="card" style="display: flex; gap: 1rem; align-items: center;">
        <i class="fa-solid fa-file-pdf" style="font-size: 2rem; color: #e53e3e;"></i>
        <div>
            <h4 style="font-size: 1rem;">Association Bylaws</h4>
            <p style="font-size: 0.8rem; color: #718096;">PDF Document • 2.4 MB</p>
        </div>
    </div>
    
    <div class="card" style="display: flex; gap: 1rem; align-items: center;">
        <i class="fa-solid fa-file-lines" style="font-size: 2rem; color: #3182ce;"></i>
        <div>
            <h4 style="font-size: 1rem;">Annual Report 2023</h4>
            <p style="font-size: 0.8rem; color: #718096;">PDF Document • 5.1 MB</p>
        </div>
    </div>

    <div class="card" style="display: flex; gap: 1rem; align-items: center;">
        <i class="fa-solid fa-graduation-cap" style="font-size: 2rem; color: #38a169;"></i>
        <div>
            <h4 style="font-size: 1rem;">Mentorship Guide</h4>
            <p style="font-size: 0.8rem; color: #718096;">DOCX Document • 1.2 MB</p>
        </div>
    </div>

    <div class="card" style="display: flex; gap: 1rem; align-items: center;">
        <i class="fa-solid fa-link" style="font-size: 2rem; color: #805ad5;"></i>
        <div>
            <h4 style="font-size: 1rem;">Institution Website</h4>
            <p style="font-size: 0.8rem; color: #718096;">External Link</p>
        </div>
    </div>
</div>
@endsection
