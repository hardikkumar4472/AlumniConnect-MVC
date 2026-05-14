<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniEvent;
use App\Models\JobOpportunity;
use App\Models\SuccessStory;
use App\Models\Donation;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_alumni' => User::where('role', 'alumni')->count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_donations' => Donation::sum('amount'),
            'active_jobs' => JobOpportunity::count(),
            'active_events' => AlumniEvent::count(),
            'pending_feedback' => Feedback::count(),
        ];

        $recent_users = User::orderBy('created_at', 'desc')->take(5)->get();
        $recent_donations = Donation::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_donations'));
    }

    // User Management
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User deleted successfully.');
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::find($id);
        $user->role = $request->role;
        $user->save();
        return back()->with('success', 'User role updated.');
    }

    // Job Management
    public function jobs()
    {
        $jobs = JobOpportunity::orderBy('created_at', 'desc')->get();
        return view('admin.jobs', compact('jobs'));
    }

    public function storeJob(Request $request)
    {
        JobOpportunity::create($request->all());
        return back()->with('success', 'Job posted successfully.');
    }

    public function deleteJob($id)
    {
        JobOpportunity::destroy($id);
        return back()->with('success', 'Job deleted.');
    }

    // Event Management
    public function events()
    {
        $events = AlumniEvent::orderBy('date', 'asc')->get();
        return view('admin.events', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        AlumniEvent::create($request->all());
        return back()->with('success', 'Event created successfully.');
    }

    public function deleteEvent($id)
    {
        AlumniEvent::destroy($id);
        return back()->with('success', 'Event deleted.');
    }

    // Story Management
    public function stories()
    {
        $stories = SuccessStory::all();
        return view('admin.stories', compact('stories'));
    }

    public function storeStory(Request $request)
    {
        SuccessStory::create($request->all());
        return back()->with('success', 'Story added successfully.');
    }

    public function deleteStory($id)
    {
        SuccessStory::destroy($id);
        return back()->with('success', 'Story deleted.');
    }

    // Feedback Management
    public function feedback()
    {
        $feedback = Feedback::orderBy('created_at', 'desc')->get();
        return view('admin.feedback', compact('feedback'));
    }
}
