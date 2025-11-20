@extends('admin.layouts.app')
@section('title', 'Admin Profile')

@section('content')
    <div class="dashboard-container flex min-h-screen">
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Welcome Admin</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-bg-primary">
                                <div class="inner">
                                    <h3>{{ $data['newOrders'] }}</h3>
                                    <p>New Orders</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path
                                        d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                                    </path>
                                </svg>
                                <a href="#"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3>{{ $data['pageViews'] }}</h3>
                                    <p>Page Views</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path
                                        d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                                    </path>
                                </svg>
                                <a href="#"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-bg-warning">
                                <div class="inner">
                                    <h3>{{ $data['registeredUsers'] }}</h3>
                                    <p>User Registrations</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path
                                        d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                    </path>
                                </svg>
                                <a href="#"
                                    class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3>{{ $data['uniqueVisitors'] }}</h3>
                                    <p>Unique Visitors</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                                    </path>
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                                    </path>
                                </svg>
                                <a href="#"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Monthly Recap Report</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="info-box mb-3 text-bg-warning">
                                                <span class="info-box-icon"> <i class="bi bi-tag-fill"></i> </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Inventory</span>
                                                    <span class="info-box-number">{{ $data['inventoryCount'] }}</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 text-bg-info">
                                                <span class="info-box-icon"> <i class="bi bi-chat-fill"></i> </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Direct Messages</span>
                                                    <span class="info-box-number">{{ $data['directMessages'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!-- ./card-body -->
                                <div class="card-footer">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="text-center border-end">
                                                <h5 class="fw-bold mb-0">{{ $data['totalOrders'] }}</h5>
                                                <span class="text-uppercase">TOTAL ORDERS</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="text-center border-end">
                                                <h5 class="fw-bold mb-0">{{ format_currency($data['totalRevenue']) }}</h5>
                                                <span class="text-uppercase">TOTAL REVENUE</span>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6 mb-4">
                            <!-- PRODUCT LIST -->
                            <div class="card recently-products-dashboard">
                                <div class="card-header">
                                    <h3 class="card-title">Recently Added Products</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="px-2">
                                        @forelse($data['latestProducts'] as $product)
                                            <div class="d-flex border-top py-2 px-1">
                                                <div class="col-2">
                                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/default-150x150.png') }}"
                                                        alt="{{ $product->name }}" class="img-size-50" />
                                                </div>
                                                <div class="col-10 px-2">
                                                    <a href="javascript:void(0) "
                                                        class="fw-bold text-dark text-decoration-none">
                                                        {{ $product->name }}
                                                        <span
                                                            class="badge float-end
                            @if ($loop->iteration % 4 == 1) text-bg-warning
                            @elseif($loop->iteration % 4 == 2) text-bg-info
                            @elseif($loop->iteration % 4 == 3) text-bg-danger
                            @else text-bg-success @endif">
                                                            {{ format_currency($product->price) }}
                                                        </span>
                                                    </a>
                                                    <div class="text-truncate">{{ $product->description }}</div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-2">No products found.</div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer text-center">
                                    <a href="javascript:void(0)" class="uppercase"> View All Products </a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-md-12">
                            <!--begin::Row-->
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- USERS LIST -->
                                    <div class="card latest-members">
                                        <div class="card-header">
                                            <h3 class="card-title">Latest Members</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-lte-toggle="card-collapse">
                                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool"
                                                    data-lte-toggle="card-remove">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="row text-center m-1">
                                                @foreach ($data['latestMembers'] as $member)
                                                    <div class="col-3 p-2">
                                                        <img class="img-fluid rounded-circle"
                                                            src="{{ asset('storage/' . $member->avatar) ?? asset('assets/images/default-150x150.png') }}"
                                                            alt="User Image" />
                                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                            href="#">
                                                            {{ $member->name }}
                                                        </a>
                                                        <div class="fs-8">
                                                            {{ $member->created_at?->diffForHumans() ?? 'N/A' }}</div>

                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- /.users-list -->
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer text-center">
                                            <a href="javascript:"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View
                                                All Users</a>
                                        </div>
                                        <!-- /.card-footer -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!--begin::Latest Order Widget-->
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Latest Orders</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-lte-toggle="card-collapse">
                                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool"
                                                    data-lte-toggle="card-remove">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table m-0 text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>Order ID</th>
                                                            <th>Item</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data['latestOrders'] as $order)
                                                            <tr>
                                                                <td>
                                                                    <span class="text-primary fw-bold">
                                                                        {{ $order['order_number'] }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $order['product_name'] }}</td>
                                                                <td>
                                                                    <span
                                                                        class="badge 
                    @if ($order['status'] == 'completed') text-bg-success
                    @elseif($order['status'] == 'pending') text-bg-warning
                    @elseif($order['status'] == 'processing') text-bg-info
                    @else text-bg-danger @endif">
                                                                        {{ ucfirst($order['status']) }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>

                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer text-center">
                                            <a href="javascript:"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View
                                                All Orders</a>
                                        </div>
                                        <!-- /.card-footer -->
                                    </div>
                                </div>
                            </div>
                            <!--end::Row-->

                            <!-- /.card -->
                        </div>
                        <!-- /.col -->

                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
    </div>
@endsection
