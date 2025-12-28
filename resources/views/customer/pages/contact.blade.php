@extends('customer.layouts.app')

@section('title', 'Contact Us - Mstore24')

@section('content')
    <!-- Banner -->
    <div class="bg-gray-900 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="http://127.0.0.1:8000/storage/uploads/contact/title-section.jpg" alt="Contact Us" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ __('contact_us') }}</h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">{{ __('wed_love_to_hear') }}</p>
        </div>
    </div>

    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row">
                <!-- Contact Info -->
                <div class="bg-primary text-white p-8 md:w-1/3">
                    <h2 class="text-2xl font-bold mb-6">{{ __('contact_information') }}</h2>
                    <p class="mb-6 text-white text-opacity-90">{{ __('fill_up_form') }}</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ __('contact_phone') }}</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>{{ __('contact_email') }}</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ __('contact_address') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="p-8 md:w-2/3">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('send_us_message') }}</h2>
                    <!-- TODO: Update action to the correct backend route if available -->
                    <form action="{{ route('contact.submit', app()->getLocale()) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('name') }}</label>
                                <input type="text" id="name" name="name" class="form-input" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('email') }}</label>
                                <input type="email" id="email" name="email" class="form-input" required>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">{{ __('subject') }}</label>
                            <input type="text" id="subject" name="subject" class="form-input" required>
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">{{ __('message') }}</label>
                            <textarea id="message" name="message" rows="4" class="form-input" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full">{{ __('send_message') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
