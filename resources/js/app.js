import './bootstrap';
let guardName = document.getElementById('guard_name');
if(guardName){
    guardName.addEventListener('change', function() {
        let selectedGuard = this.value;
        document.querySelectorAll('.permissions-group').forEach(g => g.style.display = 'none');
        if(selectedGuard) {
            document.getElementById('permissions_section').style.display = 'block';
            let target = document.querySelector(`.permissions-group[data-guard="${selectedGuard}"]`);
            if(target) target.style.display = 'block';
        } else {
            document.getElementById('permissions_section').style.display = 'none';
        }
    });
}

// Js for Edit Role Page In Admin Dashboard
const editGuardName = document.getElementById('edit_guard_name');
if(editGuardName) {
    editGuardName.addEventListener('change', function () {
        let guard = this.value;

        let url = getPermissionsUrl.replace(':guard', guard);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                let wrapper = document.getElementById('edit-permissions-wrapper');
                wrapper.innerHTML = '';

                data.forEach(permission => {
                    let checked = rolePermissions.includes(permission.id) ? 'checked' : '';

                    wrapper.innerHTML += `
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="permissions[]" value="${permission.id}" id="edit_perm_${permission.id}" ${checked}>
                                <label class="form-check-label" for="edit_perm_${permission.id}">${permission.name}</label>
                            </div>
                        </div>
                    `;
                });
            });
    });
}



// Chat Vendor
document.addEventListener('DOMContentLoaded', function() {
    if(document.querySelector('aside.app-sidebar.vendor')){
        const toggleBtn = document.getElementById('chat-toggle');
        const chatWindow = document.getElementById('chat-window');
        const closeBtn = document.getElementById('chat-close');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');

        window.Echo.private('chat.vendor.' + vendorId)
            .listen('MessageSent', (e) => {
                appendMessageFromAdmin('admin', e.message);
            });

        toggleBtn.addEventListener('click', () => {
            chatWindow.style.display = chatWindow.style.display === 'none' ? 'flex' : 'none';
            toggleBtn.style.display = toggleBtn.style.display === 'none' ? 'flex' : 'none';
            scrollChatToBottom();
            loadChatData(fetchMessagesUrl);
        });

        closeBtn.addEventListener('click', () => {
            chatWindow.style.display = 'none';
            toggleBtn.style.display = toggleBtn.style.display === 'none' ? 'block' : 'none';
        });

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = chatInput.value.trim();
            sendMessage(message);
        });

        function sendMessage(message) {
            if(message === '') return;
            fetch(vendorSendMessageUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: message })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success'){
                    appendMessage('vendor', data.message.content, data.message.created_at);
                    chatInput.value = '';
                } else {
                    console.error('Error sending message:', data.error);
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
            });
        }

        function scrollChatToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function appendMessage(sender, content, time = null) {
            const msgDiv = document.createElement('div');
            msgDiv.className = `mb-3 ${sender === 'vendor' ? 'text-start' : 'text-end'}`;
            msgDiv.innerHTML = `
                <div class="d-inline-block p-2 rounded ${sender === 'vendor' ? 'bg-primary text-white' : 'bg-light'}">
                    ${content}
                </div>
                <div class="small text-muted mt-1">
                    ${time ? time : ''}
                </div>
            `;
            chatMessages.appendChild(msgDiv);
            scrollChatToBottom();
        }

        function appendMessageFromAdmin(sender, messageObj, time = null) {
            const msgDiv = document.createElement('div');
            const content = typeof messageObj === 'string' ? messageObj : messageObj.message;
            let displayTime = time;
            if (!displayTime && messageObj && messageObj.created_at) {
                displayTime = new Date(messageObj.created_at).toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
            }
            msgDiv.className = `mb-3 ${sender === 'vendor' ? 'text-start' : 'text-end'}`;
            msgDiv.innerHTML = `
                <div class="d-inline-block p-2 rounded ${sender === 'vendor' ? 'bg-primary text-white' : 'bg-light'}">
                    ${content}
                </div>
                <div class="small text-muted mt-1">
                    ${displayTime || ''}
                </div>
            `;
            chatMessages.appendChild(msgDiv);
            scrollChatToBottom();
        }

        function loadChatData(fetchMessagesUrl) {
            fetch(fetchMessagesUrl)
                .then(res => res.json())
                .then(messages => {
                    const chatMessages = document.getElementById('chat-messages');
                    chatMessages.innerHTML = '';
                    messages.forEach(message => {
                        const div = document.createElement('div');
                        div.className = `mb-3 ${message.sender === 'vendor' ? 'text-start' : 'text-end'}`;
                        div.innerHTML = `
                            <div class="d-inline-block p-2 rounded ${message.sender === 'vendor' ? 'bg-primary text-white' : 'bg-light'}">
                                ${message.content}
                            </div>
                            <div class="small text-muted mt-1">
                                ${message.created_at}
                            </div>
                        `;
                        chatMessages.appendChild(div);
                    });
                    scrollChatToBottom();
                });
        }
    }
});


// Chat Admin
document.addEventListener("DOMContentLoaded", function() {
    if (!document.querySelector('aside.app-sidebar.admin')) return;
        const chatBody = document.querySelector('.card-body');
        if (chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }
        let chatMessages = document.getElementById('chat-messages');
        let messageForm = document.getElementById('admin-send-message');
        let messageFormToCustomer = document.getElementById('admin-send-message-to-customer');
        let messageInput = document.getElementById('message-input');

        if(!messageFormToCustomer) {
            if (typeof senderId !== 'undefined') {
                window.Echo.private('chat.admin.' + senderId)
                    .listen('MessageSent', (e) => {
                        appendMessageFromVendor('vendor', e.message);
                    });
            }
        }else {
            if (typeof senderId !== 'undefined') {
                window.Echo.private('chat.admin.' + senderId)
                    .listen('MessageSentWithPusher', (e) => {
                        appendMessageFromCustomer('customer', e.message);
                    });
            }
        }

        // form admin to vendor
        if (messageForm && messageInput) {
            messageForm.addEventListener('submit', function (e) {
                e.preventDefault();
                sendMessage(messageInput.value);
            });
        }

        // form admin to customer
        if (messageFormToCustomer && messageInput) {
            messageFormToCustomer.addEventListener('submit', function (e) {
                e.preventDefault();
                sendMessageToCustomer(messageInput.value);
            });
        }

        function sendMessage(message){
            if (message) {
                fetch(adminSendMessageUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            appendMessage('admin', data.message, data.created_at);
                            messageInput.value = '';
                        }
                    });
            }
        }

        function sendMessageToCustomer(message){
            if (message) {
                fetch(adminSendMessageUrlToCustomer, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            appendMessage('admin', data.message, data.created_at);
                            messageInput.value = '';
                        }
                    });
            }
        }

        function appendMessage(sender, content, time = '') {
            const msgDiv = document.createElement('div');
            msgDiv.className = `mb-3 ${sender === 'admin' ? 'text-end' : 'text-start'}`;
            msgDiv.innerHTML = `
                <div class="d-inline-block p-2 rounded ${sender === 'admin' ? 'bg-primary text-white' : 'bg-light'}">
                    ${content}
                </div>
                <div class="small text-muted mt-1">
                    ${time}
                </div>
            `;
            chatMessages.appendChild(msgDiv);
            scrollChatToBottom();
        }

        function appendMessageFromVendor(sender, messageObj, time = '') {
            const msgDiv = document.createElement('div');
            const content = typeof messageObj === 'string' ? messageObj : messageObj.message;
            let displayTime = time;
            if (!displayTime && messageObj && messageObj.created_at) {
                displayTime = new Date(messageObj.created_at).toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
            }
            msgDiv.className = `mb-3 ${sender === 'vendor' ? 'text-start' : 'text-end'}`;
            msgDiv.innerHTML = `
                <div class="d-inline-block p-2 rounded ${sender === 'vendor' ? 'bg-light' : 'bg-primary text-white'}">
                    ${content}
                </div>
                <div class="small text-muted mt-1">
                    ${displayTime || ''}
                </div>
            `;
            chatMessages.appendChild(msgDiv);
            scrollChatToBottom();
        }


        function appendMessageFromCustomer(sender, messageObj, time = '') {
            const msgDiv = document.createElement('div');
            const content = typeof messageObj === 'string' ? messageObj : messageObj.message;
            let displayTime = time;
            if (!displayTime && messageObj && messageObj.created_at) {
                displayTime = new Date(messageObj.created_at).toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
            }
            msgDiv.className = `mb-3 ${sender === 'customer' ? 'text-start' : 'text-end'}`;
            msgDiv.innerHTML = `
                <div class="d-inline-block p-2 rounded ${sender === 'vendor' ? 'bg-light' : 'bg-primary text-white'}">
                    ${content}
                </div>
                <div class="small text-muted mt-1">
                    ${displayTime}
                </div>
            `;
            chatMessages.appendChild(msgDiv);
            scrollChatToBottom();
        }

        function scrollChatToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
});
