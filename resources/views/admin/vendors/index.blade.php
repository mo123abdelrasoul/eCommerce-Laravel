@extends('admin.layouts.app')

@section('title', 'Admin Vendors')

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
                    <h3 class="mb-0">Vendors</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vendors</li>
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
                            <h3 class="card-title">Vendors</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    @if ($vendors->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Vendors found.</p>
                                    @else
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Phone</th>
                                            <th>Company</th>
                                            <th>Registration ID</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendors as $vendor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vendor->name }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $vendor->avatar) }}"
                                                    alt="{{ $vendor->name }}" class="img-fluid"
                                                    style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                            </td>
                                            <td>{{ $vendor->phone ?? 'N/A' }}</td>
                                            <td>{{ $vendor->company ?? 'N/A' }}</td>
                                            <td>{{ $vendor->registration_id }}</td>
                                            <td>{{ ucfirst($vendor->status) }}</td>
                                            <td>
                                                <a href="{{ route('admin.vendors.show', ['lang' => app()->getLocale(), 'vendor' => $vendor->id]) }}"
                                                    class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('admin.vendors.edit', ['lang' => app()->getLocale(), 'vendor' => $vendor->id]) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <form
                                                    action="{{ route('admin.vendors.destroy', ['lang' => app()->getLocale(), 'vendor' => $vendor->id]) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this vendor?');">
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
