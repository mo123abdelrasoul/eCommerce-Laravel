@extends('admin.layouts.app')

@section('title', 'Withdraw Requests')

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

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Withdraw Requests</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Withdraw Requests</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-12">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3">

                            <form action="{{ route('admin.withdraw.index', app()->getLocale()) }}" method="GET"
                                class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search withdraw requests by vendor..." style="width: 300px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped text-center">
                                <thead>
                                    @if ($withdrawals->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Withdraw Requests found.</p>
                                    @else
                                        <tr>
                                            <th>#</th>
                                            <th>Vendor</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Requested At</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawals as $withdrawal)
                                        <tr>
                                            <td>{{ $withdrawals->firstItem() + $loop->index }}</td>
                                            <td>{{ $withdrawal->vendor?->name ?? 'N/A' }}</td>
                                            <td>{{ format_currency($withdrawal->amount) }}</td>
                                            <td>
                                                @switch($withdrawal->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @break

                                                    @case('approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @break

                                                    @case('rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($withdrawal->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $withdrawal->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if ($withdrawal->status === 'pending')
                                                    <form
                                                        action="{{ route('admin.withdraw.approve', app()->getLocale()) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to approve this withdrawal request?');">
                                                        @csrf
                                                        <input type="hidden" name="withdraw_id"
                                                            value="{{ $withdrawal->id }}">
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm">Approve</button>
                                                    </form>

                                                    <form action="{{ route('admin.withdraw.reject', app()->getLocale()) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to reject this withdrawal request?');">
                                                        @csrf
                                                        <input type="hidden" name="withdraw_id"
                                                            value="{{ $withdrawal->id }}">
                                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">No actions</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination-container d-flex justify-content-center mt-3">
                                {{ $withdrawals->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
