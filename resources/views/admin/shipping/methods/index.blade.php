@extends('admin.layouts.app')

@section('title', 'Admin Shipping Methods')

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
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Shipping Methods</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard', ['lang' => app()->getLocale()]) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Shipping Methods</li>
                    </ol>
                </div>
            </div>
        </div>
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
                            <form action="{{ route('admin.regions.index', ['lang' => app()->getLocale()]) }}" method="GET"
                                class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search regions by name..." style="width: 300px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                            <a href="{{ route('admin.methods.create', ['lang' => app()->getLocale()]) }}"
                                class="btn btn-success">Add Shipping Method</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped text-center">
                                <thead>
                                    @if ($shipping_methods->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Shipping Methods found.</p>
                                    @else
                                        <tr>
                                            <th>#</th>
                                            <th>Method</th>
                                            <th>Description</th>
                                            <th>Delivery time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shipping_methods as $method)
                                        <tr>
                                            <td>{{ $shipping_methods->firstItem() + $loop->index }}</td>
                                            <td>{{ $method->name }}</td>
                                            <td>{{ $method->description ?? 'N/A' }}</td>
                                            <td>{{ $method->delivery_time }}</td>
                                            <td>
                                                @if ($method->is_active == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.methods.edit', ['lang' => app()->getLocale(), 'method' => $method->id]) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form
                                                    action="{{ route('admin.methods.destroy', ['lang' => app()->getLocale(), 'method' => $method->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this method?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination-container d-flex justify-content-center mt-3">
                                {{ $shipping_methods->appends(request()->query())->links('pagination::bootstrap-5') }}
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
