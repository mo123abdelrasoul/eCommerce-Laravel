console.log('Cart JS Loaded');

// ======================
// 🔹 Helpers
// ======================

function getCSRFToken() {
    const input = document.querySelector('input[name="_token"]');
    return input ? input.value : '';
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

function openCart() {
    document.getElementById('cartSidebar').classList.add('active');
    document.getElementById('cartOverlay').classList.add('active');
}

function closeCart() {
    document.getElementById('cartSidebar').classList.remove('active');
    document.getElementById('cartOverlay').classList.remove('active');
}

function renderCartItems(products, cart, formattedCartTotal) {
    const cartContent = document.querySelector('#cartSidebar .cart-content');
    if (!cartContent) return;
    cartContent.innerHTML = '';
    products.forEach(product => {
        const qty = cart[product.id] || 0;
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('cart-item');
        itemDiv.innerHTML = `
            <img src="storage/${product.image}" alt="${product.name}">
            <div class="cart-item-details">
                <h4 class="cart-item-title">${product.name}</h4>
                <p class="cart-item-qty">Quantity: ${qty}</p>
                <p class="cart-item-price">${product.formatted_price}</p>
            </div>
        `;
        cartContent.appendChild(itemDiv);
    });
    updateText('#cartTotalPrice', formattedCartTotal);
}

function updateCartCount(count) {
    updateText('.cart-count', count);
}

function handleEmptyCart() {
    const container = document.querySelector('.cart-container');
    if (container) {
        container.innerHTML = `
            <div class="text-center py-5">
                <div class="alert alert-danger">Your cart is empty.</div>
                <a href="${window.location.origin + '/' + document.documentElement.lang}" class="btn btn-primary btn-lg">
                    Continue Shopping
                </a>
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

    await fetch(updateCartQuantity, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ items })
    });

    return true;
}

async function addToCart(productId) {
    const csrf = getCSRFToken();
    const response = await fetch(addToCartUrl, {
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
        openCart();
    }
}

async function removeFromCart(productId, button) {
    const csrf = getCSRFToken();
    const response = await fetch(`${removeCartUrl}/${productId}`, {
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
        updateText(".cartTotal h3", `Grand Total: ${data.cartTotal.toFixed(2)}`);

        const tbody = document.querySelector("table tbody");
        if (tbody && tbody.children.length === 0) handleEmptyCart();
    }
}

// ======================
// 🔹 Event Listeners
// ======================

document.addEventListener("DOMContentLoaded", () => {
    const proceedBtn = document.querySelector("#proceed-to-checkout");
    const addCartBtns = document.querySelectorAll(".add-cart-btn");
    const removeBtns = document.querySelectorAll(".remove-cart-item");

    if (proceedBtn) {
        proceedBtn.addEventListener("click", async (e) => {
            e.preventDefault();
            const success = await updateCartQuantities();
            if (success) window.location.href = proceedBtn.getAttribute('href');
        });
    }

    addCartBtns.forEach(btn => {
        btn.addEventListener("click", () => addToCart(btn.dataset.productId));
    });

    removeBtns.forEach(btn => {
        btn.addEventListener("click", () => removeFromCart(btn.dataset.productId, btn));
    });

    // expose to window (optional)
    window.openCart = openCart;
    window.closeCart = closeCart;
});
