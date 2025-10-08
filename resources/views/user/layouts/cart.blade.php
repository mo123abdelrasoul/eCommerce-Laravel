<!-- 🛒 Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
        <h2>Shopping Cart</h2>
        <button class="close-cart" onclick="closeCart()">&times;</button>
    </div>

    <div class="cart-content" id="cartItemsContainer">
        <!-- المنتجات هتضاف هنا ديناميكياً -->
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
            <strong id="cartTotalPrice">$0.00</strong>
        </div>

        <div class="cart-actions">
            <a href="{{ url(app()->getLocale() . '/cart') }}" class="btn-view-cart">View Cart</a>
            <a href="{{ url(app()->getLocale() . '/checkout') }}" class="btn-checkout">Checkout</a>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="cartOverlay" class="cart-overlay" onclick="closeCart()"></div>

<script>
    const addToCartUrl = "{{ url(app()->getLocale() . '/cart/add') }}";
</script>
