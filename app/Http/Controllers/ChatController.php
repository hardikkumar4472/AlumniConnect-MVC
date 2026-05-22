<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Connection;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat($id)
    {
        $user = Auth::user();
        $targetUser = User::findOrFail($id);

        // Verify they are connected
        $isConnected = Connection::where(function($q) use ($user, $targetUser) {
            $q->where('requester_id', $user->_id)->where('recipient_id', $targetUser->_id);
        })->orWhere(function($q) use ($user, $targetUser) {
            $q->where('requester_id', $targetUser->_id)->where('recipient_id', $user->_id);
        })->where('status', 'accepted')->exists();

        if (!$isConnected) {
            return redirect()->route('network')->with('error', 'You can only message connected alumni/students.');
        }

        return view('pages.chat', compact('targetUser'));
    }

    public function fetchMessages($id)
    {
        $userId = Auth::user()->_id;
        $targetId = $id;

        $messages = Message::where(function($q) use ($userId, $targetId) {
            $q->where('sender_id', $userId)->where('receiver_id', $targetId);
        })->orWhere(function($q) use ($userId, $targetId) {
            $q->where('sender_id', $targetId)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // Mark unread messages as read
        Message::where('sender_id', $targetId)
               ->where('receiver_id', $userId)
               ->where('is_read', false)
               ->update(['is_read' => true]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => Auth::user()->_id,
            'receiver_id' => $id,
            'content' => $request->content,
            'is_read' => false,
        ]);

        return response()->json($message);
    }
}
