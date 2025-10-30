@extends('admin.layouts.app')
@section('title', 'Create Region')

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
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Create New Region</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.regions.index', app()->getLocale()) }}">Regions</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ 'Create' }}</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--begin::Form Validation-->
        <div class="card card-info card-outline mb-4">
            <!--begin::Form-->
            <form form action="{{ route('admin.regions.store', app()->getLocale()) }}" method="POST"
                enctype="multipart/form-data" class="needs-validation">
                @csrf
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="row g-3">
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                id="name" required />
                            @error('name')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" value="{{ old('description') }}" class="form-control"
                                id="description" />
                            @error('description')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6 mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" id="is_active" class="form-select" required>
                                <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>
                                    Disabled</option>
                            </select>
                            @error('is_active')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button class="btn btn-info" type="submit">Create region</button>
                    </div>
                    <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Form Validation-->
    </div>
@endsection
