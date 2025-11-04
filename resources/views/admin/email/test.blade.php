@extends('admin.layouts.app')

@section('title', 'Send Test Mail')

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
                    <h3>Send Test Mail</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard', ['lang' => app()->getLocale()]) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.email.index', ['lang' => app()->getLocale()]) }}">Email Settings</a>
                        </li>
                        <li class="breadcrumb-item active">Send Test Mail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-envelope"></i> Test Email</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.email.test.send', app()->getLocale()) }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-8">
                                <label for="test_email" class="form-label">Recipient Email</label>
                                <input type="email" name="test_email" id="test_email" class="form-control"
                                    placeholder="Enter email address to send test mail" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Send Test Mail
                        </button>
                    </form>

                    <div class="alert alert-info mt-4 d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle me-2 fs-5"></i>
                        <span>This will use your current mail configuration to send a test message.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
