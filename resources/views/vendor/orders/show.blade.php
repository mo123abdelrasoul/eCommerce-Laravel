@extends('vendor.layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="container mt-4">

        <!-- Order Header -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Order #{{ $order_details->order_number }}</h4>
            </div>
            <div class="card-body row">
                <div class="col-md-6">
                    <p><strong>Customer:</strong> {{ $customer_name }}</p>
                    <p><strong>Status:</strong>
                        <span
                            class="badge 
                        @if ($order_details->status == 'pending') bg-warning 
                        @elseif($order_details->status == 'completed') bg-success 
                        @else bg-secondary @endif">
                            {{ ucfirst($order_details->status) }}
                        </span>
                    </p>
                    <p><strong>Payment Status:</strong>
                        <span
                            class="badge 
                        @if ($order_details->payment_status == 'paid') bg-success 
                        @elseif($order_details->payment_status == 'failed') bg-danger 
                        @else bg-warning @endif">
                            {{ ucfirst($order_details->payment_status) }}
                        </span>
                    </p>
                    <p><strong>Shipping Address:</strong> {{ $order_details->shipping_address ?? 'N/A' }}</p>
                    <p><strong>Shipping Method:</strong> {{ $order_details->shipping_method ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Shipping Cost:</strong> {{ number_format($order_details->shipping_cost, 2) }} EGP</p>
                    <p><strong>Discount Amount:</strong> -%{{ number_format($order_details->discount_amount, 2) }}</p>
                    <p><strong>Tax Amount:</strong> {{ number_format($order_details->tax_amount, 2) }} EGP</p>
                    <p><strong>Subtotal:</strong> {{ number_format($order_details->sub_total, 2) }} EGP</p>
                    <p><strong>Total Amount:</strong> <span
                            class="fw-bold">{{ number_format($order_details->total_amount, 2) }} EGP</span></p>
                    <p><strong>Date:</strong> {{ $order_details->created_at->format('d M Y, h:i A') }}</p>
                </div>
                @if (!empty($order_details->notes))
                    <div class="col-12 mt-2">
                        <p><strong>Notes:</strong> {{ $order_details->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Products Table -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Products</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
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
                                <td>{{ number_format($product->product_price * $product->quantity, 2) }}EGP</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">Subtotal</th>
                            <th>{{ number_format($order_details->sub_total, 2) }} EGP</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Shipping</th>
                            <th>{{ number_format($order_details->shipping_cost, 2) }} EGP</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Tax</th>
                            <th>{{ number_format($order_details->tax_amount, 2) }} EGP</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Discount</th>
                            <th>- %{{ number_format($order_details->discount_amount, 2) }}</th>
                        </tr>
                        <tr class="table-dark">
                            <th colspan="3" class="text-end">Total</th>
                            <th>{{ number_format($order_details->total_amount, 2) }} EGP</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
@endsection
