@extends('layouts.app')
@section('title','Orders')

@section('content')
<div class="dashboard-container flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    @include('vendor.layouts.Sidebar')

    {{-- Main Content --}}
    <div class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Orders</h1>
        </div>

        {{-- Orders Table --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-200 text-xs uppercase text-gray-600">
                @if ($orders->isEmpty())
                    <p>No orders found.</p>
                @else
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Order Number</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Method</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Order Date</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                    @foreach ($orders as $order)
                    <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $order->order_number }}</td>
                        <td class="px-6 py-4">{{ $order->customer->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-white text-xs bg-green-500">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $order->payment_method }}</td>
                        <td class="px-6 py-4">{{ $order->total_amount }}</td>
                        <td class="px-6 py-4">{{ $order->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-4">
                                <a href="{{ route('order.show',['id' => $order->id,'lang' => app()->getLocale()]) }}" class="text-blue-500 hover:underline">View</a>
                                <a href="{{ route('order.edit',['id' => $order->id,'lang' => app()->getLocale()]) }}" class="text-yellow-500 hover:underline">Edit</a>
                                <form
                                    action="{{ route('order.destroy',['id' => $order->id , 'lang' => app()->getLocale()]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this order?');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline bg-transparent border-0 cursor-pointer p-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    @endforeach
                @endif
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
