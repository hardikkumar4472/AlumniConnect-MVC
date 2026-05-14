<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniEvent;
use App\Models\JobOpportunity;
use App\Models\SuccessStory;
use App\Models\Donation;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $alumni_count = User::count();
        $events_count = AlumniEvent::count();
        $jobs_count = JobOpportunity::count();
        $donations_total = Donation::sum('amount');

        return view('landing', compact(
            'alumni_count',
            'events_count',
            'jobs_count',
            'donations_total'
        ));
    }

    public function dashboard()
    {
        $alumni_count = User::count();
        $events_count = AlumniEvent::count();
        $jobs_count = JobOpportunity::count();
        $donations_total = Donation::sum('amount');
        
        $events = AlumniEvent::orderBy('date', 'asc')->take(2)->get();
        $featured_story = SuccessStory::where('is_featured', true)->first();
        $recent_donations = Donation::orderBy('created_at', 'desc')->take(3)->get();
        
        return view('dashboard', compact(
            'alumni_count',
            'events_count',
            'jobs_count',
            'donations_total',
            'events', 
            'featured_story', 
            'recent_donations'
        ));
    }

    public function directory(Request $request)
    {
        $query = User::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $alumni = $query->paginate(12);
        return view('pages.directory', compact('alumni'));
    }

    public function network()
    {
        $mentors = User::take(6)->get();
        return view('pages.network', compact('mentors'));
    }

    public function jobs()
    {
        $jobs = JobOpportunity::orderBy('created_at', 'desc')->get();
        return view('pages.jobs', compact('jobs'));
    }

    public function events()
    {
        $events = AlumniEvent::orderBy('date', 'asc')->get();
        return view('pages.events', compact('events'));
    }

    public function donations()
    {
        $my_donations = Donation::where('user_id', Auth::id())->get();
        return view('pages.donations', compact('my_donations'));
    }

    public function processDonation(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'purpose' => 'required|string',
        ]);

        Donation::create([
            'user_id' => Auth::id(),
            'contributor_name' => Auth::user()->name,
            'amount' => $request->amount,
            'purpose' => $request->purpose,
        ]);

        return back()->with('success', 'Thank you for your contribution!');
    }

    public function stories()
    {
        $stories = SuccessStory::all();
        return view('pages.stories', compact('stories'));
    }

    public function feedback()
    {
        return view('pages.feedback');
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }

    public function resources()
    {
        return view('pages.resources');
    }
}
