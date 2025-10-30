@extends('admin.layouts.app')

@section('title', 'Chat with ' . $chat['vendor_name'])

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Chat: {{ $chat['vendor_name'] }}</h4>
            <a href="{{ route('admin.chats.index', app()->getLocale()) }}" class="btn btn-secondary btn-sm">← Back</a>
        </div>

        <div class="card">
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @foreach ($chat['messages'] as $message)
                    <div class="mb-3 {{ $message['sender'] === 'admin' ? 'text-start' : 'text-end' }}">
                        <div
                            class="d-inline-block p-2 rounded {{ $message['sender'] === 'admin' ? 'bg-primary text-white' : 'bg-light' }}">
                            {{ $message['content'] }}
                        </div>
                        <div class="small text-muted mt-1">
                            {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card-footer bg-light border-0 shadow-sm">
                <form
                    action="{{ route('admin.chats.send.message', ['lang' => app()->getLocale(), 'chat' => $chat['id']]) }}"
                    method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    <div class="flex-grow-1 position-relative">
                        <input type="text" name="message" class="form-control rounded-pill ps-3 pe-5"
                            placeholder="Type your message..." required>
                        <button type="submit"
                            class="btn btn-primary rounded-circle position-absolute end-0 top-50 translate-middle-y px-3 py-2">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
