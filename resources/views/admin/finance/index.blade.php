@extends('admin.layouts.app')

@section('title', 'Finance Overview')

@push('styles')
    <style>
        .finance-card {
            transition: all 0.3s ease-in-out;
            border: none;
            border-radius: 12px;
            height: 100%;
        }

        .finance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .finance-card h6 {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .finance-card h3 {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .chart-container {
            position: relative;
            height: 400px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Finance Overview</h4>
        </div>

        <!-- Summary Cards -->
        <div class="row g-4">
            <!-- Total Orders (count) -->
            <div class="col-md-3 col-sm-6">
                <div class="card finance-card shadow-sm text-center p-3">
                    <h6>Total Orders</h6>
                    <h3 class="text-primary">{{ $totalOrdersCount }}</h3>
                    <small class="text-secondary">All orders placed</small>
                </div>
            </div>

            <!-- Total Orders (value) -->
            <div class="col-md-3 col-sm-6">
                <div class="card finance-card shadow-sm text-center p-3">
                    <h6>Total Sales</h6>
                    <h3 class="text-success">{{ format_currency($totalOrdersAmount) }}</h3>
                    <small class="text-secondary">Total sales amount</small>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="col-md-3 col-sm-6">
                <div class="card finance-card shadow-sm text-center p-3">
                    <h6>Completed Orders</h6>
                    <h3 class="text-info">{{ format_currency($totalSales) }}</h3>
                    <small class="text-secondary">Delivered / paid orders</small>
                </div>
            </div>

            <!-- Cancelled Orders -->
            <div class="col-md-3 col-sm-6">
                <div class="card finance-card shadow-sm text-center p-3">
                    <h6>Cancelled Orders</h6>
                    <h3 class="text-danger">{{ $totalCanceledOrdersCount }}</h3>
                    <small class="text-secondary d-block mb-1">Cancelled orders</small>
                    <small class="text-danger fw-semibold">Value: {{ format_currency($totalCanceledOrders) }}</small>
                </div>
            </div>

            <!-- Platform Commission -->
            <div class="col-md-3 col-sm-6">
                <div class="card finance-card shadow-sm text-center p-3">
                    <h6>Platform Commission</h6>
                    <h3 class="text-info">{{ format_currency($totalCommission) }}</h3>
                    <small class="text-secondary">Website earnings</small>
                </div>
            </div>

            <!-- Vendors Earnings -->
            <div class="col-md-3 col-sm-6">
                <div class="card finance-card shadow-sm text-center p-3">
                    <h6>Vendors’ Earnings</h6>
                    <h3 class="text-primary">{{ format_currency($totalVendorEarnings) }}</h3>
                    <small class="text-secondary">Payable to vendors</small>
                </div>
            </div>

            <!-- Pending Withdrawals -->
            <div class="col-md-3 col-sm-6">
                <div class="card finance-card shadow-sm text-center p-3">
                    <h6>Pending Withdrawals</h6>
                    <h3 class="text-warning">{{ format_currency($pendingWithdrawals) }}</h3>
                    <small class="text-secondary">Awaiting approval</small>
                </div>
            </div>

            <!-- Approved Withdrawals -->
            <div class="col-md-3 col-sm-6">
                <div class="card finance-card shadow-sm text-center p-3">
                    <h6>Approved Withdrawals</h6>
                    <h3 class="text-success">{{ format_currency($approvedWithdrawals) }}</h3>
                    <small class="text-secondary">Processed successfully</small>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="card mt-5 finance-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Monthly Sales Overview
                    </h5>
                </div>
                <div class="chart-container">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('financeChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Total Sales',
                    data: @json($salesData),
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => value
                        }
                    }
                }
            }
        });
    </script>
@endpush
