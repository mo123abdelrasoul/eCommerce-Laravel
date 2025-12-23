@extends('customer.layouts.app')

@section('title', 'Privacy Policy - Mstore24')

@section('content')
    <!-- Banner -->
    <div class="bg-gray-900 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1507925921958-8a62f3d1a50d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Privacy Policy" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Privacy Policy</h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">Your privacy is important to us.</p>
        </div>
    </div>

    <div class="bg-white py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="prose prose-lg text-gray-600">
                <p class="mb-4">Last updated: {{ date('F d, Y') }}</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">1. Introduction</h2>
                <p class="mb-4">
                    Welcome to Mstore24. We respect your privacy and are committed to protecting your personal data.
                    This privacy policy will inform you as to how we look after your personal data when you visit our website.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">2. Data We Collect</h2>
                <p class="mb-4">
                    We may collect, use, store and transfer different kinds of personal data about you which we have grouped together follows:
                </p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Identity Data includes first name, last name, username or similar identifier.</li>
                    <li>Contact Data includes billing address, delivery address, email address and telephone numbers.</li>
                    <li>Transaction Data includes details about payments to and from you and other details of products you have purchased from us.</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">3. How We Use Your Data</h2>
                <p class="mb-4">
                    We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:
                </p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Where we need to perform the contract we are about to enter into or have entered into with you.</li>
                    <li>Where it is necessary for our legitimate interests (or those of a third party) and your interests and fundamental rights do not override those interests.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
