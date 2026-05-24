<?php

namespace App\Http\Controllers;

use App\Models\ForumQuestion;
use App\Models\ForumAnswer;
use App\Models\ForumVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $query = ForumQuestion::query();

        // Search questions
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('body', 'like', '%' . $searchTerm . '%')
                  ->orWhere('tags', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply filters
        $tab = $request->get('tab', 'latest');
        if ($tab === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($tab === 'unanswered') {
            $query->whereNull('accepted_answer_id')->orderBy('created_at', 'desc');
        } elseif ($tab === 'popular') {
            $query->orderBy('views', 'desc');
        }

        $questions = $query->paginate(15);

        return view('forum.index', compact('questions', 'tab'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
            'tags'  => 'nullable|string',
        ]);

        $tagsArray = [];
        if ($request->filled('tags')) {
            $tagsArray = array_map('trim', explode(',', $request->tags));
            $tagsArray = array_filter($tagsArray);
        }

        ForumQuestion::create([
            'user_id'   => Auth::id(),
            'user_name' => Auth::user()->name,
            'title'     => $request->title,
            'body'      => $request->body,
            'tags'      => $tagsArray,
            'views'     => 0,
        ]);

        return redirect()->route('forum.index')->with('success', 'Your question has been posted successfully!');
    }

    public function show($id)
    {
        $question = ForumQuestion::findOrFail($id);
        $question->increment('views');

        $answers = ForumAnswer::where('question_id', $id)
            ->orderBy('is_accepted', 'desc')
            ->orderBy('upvotes', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        // Get user votes on these answers/question
        $votes = ForumVote::where('user_id', Auth::id())->get()->keyBy('votable_id');

        return view('forum.show', compact('question', 'answers', 'votes'));
    }

    public function storeAnswer(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        ForumAnswer::create([
            'question_id' => $id,
            'user_id'     => Auth::id(),
            'user_name'   => Auth::user()->name,
            'body'        => $request->body,
            'upvotes'     => 0,
            'is_accepted' => false,
        ]);

        return back()->with('success', 'Your answer has been posted!');
    }

    public function acceptAnswer($id, $answerId)
    {
        $question = ForumQuestion::findOrFail($id);

        if ($question->user_id !== Auth::id()) {
            return back()->with('error', 'Only the author of the question can accept an answer.');
        }

        // Reset previous accepted answer
        ForumAnswer::where('question_id', $id)->update(['is_accepted' => false]);

        $answer = ForumAnswer::findOrFail($answerId);
        $answer->update(['is_accepted' => true]);

        $question->update(['accepted_answer_id' => $answerId]);

        return back()->with('success', 'You have marked this answer as accepted!');
    }

    public function vote(Request $request)
    {
        $request->validate([
            'votable_id'   => 'required|string',
            'votable_type' => 'required|string|in:question,answer',
            'type'         => 'required|string|in:upvote,downvote',
        ]);

        $userId = Auth::id();
        $votableId = $request->votable_id;
        $votableType = $request->votable_type;
        $type = $request->type;

        // Check if vote already exists
        $existingVote = ForumVote::where('user_id', $userId)
            ->where('votable_id', $votableId)
            ->where('votable_type', $votableType)
            ->first();

        $increment = 0;

        if ($existingVote) {
            if ($existingVote->type === $type) {
                // Clicking the same vote button retracts the vote
                $existingVote->delete();
                $increment = ($type === 'upvote') ? -1 : 1;
            } else {
                // Switching votes (upvote to downvote or vice versa)
                $existingVote->update(['type' => $type]);
                $increment = ($type === 'upvote') ? 2 : -2;
            }
        } else {
            // New vote
            ForumVote::create([
                'user_id'      => $userId,
                'votable_id'   => $votableId,
                'votable_type' => $votableType,
                'type'         => $type,
            ]);
            $increment = ($type === 'upvote') ? 1 : -1;
        }

        // Update vote count inside target document
        if ($votableType === 'answer') {
            $answer = ForumAnswer::find($votableId);
            if ($answer) {
                $answer->increment('upvotes', $increment);
                return response()->json(['success' => true, 'new_score' => $answer->upvotes]);
            }
        }

        return response()->json(['success' => true]);
    }
}
