@extends('admin.layouts.app')
@section('title', 'Edit User Profile')

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
                        <h3 class="mb-0">Edit {{ $user->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('users.show', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">Profile</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
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
            <form form action="{{ route('users.update', ['lang' => app()->getLocale(), 'user' => $user->id]) }}"
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
                            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                                class="form-control" id="name" required />
                            @error('name')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" value="{{ old('email', $user->email ?? '') }}" name="email"
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
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                class="form-control" id="phone" />
                            @error('phone')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 mb-3 col-md-6">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" name="avatar" class="form-control" id="avatar" />
                            @if (!empty($user->avatar))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                        style="width: 100%; height:300px; object-fit: cover; border-radius: 4px;">
                                </div>
                            @endif
                            @error('avatar')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->
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
