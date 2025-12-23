@extends('customer.layouts.app')

@section('title', 'Home - Mstore24')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gray-900 text-white relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="http://127.0.0.1:8000/storage/uploads/home/hero3.jpg" alt="{{ __('summer_sale_live') }}"
                class="w-full h-full object-cover opacity-50">
        </div>
        <div class="container mx-auto px-4 py-32 relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                {{ __('summer_sale_live') }}
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto">
                {{ __('get_up_to_off', ['percent' => '50%']) }}
            </p>
            <a href="{{ url(app()->getLocale() . '/shop') }}"
                class="inline-block bg-primary text-white font-bold py-2 px-10 rounded-full hover:bg-opacity-90 transition transform hover:scale-105 shadow-lg text-lg">
                {{ __('shop_now') }}
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6 border rounded-lg hover:shadow-lg transition">
                <div class="text-primary mb-4 flex justify-center">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">{{ __('quality_guarantee') }}</h3>
                <p class="text-gray-600">{{ __('quality_guarantee_desc') }}</p>
            </div>
            <div class="p-6 border rounded-lg hover:shadow-lg transition">
                <div class="text-primary mb-4 flex justify-center">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">{{ __('fast_shipping') }}</h3>
                <p class="text-gray-600">{{ __('fast_shipping_desc') }}</p>
            </div>
            <div class="p-6 border rounded-lg hover:shadow-lg transition">
                <div class="text-primary mb-4 flex justify-center">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">{{ __('secure_payment') }}</h3>
                <p class="text-gray-600">{{ __('secure_payment_desc') }}</p>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-end mb-8">
                <h2 class="text-3xl font-bold text-gray-900">{{ __('featured_products') }}</h2>
                <a href="{{ url(app()->getLocale() . '/shop') }}"
                    class="text-primary hover:underline font-semibold">{{ __('view_all') }}</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($featured_products as $product)
                    @include('customer.components.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    <!-- Promotional Banner -->
    <section class="py-16 bg-primary text-white">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-8 md:mb-0 md:w-1/2">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">{{ __('summer_sale_live') }}</h2>
                <p class="text-lg mb-6 text-white text-opacity-90">{{ __('get_up_to_off', ['percent' => '50%']) }}</p>
                <a href="{{ url(app()->getLocale() . '/shop') }}"
                    class="bg-white text-primary font-bold py-3 px-8 rounded-lg hover:bg-gray-100 transition">
                    {{ __('shop_sale') }}
                </a>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="http://127.0.0.1:8000/storage/uploads/home/sale.jpg" alt="{{ __('summer_sale_live') }}"
                    class="rounded-lg shadow-lg">
            </div>
        </div>
    </section>

    <!-- Best Selling Products -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">{{ __('best_selling') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($best_selling_products as $product)
                    @include('customer.components.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
@endsection
