@extends('user.layouts.app')

@section('title', 'Checkout')
@section('content')

    <div class="checkout-container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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

        <h1 class="checkout-title">Checkout</h1>

        <div class="checkout-grid">
            <!-- User Details -->
            <div class="checkout-section checkout-user">
                <h2 class="checkout-subtitle">User Details</h2>

                <form id="checkout-form" action="{{ route('checkout.process', ['lang' => app()->getLocale()]) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ old('name') }}" required>
                    <div class="checkout-form">

                        <div class="checkout-form-row">
                            <div class="checkout-form-group">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="checkout-form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="checkout-form-row">
                            <div class="checkout-form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="checkout-form-group">
                                <label for="city">City</label>
                                <select name="city" id="city" required>
                                    <option value="">Select City</option>
                                    @if (!empty($cities))
                                        @foreach ($cities as $city)
                                            <option value="{{ $city['id'] }}">
                                                {{ $city['name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="checkout-form-row">
                            <div class="checkout-form-group">
                                <label for="street_number">Street Number</label>
                                <input type="text" id="street_number" name="street_number"
                                    value="{{ old('street_number') }}" required>
                            </div>
                            <div class="checkout-form-group">
                                <label for="street_name">Street Name</label>
                                <input type="text" id="street_name" name="street_name" value="{{ old('street_name') }}"
                                    required>
                            </div>
                        </div>
                        <div class="checkout-form-group full-width">
                            <label for="zip_code">ZIP Code</label>
                            <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                        </div>
                        <div class="checkout-form-group full-width">
                            <label for="coupon_code">Coupon Code</label>
                            <div class="checkout-coupon">
                                <input type="text" id="coupon_code" name="coupon_code" autocomplete="off"
                                    class="checkout-coupon-input">
                                <button type="button" class="checkout-coupon-btn">Apply</button>
                            </div>
                            <div class="coupon-msg"></div>
                        </div>
                        <div class="checkout-form-group full-width">
                            <label for="shipping_method">Shipping Method</label>
                            <select name="shipping_method" id="shipping_method" required>
                                <option value="">Select Shipping Method</option>
                                @if (!empty($shipping_methods))
                                    @foreach ($shipping_methods as $method)
                                        <option value="{{ $method['id'] }}">
                                            {{ $method['name'] }} ({{ $method['description'] }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="checkout-form-group full-width">
                            <label for="notes">Order Notes (optional)</label>
                            <textarea id="notes" name="notes" rows="3" placeholder="Add any notes about your order...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    <!-- Payment -->
                    <h2 class="checkout-subtitle">Payment Method</h2>
                    <div class="checkout-payment">
                        <select name="payment_method" id="payment-method" required>
                            <option value="">Select Payment Method</option>
                            @if (!empty($payment_methods))
                                @foreach ($payment_methods as $payment)
                                    <option value="{{ $payment['id'] }}">
                                        {{ $payment['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <button type="submit" class="checkout-btn-submit">Place Order</button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="checkout-section checkout-summary">
                <h2 class="checkout-subtitle">Order Summary</h2>
                <div class="checkout-order-box">
                    @php
                        $cart = session('cart');
                        $cartTotal = 0;
                    @endphp
                    @foreach ($products as $product)
                        <div class="checkout-order-item">
                            <div class="checkout-order-left">
                                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product->name }}"
                                    class="checkout-order-image">
                                <span>{{ $product->name }} x {{ $cart[$product->id] }}</span>
                            </div>
                            <span
                                class="checkout-order-price">${{ number_format($product->price * $cart[$product->id], 2) }}</span>
                            @php $cartTotal += $product->price * $cart[$product->id]; @endphp
                        </div>
                    @endforeach

                    <div class="checkout-order-total">
                        <strong>SubTotal:</strong> <strong>${{ number_format($cartTotal, 2) }}</strong>
                    </div>
                    <div class="checkout-order-shipping">
                        <strong>Shipping:</strong><strong id="shipping-cost">{{ 'Not calculated yet' }}</strong>
                    </div>
                    <div class="checkout-order-coupon">
                        <strong>Coupon:</strong><strong>${{ 0 }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    const ShippingUrl = "{{ url(app()->getLocale() . '/checkout/shipping-rate') }}";
    const CouponUrl = "{{ url(app()->getLocale() . '/checkout/apply-coupon') }}";
</script>
