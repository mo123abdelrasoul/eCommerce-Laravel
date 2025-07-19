@extends('layouts.app')

@section('title', 'Vendor Profile')

@section('content')
<div class="dashboard-container flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    @include('vendor.layouts.Sidebar')

    <div class="flex-1 flex items-center justify-center">
        <div class="w-full h-full bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center space-x-6">
                <img src="{{ asset('images/vendor-avatar.png') }}" alt="Vendor Avatar" class="w-60 h-60 rounded-full border-4 border-indigo-500 shadow">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $vendor->name }}</h2>
                    <p class="text-gray-500">{{ $vendor->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">Vendor</span>
                </div>
            </div>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-indigo-50 p-4 rounded-lg text-center">
                    <div class="text-lg font-semibold text-indigo-700">Products</div>
                    <div class="text-2xl font-bold text-gray-800 mt-2">{{ $productsCount }}</div>
                </div>
                <div class="bg-indigo-50 p-4 rounded-lg text-center">
                    <div class="text-lg font-semibold text-indigo-700">Orders</div>
                    <div class="text-2xl font-bold text-gray-800 mt-2">{{ $ordersCount }}</div>
                </div>
                <div class="bg-indigo-50 p-4 rounded-lg text-center">
                    <div class="text-lg font-semibold text-indigo-700">Revenue</div>
                    <div class="text-2xl font-bold text-gray-800 mt-2">{{ $revenue }}</div>
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <a href="{{ route('profile.edit',app()->getLocale()) }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
@endsection
