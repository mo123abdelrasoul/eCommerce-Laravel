<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
    <form id="shop-filter-form" action="{{ url()->current() }}" method="GET">
        <!-- Search -->
        <div class="mb-6">
            <h3 class="font-bold text-gray-900 mb-3">{{ __('search') }}</h3>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('search_products') }}" class="form-input px-3 py-2 border rounded w-full">
        </div>

        <!-- Categories -->
        <div class="mb-6">
            <h3 class="font-bold text-gray-900 mb-3">{{ __('categories') }}</h3>
            <div class="space-y-2 max-h-60 overflow-y-auto">
                @if(isset($categories))
                    @foreach($categories as $category)
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="category[]" value="{{ $category->id }}" 
                                {{ in_array($category->id, (array)request('category')) ? 'checked' : '' }}
                                class="rounded text-primary focus:ring-primary">
                            <span class="text-gray-700">{{ $category->name }}</span>
                        </label>
                    @endforeach
                @else
                    <p class="text-gray-500 text-sm">{{ __('no_categories_available') }}</p>
                @endif
            </div>
        </div>

        <!-- Price Range -->
        <div class="mb-6">
            <h3 class="font-bold text-gray-900 mb-3">{{ __('price_range') }}</h3>
            <div class="flex items-center space-x-2 mb-2">
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="{{ __('min') }}" class="w-1/2 px-3 py-2 border rounded form-input">
                <span class="text-gray-500">-</span>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ __('max') }}" class="w-1/2 px-3 py-2 border rounded form-input">
            </div>
            <input type="range" id="price-range" min="0" max="1000" step="10" class="w-full">
            <div class="text-xs text-gray-500 mt-1">{{ __('adjust_to_filter') }}</div>
        </div>

        <!-- Sort -->
        <div class="mb-6">
            <h3 class="font-bold text-gray-900 mb-3">{{ __('sort_by') }}</h3>
            <select name="sort" class="w-full px-3 py-2 border rounded form-input" onchange="this.form.submit()">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('newest_arrivals') }}</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('price_low_to_high') }}</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('price_high_to_low') }}</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ __('name_a_to_z') }}</option>
            </select>
        </div>

        <button type="submit" class="w-full btn-primary">{{ __('apply_filters') }}</button>
        
        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
            <a href="{{ url()->current() }}" class="block text-center mt-3 text-sm text-gray-500 hover:text-primary">{{ __('clear_filters') }}</a>
        @endif
    </form>
</div>
