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
                        <li class="breadcrumb-item"><a
                                href="{{ route('vendor.dashboard', ['lang' => app()->getLocale()]) }}">Home</a></li>
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
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3">
                            <form action="{{ route('vendor.brands.index', ['lang' => app()->getLocale()]) }}" method="GET"
                                class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search brands by name..." style="width: 300px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped text-center">
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
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $brands->firstItem() + $loop->index }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                                    class="img-fluid"
                                                    style="width: 50px; height: 35px; object-fit: cover; border-radius: 4px;">
                                            </td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->description ?? 'N/A' }}</td>
                                            <td>
                                                @if ($brand->status)
                                                    <span class="badge bg-success">{{ 'Active' }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ 'Disabled' }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination-container d-flex justify-content-center mt-3">
                                {{ $brands->links('pagination::bootstrap-5') }}
                            </div>
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
