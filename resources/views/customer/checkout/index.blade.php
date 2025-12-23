@extends('customer.layouts.app')

@section('title', 'Checkout')

@push('styles')
    @vite(['resources/css/checkout.scss', 'resources/js/checkout.js'])
@endpush

@section('content')
    <div class="checkout-container">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session('success'))
            <div class="alert alert-success">{{ session('message') }}</div>
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

        <h1 class="checkout-title">{{ __('checkout') }}</h1>

        <div class="checkout-grid">
            <!-- User Details -->
            <div class="checkout-section checkout-user">
                <h2 class="checkout-subtitle">{{ __('billing_details') }}</h2>

                <form id="checkout-form" action="{{ route('user.checkout.process', ['lang' => app()->getLocale()]) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ old('name') }}" required>
                    <div class="checkout-form">

                        <div class="checkout-form-row">
                            <div class="checkout-form-group">
                                <label for="name">{{ __('full_name') }}</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="checkout-form-group">
                                <label for="email">{{ __('email_address') }}</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="checkout-form-row">
                            <div class="checkout-form-group">
                                <label for="phone">{{ __('phone_number') }}</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="checkout-form-group">
                                <label for="city">{{ __('city') }}</label>
                                <select name="city" id="city" autocomplete="off" required>
                                    <option value="">{{ __('select_city') }}</option>
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
                                <label for="street_number">{{ __('street_number') }}</label>
                                <input type="text" id="street_number" name="street_number"
                                    value="{{ old('street_number') }}" required>
                            </div>
                            <div class="checkout-form-group">
                                <label for="street_name">{{ __('street_name') }}</label>
                                <input type="text" id="street_name" name="street_name" value="{{ old('street_name') }}"
                                    required>
                            </div>
                        </div>
                        <div class="checkout-form-group full-width">
                            <label for="zip_code">{{ __('zip_code') }}</label>
                            <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                        </div>
                        <div class="checkout-form-group full-width">
                            <label for="coupon_code">{{ __('have_coupon') }}</label>
                            <div class="checkout-coupon">
                                <input type="text" id="coupon_code" name="coupon_code"
                                    autocomplete="off"
                                    class="checkout-coupon-input">
                                <button type="button" class="checkout-coupon-btn">{{ __('apply') }}</button>
                            </div>
                            <div class="coupon-msg"></div>
                        </div>
                        <div class="checkout-form-group full-width">
                            <label for="shipping_method">{{ __('shipping_method') }}</label>
                            <select name="shipping_method" id="shipping_method" autocomplete="off" required>
                                <option value="">{{ __('select_shipping_method') }}</option>
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
                            <label for="notes">{{ __('order_notes') }}</label>
                            <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    <!-- Payment -->
                    <h2 class="checkout-subtitle">{{ __('payment_method') }}</h2>
                    <div class="checkout-payment">
                        <select name="payment_method" id="payment-method" required>
                            <option value="">{{ __('select_payment_method') }}</option>
                            @if (!empty($payment_methods))
                                @foreach ($payment_methods as $payment)
                                    <option value="{{ $payment['id'] }}">
                                        {{ $payment['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <button type="submit" class="checkout-btn-submit">{{ __('place_order') }}</button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="checkout-section checkout-summary">
                <h2 class="checkout-subtitle">{{ __('order_summary') }}</h2>
                <div class="checkout-order-box">
                    @php
                        $cart = session('cart');
                        $cartTotal = 0;
                    @endphp
                    @if (!empty($products))
                        @foreach ($products as $product)
                            <div class="checkout-order-item">
                                <div class="checkout-order-left">
                                    <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product->name }}"
                                        class="checkout-order-image">
                                    <span>{{ $product->name }} x {{ $cart[$product->id] }}</span>
                                </div>
                                <span
                                    class="checkout-order-price">{{ format_currency($product->price * $cart[$product->id]) }}
                                </span>
                                @php $cartTotal += $product->price * $cart[$product->id]; @endphp
                            </div>
                        @endforeach
                    @endif
                    <div class="checkout-order-total">
                        <strong>{{ __('subtotal') }}:</strong> <strong id="sub-total" data-value="{{ $cartTotal }}">{{ format_currency($cartTotal) }}</strong>
                    </div>
                    <div class="checkout-order-shipping">
                        <strong>{{ __('shipping') }}:</strong><strong id="shipping-cost" data-value="0">{{ __('calculated_at_next_step') }}</strong>
                    </div>
                    <div class="checkout-order-coupon">
                        <strong>{{ __('discount') }}:</strong><strong id="coupon-discount" data-value="0">{{ format_currency(0) }}</strong>
                    </div>
                    <div class="checkout-order-total-final">
                        <strong>{{ __('total') }}:</strong>
                        <strong id="final-total" data-value="{{ $cartTotal }}">{{ format_currency($cartTotal) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ShippingUrl = "{{ url(app()->getLocale() . '/user/checkout/shipping-rate') }}";
        const CouponUrl = "{{ url(app()->getLocale() . '/user/checkout/apply-coupon') }}";
    </script>
@endsection
