@extends('customer.layouts.app')

@section('title', 'Shop - Mstore24')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            <nav class="text-sm text-gray-500 mb-6">
                <a href="{{ route('home', app()->getLocale()) }}" class="hover:text-primary">{{ __('home') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ __('shop') }}</span>
            </nav>

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar -->
                <aside class="w-full md:w-1/4">
                    @include('customer.partials.shop-sidebar')
                </aside>

                <!-- Product Grid -->
                <div class="w-full md:w-3/4">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">{{ __('all_products') }}</h1>
                        <span class="text-gray-500 text-sm">
                            @if(isset($products))
                                {{ __('showing_results', ['count' => $products->count()]) }}
                            @else
                                {{ __('showing_results', ['count' => 0]) }}
                            @endif
                        </span>
                    </div>

                    @if(isset($products) && $products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                @include('customer.components.product-card', ['product' => $product])
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="bg-white p-12 rounded-lg shadow-sm text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('no_products_found') }}</h3>
                            <p class="text-gray-500 mt-2">{{ __('try_adjusting_filters') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
