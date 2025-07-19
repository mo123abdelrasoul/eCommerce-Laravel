@extends('layouts.app')

@section('title', 'Register')

@section('content')

<h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Register to Create an Account</h2>

<form action="{{ route('registerForm', app()->getLocale()) }}" method="POST" class="space-y-4">
    @csrf

    @if (session('success'))
    <p class="text-green-500">{{ session('success') }}</p>
    @endif
    <div>
        <label class="block text-gray-700 font-medium mb-2">Name</label>
        <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-gray-700 font-medium mb-2">Email</label>
        <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>


    <div>
        <label class="block text-gray-700 font-medium mb-2">Phone</label>
        <input type="number" name="phone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
        @error('phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-gray-700 font-medium mb-2">Role</label>
        <div class="flex space-x-4">
            <label class="flex items-center">
                <input type="radio" name="role" value="vendor" class="form-radio text-blue-500" required>
                <span class="ml-2">Vendor</span>
            </label>
            <label class="flex items-center">
                <input type="radio" name="role" value="customer" class="form-radio text-blue-500" required>
                <span class="ml-2">Customer</span>
            </label>
        </div>
        @error('role')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>


    <div>
        <label class="block text-gray-700 font-medium mb-2">Password</label>
        <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
        @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-gray-700 font-medium mb-2">Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
    </div>

    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Register</button>

    <p class="text-center text-sm text-gray-600 mt-4">
        Already have an account? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
    </p>
</form>

@endsection
