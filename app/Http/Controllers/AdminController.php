<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniEvent;
use App\Models\JobOpportunity;
use App\Models\SuccessStory;
use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'     => User::count(),
            'total_alumni'    => User::where('role', 'alumni')->count(),
            'total_students'  => User::where('role', 'student')->count(),
            'total_donations' => Donation::where('status', 'success')->sum('amount'),
            'active_jobs'     => JobOpportunity::count(),
            'active_events'   => AlumniEvent::count(),
            'pending_feedback'=> Feedback::count(),
        ];

        $recent_users     = User::orderBy('created_at', 'desc')->take(5)->get();
        $recent_donations = Donation::where('status', 'success')
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_donations'));
    }

    // Donation Management
    public function donations(Request $request)
    {
        $query = Donation::where('status', 'success')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('user_name', 'like', '%' . $s . '%')
                  ->orWhere('purpose', 'like', '%' . $s . '%')
                  ->orWhere('payment_id', 'like', '%' . $s . '%');
            });
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        $donations     = $query->paginate(15);
        $total_raised  = Donation::where('status', 'success')->sum('amount');
        $donor_count   = Donation::where('status', 'success')->distinct('user_id')->count('user_id');
        $this_month    = Donation::where('status', 'success')
                            ->where('created_at', '>=', now()->startOfMonth())
                            ->sum('amount');
        $campaigns     = DonationCampaign::orderBy('created_at', 'desc')->get();

        // Top donors
        $top_donors = Donation::where('status', 'success')
                        ->get()
                        ->groupBy('user_id')
                        ->map(fn($group) => [
                            'user_name' => $group->first()->user_name,
                            'user_id'   => $group->first()->user_id,
                            'total'     => $group->sum('amount'),
                            'count'     => $group->count(),
                        ])
                        ->sortByDesc('total')
                        ->take(10)
                        ->values();

        return view('admin.donations', compact(
            'donations', 'total_raised', 'donor_count', 'this_month', 'campaigns', 'top_donors'
        ));
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
        
        foreach ($events as $event) {
            $event->rsvps = \App\Models\EventRsvp::with('user')
                ->where('event_id', (string) $event->_id)
                ->get();
            $event->rsvps_count = $event->rsvps->count();
        }
        
        return view('admin.events', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        AlumniEvent::create($request->all());
        return back()->with('success', 'Event created successfully.');
    }

    public function updateEvent(Request $request, $id)
    {
        $event = AlumniEvent::findOrFail($id);
        $event->update($request->all());
        return back()->with('success', 'Event updated successfully.');
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

    public function updateStory(Request $request, $id)
    {
        $story = SuccessStory::findOrFail($id);
        $story->update($request->all());
        return back()->with('success', 'Story updated successfully.');
    }

    public function deleteStory($id)
    {
        SuccessStory::destroy($id);
        return back()->with('success', 'Story deleted.');
    }

    // Feedback Management
    // Campus News Management
    public function news()
    {
        $news = \App\Models\CampusNews::orderBy('created_at', 'desc')->get();
        return view('admin.news', compact('news'));
    }

    public function storeNews(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|string',
        ]);

        \App\Models\CampusNews::create($request->all());
        return back()->with('success', 'Campus News added successfully!');
    }

    public function updateNews(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|string',
        ]);

        $newsItem = \App\Models\CampusNews::findOrFail($id);
        $newsItem->update($request->all());
        return back()->with('success', 'Campus News updated successfully!');
    }

    public function deleteNews($id)
    {
        $newsItem = \App\Models\CampusNews::findOrFail($id);
        $newsItem->delete();
        return back()->with('success', 'Campus News deleted successfully!');
    }

    public function feedback()
    {
        $feedback = \App\Models\Feedback::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.feedback', compact('feedback'));
    }

    // Resource Management
    public function resources()
    {
        $resources = \App\Models\Resource::orderBy('created_at', 'desc')->get();
        return view('admin.resources', compact('resources'));
    }

    public function storeResource(Request $request)
    {
        \App\Models\Resource::create($request->all());
        return back()->with('success', 'Resource added successfully.');
    }

    public function updateResource(Request $request, $id)
    {
        $resource = \App\Models\Resource::findOrFail($id);
        $resource->update($request->all());
        return back()->with('success', 'Resource updated successfully.');
    }

    public function deleteResource($id)
    {
        \App\Models\Resource::destroy($id);
        return back()->with('success', 'Resource deleted.');
    }
}
