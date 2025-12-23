@extends('customer.layouts.app')

@section('title', 'Shipping Policy - Mstore24')

@section('content')
    <div class="bg-white py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Shipping Policy</h1>
            
            <div class="prose prose-lg text-gray-600">
                <p class="mb-4">
                    Thank you for visiting and shopping at Mstore24. Following are the terms and conditions that constitute our Shipping Policy.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">Shipment processing time</h2>
                <p class="mb-4">
                    All orders are processed within 2-3 business days. Orders are not shipped or delivered on weekends or holidays.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">Shipping rates & delivery estimates</h2>
                <p class="mb-4">
                    Shipping charges for your order will be calculated and displayed at checkout.
                </p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Standard Shipping: 5-7 business days</li>
                    <li>Express Shipping: 2-3 business days</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
