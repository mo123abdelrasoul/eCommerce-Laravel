@extends('vendor.layouts.app')

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
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('coupons.create', ['lang' => app()->getLocale()]) }}" class="btn btn-success">
            Create Coupon
        </a>
    </div>
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
                        <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}">Home</a></li>
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
                        <div class="card-header">
                            <h3 class="card-title">Coupons</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    @if ($coupons->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Coupons found.</p>
                                    @else
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Coupon</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $coupon->code }}</td>
                                            <td>{{ $coupon->discount_type }}</td>
                                            <td>{{ $coupon->discount_value }}</td>
                                            <td>{{ date('d-m-Y', strtotime($coupon->start_date)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($coupon->end_date)) }}</td>
                                            <td>{{ $coupon->status }} </td>
                                            <td>
                                                <a href="{{ route('coupons.show', ['lang' => app()->getLocale(), 'coupon' => $coupon->id]) }}"
                                                    class="btn btn-info">View
                                                </a>
                                                <a class="btn btn-primary"
                                                    href="{{ route('coupons.edit', ['coupon' => $coupon->id, 'lang' => app()->getLocale()]) }}">
                                                    Edit
                                                </a>
                                                <form
                                                    action="{{ route('coupons.destroy', ['coupon' => $coupon->id, 'lang' => app()->getLocale()]) }}"
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
