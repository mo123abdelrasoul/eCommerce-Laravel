@php
    // Static customer chat UI (presentation-only)
    $customerId = auth()->guard('web')->id();
@endphp
<!-- Styles moved to resources/front/css/main.css -->
<div id="customer-chat-widget">
    <!-- CSS-only toggle using a hidden checkbox -->
    <input type="checkbox" id="customer-chat-checkbox" />

    <label for="customer-chat-checkbox" id="customer-chat-toggle" class="btn btn-primary position-relative rounded-circle">
        <i class="bi bi-chat-dots fs-4"></i>
        {{-- <span id="customer-chat-badge"
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            0
        </span> --}}
    </label>

    <div id="customer-chat-window" class="customer-chat-window card shadow">
        <div class="card-header bg-primary text-white position-relative">
            <span>Chat with Admin</span>
            <label for="customer-chat-checkbox" id="customer-chat-close"
                class="btn btn-sm btn-light position-absolute top-50 translate-middle-y">&times;</label>
        </div>

        <div class="card-body overflow-y-auto" id="customer-chat-messages">
            <div class="mb-3 text-start chat">
                @if ($customerId == null)
                    <div class="alert alert-info">
                        Please
                        <a href="{{ route('user.login', ['lang' => app()->getLocale()]) }}" class="alert-link">
                            log in
                        </a>
                        to use the chat feature.
                    </div>
                @endif
                <!-- Static example messages (presentation only) -->
            </div>
        </div>
        <div class="card-footer">
            <form id="customer-chat-form" onsubmit="return false;">
                <div class="input-group">
                    <input type="text" id="customer-chat-input" class="form-control" placeholder="Type a message..."
                        required>
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const fetchMessagesUrlFromCustomer =
        "{{ route('customer.chats.load.messages', ['lang' => app()->getLocale()]) }}";
    const customerSendMessageUrl = "{{ route('customer.chat.send.message', ['lang' => app()->getLocale()]) }}";
    let customerId = {{ $customerId ?? 'null' }};
</script>
