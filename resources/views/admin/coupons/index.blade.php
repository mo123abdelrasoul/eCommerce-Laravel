@extends('admin.layouts.app')

@section('title', 'Coupons')

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
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Coupons</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard', ['lang' => app()->getLocale()]) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Coupons</li>
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
                            <form action="{{ route('admin.coupons.index', ['lang' => app()->getLocale()]) }}" method="GET"
                                class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search coupons by code..." style="width: 300px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped text-center">
                                <thead>
                                    @if ($coupons->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Coupons found.</p>
                                    @else
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Status</th>
                                            <th>Is approved</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $coupons->firstItem() + $loop->index }}</td>
                                            <td>{{ $coupon->code }}</td>
                                            <td>{{ $coupon->discount_type }}</td>
                                            <td>{{ $coupon->discount_value }}</td>
                                            <td>{{ date('d-m-Y', strtotime($coupon->start_date)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($coupon->end_date)) }}</td>
                                            <td>
                                                @if ($coupon->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($coupon->status === 'expired')
                                                    <span class="badge bg-danger">Expired</span>
                                                @else
                                                    <span class="badge bg-secondary">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coupon->approval_status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif ($coupon->approval_status == 'pending')
                                                    <span class="badge bg-warning text-white">Pending</span>
                                                @elseif ($coupon->approval_status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.coupons.show', ['lang' => app()->getLocale(), 'coupon' => $coupon->id]) }}"
                                                    class="btn btn-info">View
                                                </a>
                                                <a class="btn btn-warning"
                                                    href="{{ route('admin.coupons.edit', ['coupon' => $coupon->id, 'lang' => app()->getLocale()]) }}">
                                                    Edit
                                                </a>
                                                <form
                                                    action="{{ route('admin.coupons.destroy', ['coupon' => $coupon->id, 'lang' => app()->getLocale()]) }}"
                                                    method="POST" onsubmit="return confirm('Delete this coupon?')"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination-container d-flex justify-content-center mt-3">
                                {{ $coupons->links('pagination::bootstrap-5') }}
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
