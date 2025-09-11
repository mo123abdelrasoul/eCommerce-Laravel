@extends('admin.layouts.app')

@section('title', 'Admin Products')

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                                            <th>Deleted</th>
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
                                            <td>
                                                @if ($product->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif ($product->status === 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif ($product->status === 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product->deleted_at === null)
                                                    <span class="badge bg-success">No</span>
                                                @else
                                                    <span class="badge bg-danger">Yes</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="{{ route('admin.products.show', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                    class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('admin.products.edit', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                @if ($product->deleted_at !== null)
                                                    <form
                                                        action="{{ route('admin.products.restore', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to restore this product?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm">Restore</button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route('admin.products.destroy', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                @endif
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
