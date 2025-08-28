@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Login to Your Admin Account</h2>

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.login.submit', app()->getLocale()) }}" method="POST" class="space-y-4">
        @csrf
        @if (session('success'))
            <p class="text-green-500">{{ session('success') }}</p>
        @endif
        <div>
            <label class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
            @error('email')
                <p class="msg-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Password</label>
            <input type="password" name="password"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
            @error('password')
                <p class="msg-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="text-blue-500">
                <span class="ml-2 text-gray-600 text-sm">Remember Me</span>
            </label>
        </div>

        <button type="submit"
            class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Login</button>

        <p class="text-center text-sm text-gray-600 mt-4">
            Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Sign Up</a>
        </p>
    </form>

@endsection
