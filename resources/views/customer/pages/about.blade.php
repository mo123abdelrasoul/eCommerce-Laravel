@extends('customer.layouts.app')

@section('title', 'About Us - Mstore24')

@section('content')
    <!-- Banner -->
    <div class="bg-gray-900 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80" alt="About Us" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ __('about_us') }}</h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">{{ __('discover_our_story') }}</p>
        </div>
    </div>

    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80" alt="Our Team" class="rounded-lg shadow-lg">
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('our_story') }}</h2>
                    <p class="text-gray-600 mb-4">
                        {{ __('our_story_p1') }}
                    </p>
                    <p class="text-gray-600">
                        {{ __('our_story_p2') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 bg-gray-50 rounded-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('our_mission') }}</h3>
                    <p class="text-gray-600">{{ __('our_mission_desc') }}</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('our_vision') }}</h3>
                    <p class="text-gray-600">{{ __('our_vision_desc') }}</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('our_values') }}</h3>
                    <p class="text-gray-600">{{ __('our_values_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
