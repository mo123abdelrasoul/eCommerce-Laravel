<!-- 🛒 Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
        <h2>{{ __('cart') }}</h2>
        <button class="close-cart" onclick="closeCart()" aria-label="Close cart">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

<div class="cart-content" id="cartItemsContainer">
    @if(!empty($products) && $products->count() > 0)
        @foreach ($products as $product)
            <div class="cart-item">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <div class="cart-item-details">
                    <h4 class="cart-item-title">{{ $product->name }}</h4>
                    <p class="text-xs text-gray-500">{{ __('quantity') }}: {{ $cart[$product->id] ?? 0 }}</p>
                    <p class="cart-item-price">{{ format_currency($product->price * ($cart[$product->id] ?? 0)) }}</p>
                </div>
            </div>
        @endforeach
    @else
        <p class="p-4 text-center text-gray-500">{{ __('your_cart_is_empty') }}</p>
    @endif
</div>


    <!-- Cart Footer -->
    <div class="cart-footer p-4 border-t border-gray-200 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <span class="font-bold text-lg text-gray-900">{{ __('total') }}:</span>
            <strong class="font-bold text-xl text-primary" id="cartTotalPrice">
                {{ format_currency($products->sum(function($p) use ($cart) {
                    return $p->price * ($cart[$p->id] ?? 0);
                })) }}
            </strong>
        </div>

        <div class="space-y-2">
            <a href="{{ route('user.cart.index', app()->getLocale()) }}" class="block w-full btn-secondary text-center">{{ __('view_cart') }}</a>
            <a href="{{ route('user.checkout.index', app()->getLocale()) }}" class="block w-full btn-primary text-center">{{ __('checkout') }}</a>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="cartOverlay" class="cart-overlay" onclick="closeCart()"></div>

<script>
    window.addToCartUrl = "{{ url(app()->getLocale() . '/user/cart/add') }}";
    window.getCartDataUrl = "{{ url(app()->getLocale() . '/user/cart/data') }}";
    window.updateCartQuantity = "{{ url(app()->getLocale() . '/user/cart/update') }}";
    window.removeCartUrl = "{{ url(app()->getLocale() . '/user/cart/delete') }}";
</script>
