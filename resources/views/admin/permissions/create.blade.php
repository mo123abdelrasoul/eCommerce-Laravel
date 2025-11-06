@extends('admin.layouts.app')
@section('title', 'Add Permission')

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
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Add Permission</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.permissions.index', app()->getLocale()) }}">Permissions</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Permission</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.permissions.store', app()->getLocale()) }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Permission Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Permission Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Guard Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guard Name</label>
                                <select name="guard_name" class="form-select" required>
                                    <option value="">-- Select Guard --</option>
                                    @foreach ($guards as $guard)
                                        <option value="{{ $guard }}"
                                            {{ old('guard_name') == $guard ? 'selected' : '' }}>
                                            {{ ucfirst($guard) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('guard_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Save Permission
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
