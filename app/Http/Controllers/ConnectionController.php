<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function sendRequest($id)
    {
        if (Auth::id() == $id) {
            return back()->with('error', 'You cannot connect with yourself.');
        }

        // Check if a connection already exists
        $existing = Connection::where(function ($q) use ($id) {
            $q->where('requester_id', Auth::id())->where('recipient_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('requester_id', $id)->where('recipient_id', Auth::id());
        })->first();

        if ($existing) {
            return back()->with('error', 'Connection request already exists or is established.');
        }

        Connection::create([
            'requester_id' => Auth::id(),
            'recipient_id' => $id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Connection request sent!');
    }

    public function acceptRequest($id)
    {
        $connection = Connection::findOrFail($id);

        if ($connection->recipient_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $connection->update(['status' => 'accepted']);

        return back()->with('success', 'Connection request accepted!');
    }

    public function rejectRequest($id)
    {
        $connection = Connection::findOrFail($id);

        if ($connection->recipient_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $connection->delete();

        return back()->with('success', 'Connection request rejected.');
    }
}
