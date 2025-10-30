@extends('vendor.layouts.app')

@section('title', 'Categories')

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
                    <h3 class="mb-0">Categories</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a
                                href="{{ route('vendor.dashboard', ['lang' => app()->getLocale()]) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
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
                            <form action="{{ route('vendor.categories.index', ['lang' => app()->getLocale()]) }}"
                                method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search categories by name..." style="width: 300px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped text-center">
                                <thead>
                                    @if ($categories->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Categories found.</p>
                                    @else
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Describtion</th>
                                            <th>Status</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $categories->firstItem() + $loop->index }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $category->image) }}"
                                                    alt="{{ $category->name }}" class="img-fluid"
                                                    style="width: 50px; height: 35px; object-fit: cover; border-radius: 4px;">
                                            </td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->parent ? $category->parent->name : 'N/A' }}</td>
                                            <td>
                                                @if ($category->status)
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
                                {{ $categories->links('pagination::bootstrap-5') }}
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
