@extends('admin.layouts.app')
@section('title', 'Add Admin')

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
                        <h3 class="mb-0">Add Admin</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.admins.index', app()->getLocale()) }}">Admins</a></li>
                            <li class="breadcrumb-item active">Add Admin</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content Header-->

        <!--begin::Form-->
        <div class="card card-info card-outline mb-4">
            <form action="{{ route('admin.admins.store', app()->getLocale()) }}" method="POST" class="needs-validation">
                @csrf
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                            @error('name')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                            @error('email')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" type="submit">Create Admin</button>
                </div>
            </form>
        </div>
        <!--end::Form-->
    </div>
@endsection
