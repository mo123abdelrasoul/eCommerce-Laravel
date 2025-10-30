@extends('vendor.layouts.app')

@section('title', 'Edit Withdraw Request')

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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit: Withdraw Request</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('vendor.withdraw.index', app()->getLocale()) }}">Withdrawals</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Form Card-->
        @if ($withdraw->status == 'approved')
            <div class="alert alert-danger">
                ⚠ This withdrawal has already been approved and cannot be modified.
            </div>
        @else
            <div class="card card-info card-outline mb-4">
                <form
                    action="{{ $withdraw->status == 'approved' ? '#' : route('vendor.withdraw.update', ['lang' => app()->getLocale(), 'withdraw' => $withdraw->id]) }}"
                    method="POST" class="needs-validation">
                    @csrf
                    @if ($withdraw->status != 'approved')
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Amount Input -->
                            <div class="col-md-12">
                                <label for="amount" class="form-label">Amount to Withdraw</label>
                                <input type="number" name="amount" id="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $withdraw->amount) }}"
                                    {{ $withdraw->status == 'approved' ? 'readonly' : '' }}>
                                @error('amount')
                                    <p class="msg-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes Input -->
                            <div class="col-md-12">
                                <label for="notes" class="form-label">Notes (optional)</label>
                                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"
                                    {{ $withdraw->status == 'approved' ? 'readonly' : '' }}>{{ old('notes', $withdraw->notes) }}</textarea>
                                @error('notes')
                                    <p class="msg-error">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <!--end::Body-->

                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button class="btn btn-info" type="submit"
                            {{ $withdraw->status == 'approved' ? 'disabled' : '' }}>
                            <i class="bi bi-cash-stack me-2"></i>
                            {{ $withdraw->status == 'approved' ? 'Cannot Update' : 'Update Withdrawal' }}
                        </button>
                    </div>
                    <!--end::Footer-->
                </form>
            </div>
        @endif
        <!--end::Form Card-->
    </div>
@endsection
