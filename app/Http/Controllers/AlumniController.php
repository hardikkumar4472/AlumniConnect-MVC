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

        return view('dashboard', compact('alumni_count', 'events', 'featured_story', 'recent_donations'));
    }

    public function directory(Request $request)
    {
        $query = User::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('department', 'like', '%' . $request->search . '%')
                  ->orWhere('graduation_year', 'like', '%' . $request->search . '%');
        }
        $alumni = $query->paginate(12);
        return view('pages.directory', compact('alumni'));
    }

    public function network() { return view('pages.network'); }

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

    public function donations() { return view('pages.donations'); }
    public function processDonation(Request $request) { return back()->with('success', 'Thank you for your donation!'); }

    public function stories()
    {
        $stories = SuccessStory::all();
        return view('pages.stories', compact('stories'));
    }

    public function feedback() { return view('pages.feedback'); }
    public function submitFeedback(Request $request) { return back()->with('success', 'Feedback submitted!'); }

    public function resources() { return view('pages.resources'); }
}
