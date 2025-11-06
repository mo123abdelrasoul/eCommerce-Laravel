@extends('admin.layouts.app')
@section('title', 'Edit Permission')

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

        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Permission: {{ $permission->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.permissions.index', app()->getLocale()) }}">Permissions</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $permission->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-info card-outline mb-4">

            <form
                action="{{ route('admin.permissions.update', ['lang' => app()->getLocale(), 'permission' => $permission->id]) }}"
                method="POST" class="needs-validation">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Permission Name</label>
                            <input type="text" name="name" value="{{ old('name', $permission->name) }}"
                                class="form-control" required>
                            @error('name')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Guard Name</label>

                            {{-- لو guard واحد فقط مثلاً admin خلي دي hidden --}}
                            {{-- <input type="hidden" name="guard_name" value="admin"> --}}

                            <select name="guard_name" class="form-select">
                                @foreach ($guards as $guard)
                                    <option value="{{ $guard }}"
                                        {{ old('guard_name', $permission->guard_name) == $guard ? 'selected' : '' }}>
                                        {{ $guard }}
                                    </option>
                                @endforeach
                            </select>

                            @error('guard_name')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-info" type="submit">
                        Update Permission
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
