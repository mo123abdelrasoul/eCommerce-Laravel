@extends('customer.layouts.app')

@section('title', 'Terms & Conditions - Mstore24')

@section('content')
    <div class="bg-white py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Terms & Conditions</h1>
            
            <div class="prose prose-lg text-gray-600">
                <p class="mb-4">Last updated: {{ date('F d, Y') }}</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">1. Introduction</h2>
                <p class="mb-4">
                    These Website Standard Terms and Conditions written on this webpage shall manage your use of our website, Mstore24 accessible at mstore24.com.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">2. Intellectual Property Rights</h2>
                <p class="mb-4">
                    Other than the content you own, under these Terms, Mstore24 and/or its licensors own all the intellectual property rights and materials contained in this Website.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">3. Restrictions</h2>
                <p class="mb-4">
                    You are specifically restricted from all of the following:
                </p>
                <ul class="list-disc pl-6 mb-4">
                    <li>publishing any Website material in any other media;</li>
                    <li>selling, sublicensing and/or otherwise commercializing any Website material;</li>
                    <li>publicly performing and/or showing any Website material;</li>
                    <li>using this Website in any way that is or may be damaging to this Website;</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
