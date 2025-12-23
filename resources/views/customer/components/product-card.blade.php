@props(['product'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
    <div class="relative aspect-w-1 aspect-h-1 bg-gray-200">
        <a href="{{ route('product.show', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
            <img src="{{ asset($product->image ? 'storage/' . $product->image : 'assets/images/default-150x150.png') }}"
                alt="{{ $product->name }}"
                class="w-full h-48 object-cover object-center group-hover:opacity-75 transition">
        </a>
    </div>
    <div class="p-4">
        <a href="{{ route('product.show', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
            class="text-decoration-none">
            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
        </a>
        <p class="mt-1 text-sm text-gray-500 truncate">
            {{ Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 100) }}</p>
        <div class="mt-2 flex items-center justify-between">
            <span class="text-xl font-bold text-primary">{{ format_currency($product->price) }}</span>
            @if ($product->old_price)
                <span class="text-sm text-gray-400 line-through">{{ format_currency($product->old_price) }}</span>
            @endif
        </div>
        <div class="mt-4">
            <button class="add-to-cart-btn btn-primary w-full flex items-center justify-center space-x-2"
                data-product-id="{{ $product->id }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                {{ __('add_to_cart') }}
            </button>
        </div>
    </div>
</div>
