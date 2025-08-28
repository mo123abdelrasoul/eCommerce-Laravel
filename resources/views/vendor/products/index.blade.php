@extends('layouts.app')

@section('title', 'Vendor Products')

@section('content')
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
    <!--begin::App Content Header-->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('products.create', ['lang' => app()->getLocale()]) }}" class="btn btn-success">
            Create Product
        </a>
    </div>
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Products</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <!-- /.card -->
                    <div class="card mb-12">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    @if ($products->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Products found.</p>
                                    @else
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>price</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Sku</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                    alt="{{ $product->name }}" class="img-fluid"
                                                    style="width: 50px; height: 35px; object-fit: cover; border-radius: 4px;">
                                            </td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                            <td>
                                                @if ($product->tags == null)
                                                    N/A
                                                @else
                                                    {{ implode(', ', json_decode($product->tags)) }}
                                                @endif
                                            </td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->status ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="{{ route('products.show', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                    class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('products.edit', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <form
                                                    action="{{ route('products.destroy', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection
