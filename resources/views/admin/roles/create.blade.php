@extends('admin.layouts.app')
@section('title', 'Create Role')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Add Role</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.roles.index', app()->getLocale()) }}">Roles</a>
                        </li>
                        <li class="breadcrumb-item active">Add Role</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('admin.roles.store', app()->getLocale()) }}" method="POST">
                        @csrf

                        <div class="row">

                            <!-- Role Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Guard Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guard Name</label>
                                <select name="guard_name" id="guard_name" class="form-select" required>
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

                        <!-- Permissions (Hidden by default) -->
                        <div id="permissions_section" class="col-12" style="display:none;">
                            <label class="form-label">Assign Permissions</label>
                            @foreach ($permissions as $guard => $group)
                                <div class="permissions-group" data-guard="{{ $guard }}" style="display:none;">
                                    <div class="row mt-2">
                                        @foreach ($group as $permission)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @error('permissions')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        @error('permissions')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Save Role
                            </button>
                        </div>

                </div>


                </form>

            </div>
        </div>
    </div>
    </div>
@endsection
