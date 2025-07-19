@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="dashboard-container flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    @include('vendor.layouts.Sidebar')

    {{-- Main Content --}}
    <div class="flex-1 p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit: {{ $product->name }}</h2>

            <form action="{{ route('product.update', ['id'=> $product->id,'lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Vendor ID -->
                <input type="text" hidden name="vendor" value="{{$product->vendor_id}}" class="w-full mt-1 border border-gray-300 rounded px-4 py-2">
                <!-- Name -->
                <div>
                    <label class="block text-gray-700">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full mt-1 border border-gray-300 rounded px-4 py-2">
                </div>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Description -->
                <div>
                    <label class="block text-gray-700">Description</label>
                    <textarea name="description" rows="4" class="w-full mt-1 border border-gray-300 rounded px-4 py-2">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <!-- Image Upload + Preview -->
                <div>
                    <label class="block text-gray-700">Product Image</label>
                    <input type="file" name="image" accept="image/*" onchange="previewImage(event)" class="mt-1">
                    <div class="mt-3">
                        <img id="imagePreview" src="{{ asset('storage/' . $product->image) ?? '' }}" alt="Image Preview" class="w-40 h-40 object-cover border mt-2 {{ isset($product->image) ? '' : 'hidden' }}">
                    </div>
                </div>
                @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Price -->
                <div>
                    <label class="block text-gray-700">Price ($)</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price', $product->price ?? '') }}" class="w-full mt-1 border border-gray-300 rounded px-4 py-2">
                </div>
                @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Quantity -->
                <div>
                    <label class="block text-gray-700">Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $product->quantity ?? '') }}" class="w-full mt-1 border border-gray-300 rounded px-4 py-2">
                </div>
                @error('quantity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Category ID -->
                <div>
                    <label class="block font-medium mb-1">Category</label>
                    <select name="category_id" class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- SKU -->
                <div>
                    <label class="block text-gray-700">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full mt-1 border border-gray-300 rounded px-4 py-2">
                </div>
                @error('sku')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Discount -->
                <div>
                    <label class="block text-gray-700">Discount (%)</label>
                    <input type="number" name="discount" value="{{ old('discount', $product->discount ?? '') }}" class="w-full mt-1 border border-gray-300 rounded px-4 py-2">
                </div>
                @error('discount')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Status -->
                <div>
                    <label class="block text-gray-700">Status</label>
                    <select name="status" class="w-full mt-1 border border-gray-300 rounded px-4 py-2">
                        <option value="active" {{ old('status', $product->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $product->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Tags -->
                <div>
                    @php
                        $tags = json_decode($product->tags,true);
                        $tagsString = is_array($tags) ? implode(',' , $tags) : '';
                    @endphp
                    <label class="block text-gray-700">Tags</label>

                    <input type="text" name="tags" id="tags"
                        value="{{ old('tags', $tagsString) }}"
                        class="w-full mt-1 border border-gray-300 rounded px-4 py-2"
                        required>
                </div>
                @error('tags')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Out of Stock -->
                <div>
                    <label class="block text-gray-700">Out of Stock</label>
                    <select name="out_of_stock" class="w-full mt-1 border border-gray-300 rounded px-4 py-2">
                        <option value="0" {{ old('out_of_stock', $product->out_of_stock ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('out_of_stock', $product->out_of_stock ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                @error('out_of_stock')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <!-- Submit -->
                <div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
