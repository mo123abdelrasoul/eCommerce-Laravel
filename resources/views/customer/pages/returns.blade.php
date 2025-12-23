@extends('customer.layouts.app')

@section('title', 'Returns Policy - Mstore24')

@section('content')
    <div class="bg-white py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Returns Policy</h1>
            
            <div class="prose prose-lg text-gray-600">
                <p class="mb-4">
                    Our policy lasts 30 days. If 30 days have gone by since your purchase, unfortunately we can’t offer you a refund or exchange.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">Eligibility for Returns</h2>
                <p class="mb-4">
                    To be eligible for a return, your item must be unused and in the same condition that you received it. It must also be in the original packaging.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">Non-returnable items:</h2>
                <ul class="list-disc pl-6 mb-4">
                    <li>Gift cards</li>
                    <li>Downloadable software products</li>
                    <li>Some health and personal care items</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
