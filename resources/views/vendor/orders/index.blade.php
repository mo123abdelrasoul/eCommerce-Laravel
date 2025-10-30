@extends('vendor.layouts.app')
@section('title', 'Orders')

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
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Orders</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a
                                href="{{ route('vendor.dashboard', ['lang' => app()->getLocale()]) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Orders</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <!-- /.card -->
                    <div class="card mb-12">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3">
                            <form action="{{ route('vendor.orders.index', ['lang' => app()->getLocale()]) }}" method="GET"
                                class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search orders by order number..." style="width: 300px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped text-center">
                                <thead>
                                    @if ($orders->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No orders found.</p>
                                    @else
                                        <tr>
                                            <th>#</th>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th>Method</th>
                                            <th>Total</th>
                                            <th>Payment Status</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $orders->firstItem() + $loop->index }}</td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->customer->name }}</td>
                                            <td>
                                                @switch($order->status)
                                                    @case('completed')
                                                        <span class="badge bg-success">{{ $order->status }}</span>
                                                    @break

                                                    @case('pending')
                                                        <span class="badge bg-warning">{{ $order->status }}</span>
                                                    @break

                                                    @case('processing')
                                                        <span class="badge bg-info">{{ $order->status }}</span>
                                                    @break

                                                    @case('cancelled')
                                                        <span class="badge bg-danger">{{ $order->status }}</span>
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                            <td>{{ $order->payment_method }}</td>
                                            <td>
                                                {{ $order->total_amount }}
                                            </td>
                                            <td>
                                                @switch($order->payment_status)
                                                    @case('paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @break

                                                    @case('unpaid')
                                                        <span class="badge bg-warning">Unpaid</span>
                                                    @break

                                                    @case('failed')
                                                        <span class="badge bg-danger">Failed</span>
                                                    @break

                                                    @case('refunded')
                                                        <span class="badge bg-secondary">Refunded</span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="badge bg-light text-dark">{{ ucfirst($order->payment_status ?? 'Unknown') }}</span>
                                                @endswitch
                                            </td>

                                            <td>
                                                <a href="{{ route('vendor.orders.show', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
                                                    class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('vendor.orders.edit', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form
                                                    action="{{ route('vendor.orders.destroy', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination-container d-flex justify-content-center mt-3">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection
