@extends('vendor.layouts.app')

@section('title', 'Verify Your Email')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Verify Your Email</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('vendor.dashboard', ['lang' => app()->getLocale()]) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Verify Email</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card p-4">
                        <h4 class="card-title mb-3">Verify Your Email Address</h4>

                        <p class="card-text mb-4">
                            Thanks for signing up! Before getting started, please verify your email address by clicking the
                            link we just emailed to you.
                            If you didn’t receive the email, we will gladly send you another.
                        </p>

                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('vendor.verification.send', app()->getLocale()) }}"
                            class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                Resend Verification Email
                            </button>
                        </form>

                        <form method="POST" action="{{ route('vendor.logout.submit', app()->getLocale()) }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none w-100">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content-->
@endsection
