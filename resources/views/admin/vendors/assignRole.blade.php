@extends('admin.layouts.app')
@section('title', 'Assign Role to Vendor')

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
                        <h3 class="mb-0">Assign Role to: {{ $vendor->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.vendors.show', ['lang' => app()->getLocale(), 'vendor' => $vendor->id]) }}">Profile</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Assign Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Form Card-->
        <div class="card card-info card-outline mb-4">
            <form action="{{ route('admin.vendors.assignRole', [app()->getLocale(), $vendor->id]) }}" method="POST"
                class="needs-validation">
                @csrf
                <div class="card-body">
                    <div class="row g-3">
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label class="form-label">Select Role</label>
                            <select name="role" class="form-select" required>
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $vendor->hasRole($role->name, $role->guard_name) ? 'selected' : '' }}>
                                        {{ $role->name }} ({{ $role->guard_name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                </div>

                <!--begin::Footer-->
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-check-circle"></i> Assign Role
                    </button>
                </div>
            </form>
        </div>
        <!--end::Form Card-->
    </div>
@endsection
