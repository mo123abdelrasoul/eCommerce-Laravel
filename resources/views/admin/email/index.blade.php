@extends('admin.layouts.app')

@section('title', 'Email Settings')

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
                    <h3>Email Settings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard', ['lang' => app()->getLocale()]) }}">Home</a></li>
                        <li class="breadcrumb-item active">Email Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Current Email Configuration</h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ route('admin.email.update', ['lang' => app()->getLocale(), 'email' => $settings->id ?? 1]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="mailer" class="form-label">Mailer</label>
                                <input type="text" name="mailer" id="mailer" class="form-control"
                                    value="{{ old('mailer', $settings->mailer ?? '') }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="host" class="form-label">Mail Host</label>
                                <input type="text" name="host" id="host" class="form-control"
                                    value="{{ old('host', $settings->host ?? '') }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="port" class="form-label">Mail Port</label>
                                <input type="number" name="port" id="port" class="form-control"
                                    value="{{ old('port', $settings->port ?? '') }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    value="{{ old('username', $settings->username ?? '') }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" name="password" id="password" class="form-control"
                                    placeholder="Enter new password to change">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="encryption" class="form-label">Encryption</label>
                                <input type="text" name="encryption" id="encryption" class="form-control"
                                    value="{{ old('encryption', $settings->encryption ?? '') }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="from_address" class="form-label">From Email</label>
                                <input type="email" name="from_address" id="from_address" class="form-control"
                                    value="{{ old('from_address', $settings->from_address ?? '') }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="from_name" class="form-label">From Name</label>
                                <input type="text" name="from_name" id="from_name" class="form-control"
                                    value="{{ old('from_name', $settings->from_name ?? '') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
