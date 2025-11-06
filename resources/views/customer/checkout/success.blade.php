@extends('customer.layouts.app')

@section('title', 'Checkout Success')

@section('content')
    <div class="payment-container success">
        <div class="payment-box">
            <div class="icon">✅</div>
            <h1>Order created Successfully!</h1>
            @if (session('message'))
                <p class="message">{{ session('message') }}</p>
            @endif
            <a href="{{ route('home', app()->getLocale()) }}" class="btn-back">Back to Shop</a>
        </div>
    </div>
@endsection
