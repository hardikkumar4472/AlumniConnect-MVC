<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Connection;
use App\Models\Message;
use App\Models\AlumniEvent;
use App\Models\Donation;
use App\Models\CampusNews;
use App\Models\JobOpportunity;

class NotificationController extends Controller
{
    public function index()
    {
        $user        = Auth::user();
        $userId      = (string) $user->_id;
        $role        = $user->role;
        $notifications = collect();

        // ── 1. Pending connection requests (incoming) ──────────────
        $pendingConnections = Connection::with('requester')
            ->where('recipient_id', $userId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        foreach ($pendingConnections as $conn) {
            $requester = $conn->requester;
            $notifications->push([
                'id'      => (string) $conn->_id,
                'type'    => 'connection_request',
                'icon'    => 'fa-user-plus',
                'color'   => '#3b82f6',
                'bg'      => '#eff6ff',
                'title'   => ($requester->name ?? 'Someone') . ' sent you a connection request',
                'body'    => 'Batch of ' . ($requester->graduation_year ?? 'N/A') . ' · ' . ($requester->department ?? 'Engineering'),
                'link'    => route('network'),
                'time'    => $conn->created_at,
                'read'    => false,
            ]);
        }

        // ── 2. Unread messages ─────────────────────────────────────
        $unreadMessages = Message::with('sender')
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        foreach ($unreadMessages as $msg) {
            $sender = $msg->sender;
            $notifications->push([
                'id'    => (string) $msg->_id,
                'type'  => 'message',
                'icon'  => 'fa-envelope',
                'color' => '#8b5cf6',
                'bg'    => '#fdf4ff',
                'title' => 'New message from ' . ($sender->name ?? 'Someone'),
                'body'  => \Str::limit($msg->body ?? $msg->content ?? '(No content)', 60),
                'link'  => route('chat', $msg->sender_id ?? ($sender->_id ?? '#')),
                'time'  => $msg->created_at,
                'read'  => false,
            ]);
        }

        // ── 3. Recently added events (last 7 days) ─────────────────
        $newEvents = AlumniEvent::where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($newEvents as $event) {
            $notifications->push([
                'id'    => (string) $event->_id,
                'type'  => 'event',
                'icon'  => 'fa-calendar-days',
                'color' => '#0047ab',
                'bg'    => '#eff6ff',
                'title' => 'New event: ' . $event->title,
                'body'  => ($event->month ?? '') . ' ' . ($event->date ?? '') . ' · ' . ($event->location ?? ''),
                'link'  => route('events'),
                'time'  => $event->created_at,
                'read'  => false,
            ]);
        }

        // ── 4. Recent successful donations (your own) ──────────────
        $myDonations = Donation::where('user_id', $userId)
            ->where('status', 'success')
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($myDonations as $d) {
            $notifications->push([
                'id'    => (string) $d->_id,
                'type'  => 'donation',
                'icon'  => 'fa-heart',
                'color' => '#f43f5e',
                'bg'    => '#fff1f2',
                'title' => 'Donation confirmed: ₹' . number_format($d->amount),
                'body'  => $d->purpose . ' · Payment ID: ' . \Str::limit($d->payment_id ?? 'N/A', 20),
                'link'  => route('donations'),
                'time'  => $d->created_at,
                'read'  => false,
            ]);
        }

        // ── 5. Campus news (students only, last 7 days) ────────────
        if ($role === 'student') {
            $news = CampusNews::where('created_at', '>=', now()->subDays(7))
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();

            foreach ($news as $n) {
                $notifications->push([
                    'id'    => (string) $n->_id,
                    'type'  => 'news',
                    'icon'  => 'fa-newspaper',
                    'color' => '#f59e0b',
                    'bg'    => '#fffbeb',
                    'title' => 'Campus News: ' . $n->title,
                    'body'  => \Str::limit($n->content ?? '', 70),
                    'link'  => route('dashboard'),
                    'time'  => $n->created_at,
                    'read'  => false,
                ]);
            }
        }

        // ── 6. New job postings (last 3 days) ──────────────────────
        $newJobs = JobOpportunity::where('created_at', '>=', now()->subDays(3))
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($newJobs as $job) {
            $notifications->push([
                'id'    => (string) $job->_id,
                'type'  => 'job',
                'icon'  => 'fa-briefcase',
                'color' => '#f97316',
                'bg'    => '#fff7ed',
                'title' => 'New Job: ' . $job->title,
                'body'  => ($job->company ?? 'Company') . ' · ' . ($job->location ?? ''),
                'link'  => route('jobs'),
                'time'  => $job->created_at,
                'read'  => false,
            ]);
        }

        // ── 7. Mentorship Notifications ─────────────────────────────
        if ($role === 'alumni') {
            $pendingMentors = \App\Models\MentorshipSession::with('mentee')
                ->where('mentor_id', $userId)
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();
            foreach ($pendingMentors as $m) {
                $notifications->push([
                    'id'    => (string) $m->_id,
                    'type'  => 'mentorship',
                    'icon'  => 'fa-graduation-cap',
                    'color' => '#10b981',
                    'bg'    => '#ecfdf5',
                    'title' => 'Mentorship request received',
                    'body'  => ($m->mentee->name ?? 'Student') . ' has requested you as a mentor.',
                    'link'  => route('network'),
                    'time'  => $m->created_at,
                    'read'  => false,
                ]);
            }
        } else {
            $activeMentors = \App\Models\MentorshipSession::with('mentor')
                ->where('mentee_id', $userId)
                ->whereIn('status', ['active', 'completed', 'rejected'])
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get();
            foreach ($activeMentors as $m) {
                $notifications->push([
                    'id'    => (string) $m->_id,
                    'type'  => 'mentorship',
                    'icon'  => 'fa-graduation-cap',
                    'color' => '#10b981',
                    'bg'    => '#ecfdf5',
                    'title' => 'Mentorship status: ' . ucfirst($m->status),
                    'body'  => 'Your mentor ' . ($m->mentor->name ?? 'Alumni') . ' updated the status.',
                    'link'  => route('network'),
                    'time'  => $m->updated_at ?? $m->created_at,
                    'read'  => false,
                ]);
            }
        }

        // ── 8. Resume Review Notifications ──────────────────────────
        if ($role === 'student') {
            $reviewedResumes = \App\Models\ResumeReview::with('alumni')
                ->where('student_id', $userId)
                ->where('status', 'reviewed')
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get();
            foreach ($reviewedResumes as $r) {
                $notifications->push([
                    'id'    => (string) $r->_id,
                    'type'  => 'resume_review',
                    'icon'  => 'fa-file-invoice',
                    'color' => '#ec4899',
                    'bg'    => '#fdf2f8',
                    'title' => 'Resume reviewed: Grade ' . $r->grade . '/10',
                    'body'  => 'Reviewed by ' . ($r->alumni->name ?? 'Alumni') . ': "' . \Str::limit($r->feedback ?? '', 40) . '"',
                    'link'  => route('resumes.portal'),
                    'time'  => $r->updated_at,
                    'read'  => false,
                ]);
            }
        } else {
            $pendingReviews = \App\Models\ResumeReview::with('student')
                ->where('alumni_id', $userId)
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            foreach ($pendingReviews as $r) {
                $notifications->push([
                    'id'    => (string) $r->_id,
                    'type'  => 'resume_review',
                    'icon'  => 'fa-file-signature',
                    'color' => '#ec4899',
                    'bg'    => '#fdf2f8',
                    'title' => 'Resume review request',
                    'body'  => 'A review request has been sent by ' . ($r->student->name ?? 'Student'),
                    'link'  => route('resumes.portal'),
                    'time'  => $r->created_at,
                    'read'  => false,
                ]);
            }
        }

        // ── 9. Job Application Status Changes ───────────────────────
        if ($role === 'student') {
            $myApplications = \App\Models\JobApplication::where('applicant_id', $userId)
                ->where('status', '!=', 'pending')
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get();
            foreach ($myApplications as $appl) {
                $job = \App\Models\JobOpportunity::find($appl->job_id);
                if ($job) {
                    $notifications->push([
                        'id'    => (string) $appl->_id,
                        'type'  => 'job_application',
                        'icon'  => 'fa-user-tie',
                        'color' => '#06b6d4',
                        'bg'    => '#ecfeff',
                        'title' => 'Job Application: ' . ucfirst($appl->status),
                        'body'  => 'Status updated for ' . $job->title . ' at ' . $job->company,
                        'link'  => route('jobs'),
                        'time'  => $appl->updated_at,
                        'read'  => false,
                    ]);
                }
            }
        }

        // Sort all by newest first
        $sorted = $notifications
            ->sortByDesc('time')
            ->take(15)
            ->values();

        // Format times for JSON
        $formatted = $sorted->map(function ($n) {
            $n['time_human'] = $n['time'] ? $n['time']->diffForHumans() : '';
            $n['time']       = $n['time'] ? $n['time']->toISOString() : null;
            return $n;
        });

        return response()->json([
            'notifications' => $formatted,
            'total'         => $formatted->count(),
            'unread'        => $formatted->where('read', false)->count(),
        ]);
    }

    /**
     * Mark all notifications as read (clears unread messages for now).
     */
    public function markAllRead()
    {
        $userId = (string) Auth::id();

        // Mark messages as read
        Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
