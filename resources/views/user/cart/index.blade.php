@extends('user.layouts.app')

@section('title', 'Cart')


@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container py-5">
        <h1 class="mb-4 fs-1">{{ __('Your Cart') }}</h1>
        @if ($products->isEmpty())
            <p>{{ __('Your cart is empty.') }}</p>
            <a href="#" class="btn btn-primary">
                {{ __('Continue Shopping') }}
            </a>
        @else
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Product Price') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                    @endphp
                    @foreach ($products as $product)
                        @php
                            $total = $product['price'] * $cart[$product['id']];
                            $grandTotal += $total;
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                    width="60" class="me-2">
                                {{ $product['name'] }}
                            </td>
                            <td>
                                <input type="number" value="{{ $cart[$product['id']] }}" min="1"
                                    class="form-control w-50 quantity-input" data-product-id="{{ $product['id'] }}">
                            </td>
                            <td>${{ number_format($product['price'], 2) }}</td>
                            <td>${{ number_format($total, 2) }}</td>
                            <td>
                                <form
                                    action="{{ route('cart.delete', ['lang' => app()->getLocale(), 'id' => $product['id']]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">{{ __('Remove') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h3>{{ __('Grand Total') }}: ${{ number_format($grandTotal, 2) }}</h3>
                <a href="{{ route('checkout.index', ['lang' => app()->getLocale()]) }}" class="btn btn-lg btn-primary"
                    id="proceed-to-checkout">
                    {{ __('Proceed to Checkout') }}
                </a>
            </div>
        @endif
    </div>
@endsection
<script>
    const updateCartQuantity = "{{ url(app()->getLocale() . '/cart/update') }}";
</script>
