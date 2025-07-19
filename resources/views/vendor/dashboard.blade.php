@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')
<div class="dashboard-container flex min-h-screen">
    @include('vendor.layouts.Sidebar')

    <main class="content flex-1 p-4 bg-gray-100">
        <header class="mb-4">
            <h1 class="text-2xl font-bold">Welcome Mohamed</h1>
        </header>

        <section class="grid grid-cols-3 gap-4 mb-4">
            <div class="p-4 bg-blue-500 text-white rounded-lg shadow">Total Sales: <span class="font-bold">{{ $total_orders }} EGP</span></div>
            <div class="p-4 bg-green-500 text-white rounded-lg shadow">Orders: <span class="font-bold">{{ $ordersCount }}</span></div>
            <div class="p-4 bg-yellow-500 text-white rounded-lg shadow">Products: <span class="font-bold">{{ $productsCount }}</span></div>
        </section>
        <section class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
            <table class="w-full border-collapse border border-gray-300">
            @if ($orders->isEmpty())
                <p>No orders found.</p>
            @else
            @endif
                <tr class="bg-gray-100">
                    <th class="border p-2">Order ID</th>
                    <th class="border p-2">Customer</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Total</th>
                </tr>
            @foreach ($orders as $order)
                <tr>
                    <td class="border p-2">{{ $order->id }}</td>
                    <td class="border p-2">{{ $order->customer->name }}</td>
                    <td class="border p-2 text-green-600">{{ $order->status }}</td>
                    <td class="border p-2">{{ $order->total_amount }}</td>
                </tr>
            @endforeach

            </table>
        </section>
    </main>
</div>
@endsection
