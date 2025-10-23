<!-- 🛒 Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
        <h2>Shopping Cart</h2>
        <button class="close-cart" onclick="closeCart()">&times;</button>
    </div>

    <div class="cart-content" id="cartItemsContainer">
        <div class="cart-item">
            <img src="" alt="Product Image">
            <div class="cart-item-details">
                <h4 class="cart-item-title"></h4>
                <p class="cart-item-qty"></p>
                <p class="cart-item-price"></p>
            </div>
        </div>
    </div>

    <!-- Cart Footer -->
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total:</span>
            <strong id="cartTotalPrice">{{ format_currency(0.0) }}</strong>
        </div>

        <div class="cart-actions">
            <a href="{{ route('user.cart.index', app()->getLocale()) }}" class="btn-view-cart">View Cart</a>
            <a href="{{ route('user.checkout.index', app()->getLocale()) }}" class="btn-checkout">Checkout</a>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="cartOverlay" class="cart-overlay" onclick="closeCart()"></div>

<script>
    const addToCartUrl = "{{ url(app()->getLocale() . '/user/cart/add') }}";
</script>
