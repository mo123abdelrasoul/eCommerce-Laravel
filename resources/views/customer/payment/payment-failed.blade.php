@extends('user.layouts.app')

@section('title', 'Payment Failed')

@section('content')
    <div class="payment-container failed">
        <div class="payment-box">
            <div class="icon">❌</div>
            <h1>Payment Failed</h1>
            @if (session('message'))
                <p class="message">{{ session('message') }}</p>
            @endif
            <a href="{{ route('checkout.index') }}" class="btn-back">Back to Checkout</a>
        </div>
    </div>
@endsection
