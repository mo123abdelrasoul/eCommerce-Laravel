@extends('vendor.layouts.app')

@section('title', 'Vendor Products')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Products</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('vendor.dashboard', ['lang' => app()->getLocale()]) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-12">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3">
                            <form action="{{ route('vendor.products.index', ['lang' => app()->getLocale()]) }}"
                                method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search products by name..." style="width: 300px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                            <a href="{{ route('vendor.products.create', ['lang' => app()->getLocale()]) }}"
                                class="btn btn-success">Create Product</a>
                        </div>
                        <div class="card-body p-0">
                            @if ($products->isEmpty())
                                <p style="padding: 15px;">No Products found.</p>
                            @else
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>SKU</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $products->firstItem() + $loop->index }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}" class="img-fluid"
                                                        style="width: 50px; height: 35px; object-fit: cover; border-radius: 4px;">
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->category?->name ?? 'N/A' }}</td>
                                                <td>
                                                    {{ $product->tags ? implode(', ', json_decode($product->tags)) : 'N/A' }}
                                                </td>
                                                <td>{{ $product->sku }}</td>
                                                <td>
                                                    @switch($product->status)
                                                        @case('approved')
                                                            <span class="badge bg-success">{{ $product->status }}</span>
                                                        @break

                                                        @case('pending')
                                                            <span class="badge bg-warning">{{ $product->status }}</span>
                                                        @break

                                                        @case('rejected')
                                                            <span class="badge bg-danger">{{ $product->status }}</span>
                                                        @break

                                                        @default
                                                            <span class="badge bg-warning">{{ $product->status }}</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <a href="{{ route('vendor.products.show', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                        class="btn btn-info btn-sm">View</a>
                                                    <a href="{{ route('vendor.products.edit', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form
                                                        action="{{ route('vendor.products.destroy', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-container d-flex justify-content-center mt-3">
                                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
