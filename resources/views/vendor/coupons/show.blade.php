@extends('vendor.layouts.app') {{-- غيرها لو عندك layout مختلف --}}

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-ticket-perforated me-2"></i> Coupon Details
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 30%">Code</th>
                            <td>{{ $coupon->code }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $coupon->description ?? '---' }}</td>
                        </tr>
                        <tr>
                            <th>Discount Type</th>
                            <td>{{ ucfirst($coupon->discount_type) }}</td>
                        </tr>
                        <tr>
                            <th>Discount Value</th>
                            <td>{{ $coupon->discount_value }}</td>
                        </tr>
                        <tr>
                            <th>Max Discount</th>
                            <td>{{ $coupon->max_discount ?? 'No Limit' }}</td>
                        </tr>
                        <tr>
                            <th>Min Order Amount</th>
                            <td>{{ $coupon->min_order_amount ?? '---' }}</td>
                        </tr>
                        <tr>
                            <th>Max Order Amount</th>
                            <td>{{ $coupon->max_order_amount ?? '---' }}</td>
                        </tr>
                        <tr>
                            <th>Usage Limit</th>
                            <td>{{ $coupon->usage_limit ?? 'Unlimited' }}</td>
                        </tr>
                        <tr>
                            <th>Usage Limit Per User</th>
                            <td>{{ $coupon->usage_limit_per_user ?? 'Unlimited' }}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ $coupon->start_date ? date('d-m-Y', strtotime($coupon->start_date)) : '---' }}
                            </td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ $coupon->end_date ? date('d-m-Y', strtotime($coupon->end_date)) : '---' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($coupon->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($coupon->status === 'expired')
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    <span class="badge bg-secondary">Disabled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Approval Status</th>
                            <td>
                                @if ($coupon->approval_status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($coupon->approval_status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @if ($coupon->admin_feedback)
                            <tr>
                                <th>Admin Feedback</th>
                                <td>{{ $coupon->admin_feedback }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('vendor.coupons.index', app()->getLocale()) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Coupons
                </a>
            </div>
        </div>
    </div>
@endsection
