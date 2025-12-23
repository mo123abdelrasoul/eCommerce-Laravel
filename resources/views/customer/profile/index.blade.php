@extends('customer.layouts.app')

@section('title', 'My Profile - Mstore24')

@section('content')
    <div class="bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- User Info Sidebar -->
                <aside class="w-full md:w-1/3 lg:w-1/4">
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <div class="w-28 h-28 rounded-full mx-auto mb-4 overflow-hidden">
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                class="w-full h-full object-cover">
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-500 mb-4">{{ $user->email }}</p>

                        <div class="border-t pt-4 mt-4 text-left">
                            <h3 class="font-semibold text-gray-900 mb-2">{{ __('account_details') }}</h3>
                            <p class="text-sm text-gray-600 mb-1"><strong>{{ __('phone') }}:</strong>
                                {{ $user->phone ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600"><strong>{{ __('joined') }}:</strong>
                                {{ $user->created_at->format('M d, Y') }}</p>
                        </div>

                        <form action="{{ route('user.logout.submit', app()->getLocale()) }}" method="POST" class="mt-6">
                            @csrf
                            <button type="submit" class="w-full btn-secondary text-red-500 border-red-200 hover:bg-red-50">
                                {{ __('logout') }}
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Orders Section -->
                <div class="w-full md:w-2/3 lg:w-3/4">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">{{ __('my_orders') }}</h2>

                        @if (!empty($orders) && $orders->count() > 0)
                            <div class="space-y-6">
                                @foreach ($orders as $order)
                                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                                        <div
                                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                                            <div>
                                                <h3 class="font-bold text-lg text-gray-900">{{ __('order') }}
                                                    #{{ $order->id }}</h3>
                                                <p class="text-sm text-gray-500">{{ __('placed_on') }}
                                                    {{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div class="mt-2 sm:mt-0 text-right">
                                                <span
                                                    class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                                    {{ $order->status == 'completed'
                                                        ? 'bg-green-100 text-green-800'
                                                        : ($order->status == 'pending'
                                                            ? 'bg-yellow-100 text-yellow-800'
                                                            : 'bg-gray-100 text-gray-800') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                                <p class="font-bold text-gray-900 mt-1">
                                                    {{ format_currency($order->total_amount) }}</p>
                                            </div>
                                        </div>

                                        <!-- Order Items Preview -->
                                        <div class="text-sm text-gray-600">
                                            {{ $order->items_count ?? ($order->products?->count() ?? 0) }}
                                            {{ __('items') }} </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('no_orders_yet') }}</h3>
                                <p class="text-gray-500 mt-2">{{ __('go_shop_first_order') }}</p>
                                <a href="{{ url(app()->getLocale() . '/shop') }}"
                                    class="btn-primary mt-4 inline-block">{{ __('start_shopping') }}</a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
