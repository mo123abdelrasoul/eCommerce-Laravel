@extends('admin.layouts.app')
@section('title', 'Edit Admin Profile')

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

    <div class="dashboard-container flex min-h-screen">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit {{ $admin->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.admins.index', app()->getLocale()) }}">Admins</a></li>
                            <li class="breadcrumb-item active">{{ $admin->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <div class="card card-info card-outline mb-4">
            <form action="{{ route('admin.admins.update', ['lang' => app()->getLocale(), 'admin' => $admin->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                class="form-control" id="name" required>
                            @error('name')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                class="form-control" id="email" required>
                            @error('email')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="input-group mb-3 ">
                            <input type="password" name="password" autocomplete="new-password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password (leave blank to keep current)">
                            <div class="input-group-text">
                                <span class="bi bi-lock-fill"></span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-info" type="submit">Update Admin</button>
                </div>
            </form>
        </div>
    </div>
@endsection
