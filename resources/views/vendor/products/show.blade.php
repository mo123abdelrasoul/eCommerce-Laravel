@extends('vendor.layouts.app')
@section('title', 'Product Details')
@section('content')
    <!--begin::App Content Header-->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('vendor.products.create', ['lang' => app()->getLocale()]) }}" class="btn btn-success">
            Create Product
        </a>
    </div>
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Product: <small>{{ $product->name }}</small></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a
                                href="{{ route('vendor.dashboard', ['lang' => app()->getLocale()]) }}">Home</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('vendor.products.index', app()->getLocale()) }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>

                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <div class="content-wrapper">
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Overview</h3>
                    <div class="card-tools">
                        <a href="{{ route('vendor.products.edit', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                            class="btn btn-primary btn-sm">Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid"
                                alt="{{ $product->name }}">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered text-center">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $product->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>{{ $product->price ?? '' }} EGP</td>
                                    </tr>
                                    <tr>
                                        <th>Stock</th>
                                        <td>{{ $product->quantity ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ $product->category->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $product->description ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>SKU</th>
                                        <td>{{ $product->sku }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($product->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td>{{ $product->discount }}%</td>
                                    </tr>
                                    <tr>
                                        <th>Views</th>
                                        <td>{{ $product->views }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rating</th>
                                        <td>{{ number_format($product->rating, 1) }} / 5</td>
                                    </tr>
                                    <tr>
                                        <th>Tags</th>
                                        <td>
                                            @if ($product->tags)
                                                {{ implode(', ', json_decode($product->tags)) }}
                                            @else
                                                <em>No tags</em>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
