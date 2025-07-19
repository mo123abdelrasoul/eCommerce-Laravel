@extends('layouts.app')

@section('title', 'Edit Vendor Profile')

@section('content')
<div class="dashboard-container flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    @include('vendor.layouts.Sidebar')

    <div class="flex-1 flex items-center justify-center">
        <div class="w-full bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Profile</h2>
            <form method="POST" action="{{ route('profile.update', app()->getLocale()) }}" >
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="avatar">Profile Picture</label>
                    <img id="avatarPreview" src="{{ asset('storage/' . $profile->avatar ?? '') }}" alt="Avatar Preview" class="w-32 h-32 rounded-full mb-4 border-2 border-indigo-400 object-cover">
                    <input type="file" id="avatar" name="avatar" class="w-full border border-gray-300 rounded-lg px-4 py-2" accept="image/*">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="name">Name</label>
                    <input type="text" value="{{ old('name', $profile->name ?? '') }}" id="name" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" placeholder="Vendor Name">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
                    <input type="email" value="{{ old('email', $profile->email ?? '') }}" id="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" placeholder="Vendor Email">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="phone">Phone</label>
                    <input type="number" value="{{ old('phone', $profile->phone ?? '') }}" id="phone" name="phone" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" placeholder="Phone Number">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="store_name">Company Name</label>
                    <input type="text" value="{{ old('company', $profile->company ?? '') }}" id="store_name" name="store_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" placeholder="Store Name">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
