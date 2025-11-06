@extends('admin.layouts.app')
@section('title', 'Permissions')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="dashboard-container flex min-h-screen">

        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Permissions</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Permissions</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content Header-->

        <div class="app-content">
            <div class="container-fluid">

                <div class="card card-info card-outline mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3">
                        <form action="{{ route('admin.permissions.index', ['lang' => app()->getLocale()]) }}" method="GET"
                            class="d-flex">
                            <input type="text" name="search" class="form-control me-2"
                                placeholder="Search permissions by name..." style="width: 250px;"
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>

                        <a href="{{ route('admin.permissions.create', app()->getLocale()) }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Add Permission
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped text-center">
                            <thead>
                                @if ($permissions->isEmpty())
                                    <p style="padding: 15px;">No permissions found.</p>
                                @else
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Guard</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                @endif
                            </thead>

                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permissions->firstItem() + $loop->index }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                        <td>{{ $permission->created_at?->format('Y-m-d') ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.permissions.edit', ['lang' => app()->getLocale(), 'permission' => $permission->id]) }}"
                                                class="btn btn-warning btn-sm">Edit</a>

                                            <form
                                                action="{{ route('admin.permissions.destroy', ['lang' => app()->getLocale(), 'permission' => $permission->id]) }}"
                                                method="POST" style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure you want to delete this permission?');">
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
                            {{ $permissions->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
