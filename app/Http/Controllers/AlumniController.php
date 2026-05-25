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

        $featured_stories = SuccessStory::where('is_featured', true)->get();
        if ($featured_stories->isEmpty()) {
            $featured_stories = SuccessStory::take(5)->get();
        }
        $upcoming_events = AlumniEvent::orderBy('date', 'asc')->take(3)->get();

        return view('landing', compact('stats', 'featured_stories', 'upcoming_events'));
    }

    public function dashboard()
    {
        $alumni_count = User::count();
        $events = AlumniEvent::orderBy('date', 'asc')->take(3)->get();
        $featured_story = SuccessStory::first();
        $recent_donations = Donation::where('status', 'success')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $unread_messages_count = \App\Models\Message::where('receiver_id', Auth::user()->_id)
            ->where('is_read', false)
            ->count();
        $campus_news = \App\Models\CampusNews::orderBy('created_at', 'desc')->take(3)->get();

        return view('dashboard', compact(
            'alumni_count', 'events', 'featured_story',
            'recent_donations', 'unread_messages_count', 'campus_news'
        ));
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

        // Donation summary visible on alumni profile
        $profile_donation_total = \App\Models\Donation::where('user_id', (string) $user->_id)
            ->where('status', 'success')
            ->sum('amount');
        $profile_donation_count = \App\Models\Donation::where('user_id', (string) $user->_id)
            ->where('status', 'success')
            ->count();

        return view('pages.profile', compact('user', 'connection', 'profile_donation_total', 'profile_donation_count'));
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

        // ── Mentorship Session Bundling ─────────────────────────────
        $userId = Auth::id();
        $role   = Auth::user()->role;
        $my_mentorships = collect();
        $incoming_mentorships = collect();

        if ($role === 'alumni') {
            $incoming_mentorships = \App\Models\MentorshipSession::with('mentee')
                ->where('mentor_id', $userId)
                ->where('status', 'pending')
                ->get();
            $my_mentorships = \App\Models\MentorshipSession::with('mentee')
                ->where('mentor_id', $userId)
                ->whereIn('status', ['active', 'completed', 'rejected'])
                ->get();
        } else {
            $my_mentorships = \App\Models\MentorshipSession::with('mentor')
                ->where('mentee_id', $userId)
                ->get();
        }

        return view('pages.network', compact(
            'mentors', 
            'pending_requests', 
            'connected_users', 
            'sent_request_ids', 
            'connected_user_ids',
            'my_mentorships',
            'incoming_mentorships'
        )); 
    }

    public function jobs()
    {
        $jobs = \App\Models\JobOpportunity::with('applications')->orderBy('created_at', 'desc')->get();
        
        $applied_jobs_status = [];
        if (Auth::check() && Auth::user()->role === 'student') {
            $applied_jobs_status = \App\Models\JobApplication::where('applicant_id', Auth::id())
                ->get()
                ->pluck('status', 'job_id')
                ->toArray();
        }

        return view('pages.jobs', compact('jobs', 'applied_jobs_status'));
    }

    public function events()
    {
        $events = AlumniEvent::orderBy('date', 'asc')->get();
        
        foreach ($events as $event) {
            $event->rsvps = \App\Models\EventRsvp::with('user')
                ->where('event_id', (string) $event->_id)
                ->get();
            $event->my_rsvp = Auth::check()
                ? \App\Models\EventRsvp::where('event_id', (string) $event->_id)->where('user_id', Auth::id())->first()
                : null;
        }
        
        return view('pages.events', compact('events'));
    }

    public function donations() {
        return app(\App\Http\Controllers\DonationController::class)->index();
    }
    public function processDonation(Request $request) {
        return back()->with('success', 'Thank you for your donation!');
    }

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
        
        return back()->with('success', 'Feedback submitted! It has been securely sent to the admin.'); 
    }

    public function resources() 
    {
        $resources = \App\Models\Resource::orderBy('created_at', 'desc')->get();
        return view('pages.resources', compact('resources')); 
    }

    // ── MENTORSHIP MODULE ───────────────────────────────────────────
    public function toggleMentorship(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'is_mentor' => $request->has('is_mentor'),
            'skills'    => $request->filled('skills') ? array_map('trim', explode(',', $request->skills)) : []
        ]);
        return back()->with('success', 'Your mentorship status and skills have been updated successfully!');
    }

    public function requestMentorship(Request $request, $id)
    {
        $mentor = User::findOrFail($id);
        
        $exists = \App\Models\MentorshipSession::where('mentor_id', $id)
            ->where('mentee_id', Auth::id())
            ->whereIn('status', ['pending', 'active'])
            ->first();
            
        if ($exists) {
            return back()->with('error', 'You already have a pending or active mentorship session with this mentor.');
        }

        \App\Models\MentorshipSession::create([
            'mentor_id'  => $id,
            'mentee_id'  => Auth::id(),
            'status'     => 'pending',
            'message'    => $request->message ?? 'I would love to be your mentee!',
            'milestones' => [
                ['title' => 'Initial Connect & Resume Sharing', 'completed' => false],
                ['title' => '1-on-1 Mock Interview Session', 'completed' => false],
                ['title' => 'Career Goal Review & Final Check-in', 'completed' => false]
            ]
        ]);
        return back()->with('success', 'Mentorship request sent successfully!');
    }

    public function acceptMentorship($id)
    {
        $session = \App\Models\MentorshipSession::findOrFail($id);
        if ($session->mentor_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }
        $session->update(['status' => 'active']);
        return back()->with('success', 'Mentorship request accepted successfully! Get ready to connect.');
    }

    public function rejectMentorship($id)
    {
        $session = \App\Models\MentorshipSession::findOrFail($id);
        if ($session->mentor_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }
        $session->update(['status' => 'rejected']);
        return back()->with('success', 'Mentorship request rejected.');
    }

    public function completeMentorship(Request $request, $id)
    {
        $session = \App\Models\MentorshipSession::findOrFail($id);
        
        $session->update([
            'status'   => 'completed',
            'rating'   => (int) ($request->rating ?? 5),
            'feedback' => $request->feedback ?? ''
        ]);
        return back()->with('success', 'Mentorship session marked as completed! Thank you for sharing your experience.');
    }

    // ── RESUME PORTAL ───────────────────────────────────────────────
    public function resumePortal()
    {
        $userId = Auth::id();
        $role   = Auth::user()->role;
        
        if ($role === 'student') {
            $reviews = \App\Models\ResumeReview::with('alumni')
                ->where('student_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
                
            // Fetch connected alumni
            $connections = \App\Models\Connection::where('status', 'accepted')
                ->where(function ($q) use ($userId) {
                    $q->where('requester_id', $userId)
                      ->orWhere('recipient_id', $userId);
                })->get();
                
            $connectedAlumni = $connections->map(function ($conn) use ($userId) {
                $targetId = ($conn->requester_id == $userId) ? $conn->recipient_id : $conn->requester_id;
                return User::find($targetId);
            })->filter(function($u) {
                return $u && $u->role === 'alumni';
            });
            
            return view('pages.resume_portal', compact('reviews', 'connectedAlumni'));
        } else {
            $reviews = \App\Models\ResumeReview::with('student')
                ->where('alumni_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
            return view('pages.resume_portal', compact('reviews'));
        }
    }

    public function requestReview(Request $request)
    {
        $request->validate([
            'alumni_id' => 'required|string',
            'resume'    => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);
        
        if ($request->hasFile('resume')) {
            $file     = $request->file('resume');
            $filename = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            // Store inside public folder so it can be previewed or downloaded
            $path     = $file->storeAs('public/resumes', $filename);
            
            \App\Models\ResumeReview::create([
                'student_id'      => Auth::id(),
                'alumni_id'       => $request->alumni_id,
                'resume_filename' => $file->getClientOriginalName(),
                'resume_url'      => \Storage::url($path),
                'status'          => 'pending',
            ]);
            return back()->with('success', 'Resume review request sent to alumnus successfully!');
        }
        return back()->with('error', 'Please upload a valid document file.');
    }

    public function submitReview(Request $request, $id)
    {
        $review = \App\Models\ResumeReview::findOrFail($id);
        if ($review->alumni_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }
        
        $request->validate([
            'grade'    => 'required|integer|min:1|max:10',
            'feedback' => 'required|string',
        ]);
        
        $review->update([
            'status'   => 'reviewed',
            'grade'    => (int) $request->grade,
            'feedback' => $request->feedback,
        ]);
        return back()->with('success', 'Your review feedback and grade have been submitted successfully!');
    }

    // ── RSVP MODULE ─────────────────────────────────────────────────
    public function rsvpEvent(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:going,interested,not_going',
        ]);
        
        \App\Models\EventRsvp::updateOrCreate(
            [
                'user_id'  => Auth::id(),
                'event_id' => $id,
            ],
            [
                'status'   => $request->status,
            ]
        );
        return back()->with('success', 'Your RSVP for this event has been updated to: ' . ucfirst($request->status));
    }
}
