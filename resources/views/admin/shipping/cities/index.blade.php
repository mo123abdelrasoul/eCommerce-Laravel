@extends('admin.layouts.app')

@section('title', 'Admin Cities')

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
                    <h3 class="mb-0">Cities</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard', ['lang' => app()->getLocale()]) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cities</li>
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
                            <form action="{{ route('admin.cities.index', ['lang' => app()->getLocale()]) }}" method="GET"
                                class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search cities by name..." style="width: 300px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                            <a href="{{ route('admin.cities.create', ['lang' => app()->getLocale()]) }}"
                                class="btn btn-success">Add City</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped text-center">
                                <thead>
                                    @if ($cities->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Cities found.</p>
                                    @else
                                        <tr>
                                            <th>#</th>
                                            <th>City</th>
                                            <th>Region</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cities as $city)
                                        <tr>
                                            <td>{{ $cities->firstItem() + $loop->index }}</td>
                                            <td>{{ $city->name }}</td>
                                            <td>{{ $city->region->name ?? 'N/A' }}</td>
                                            <td>
                                                @if ($city->is_active == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.cities.edit', ['lang' => app()->getLocale(), 'city' => $city->id]) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form
                                                    action="{{ route('admin.cities.destroy', ['lang' => app()->getLocale(), 'city' => $city->id]) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this city?');">
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
                            <div class="pagination-container d-flex justify-content-center mt-3">
                                {{ $cities->appends(request()->query())->links('pagination::bootstrap-5') }}
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
