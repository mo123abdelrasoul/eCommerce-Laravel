@extends('vendor.layouts.app')
@section('hideLayout', true)
@section('title', 'Register')

@section('content')

    <div class="register-box">
        <div class="register-logo">
            <a href="{{ route('home', app()->getLocale()) }}"><b>Your</b>App</a>
        </div>
        <!-- /.register-logo -->

        <div class="card">
            <div class="card-body register-card-body">
                <p class="register-box-msg">Register a new membership</p>

                <form action="{{ route('registerForm', app()->getLocale()) }}" method="POST">
                    @csrf

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Name Field -->
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Full Name" value="{{ old('name') }}" required>
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" required>
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div class="input-group mb-3">
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            placeholder="Phone Number" value="{{ old('phone') }}" required>
                        <div class="input-group-text">
                            <span class="bi bi-telephone"></span>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" required>
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm Password" required>
                        <div class="input-group-text">
                            <span class="bi bi-lock"></span>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="mb-3">
                        <p class="mb-2">Role:</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" value="customer" id="customer"
                                {{ old('role') == 'customer' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="customer">
                                <i class="bi bi-person-check me-1"></i>Customer
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" value="vendor" id="vendor"
                                {{ old('role') == 'vendor' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="vendor">
                                <i class="bi bi-shop me-1"></i>Vendor
                            </label>
                        </div>
                        @error('role')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="agreeTerms" required>
                                <label class="form-check-label" for="agreeTerms">
                                    I agree to the <a href="#" class="text-decoration-none">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                </form>

                <!-- Social Auth Links (Optional) -->
                <div class="social-auth-links text-center mb-3 d-grid gap-2">
                    <p>- OR -</p>
                    {{-- <a href="#" class="btn btn-primary">
                        <i class="bi bi-facebook me-2"></i> Register using Facebook
                    </a> --}}
                    <a href="{{ route('google.redirect', ['lang' => app()->getLocale()]) }}?type=user"
                        class="btn btn-danger">
                        <i class="bi bi-google me-2"></i> Register using Google+
                    </a>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-0 text-center">
                    <a href="{{ route('user.login', app()->getLocale()) }}" class="text-center">I already have a
                        membership</a>
                </p>
            </div>
            <!-- /.register-card-body -->
        </div>
    </div>
    <!-- /.register-box -->

@endsection

@section('body-class', 'register-page bg-body-secondary')
