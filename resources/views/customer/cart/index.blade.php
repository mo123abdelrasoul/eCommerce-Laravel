@extends('customer.layouts.app')

@section('title', 'Cart')

@section('content')
    <div class="container py-5 cart-container">

        @if (session('error'))
            <div class="text-center py-5">
                <div class="alert alert-danger">{{ session('error') }}</div>
                <a href="{{ route('home', app()->getLocale()) }}" class="btn btn-primary btn-lg">
                    {{ __('Continue Shopping') }}
                </a>
            </div>
        @elseif (!session('error') && $products->isEmpty())
            <div class="text-center py-5">
                <div class="alert alert-danger">{{ 'Your cart is empty.' }}</div>
                <a href="{{ route('home', app()->getLocale()) }}" class="btn btn-primary btn-lg">
                    {{ __('Continue Shopping') }}
                </a>
            </div>
        @else
            <h1 class="mb-4 fs-1">{{ __('Your Cart') }}</h1>

            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Product Price') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach ($products as $product)
                        @php
                            $total = $product->price * $cart[$product->id];
                            $grandTotal += $total;
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" width="60"
                                    alt="{{ $product->name }}">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <input type="number" value="{{ $cart[$product->id] }}" min="1"
                                    class="form-control w-50 quantity-input" data-product-id="{{ $product->id }}">
                            </td>
                            <td>{{ format_currency($product->price) }}</td>
                            <td>{{ format_currency($total) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger remove-cart-item"
                                    data-product-id="{{ $product->id }}">
                                    {{ __('Remove') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4 cartTotal">
                <h3>{{ __('Grand Total') }}: {{ format_currency($grandTotal) }}</h3>
                <a href="{{ route('user.checkout.index', app()->getLocale()) }}" class="btn btn-lg btn-primary">
                    {{ __('Proceed to Checkout') }}
                </a>
            </div>
        @endif
    </div>
@endsection

<script>
    const updateCartQuantity = "{{ url(app()->getLocale() . '/user/cart/update') }}";
    const removeCartUrl = "{{ url(app()->getLocale() . '/user/cart/delete') }}";
</script>
