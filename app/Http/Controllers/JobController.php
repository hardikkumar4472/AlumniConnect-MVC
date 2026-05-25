<?php

namespace App\Http\Controllers;

use App\Models\JobOpportunity;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'alumni' && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Only alumni can post jobs.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
        ]);

        JobOpportunity::create([
            'title' => $request->title,
            'company' => $request->company,
            'description' => $request->description,
            'type' => $request->type,
            'link' => '#', // Internal
            'posted_by' => Auth::id(),
        ]);

        return back()->with('success', 'Job posted successfully!');
    }

    public function apply(Request $request, $id)
    {
        if (Auth::user()->role !== 'student') {
            return back()->with('error', 'Only students can apply for jobs.');
        }

        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        $job = JobOpportunity::findOrFail($id);

        $existing = JobApplication::where('job_id', $job->_id)
            ->where('applicant_id', Auth::id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already applied for this job.');
        }

        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $filename = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('resumes', $filename);

            JobApplication::create([
                'job_id' => $job->_id,
                'applicant_id' => Auth::id(),
                'resume_path' => $path,
                'status' => 'pending'
            ]);

            return back()->with('success', 'Application submitted successfully!');
        }

        return back()->with('error', 'Failed to upload resume.');
    }

    public function viewApplications($id)
    {
        $job = JobOpportunity::findOrFail($id);

        if ($job->posted_by !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('jobs')->with('error', 'Unauthorized access.');
        }

        $applications = JobApplication::with('applicant')->where('job_id', $job->_id)->get();

        return view('pages.job_applications', compact('job', 'applications'));
    }

    public function downloadResume($id)
    {
        $application = JobApplication::findOrFail($id);
        $job = JobOpportunity::findOrFail($application->job_id);

        if ($job->posted_by !== Auth::id() && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized to view this resume.');
        }

        $path = storage_path('app/' . $application->resume_path);

        if (!file_exists($path)) {
            return back()->with('error', 'Resume file not found.');
        }

        return response()->download($path);
    }

    public function updateStatus(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);
        $job         = JobOpportunity::findOrFail($application->job_id);

        if ($job->posted_by !== Auth::id() && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'status' => 'required|string|in:applied,shortlisted,interviewing,offered,rejected',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Candidate application status successfully updated to: ' . ucfirst($request->status));
    }
}
