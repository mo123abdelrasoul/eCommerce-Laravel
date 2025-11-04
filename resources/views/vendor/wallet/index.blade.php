@extends('vendor.layouts.app')

@section('title', 'Wallet & Earnings')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>💰 Wallet Overview</h2>
            <a href="{{ route('vendor.withdraw.index', app()->getLocale()) }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="bi bi-cash-stack me-2"></i> Withdraw Earnings
            </a>
        </div>

        <div class="row mb-4">
            <!-- Total Credits -->
            <div class="col-md-4">
                <div class="card text-center p-3 shadow-sm">
                    <h5>Total Earnings</h5>
                    <h3 class="text-success">{{ number_format($totalCredits, 2) }} EGP</h3>
                </div>
            </div>

            <!-- Total Debits -->
            <div class="col-md-4">
                <div class="card text-center p-3 shadow-sm">
                    <h5>Total Deductions</h5>
                    <h3 class="text-danger">{{ number_format($totalDebits, 2) }} EGP</h3>
                </div>
            </div>

            <!-- Available Balance -->
            <div class="col-md-4">
                <div class="card text-center p-3 shadow-sm">
                    <h5>Available Balance</h5>
                    <h3 class="text-primary">{{ number_format($balance, 2) }} EGP</h3>
                </div>
            </div>
        </div>

        <h4 class="mb-3">Transaction History</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Amount (EGP)</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td>{{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ $transaction->description ?? '-' }}</td>
                            <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No transactions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
