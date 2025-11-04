@extends('customer.layouts.app')
@section('hideLayout', true)
@section('title', 'Forgot Password')

@section('content')

    <div class="login-box">
        <div class="login-logo">
            Forgot Password
        </div>
        <!-- /.login-logo -->

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Enter your email to reset your password</p>

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.password.email', app()->getLocale()) }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" required autofocus>
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                    </div>
                </form>

                <p class="mt-3 text-center">
                    <a href="{{ route('admin.login', app()->getLocale()) }}">Back to login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

@endsection

@section('body-class', 'login-page bg-body-secondary')
