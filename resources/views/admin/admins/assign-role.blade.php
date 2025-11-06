@extends('admin.layouts.app')
@section('title', 'Assign Role to Admin')

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
                        <h3>Assign Role to: {{ $admin->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.admins.index', app()->getLocale()) }}">Admins</a></li>
                            <li class="breadcrumb-item active">Assign Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <div class="card card-info card-outline mb-4">
            <form action="{{ route('admin.admins.assignRole', ['lang' => app()->getLocale(), 'admin' => $admin->id]) }}"
                method="POST">
                @csrf
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="role" class="form-label">Select Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $admin->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Assign Role</button>
                </div>
            </form>
        </div>
    </div>
@endsection
