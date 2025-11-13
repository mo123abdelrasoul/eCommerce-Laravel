@extends('admin.layouts.app')
@section('title', 'Edit Role')

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
                    <h3 class="mb-0">Edit Role</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.roles.index', app()->getLocale()) }}">Roles</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.roles.update', ['lang' => app()->getLocale(), 'role' => $role->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Role Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $role->name) }}" required>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Guard Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guard Name</label>
                                <select name="guard_name" id="edit_guard_name" class="form-select" required>
                                    @foreach ($guards as $guard)
                                        <option value="{{ $guard }}"
                                            {{ $role->guard_name == $guard ? 'selected' : '' }}>
                                            {{ ucfirst($guard) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guard_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr>

                            <!-- Permissions -->
                            <div class="mb-3">
                                <label class="form-label">Assign Permissions</label>
                                <div class="row" id="edit-permissions-wrapper">
                                    @error('permissions')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @foreach ($permissions as $permission)
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="permissions[]"
                                                    value="{{ $permission->id }}" id="perm_{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>

                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-info">
                                    <i class="bi bi-check-circle"></i> Update Role
                                </button>
                            </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
<script>
    let getPermissionsUrl =
        "{{ route('admin.roles.getPermissions', ['lang' => app()->getLocale(), 'guard' => ':guard']) }}";
    let rolePermissions = @json($rolePermissions);
</script>
