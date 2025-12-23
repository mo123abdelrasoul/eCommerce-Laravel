@extends('vendor.layouts.app')
@section('title', __('Dashboard'))
@section('content')

    <div class="app-wrapper">
        <div class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">{{ __('Welcome') }}, {{ auth('vendors')->user()->name }}</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('vendor.dashboard', app()->getLocale()) }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    {{-- Flash Message --}}
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Metrics Cards --}}
                    <div class="row g-4 mb-4">
                        {{-- Total Orders Card --}}
                        <div class="col-lg-4 col-md-4">
                            <div class="card text-bg-primary">
                                <div class="card-body text-center">
                                    <h3 class="card-title mb-1">{{ $ordersCount ?? 0 }}</h3>
                                    <p class="text-white-50 mb-2">{{ __('Total Orders') }}</p>
                                    <div class="mt-2"><i class="bi bi-cart-check fs-1 opacity-75"></i></div>
                                </div>
                            </div>
                        </div>

                        {{-- Total Products Card --}}
                        <div class="col-lg-4 col-md-4">
                            <div class="card text-bg-success">
                                <div class="card-body text-center">
                                    <h3 class="card-title mb-1">{{ $productsCount ?? 0 }}</h3>
                                    <p class="text-white-50 mb-2">{{ __('Total Products') }}</p>
                                    <div class="mt-2"><i class="bi bi-box-seam fs-1 opacity-75"></i></div>
                                </div>
                            </div>
                        </div>

                        {{-- Total Revenue Card --}}
                        <div class="col-lg-4 col-md-4">
                            <div class="card text-bg-info">
                                <div class="card-body text-center">
                                    <h3 class="card-title mb-1">{{ format_currency($total_revenue ?? 0) }}</h3>
                                    <p class="text-white-50 mb-2">{{ __('Total Revenue') }}</p>
                                    <div class="mt-2"><i class="bi bi-cash-coin fs-1 opacity-75"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Orders Section --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ __('Recent Orders') }}</h5>
                                </div>
                                <div class="card-body p-0">
                                    @if ($orders && count($orders) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>{{ __('Order ID') }}</th>
                                                        <th>{{ __('Customer') }}</th>
                                                        <th>{{ __('Date') }}</th>
                                                        <th>{{ __('Amount') }}</th>
                                                        <th>{{ __('Status') }}</th>
                                                        <th>{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        <tr>
                                                            <td class="fw-bold">
                                                                <a href="{{ route('vendor.orders.show', [app()->getLocale(), $order->id]) }}"
                                                                    class="text-decoration-none">
                                                                    #{{ $order->id }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                {{ $order->customer->name ?? 'N/A' }}
                                                                <br>
                                                                <small
                                                                    class="text-muted">{{ $order->customer->email ?? 'N/A' }}</small>
                                                            </td>
                                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                                            <td class="fw-bold">{{ format_currency($order->total_amount) }}
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $statusClass = match ($order->status) {
                                                                        'pending' => 'warning',
                                                                        'processing' => 'info',
                                                                        'completed' => 'success',
                                                                        'cancelled' => 'danger',
                                                                        default => 'secondary',
                                                                    };
                                                                @endphp
                                                                <span class="badge text-bg-{{ $statusClass }}">
                                                                    {{ ucfirst($order->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('vendor.orders.show', [app()->getLocale(), $order->id]) }}"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    {{ __('View') }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="p-5 text-center text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                            <p>{{ __('No orders yet. Your orders will appear here.') }}</p>
                                            <a href="{{ route('vendor.products.index', app()->getLocale()) }}"
                                                class="btn btn-sm btn-primary">
                                                {{ __('Go to Products') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-body h3 {
            font-weight: 700;
            font-size: 2rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
    </style>
@endsection
