console.log('Cart JS Loaded');
import './bootstrap';

// ======================
// 🔹 Helpers
// ======================

function getCSRFToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

function parsePrice(value) {
    return parseFloat(value) || 0;
}

function updateText(selector, value) {
    const el = document.querySelector(selector);
    if (el) el.textContent = value;
}

// ======================
// 🔹 UI Handlers
// ======================

// Fetch fresh cart data from server
async function fetchCartData() {
    try {
        const url = window.getCartDataUrl;
        if (!url) {
            console.error('getCartDataUrl is not defined');
            return null;
        }
        console.log('Fetching cart data from:', url);

        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCSRFToken()
            },
            credentials: 'include'
        });

        if (!response.ok) {
            console.error('Cart data fetch failed with status:', response.status);
            return null;
        }

        const data = await response.json();
        console.log('Cart data received:', data);

        if (data.status === 'success') {
            return data;
        }
    } catch (error) {
        console.error('Error fetching cart data:', error);
    }
    return null;
}

async function openCart(skipFetch = false) {
    document.getElementById('cartSidebar').classList.add('active');
    document.getElementById('cartOverlay').classList.add('active');

    if (!skipFetch) {
        const cartData = await fetchCartData();
        if (cartData) {
            updateCartCount(cartData.cartCount);
            renderCartItems(cartData.products, cartData.cart, cartData.formatted.cartTotal);
        }
    }
}

function closeCart() {
    document.getElementById('cartSidebar').classList.remove('active');
    document.getElementById('cartOverlay').classList.remove('active');
}

function toggleCart() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');

    if (sidebar.classList.contains('active')) {
        closeCart();
    } else {
        openCart();
    }
}

function renderCartItems(products, cart, formattedCartTotal) {
    const cartContent = document.querySelector('#cartSidebar .cart-content');
    if (!cartContent) return;

    cartContent.innerHTML = '';

    if (!products || products.length === 0) {
        cartContent.innerHTML = '<p class="text-center text-gray-500">Your cart is empty.</p>';
        updateText('#cartTotalPrice', formattedCartTotal);
        return;
    }

    products.forEach(product => {
        const qty = cart[product.id] || 0;
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('cart-item');
        itemDiv.dataset.productId = product.id;

        const imageUrl = `${window.location.origin}/storage/${product.image}`;

        itemDiv.innerHTML = `
            <img src="${imageUrl}" alt="${product.name}">
            <div class="cart-item-details">
                <h4 class="cart-item-title">${product.name}</h4>
                <p class="cart-item-qty">Quantity: ${qty}</p>
                <p class="cart-item-price">${product.formatted_line_total || product.formatted_price}</p>
            </div>
            <button class="remove-from-sidebar" onclick="removeFromSidebar(${product.id})" aria-label="Remove item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        cartContent.appendChild(itemDiv);
    });
    updateText('#cartTotalPrice', formattedCartTotal);
}

function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => {
        el.textContent = count;
        el.classList.remove('d-none', 'hidden');
    });

    const cartBadge = document.getElementById('cart-badge');
    if (cartBadge) {
        cartBadge.textContent = count;
        cartBadge.classList.remove('d-none', 'hidden');
    }
}

function handleEmptyCart() {
    const container = document.querySelector('.cart-container');
    if (container) {
        const lang = document.documentElement.lang || 'en';
        const shopUrl = `${window.location.origin}/${lang}/shop`;
        container.innerHTML = `
            <div class="flex items-center justify-center min-h-[60vh]">
                <div class="text-center max-w-md mx-auto px-4">
                    <!-- Cart Icon -->
                    <div class="mb-8">
                        <svg class="w-32 h-32 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>

                    <!-- Text Content -->
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Your Cart is Empty</h2>
                    <p class="text-gray-500 mb-8 text-lg">Looks like you haven't added anything to your cart yet. Start shopping to find amazing products!</p>

                    <!-- Button -->
                    <a href="${shopUrl}" class="inline-flex items-center justify-center px-8 py-4 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Start Shopping
                    </a>
                </div>
            </div>
        `;
    }
}

// ======================
// 🔹 Cart Operations
// ======================

async function updateCartQuantities() {
    const inputs = document.querySelectorAll(".quantity-input");
    let valid = true;
    let items = [];

    inputs.forEach(input => {
        let qty = parseInt(input.value);
        if (qty < 1) valid = false;
        items.push({ product_id: input.dataset.productId, quantity: qty });
    });

    if (!valid) {
        alert("Quantity must be at least 1");
        return false;
    }

    await fetch(window.updateCartQuantity, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ items })
    });

    return true;
}

async function addToCart(productId) {
    console.log('Adding to cart:', productId);
    const csrf = getCSRFToken();
    if (!window.addToCartUrl) {
        console.error('addToCartUrl is not defined');
        return;
    }

    const currentCount = parseInt(document.querySelector('.cart-count')?.textContent || '0');
    const optimisticCount = currentCount + 1;

    updateCartCount(optimisticCount);
    console.log('Requesting URL:', window.addToCartUrl);

    try {
        const response = await fetch(window.addToCartUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            credentials: 'include',
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        });
        const data = await response.json();

        if (data.status === 'success') {
            updateCartCount(data.cartCount);
            renderCartItems(data.products, data.cart, data.formatted.cartTotal);
            openCart(true);
        } else {
            console.error('Add to cart failed:', data);
            updateCartCount(currentCount);
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        updateCartCount(currentCount);
    }
}

async function removeFromCart(productId, button) {
    const csrf = getCSRFToken();
    const response = await fetch(`${window.removeCartUrl}/${productId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({ product_id: productId })
    });
    const data = await response.json();

    if (data.status === 'success') {
        const row = button.closest("tr");
        if (row) row.remove();

        updateCartCount(data.cartCount);
        const mainCartTotal = document.querySelector(".cartTotal h3");
        if (mainCartTotal && data.formatted && data.formatted.cartTotal) {
            mainCartTotal.textContent = `Grand Total: ${data.formatted.cartTotal}`;
        } else if (mainCartTotal) {
            mainCartTotal.textContent = `Grand Total: ${data.cartTotal.toFixed(2)}`;
        }

        const tbody = document.querySelector("table tbody");
        if (tbody && tbody.children.length === 0) handleEmptyCart();
        renderCartItems(data.products, data.cart, data.formatted.cartTotal);
    }
}

async function removeFromSidebar(productId) {
    const csrf = getCSRFToken();

    try {
        const response = await fetch(`${window.removeCartUrl}/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ product_id: productId })
        });
        const data = await response.json();

        if (data.status === 'success') {
            updateCartCount(data.cartCount);
            renderCartItems(data.products, data.cart, data.formatted.cartTotal);
            if (data.cartCount === 0) {
                closeCart();
            }
            const cartContainer = document.querySelector('.cart-container');
            if (cartContainer) {
                if (data.cartCount === 0) {
                    handleEmptyCart();
                } else {
                    const cartTable = document.querySelector('table tbody');
                    if (cartTable) {
                        const rows = cartTable.querySelectorAll('tr');
                        rows.forEach(row => {
                            const input = row.querySelector('[data-product-id]');
                            if (input && parseInt(input.dataset.productId) === productId) {
                                row.remove();
                            }
                        });
                        // Update grand total if present (use plain text, not template syntax)
                        const mainCartTotal = document.querySelector(".cartTotal h3");
                        if (mainCartTotal && data.formatted && data.formatted.cartTotal) {
                            mainCartTotal.innerHTML = `Grand Total: <span class="text-primary">${data.formatted.cartTotal}</span>`;
                        }
                    }
                }
            }
        }
    } catch (error) {
        console.error('Error removing from cart:', error);
    }
}

// ======================
// 🔹 Event Listeners
// ======================

document.addEventListener("DOMContentLoaded", () => {
    const proceedBtn = document.querySelector("#proceed-to-checkout");
    // Support both legacy and current button classes (some templates use `add-cart-btn`, others `add-to-cart-btn`)
    const addCartBtns = document.querySelectorAll(".add-cart-btn, .add-to-cart-btn");
    const removeBtns = document.querySelectorAll(".remove-cart-item");

    if (proceedBtn) {
        proceedBtn.addEventListener("click", async (e) => {
            e.preventDefault();
            const success = await updateCartQuantities();
            if (success) window.location.href = proceedBtn.getAttribute('href');
        });
    }

    addCartBtns.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const pid = btn.dataset.productId || btn.getAttribute('data-product-id');
            if (!pid) {
                console.error('No product id found on button', btn);
                return;
            }
            addToCart(pid);
        });
    });

    removeBtns.forEach(btn => {
        btn.addEventListener("click", () => removeFromCart(btn.dataset.productId, btn));
    });

    // expose to window (optional)
    window.openCart = openCart;
    window.closeCart = closeCart;
    window.toggleCart = toggleCart;
    window.removeFromSidebar = removeFromSidebar;
});




// Customer Chat Script
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('customer-chat-widget')) {
        const toggleBtn = document.getElementById('customer-chat-toggle');
        const chatWindow = document.getElementById('customer-chat-window');
        const closeBtn = document.getElementById('customer-chat-close');
        const chatForm = document.getElementById('customer-chat-form');
        const chatInput = document.getElementById('customer-chat-input');
        const chatMessages = document.getElementById('customer-chat-messages');

        const customerId = window.Customer.id;
        console.log('Customer ID:', customerId);
        window.EchoPusher.private('chat.customer.' + customerId)
            .listen('MessageSent', (e) => {
                appendMessageFromAdmin('admin', e.message);
            });

        toggleBtn.addEventListener('click', () => {
            const isHidden = (chatWindow.style.display === '' && getComputedStyle(chatWindow).display === 'none') || chatWindow.style.display === 'none';
            if (isHidden) {
                chatWindow.style.display = 'flex';
                toggleBtn.style.display = 'none';
                scrollChatToBottom();
                loadChatData(fetchMessagesUrlFromCustomer);
            } else {
                chatWindow.style.display = 'none';
                toggleBtn.style.display = 'flex';
            }
        });
        closeBtn.addEventListener('click', () => {
            chatWindow.style.display = 'none';
            toggleBtn.style.display = 'flex';
        });

        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const message = chatInput.value.trim();
            sendMessage(message);
        });

        function sendMessage(message) {
            if (message === '') return;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            fetch(customerSendMessageUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: message })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        appendMessage('customer', data.message.content, data.message.created_at);
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
            msgDiv.className = `mb-3 ${sender === 'customer' ? 'text-start' : 'text-end'}`;
            msgDiv.innerHTML = `
                <div class="d-inline-block p-2 rounded ${sender === 'customer' ? 'bg-primary text-white' : 'bg-light'}">
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
            msgDiv.className = `mb-3 ${sender === 'customer' ? 'text-start' : 'text-end'}`;
            msgDiv.innerHTML = `
                <div class="d-inline-block p-2 rounded ${sender === 'customer' ? 'bg-primary text-white' : 'bg-light'}">
                    ${content}
                </div>
                <div class="small text-muted mt-1">
                    ${displayTime || ''}
                </div>
            `;
            chatMessages.appendChild(msgDiv);
            scrollChatToBottom();
        }

        function loadChatData(fetchMessagesUrlFromCustomer) {
            fetch(fetchMessagesUrlFromCustomer)
                .then(res => res.json())
                .then(messages => {
                    const chatMessages = document.getElementById('customer-chat-messages');
                    chatMessages.innerHTML = '';
                    messages.forEach(message => {
                        const div = document.createElement('div');
                        div.className = `mb-3 ${message.sender === 'customer' ? 'text-start' : 'text-end'}`;
                        div.innerHTML = `
                            <div class="d-inline-block p-2 rounded ${message.sender === 'customer' ? 'bg-primary text-white' : 'bg-light'}">
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
