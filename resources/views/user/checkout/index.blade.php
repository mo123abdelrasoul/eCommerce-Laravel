@extends('user.layouts.app')

@section('title', 'Home')
@section('content')

    <div class="checkout-container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1>Checkout</h1>
        <div class="checkout-grid">
            <!-- User Details -->
            <div class="checkout-section">
                <h2>User Details</h2>
                <form id="checkout-form" action="{{ route('checkout.process', ['lang' => app()->getLocale()]) }}"
                    method="POST">
                    @csrf
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" required>
                    <label for="city">City</label>
                    <select name="city" id="city" required>
                        <option value="">Select City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="address">Address</label>
                    <textarea id="address" name="address"></textarea>

                    <label for="coupon_code">Coupon code</label>
                    <input type="text" id="coupon_code" name="coupon_code">
                    <label for="shipping_method">Shipping Method</label>
                    <select name="shipping_method" id="shipping_method" id="shipping_method" required>
                        <option value="">Select Shipping Method</option>
                        @foreach ($shipping_methods as $method)
                            <option value="{{ $method['id'] }}">{{ $method['name'] }} ({{ $method['description'] }})
                            </option>
                        @endforeach
                    </select>

            </div>

            <!-- Order Summary -->
            <div class="checkout-section">
                <h2>Order Summary</h2>
                <div class="order-summary">
                    @php
                        $cart = session('cart');
                        $cartTotal = 0;
                    @endphp
                    @foreach ($products as $product)
                        <div class="order-item">
                            <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product->name }}"
                                class="order-item-image">
                            <span>{{ $product->name }} x {{ $cart[$product->id] }}</span>
                            <span>${{ number_format($product->price * $cart[$product->id], 2) }}</span>
                            @php
                                $cartTotal += $product->price * $cart[$product->id];
                            @endphp
                        </div>
                    @endforeach
                    <div class="order-total">
                        <strong>SubTotal:</strong> <strong>${{ number_format($cartTotal, 2) }}</strong>
                    </div>
                    <div class="order-shipping">
                        <strong>Shipping:</strong><strong>Not calculated yet</strong>
                    </div>
                </div>

                <!-- Payment Methods -->
                <h2>Payment Methods</h2>
                <select name="payment_method" id="payment-method" required>
                    <option value="">Select Payment Method</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="cash_on_delivery">Cash on Delivery</option>
                </select>

                <button type="submit" class="btn-submit">Place Order</button>
                </form>
            </div>
        </div>
    </div>
@endsection
<script>
    const ShippingUrl = "{{ url(app()->getLocale() . '/checkout/shipping-rate') }}";
</script>
