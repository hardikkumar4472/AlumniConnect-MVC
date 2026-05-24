@extends('layouts.app')

@section('content')
<div style="max-width: 720px; margin: 0 auto;">

    {{-- Back to forum --}}
    <div style="margin-bottom: 1.25rem;">
        <a href="{{ route('forum.index') }}" style="color: #0047ab; text-decoration: none; font-size: 0.88rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Forum
        </a>
    </div>

    <div class="card" style="padding: 2.5rem; border-radius: 24px; border: 1px solid #f1f5f9; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
        <h2 style="margin-top: 0; margin-bottom: 0.5rem; font-size: 1.4rem; color: #0f172a; font-weight: 800; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-question" style="color: #0047ab;"></i> Ask a Public Question
        </h2>
        <p style="color: #64748b; font-size: 0.85rem; margin: 0 0 2rem; line-height: 1.5;">
            Be specific, explain your background clearly, and use matching tag pills so the right students or alumni can find and answer your query.
        </p>

        <form action="{{ route('forum.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label style="font-size: 0.75rem; font-weight: 700; color: #374151; display: block; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">Question Title</label>
                <input type="text" name="title" placeholder="e.g. Is it better to learn React Native or Flutter for Android Dev in 2026?" required
                       style="width: 100%; padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 0.9rem; outline: none; background: #f8fafc; color: #1e293b; font-family: inherit; box-sizing: border-box; transition: all 0.2s;">
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label style="font-size: 0.75rem; font-weight: 700; color: #374151; display: block; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">Detailed Context Description</label>
                <textarea name="body" rows="8" placeholder="Introduce the problem, describe what you have tried, paste code snippets, or explain your career aspirations in detail..." required
                          style="width: 100%; padding: 0.85rem 1.1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 0.9rem; outline: none; background: #f8fafc; color: #1e293b; font-family: inherit; box-sizing: border-box; resize: vertical; transition: all 0.2s;"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label style="font-size: 0.75rem; font-weight: 700; color: #374151; display: block; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">Tags / Subject Categories</label>
                <input type="text" name="tags" placeholder="e.g. android, react, flutter, career-guidance"
                       style="width: 100%; padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 0.9rem; outline: none; background: #f8fafc; color: #1e293b; font-family: inherit; box-sizing: border-box; transition: all 0.2s;">
                <span style="font-size: 0.72rem; color: #64748b; margin-top: 6px; display: block; line-height: 1.4;">
                    <i class="fa-solid fa-circle-info" style="color: #3b82f6; margin-right: 3px;"></i> Enter up to 5 tag subjects separated by commas (no spaces, all lowercase).
                </span>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-primary" style="flex: 1.5; padding: 0.75rem; display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 4px 12px rgba(0,71,171,0.25);">
                    <i class="fa-solid fa-bullhorn"></i> Publish Question Thread
                </button>
                <a href="{{ route('forum.index') }}" class="btn-outline" style="flex: 1; padding: 0.75rem; display: flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none; border-color: #cbd5e1; color: #475569;">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>

<style>
.form-group label {
    font-weight: 800;
}
.form-group input:focus,
.form-group textarea:focus {
    border-color: #3b82f6 !important;
    background: white !important;
}
</style>
@endsection
