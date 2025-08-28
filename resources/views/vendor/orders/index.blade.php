@extends('layouts.app')
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
                        <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}">Home</a></li>
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
                        <div class="card-header">
                            <h3 class="card-title">Orders</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
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
                                            <th>Order Date</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->customer->name }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td>{{ $order->payment_method }}</td>
                                            <td>{{ $order->total_amount ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
                                                    class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('orders.edit', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <form
                                                    action="{{ route('orders.destroy', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
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
