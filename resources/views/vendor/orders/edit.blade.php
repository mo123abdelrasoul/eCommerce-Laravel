@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')
    <div class="dashboard-container flex min-h-screen bg-gray-100">
        @include('vendor.layouts.Sidebar')

        <div class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-6">Edit Order</h1>

            <form action="{{ route('order.update', ['id' => $order->id, 'lang' => app()->getLocale()]) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="bg-red-100 text-red-800 p-4 mb-4 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- Error Message --}}
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                {{-- Success Message --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                {{-- Status --}}
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="status" id="status"
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
                        @foreach (config('order.status') as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $order->status ?? '') === $value ? 'selected' : ''}}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Method --}}
                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700 font-medium mb-2">Payment Method</label>
                    <select name="payment_method" id="payment_method"
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
                        @foreach (config('order.payment_method') as $value => $label)
                            <option value="{{ $value }}" {{ old('payment_method', $order->payment_method ?? '') === $value ? 'selected' : ''}}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Shipping Cost --}}
                <div class="mb-4">
                    <label for="shipping_cost" class="block text-gray-700 font-medium mb-2">Shipping Cost</label>
                    <input type="text" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost', $order->shipping_cost ?? '') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
                </div>

                {{-- Shipping Address --}}
                <div class="mb-4">
                    <label for="shipping_address" class="block text-gray-700 font-medium mb-2">Shipping Address</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3"
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">{{ old('shipping_address', $order->shipping_address ?? '') }}</textarea>
                </div>

                {{-- Notes --}}
                <div class="mb-4">
                    <label for="notes" class="block text-gray-700 font-medium mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">{{ old('notes', $order->notes ?? '') }}</textarea>
                </div>

                {{-- Submit Button --}}
                <div class="mt-6">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                        Update Order
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
