@extends('customer.layouts.app')

@section('title', 'Cart - Mstore24')

@section('content')
    <div class="container mx-auto px-4 py-12 cart-container">
        @if (!session('error') && !$products->isEmpty())
            <h1 class="text-3xl font-bold mb-8 text-gray-900">{{ __('your_cart_title') }}</h1>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            <a href="{{ route('home', app()->getLocale()) }}" class="btn-primary inline-block">
                {{ __('continue_shopping') }}
            </a>
        @elseif (!session('error') && $products->isEmpty())
            <div class="flex items-center justify-center min-h-[60vh]">
                <div class="text-center max-w-md mx-auto px-4">
                    <!-- Cart Icon -->
                    <div class="mb-8">
                        <svg class="w-32 h-32 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    
                    <!-- Text Content -->
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ __('your_cart_is_empty_title') }}</h2>
                    <p class="text-gray-500 mb-8 text-lg">{{ __('cart_empty_message') }}</p>
                    
                    <!-- Button -->
                    <a href="{{ route('shop', app()->getLocale()) }}" class="inline-flex items-center justify-center px-8 py-4 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        {{ __('start_shopping') }}
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-4">{{ __('product') }}</th>
                                <th class="px-6 py-4">{{ __('price') }}</th>
                                <th class="px-6 py-4">{{ __('quantity') }}</th>
                                <th class="px-6 py-4">{{ __('total') }}</th>
                                <th class="px-6 py-4 text-center">{{ __('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php $grandTotal = 0; @endphp
                            @foreach ($products as $product)
                                @php
                                    $total = $product->price * $cart[$product->id];
                                    $grandTotal += $total;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 flex items-center space-x-4">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                                        <span class="font-medium text-gray-900">{{ $product->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ format_currency($product->price) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="number" value="{{ $cart[$product->id] }}" min="1"
                                            class="form-input w-20 text-center quantity-input" 
                                            data-product-id="{{ $product->id }}">
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        {{ format_currency($total) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" class="text-red-500 hover:text-red-700 transition remove-cart-item"
                                            data-product-id="{{ $product->id }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-lg shadow-sm cartTotal">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-2xl font-bold text-gray-900">{{ __('grand_total') }}: <span class="text-primary">{{ format_currency($grandTotal) }}</span></h3>
                    <p class="text-sm text-gray-500 mt-1">{{ __('taxes_shipping_note') }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('home', app()->getLocale()) }}" class="btn-secondary">
                        {{ __('continue_shopping') }}
                    </a>
                    <a href="{{ route('user.checkout.index', app()->getLocale()) }}" id="proceed-to-checkout" class="btn-primary">
                        {{ __('proceed_to_checkout') }}
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script>
        const updateCartQuantity = "{{ url(app()->getLocale() . '/user/cart/update') }}";
        const removeCartUrl = "{{ url(app()->getLocale() . '/user/cart/delete') }}";
    </script>
@endsection
