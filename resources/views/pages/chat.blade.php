@extends('layouts.app')

@section('content')
<div class="page-header" style="display: flex; align-items: center; gap: 15px; margin-bottom: 0;">
    <a href="{{ route('network') }}" style="color: #4a5568; text-decoration: none; font-size: 1.2rem;"><i class="fa-solid fa-arrow-left"></i></a>
    <img src="https://ui-avatars.com/api/?name={{ urlencode($targetUser->name) }}&background=random" style="width: 50px; height: 50px; border-radius: 50%;">
    <div>
        <h2 style="margin: 0; font-size: 1.5rem;">{{ $targetUser->name }}</h2>
        <p style="margin: 0; font-size: 0.85rem; color: #718096;">{{ ucfirst($targetUser->role) }}</p>
    </div>
</div>

<div class="card" style="margin-top: 1rem; padding: 0; display: flex; flex-direction: column; height: 60vh; border: 1px solid #e2e8f0; overflow: hidden; background: #f8fafc;">
    
    <!-- Messages Area -->
    <div id="chat-box" style="flex: 1; padding: 1.5rem; overflow-y: auto; display: flex; flex-direction: column; gap: 10px;">
        <!-- Messages will be loaded here via AJAX -->
        <div style="text-align: center; color: #a0aec0; font-size: 0.85rem; padding: 2rem;">Loading messages...</div>
    </div>

    <!-- Input Area -->
    <div style="padding: 1rem; background: white; border-top: 1px solid #e2e8f0;">
        <form id="chat-form" style="display: flex; gap: 10px;">
            <input type="text" id="message-input" placeholder="Type a message..." required style="flex: 1; padding: 0.8rem 1rem; border-radius: 20px; border: 1px solid #cbd5e0; outline: none; font-family: 'Outfit', sans-serif;">
            <button type="submit" style="background: var(--primary); color: white; border: none; width: 45px; height: 45px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: background 0.2s;">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<script>
    const targetUserId = '{{ $targetUser->_id }}';
    const currentUserId = '{{ Auth::user()->_id }}';
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    
    let lastMessageCount = 0;

    // Fetch messages
    async function fetchMessages() {
        try {
            const response = await fetch(`/network/chat/${targetUserId}/messages`);
            const messages = await response.json();
            
            if (messages.length !== lastMessageCount) {
                renderMessages(messages);
                lastMessageCount = messages.length;
                scrollToBottom();
            }
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    }

    // Render messages
    function renderMessages(messages) {
        if (messages.length === 0) {
            chatBox.innerHTML = '<div style="text-align: center; color: #a0aec0; font-size: 0.85rem; padding: 2rem;">No messages yet. Start the conversation!</div>';
            return;
        }

        chatBox.innerHTML = '';
        messages.forEach(msg => {
            const isMe = msg.sender_id === currentUserId;
            
            const msgDiv = document.createElement('div');
            msgDiv.style.maxWidth = '70%';
            msgDiv.style.padding = '0.8rem 1rem';
            msgDiv.style.borderRadius = '15px';
            msgDiv.style.fontSize = '0.95rem';
            msgDiv.style.lineHeight = '1.4';
            msgDiv.style.wordBreak = 'break-word';

            if (isMe) {
                msgDiv.style.alignSelf = 'flex-end';
                msgDiv.style.background = 'var(--primary)';
                msgDiv.style.color = 'white';
                msgDiv.style.borderBottomRightRadius = '2px';
            } else {
                msgDiv.style.alignSelf = 'flex-start';
                msgDiv.style.background = 'white';
                msgDiv.style.color = '#2d3748';
                msgDiv.style.border = '1px solid #e2e8f0';
                msgDiv.style.borderBottomLeftRadius = '2px';
            }

            msgDiv.textContent = msg.content;
            chatBox.appendChild(msgDiv);
        });
    }

    // Scroll to bottom
    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Send message
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const content = messageInput.value.trim();
        if (!content) return;

        // Optimistic UI update
        messageInput.value = '';
        
        try {
            await fetch(`/network/chat/${targetUserId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content })
            });
            fetchMessages(); // immediately fetch to update
        } catch (error) {
            console.error('Error sending message:', error);
        }
    });

    // Initial fetch and poll
    fetchMessages();
    setInterval(fetchMessages, 3000); // Poll every 3 seconds
</script>
@endsection
