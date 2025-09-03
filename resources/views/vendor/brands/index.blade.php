@extends('vendor.layouts.app')

@section('title', 'Brands')

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
        <a href="{{ route('brands.create', ['lang' => app()->getLocale()]) }}" class="btn btn-success">
            Create Brand
        </a>
    </div>
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Brands</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Brands</li>
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
                            <h3 class="card-title">Brands</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    @if ($brands->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Brands found.</p>
                                    @else
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Image</th>
                                            <th>Brand</th>
                                            <th>Describtion</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                                    class="img-fluid"
                                                    style="width: 50px; height: 35px; object-fit: cover; border-radius: 4px;">
                                            </td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->description }}</td>
                                            <td>{{ $brand->status ? 'Active' : 'Inactive' }} </td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('brands.edit', ['brand' => $brand->id, 'lang' => app()->getLocale()]) }}">
                                                    Edit
                                                </a>
                                                <form
                                                    action="{{ route('brands.destroy', ['brand' => $brand->id, 'lang' => app()->getLocale()]) }}"
                                                    method="POST" onsubmit="return confirm('Delete this brand?')"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">
                                                        Delete
                                                    </button>
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
