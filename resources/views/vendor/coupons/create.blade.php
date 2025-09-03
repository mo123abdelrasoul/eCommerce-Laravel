@extends('vendor.layouts.app')
@section('title', 'Create Coupon')

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
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Create New Coupon</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('coupons.index') }}">Coupons</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--begin::Form Validation-->
        <div class="card card-info card-outline mb-4">
            <!--begin::Form-->
            <form form action="{{ route('coupons.store', app()->getLocale()) }}" method="POST"
                enctype="multipart/form-data" class="needs-validation">
                @csrf
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="row g-3">
                        <!--begin::Col-->
                        <input type="hidden" name="vendor_id" class="form-control" value="{{ $vendor_id }}" />
                        <div class="col-md-6">
                            <label for="code" class="form-label">Code (Required)</label>
                            <input type="text" name="code" value="{{ old('code') }}" class="form-control"
                                id="code" required />
                            @error('code')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description (Optional)</label>
                            <input type="text" name="description" value="{{ old('description') }}" class="form-control"
                                id="description" />
                            @error('description')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="discount_type" class="form-label">Discount Type (Required)</label>
                            <select name="discount_type" id="discount_type" class="form-select">
                                @foreach (config('coupon.discount_type') as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('discount_type') === $value ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            @error('discount_type')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="discount_value" class="form-label">Discount Value (Required)</label>
                            <input type="text" name="discount_value" value="{{ old('discount_value') }}"
                                class="form-control" id="discount_value" required />
                            @error('discount_value')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="max_discount" class="form-label">Max Discount (Optional)</label>
                            <input type="text" name="max_discount" value="{{ old('max_discount') }}"
                                class="form-control" id="max_discount" />
                            @error('max_discount')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="min_order_amount" class="form-label">Min Order Amount (Optional)</label>
                            <input type="text" name="min_order_amount" value="{{ old('min_order_amount') }}"
                                class="form-control" id="min_order_amount" />
                            @error('min_order_amount')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="max_order_amount" class="form-label">Max Order Amount (Optional)</label>
                            <input type="text" name="max_order_amount" value="{{ old('max_order_amount') }}"
                                class="form-control" id="max_order_amount" />
                            @error('max_order_amount')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="usage_limit" class="form-label">Usage Limit (Optional)</label>
                            <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" class="form-control"
                                id="usage_limit" />
                            @error('usage_limit')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="usage_limit_per_user" class="form-label">Usage Limit Per User (Optional)</label>
                            <input type="number" name="usage_limit_per_user" value="{{ old('usage_limit_per_user') }}"
                                class="form-control" id="usage_limit_per_user" />
                            @error('usage_limit')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="applies_to_all_products" class="form-label">Applies to all products
                                (Required)</label>
                            <select class="form-select" name="applies_to_all_products" id="applies_to_all_products">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                                @error('applies_to_all_products')
                                    <p class="msg-error">{{ $message }}</p>
                                @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="applies_to_all_categories" class="form-label">Applies to all categories
                                (Required)</label>
                            <select class="form-select" name="applies_to_all_categories" id="applies_to_all_categories">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                                @error('applies_to_all_categories')
                                    <p class="msg-error">{{ $message }}</p>
                                @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="excluded_product_ids" class="form-label">Exclude Products (comma separated)
                                (Optional)</label>
                            <input type="text" name="excluded_product_ids" value="{{ old('excluded_product_ids') }}"
                                class="form-control" id="excluded_product_ids" />
                            @error('excluded_product_ids')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="excluded_category_ids" class="form-label">Exclude Categories (comma separated)
                                (Optional)</label>
                            <input type="text" name="excluded_category_ids"
                                value="{{ old('excluded_category_ids') }}" class="form-control"
                                id="excluded_category_ids" />
                            @error('excluded_category_ids')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status (Required)</label>
                            <select name="status" id="status" class="form-select">
                                @foreach (config('coupon.status') as $value => $label)
                                    <option value="{{ $value }}" {{ old('status') === $value ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date (Optional)</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                class="form-control" id="start_date" />
                            @error('start_date')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date (Optional)</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control"
                                id="end_date" />
                            @error('end_date')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->





                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer">
                    <button class="btn btn-info" type="submit">Create coupon</button>
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Form Validation-->
    </div>
@endsection
