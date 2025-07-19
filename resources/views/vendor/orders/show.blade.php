@extends('layouts.app')

@section('title', 'Vendor Products')

@section('content')
<div class="dashboard-container flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    @include('vendor.layouts.Sidebar')
    {{-- Main Content --}}
    <div class="flex-1 p-6 overflow-auto">
        <h1 class="text-2xl font-bold mb-6">Order Details</h1>

        {{-- Order Info --}}
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-2xl font-bold mb-4">Order Information</h2>
            <div class="grid grid-cols-2 gap-4 text-gray-700">
                <div><strong>Order Number:</strong> {{ $order_details->order_number }}</div>
                <div><strong>Customer Name:</strong> {{ $customer_name }}</div>
                <div><strong>Status:</strong> {{ $order_details->status }}</div>
                <div><strong>Order Date:</strong> {{ $order_details->created_at->format('Y-m-d') }}</div>
                <div><strong>Payment Method:</strong> {{ $order_details->payment_method }}</div>
                <div><strong>Payment Status:</strong> {{ $order_details->payment_status }}</div>
                <div class="col-span-2">
                    <strong>Shipping Address:</strong> {{ $order_details->shipping_address }}
                </div>
            </div>
        </div>

        {{-- Products Table --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Products</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 border-b">Image</th>
                            <th class="p-3 border-b">Product</th>
                            <th class="p-3 border-b">Quantity</th>
                            <th class="p-3 border-b">Price</th>
                            <th class="p-3 border-b">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $total_price = 0;
                    @endphp
                    @foreach ($order_products as $product)
                        <tr class="border-b">
                            <td class="p-3">
                                <img src="https://via.placeholder.com/50" alt="Product 1" class="w-12 h-12 object-cover rounded" />
                            </td>
                            <td class="p-3">{{ $product->product_name }}</td>
                            <td class="p-3">{{ $product->quantity }}</td>
                            <td class="p-3">{{ $product->product_price }} EGP</td>
                            <td class="p-3">{{ $product->total_price }} EGP</td>
                            @php
                                $total_price+= $product->total_price;
                            @endphp
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-4 text-lg font-bold">
                Grand Total: {{ $total_price }} EGP
            </div>
        </div>
    </div>
</div>
@endsection
