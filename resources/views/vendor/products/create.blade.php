@extends('layouts.app')

@section('title', 'Vendor Products')

@section('content')
<div class="dashboard-container flex min-h-screen">
@include('vendor.layouts.Sidebar')

<main class="content flex-1 p-8 bg-gray-100">
    <header class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Add New Product</h1>
        <a href="{{ route('DashboardProductsPage') }}" class="text-blue-600 hover:underline">← Back to Products</a>
    </header>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <form action="{{ route('product.store',app()->getLocale()) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative">
                <label class="block font-semibold mb-1">Image</label>
                <input type="file" name="image" id="imageInput" class="w-full border rounded px-3 py-2" accept="image/*">
                @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div class="mt-2 relative inline-block">
                    <img id="imagePreview" src="#" alt="Image Preview" class="w-40 h-40 object-cover rounded cursor-pointer hidden">

                    <!-- زر حذف الصورة -->
                    <button type="button" id="removeImageBtn"
                        class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 hidden"
                        title="Remove image">
                        ×
                    </button>
                </div>
            </div>
            <!-- Popup for image preview -->
            <div id="imagePopup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
                <div class="relative">
                    <button id="closePopup" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700">×</button>
                    <img id="popupImage" src="#" alt="Popup Image" class="max-w-full max-h-full object-contain">
                </div>
            </div>
            <div>
                <label class="block font-semibold mb-1">Price</label>
                <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" required>
                @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Quantity</label>
                <input type="number" name="quantity" class="w-full border rounded px-3 py-2" required>
                @error('quantity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2" required>
                    <option value="" disabled selected>Select a category</option>
                    @foreach($cats as $cat)
                        {
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        }
                    @endforeach
                    @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">SKU</label>
                <input type="text" name="sku" class="w-full border rounded px-3 py-2" required>
                @error('sku')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Discount (%)</label>
                <input type="number" step="0.01" name="discount" class="w-full border rounded px-3 py-2" required>
                @error('discount')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block font-semibold mb-1">Vendor</label>
                <select name="vendor_id" class="w-full border rounded px-3 py-2" required>
                    <option value="" disabled selected>Select a vendor</option>
                    @foreach ($vendors as $vendor) {
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    }
                    @endforeach
                </select>
                @error('vendor_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Out of Stock</label>
                <select name="out_of_stock" class="w-full border rounded px-3 py-2" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
                @error('out_of_stock')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block font-semibold mb-1">Tags (comma separated)</label>
            <input type="text" name="tags" class="w-full border rounded px-3 py-2">
            @error('tags')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded px-3 py-2" required></textarea>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Create Product</button>
        </div>
    </form>

</main>

</div>
@endsection
