@extends('vendor.layouts.app')
@section('title', 'Order Details')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Order Details</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a
                                href="{{ route('vendor.dashboard', ['lang' => app()->getLocale()]) }}">Home</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('vendor.orders.index', app()->getLocale()) }}">Orders</a></li>
                        <li class="breadcrumb-item active">{{ $order->order_number }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <!-- Order Header -->
            <div class="card mb-4">
                <div class="card-body row">
                    <div class="col-md-6">
                        <p><strong>Customer:</strong> {{ $customer_name }}</p>
                        <p><strong>Status:</strong>
                            <span
                                class="badge 
                            @if ($order->status == 'pending') bg-warning 
                            @elseif($order->status == 'completed') bg-success 
                            @else bg-secondary @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                        <p><strong>Payment Status:</strong>
                            <span
                                class="badge 
                            @if ($order->payment_status == 'paid') bg-success 
                            @elseif($order->payment_status == 'failed') bg-danger 
                            @else bg-warning @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                        @php
                            $address = json_decode($order->shipping_address);
                            $cityName = null;
                            if ($address && isset($address->city)) {
                                $city = \App\Models\City::find($address->city);
                                $cityName = $city ? $city->name : 'Unknown City';
                            }
                        @endphp
                        @if ($address)
                            <p><strong>Shipping Address:</strong>
                                {{ $address->street_number ?? '' }} {{ $address->street_name ?? '' }},
                                {{ $cityName }}
                            </p>
                        @else
                            <p><strong>Shipping Address:</strong> N/A</p>
                        @endif
                        <p><strong>Shipping Method:</strong> {{ $shipping_method_name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Shipping Cost:</strong> {{ number_format($order->shipping_cost, 2) }} EGP</p>
                        <p><strong>Discount Amount:</strong> -%{{ number_format($order->discount_amount, 2) }}</p>
                        <p><strong>Tax Amount:</strong> {{ number_format($order->tax_amount, 2) }} EGP</p>
                        <p><strong>Subtotal:</strong> {{ number_format($order->sub_total, 2) }} EGP</p>
                        <p><strong>Total Amount:</strong> <span
                                class="fw-bold">{{ number_format($order->total_amount, 2) }} EGP</span></p>
                        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    @if (!empty($order->notes))
                        <div class="col-12 mt-2">
                            <p><strong>Notes:</strong> {{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Products Table -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Products</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0 text-center">
                        <thead class="table-bordered">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_products as $product)
                                <tr>
                                    <td>{{ $product->product_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($product->product_price, 2) }} EGP</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ number_format($product->product_price * $product->quantity, 2) }} EGP</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Subtotal</th>
                                <th>{{ number_format($order->sub_total, 2) }} EGP</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Shipping</th>
                                <th>{{ number_format($order->shipping_cost, 2) }} EGP</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Tax</th>
                                <th>{{ number_format($order->tax_amount, 2) }} EGP</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Discount</th>
                                <th>- %{{ number_format($order->discount_amount, 2) }}</th>
                            </tr>
                            <tr class="table-dark">
                                <th colspan="3" class="text-end">Total</th>
                                <th>{{ number_format($order->total_amount, 2) }} EGP</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
