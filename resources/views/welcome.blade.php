@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome to the Chat Application</h1>
    </div>
@endsection

@section('scripts')
    <script>
        const recipientId = @json(auth()->user()->id ?? null);
        if (recipientId) {
            window.Echo.private(`user.${recipientId}`)
                .listen('message', (event) => {
                    console.log(`Private message from ${event.message.sender_id}: ${event.message.content}`);
                });

            window.Echo.channel('public-chat')
                .listen('message', (event) => {
                    console.log(`Public message: ${event.message.content}`);
                });
        } else {
            console.log('User is not authenticated, chat functionality is disabled.');
        }
    </script>
@endsection
