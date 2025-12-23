@extends('customer.layouts.app')

@section('title', 'Order Success - Mstore24')

@section('content')
    <div class="container mx-auto px-4 py-24 text-center">
        <div class="bg-white p-12 rounded-lg shadow-lg max-w-2xl mx-auto">
            <div class="text-green-500 mb-6 flex justify-center">
                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Thank You!</h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Your order has been placed successfully.</h2>
            <p class="text-gray-600 mb-8">
                We have sent an email confirmation to your email address. 
                Your order will be processed and shipped shortly.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('home', app()->getLocale()) }}" class="btn-primary">
                    Continue Shopping
                </a>
                <!-- Optional: Link to Order History if available -->
            </div>
        </div>
    </div>
@endsection
