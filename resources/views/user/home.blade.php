@extends('user.layouts.app')

@section('title', 'Home')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- Hero Section --}}
    <section class="relative bg-blue-600 text-white py-20">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-4">Welcome to MyShop</h2>
            <p class="text-lg mb-6">Find the best products at the best prices</p>
            <a href="/shop" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
                Shop Now
            </a>
        </div>
    </section>
    {{-- Featured Products --}}
    <section class="container mx-auto py-16 px-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-8">Featured Products</h3>
        <div class="grid md:grid-cols-4 sm:grid-cols-2 gap-6">
            {{-- Example Product Card --}}
            @foreach ($featured_products as $product)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="text-lg font-semibold">{{ $product->name }}</h4>
                        <p class="text-gray-600 mb-2">${{ $product->price }}</p>
                        <form action="" class="inline">
                            @csrf
                            <button type="button"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 add-cart-btn"
                                data-product-id="{{ $product->id }}">Add
                                to cart
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Slider Section --}}
    <section class="container mx-auto py-16 px-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-8">Best Sellers</h3>
        <div class="swiper home-best-sellers-swiper">
            <div class="swiper-wrapper">
                @foreach ($best_selling_products as $product)
                    <div class="swiper-slide bg-white shadow rounded-lg p-6 text-center">
                        <img src="{{ asset('storage/' . $product->image) }}" class="mx-auto mb-4" alt="Product">
                        <h4 class="text-lg font-semibold">{{ $product->name }}</h4>
                        <p class="text-gray-600">${{ $product->price }}</p>
                        <form action="" class="inline">
                            @csrf
                            <button type="button"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 add-cart-btn"
                                data-product-id="{{ $product->id }}">Add
                                to cart
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next home-swiper-next"></div>
            <div class="swiper-button-prev home-swiper-prev"></div>
        </div>
    </section>

@endsection
@push('scripts')
    @vite('resources/js/home.js')
@endpush
