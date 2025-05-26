@extends('userdashboard.index')

@section('content')



<div class="main-content">
    <h3 id="chat-header">Select a user to start chatting</h3>

    {{-- Chat Box --}}
    <div id="chat-box" style="border:1px solid #ccc; padding: 15px; height: 300px; overflow-y: scroll; background: #f9f9f9;"></div>

    {{-- Message Sending Form --}}
    <form id="messageForm" action="{{ route('messages.send') }}" method="POST" class="mt-4" style="display: none;">
        @csrf
        <input type="hidden" name="receiver_id" id="receiver_id">
        <textarea name="message" id="message_input" class="form-control" rows="3" placeholder="Type your message..." required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Send</button>
    </form>

    {{-- Conversations List --}}


    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
   
<div class="mt-4" style="border-top: 1px solid #ccc; padding-top: 10px;">
    <h5>Messages</h5>
    <ul class="list-group">
        @foreach($conversations as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center chat-user" 
                data-user-id="{{ $user->id }}" 
                data-user-name="{{ $user->name }}">
                
                <span>{{ $user->name }}</span>

                @php
                    // Simply use the full class path without "use"
                    $loggedInUserHasActiveOrder = \App\Models\CurrencyOrder::where('user_id', Auth::id())
                        ->where('status', 'active')
                        ->exists();
                @endphp

                @if($loggedInUserHasActiveOrder)
                    <div class="btn-group">
                        <form action="{{ route('pair.user') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-sm btn-success">
                                Pair
                            </button>
                        </form>

                        <form action="{{ route('display') }}" method="get">
                            @csrf
                            <!-- <input type="hidden" name="user_id" value="{{ $user->id }}"> -->
                            <button type="submit" class="btn btn-sm btn-success">
                                Pay
                            </button>
                        </form>
                    </div>
                @endif

            </li>
        @endforeach
    </ul>
</div>


{{-- JavaScript --}}
<script>
    let currentReceiverId = null;

    const chatBox = document.getElementById('chat-box');
    const messageForm = document.getElementById('messageForm');
    const receiverInput = document.getElementById('receiver_id');
    const messageInput = document.getElementById('message_input');
    const chatHeader = document.getElementById('chat-header');

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function loadMessages(receiverId, receiverName) {
        currentReceiverId = receiverId;
        fetch(`/messages/get/${receiverId}`)
            .then(res => res.json())
            .then(messages => {
                chatBox.innerHTML = '';
                messages.forEach(msg => {
                    const isMine = msg.sender_id == {{ Auth::id() }};
                    const div = document.createElement('div');
                    div.style.textAlign = isMine ? 'right' : 'left';
                    div.style.marginBottom = '10px';
                    div.innerHTML = `
                        <strong>${isMine ? 'You' : receiverName}:</strong> ${msg.message}<br>
                        <small style="color:#888;">${new Date(msg.created_at).toLocaleString()}</small>
                    `;
                    chatBox.appendChild(div);
                });
                scrollToBottom();
                chatHeader.textContent = `Chat with ${receiverName}`;
                receiverInput.value = receiverId;
                messageForm.style.display = 'block';
            });
    }

    // Handle chat user click
    document.querySelectorAll('.chat-user').forEach(item => {
        item.addEventListener('click', function () {
            document.querySelectorAll('.chat-user').forEach(u => u.classList.remove('active'));
            this.classList.add('active');
            this.classList.remove('blinking');

            const receiverId = this.getAttribute('data-user-id');
            const receiverName = this.getAttribute('data-user-name');
            loadMessages(receiverId, receiverName);
        });
    });

    // Submit message
    messageForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData
        }).then(() => {
            messageInput.value = '';
            loadMessages(currentReceiverId, document.querySelector(`.chat-user[data-user-id="${currentReceiverId}"]`).getAttribute('data-user-name'));
        });
    });

   


    // Auto-refresh messages + blinking
    setInterval(() => {
        if (currentReceiverId) {
            const selected = document.querySelector(`.chat-user[data-user-id="${currentReceiverId}"]`);
            const receiverName = selected?.getAttribute('data-user-name') ?? 'Them';
            loadMessages(currentReceiverId, receiverName);
        }
        checkForNewMessages();
    }, 5000);

   

    scrollToBottom();
</script>
@endsection
