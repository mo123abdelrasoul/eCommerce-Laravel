@extends('user.layouts.app')

@section('title', 'Home')
@section('content')

    <div class="checkout-container">
        <h1>Checkout</h1>
        <div class="checkout-grid">
            <!-- User Details -->
            <div class="checkout-section">
                <h2>User Details</h2>
                <form id="checkout-form" action="#" method="POST">
                    @csrf
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" required>

                    <label for="address">Address</label>
                    <textarea id="address" name="address" required></textarea>
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
                        <strong>Total:</strong> <strong>${{ number_format($cartTotal, 2) }}</strong>
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
