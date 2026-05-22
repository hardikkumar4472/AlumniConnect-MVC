<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniEvent;
use App\Models\JobOpportunity;
use App\Models\Donation;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $stats = [
            'alumni_count' => User::count(),
            'events_count' => AlumniEvent::count(),
            'jobs_count' => JobOpportunity::count(),
            'donations_total' => Donation::sum('amount'),
        ];

        $featured_story = SuccessStory::first();
        $upcoming_events = AlumniEvent::orderBy('date', 'asc')->take(3)->get();

        return view('landing', compact('stats', 'featured_story', 'upcoming_events'));
    }

    public function dashboard()
    {
        $alumni_count = User::count();
        $events = AlumniEvent::orderBy('date', 'asc')->take(3)->get();
        $featured_story = SuccessStory::first();
        $recent_donations = Donation::orderBy('created_at', 'desc')->take(5)->get();
        $unread_messages_count = \App\Models\Message::where('receiver_id', Auth::user()->_id)
            ->where('is_read', false)
            ->count();
        $campus_news = \App\Models\CampusNews::orderBy('created_at', 'desc')->take(3)->get();

        return view('dashboard', compact('alumni_count', 'events', 'featured_story', 'recent_donations', 'unread_messages_count', 'campus_news'));
    }

    public function directory(Request $request)
    {
        $query = User::query();

        if (Auth::check()) {
            $query->where('_id', '!=', Auth::id());

            if (Auth::user()->role === 'student') {
                $query->where('role', 'alumni');
            }
        }

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('department', 'like', '%' . $searchTerm . '%')
                  ->orWhere('graduation_year', 'like', '%' . $searchTerm . '%');
            });
        }
        $alumni = $query->paginate(12);
        
        $sent_request_ids = [];
        $connected_user_ids = [];
        
        if (Auth::check()) {
            $sent_request_ids = \App\Models\Connection::where('requester_id', Auth::id())
                ->where('status', 'pending')
                ->pluck('recipient_id')->toArray();
                
            $connected_user_ids = \App\Models\Connection::where('status', 'accepted')
                ->where(function($q) {
                    $q->where('requester_id', Auth::id())->orWhere('recipient_id', Auth::id());
                })->get()->map(function($c) { 
                    return $c->requester_id == Auth::id() ? $c->recipient_id : $c->requester_id; 
                })->toArray();
        }

        return view('pages.directory', compact('alumni', 'sent_request_ids', 'connected_user_ids'));
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        
        $connection = null;
        if (Auth::check()) {
            $connection = \App\Models\Connection::where(function($q) use ($id) {
                $q->where('requester_id', Auth::id())->where('recipient_id', $id);
            })->orWhere(function($q) use ($id) {
                $q->where('requester_id', $id)->where('recipient_id', Auth::id());
            })->first();
        }

        return view('pages.profile', compact('user', 'connection'));
    }

    public function network() 
    { 
        $mentors = User::where('role', 'alumni')->where('_id', '!=', Auth::id())->take(6)->get();
        
        $pending_requests = \App\Models\Connection::with('requester')
            ->where('recipient_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        $sent_requests = \App\Models\Connection::where('requester_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        $connections = \App\Models\Connection::with(['requester', 'recipient'])
            ->where('status', 'accepted')
            ->where(function ($q) {
                $q->where('requester_id', Auth::id())
                  ->orWhere('recipient_id', Auth::id());
            })->get();

        $connected_users = $connections->map(function ($conn) {
            return $conn->requester_id == Auth::id() ? $conn->recipient : $conn->requester;
        });

        $sent_request_ids = $sent_requests->pluck('recipient_id')->toArray();
        $connected_user_ids = $connected_users->pluck('_id')->toArray();

        return view('pages.network', compact(
            'mentors', 
            'pending_requests', 
            'connected_users', 
            'sent_request_ids', 
            'connected_user_ids'
        )); 
    }

    public function jobs()
    {
        $jobs = \App\Models\JobOpportunity::with('applications')->orderBy('created_at', 'desc')->get();
        
        $applied_job_ids = [];
        if (Auth::check() && Auth::user()->role === 'student') {
            $applied_job_ids = \App\Models\JobApplication::where('applicant_id', Auth::id())
                ->pluck('job_id')->toArray();
        }

        return view('pages.jobs', compact('jobs', 'applied_job_ids'));
    }

    public function events()
    {
        $events = AlumniEvent::orderBy('date', 'asc')->get();
        return view('pages.events', compact('events'));
    }

    public function donations() { return view('pages.donations'); }
    public function processDonation(Request $request) { return back()->with('success', 'Thank you for your donation!'); }

    public function stories()
    {
        $stories = SuccessStory::all();
        return view('pages.stories', compact('stories'));
    }

    public function feedback() { return view('pages.feedback'); }
    public function submitFeedback(Request $request) { 
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        \App\Models\Feedback::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        
        return back()->with('success', 'Feedback submitted! It has been securely sent to the admin portal.'); 
    }

    public function resources() 
    {
        $resources = \App\Models\Resource::orderBy('created_at', 'desc')->get();
        return view('pages.resources', compact('resources')); 
    }
}
