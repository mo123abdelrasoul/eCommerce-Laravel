@extends('admin.layouts.app')

@section('title', 'Edit Shipping Method')

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
                        <h3 class="mb-0">Edit Shipping Method: {{ $shipping_method->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.methods.index', ['lang' => app()->getLocale()]) }}">Shpping
                                    Methods</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $shipping_method->name }}</li>
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
            <form form
                action="{{ route('admin.methods.update', ['lang' => app()->getLocale(), 'method' => $shipping_method->id]) }}"
                method="POST" enctype="multipart/form-data" class="needs-validation">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="row g-3">
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $shipping_method->name ?? '') }}"
                                class="form-control" id="name" required />
                            @error('name')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" value="{{ old('description', $shipping_method->description ?? '') }}"
                                name="description" id="description" class="form-control" />
                            @error('description')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="delivery_time" class="form-label">Delivery time</label>
                            <input type="number" value="{{ old('delivery_time', $shipping_method->delivery_time) }}"
                                name="delivery_time" id="delivery_time" class="form-control" required />
                            @error('delivery_time')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" name="is_active" id="is_active">
                                <option value="1"
                                    {{ old('is_active', $shipping_method->is_active ?? 1) == 1 ? 'selected' : '' }}>Active
                                </option>
                                <option value="0"
                                    {{ old('is_active', $shipping_method->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                    Disabled
                                </option>
                            </select>
                            @error('is_active')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer">
                    <button class="btn btn-info" type="submit">Update Method</button>
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Form Validation-->
    </div>
@endsection
