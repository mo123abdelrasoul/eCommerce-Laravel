@extends('customer.layouts.app')
@section('title', $product->name)
@section('content')

    <div class="container mx-auto px-4 pt-24 pb-10">

        @if (isset($available) && !$available)
            <div class="mb-6 rounded-2xl border border-yellow-300 bg-yellow-50 p-4 text-sm text-yellow-800 overflow-hidden">
                {{ __('This product is not available for public view.') }}
            </div>
        @endif

        {{-- Product Main Section --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 mt-8 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

                {{-- Image (Left) --}}
                <div class="w-full overflow-hidden rounded-2xl">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-[300px] md:h-[350px] lg:h-[380px] object-cover">
                </div>

                {{-- Content (Right) --}}
                <div class="space-y-4">

                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $product->name }}
                    </h1>

                    <div class="flex items-center gap-3">
                        <span class="text-2xl font-extrabold text-primary">
                            {{ format_currency($product->price) }}
                        </span>

                        @if ($product->discount)
                            <span class="text-sm text-gray-400 line-through">
                                {{ format_currency($product->price + ($product->price * $product->discount) / 100) }}
                            </span>
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">
                                -{{ $product->discount }}%
                            </span>
                        @endif
                    </div>

                    <p class="text-sm font-medium {{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->quantity > 0 ? __('In Stock') : __('Out of Stock') }}
                    </p>

                    <p class="text-gray-700 leading-relaxed">
                        {{ $product->description }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button data-product-id="{{ $product->id }}" @if (isset($available) && !$available) disabled @endif
                            class="add-to-cart-btn btn-primary flex-1 py-2 text-lg">
                            {{ __('Add to cart') }}
                        </button>

                        <a href="{{ route('user.cart.index', ['lang' => app()->getLocale()]) }}"
                            class="btn-secondary flex-1 py-2 text-center text-lg">
                            {{ __('View Cart') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- Product Details --}}
        <div class="mt-12 bg-white rounded-2xl shadow-sm p-6 overflow-hidden">
            <h3 class="text-lg font-semibold mb-4">
                {{ __('Product Details') }}
            </h3>

            <table class="w-full text-sm">
                <tbody class="divide-y">
                    <tr>
                        <th class="py-3 text-left text-gray-500">{{ __('SKU') }}</th>
                        <td class="py-3 text-right">{{ $product->sku }}</td>
                    </tr>
                    <tr>
                        <th class="py-3 text-left text-gray-500">{{ __('Category') }}</th>
                        <td class="py-3 text-right">{{ $product->category?->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th class="py-3 text-left text-gray-500">{{ __('Weight') }}</th>
                        <td class="py-3 text-right">{{ $product->weight ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Related Products --}}
        @if ($related && $related->count())
            <section class="py-20">
                <h2 class="text-2xl font-bold mb-10">
                    {{ __('Related Products') }}
                </h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($related as $r)
                        <a href="{{ route('product.show', ['lang' => app()->getLocale(), 'product' => $r->id]) }}"
                            class="group bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden">

                            {{-- Image without padding, parent has overflow-hidden & rounded-2xl --}}
                            <img src="{{ asset('storage/' . $r->image) }}" alt="{{ $r->name }}"
                                class="w-full h-40 object-cover group-hover:scale-105 transition">

                            {{-- Text below image with padding --}}
                            <div class="p-4">
                                <div class="text-sm font-semibold text-gray-800 line-clamp-2">
                                    {{ $r->name }}
                                </div>

                                <div class="mt-1 text-primary font-bold">
                                    {{ format_currency($r->price) }}
                                </div>
                            </div>

                        </a>
                    @endforeach
                </div>
            </section>
        @endif

    </div>
@endsection
