@extends('layouts.app')

@section('styles')
<style>
.thread-wrapper {
    max-width: 900px;
    margin: 0 auto;
}
.vote-panel {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 48px;
}
.vote-arrow {
    font-size: 1.5rem;
    color: #cbd5e1;
    cursor: pointer;
    background: none;
    border: none;
    transition: all 0.2s;
    padding: 0.2rem;
}
.vote-arrow:hover { color: #0047ab; transform: scale(1.15); }
.vote-arrow.active { color: #0047ab; }
.vote-count {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1e293b;
    margin: 4px 0;
}

.answer-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 12px rgba(0,0,0,0.01);
    margin-bottom: 1.25rem;
    display: flex;
    gap: 1.25rem;
    position: relative;
    overflow: hidden;
    transition: border-color 0.2s;
}
.answer-card-accepted {
    border-color: #a7f3d0;
    background: #f0fdf410;
}
.accepted-check-banner {
    position: absolute;
    top: 0; right: 0;
    background: #10b981;
    color: white;
    font-size: 0.65rem;
    font-weight: 800;
    padding: 0.25rem 0.85rem;
    border-bottom-left-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.btn-accept-action {
    background: #f0fdf4;
    color: #16a34a;
    border: 1.5px solid #bbf7d0;
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.btn-accept-action:hover {
    background: #16a34a;
    color: white;
    border-color: #16a34a;
}
</style>
@endsection

@section('content')
<div class="thread-wrapper">

    {{-- Back to forum --}}
    <div style="margin-bottom: 1.25rem;">
        <a href="{{ route('forum.index') }}" style="color: #0047ab; text-decoration: none; font-size: 0.88rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Forum Roster
        </a>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; font-weight: 600;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; font-weight: 600;">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Main Question Card --}}
    <div class="answer-card" style="margin-bottom: 2rem; border-left: 4px solid #0047ab;">
        <div class="vote-panel">
            <button onclick="castVote('{{ $question->_id }}', 'question', 'upvote', this)" class="vote-arrow {{ isset($votes[$question->_id]) && $votes[$question->_id]->type === 'upvote' ? 'active' : '' }}" title="This question is useful and clear">
                <i class="fa-solid fa-caret-up"></i>
            </button>
            <span class="vote-count" id="voteCount-{{ $question->_id }}">{{ $question->views }}</span>
            <span style="font-size: 0.6rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Views</span>
        </div>

        <div style="flex: 1;">
            <h2 style="margin: 0 0 1rem; font-size: 1.45rem; color: #0f172a; font-weight: 800; line-height: 1.35;">{{ $question->title }}</h2>
            
            <div style="font-size: 0.95rem; color: #374151; line-height: 1.7; margin-bottom: 1.5rem; white-space: pre-line;">{{ $question->body }}</div>

            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; border-top: 1px solid #f1f5f9; padding-top: 1rem;">
                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                    @foreach($question->tags ?? [] as $t)
                    <a href="{{ route('forum.index', ['search' => $t]) }}" class="tag-badge">{{ $t }}</a>
                    @endforeach
                </div>
                
                <div style="display: flex; align-items: center; gap: 8px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($question->user_name) }}&background=random" style="width: 32px; height: 32px; border-radius: 50%;">
                    <div>
                        <span style="font-size: 0.8rem; font-weight: 700; color: #475569; display: block;">{{ $question->user_name }}</span>
                        <span style="font-size: 0.7rem; color: #94a3b8;">Posted {{ $question->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Answers Header --}}
    <h3 style="margin-bottom: 1.25rem; color: #0f172a; font-weight: 800; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.75rem;">
        <i class="fa-solid fa-reply-all" style="color: #10b981;"></i> Answers ({{ $answers->count() }})
    </h3>

    {{-- Answers List --}}
    <div style="margin-bottom: 2.5rem;">
        @forelse($answers as $ans)
        <div class="answer-card {{ $ans->is_accepted ? 'answer-card-accepted' : '' }}">
            @if($ans->is_accepted)
            <div class="accepted-check-banner">
                <i class="fa-solid fa-circle-check"></i> Accepted Solution
            </div>
            @endif

            <div class="vote-panel">
                <button onclick="castVote('{{ $ans->_id }}', 'answer', 'upvote', this)" class="vote-arrow {{ isset($votes[$ans->_id]) && $votes[$ans->_id]->type === 'upvote' ? 'active' : '' }}" title="This answer is exceptionally helpful">
                    <i class="fa-solid fa-caret-up"></i>
                </button>
                <span class="vote-count" id="voteCount-{{ $ans->_id }}">{{ $ans->upvotes }}</span>
                <span style="font-size: 0.6rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Votes</span>
            </div>

            <div style="flex: 1; padding-top: {{ $ans->is_accepted ? '0.75rem' : '0' }};">
                <div style="font-size: 0.9rem; color: #374151; line-height: 1.7; margin-bottom: 1.25rem; white-space: pre-line;">{{ $ans->body }}</div>

                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; border-top: 1px solid #f8fafc; padding-top: 0.85rem;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($ans->user_name) }}&background=random" style="width: 30px; height: 30px; border-radius: 50%;">
                        <div>
                            <span style="font-size: 0.78rem; font-weight: 700; color: #475569; display: block;">{{ $ans->user_name }}</span>
                            <span style="font-size: 0.68rem; color: #94a3b8;">Replied {{ $ans->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    {{-- Accept Action (Question Author only, and if not already accepted) --}}
                    @if($question->user_id === Auth::id() && !$ans->is_accepted)
                    <form action="{{ route('forum.accept', [$question->_id, $ans->_id]) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-accept-action">
                            <i class="fa-solid fa-square-check"></i> Accept Answer
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8; background: white; border-radius: 20px; border: 1px solid #f1f5f9;">
            <i class="fa-regular fa-comment-dots" style="font-size: 2.5rem; margin-bottom: 1rem; display: block;"></i>
            <p style="font-size: 0.95rem; margin: 0;">No replies submitted yet.</p>
            <p style="font-size: 0.82rem; margin-top: 2px;">Share your wisdom by submitting the first answer below!</p>
        </div>
        @endforelse
    </div>

    {{-- Post Answer Form Workspace --}}
    <div class="answer-card" style="flex-direction: column;">
        <h3 style="margin-top: 0; margin-bottom: 1rem; color: #0f172a; font-weight: 800; display: flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-pen-fancy" style="color: #0047ab;"></i> Your Professional Reply
        </h3>
        <form action="{{ route('forum.answer', $question->_id) }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.25rem;">
                <textarea name="body" rows="6" placeholder="Provide highly specific details, code blocks, or step-by-step career guidelines to help..." required
                          style="width: 100%; padding: 0.85rem 1.1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 0.9rem; outline: none; background: #f8fafc; color: #1e293b; font-family: inherit; box-sizing: border-box; resize: vertical;"></textarea>
            </div>
            <button type="submit" class="btn-primary" style="padding: 0.65rem 1.75rem; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(0,71,171,0.25);">
                <i class="fa-solid fa-paper-plane"></i> Submit Answer
            </button>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
async function castVote(votableId, votableType, type, element) {
    // Basic scale anim on click
    element.style.transform = 'scale(1.2)';
    setTimeout(() => { element.style.transform = 'none'; }, 150);

    try {
        const res = await fetch('{{ route("forum.vote") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                votable_id:   votableId,
                votable_type: votableType,
                type:         type,
            })
        });

        const data = await res.json();
        if (data.success) {
            // Update vote display
            const countEl = document.getElementById('voteCount-' + votableId);
            if (countEl) {
                if (data.new_score !== undefined) {
                    countEl.textContent = data.new_score;
                }
                
                // Toggle active arrow color
                if (element.classList.contains('active')) {
                    element.classList.remove('active');
                } else {
                    element.classList.add('active');
                }
            }
        }
    } catch(err) {
        console.error('Voting failed:', err);
    }
}
</script>
@endsection
