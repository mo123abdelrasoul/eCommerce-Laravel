@extends('layouts.app')
@section('title', 'Edit Vendor Profile')

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
                        <h3 class="mb-0">Edit {{ $vendor->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vendor.profile.index') }}">Profile</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $vendor->name }}</li>
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
                action="{{ route('vendor.profile.update', ['lang' => app()->getLocale(), 'profile' => $vendor->id]) }}"
                method="POST" enctype="multipart/form-data" class="needs-validation">
                @method('PUT')
                @csrf
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="row g-3">
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $vendor->name ?? '') }}"
                                class="form-control" id="name" required />
                            @error('name')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="price" class="form-label">E-mail</label>
                            <input type="email" value="{{ old('email', $vendor->email ?? '') }}" name="email"
                                id="email" class="form-control" required />
                            @error('email')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="input-group mb-3">
                            <input type="password" name="password" autocomplete="new-password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                            <div class="input-group-text">
                                <span class="bi bi-lock-fill"></span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone', $vendor->phone ?? '') }}"
                                class="form-control" id="phone" />
                            @error('phone')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" name="company" value="{{ old('company', $vendor->company ?? '') }}"
                                class="form-control" id="company" required />
                            @error('company')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 mb-3 col-md-6">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" name="avatar" class="form-control" id="avatar" />
                            @if (!empty($vendor->avatar))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $vendor->avatar) }}" alt="{{ $vendor->name }}"
                                        style="width: 100%; height:300px; object-fit: cover; border-radius: 4px;">
                                </div>
                            @endif
                            @error('avatar')
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
                    <button class="btn btn-info" type="submit">Update profile</button>
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Form Validation-->
    </div>
@endsection
