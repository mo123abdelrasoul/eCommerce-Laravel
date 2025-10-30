@extends('admin.layouts.app')

@section('title', 'Edit Coupon')

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
                        <h3 class="mb-0">Edit Coupon: {{ $coupon->code }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.coupons.index', app()->getLocale()) }}">Coupons</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $coupon->code }}</li>
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
            <form form action="{{ route('admin.coupons.update', ['lang' => app()->getLocale(), 'coupon' => $coupon->id]) }}"
                method="POST" enctype="multipart/form-data" class="needs-validation">
                @method('PUT')
                @csrf
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="row g-3">
                        <!--begin::Col-->
                        <input type="hidden" name="vendor_id" class="form-control" value="{{ $coupon->vendor_id }}" />
                        <div class="col-md-6">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" name="code" value="{{ old('name', $coupon->code ?? '') }}"
                                class="form-control" id="code" required />
                            @error('code')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description"
                                value="{{ old('description', $coupon->description ?? '') }}" class="form-control"
                                id="description" />
                            @error('description')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="discount_type" class="form-label">Discount Type</label>
                            <select name="discount_type" id="discount_type" class="form-select">
                                @foreach (config('coupon.discount_type') as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('discount_type', $coupon->discount_type ?? '') === $value ? 'selected' : '' }}>
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
                            <label for="discount_value" class="form-label">Discount Value</label>
                            <input type="text" name="discount_value"
                                value="{{ old('discount_value', $coupon->discount_value ?? '') }}" class="form-control"
                                id="discount_value" required />
                            @error('discount_value')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="max_discount" class="form-label">Max Discount</label>
                            <input type="text" name="max_discount"
                                value="{{ old('max_discount', $coupon->max_discount ?? '') }}" class="form-control"
                                id="max_discount">
                            @error('max_discount')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="min_order_amount" class="form-label">Min Order Amount</label>
                            <input type="text" name="min_order_amount"
                                value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}" class="form-control"
                                id="min_order_amount">
                            @error('min_order_amount')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="max_order_amount" class="form-label">Max Order Amount</label>
                            <input type="text" name="max_order_amount"
                                value="{{ old('max_order_amount', $coupon->max_order_amount ?? '') }}" class="form-control"
                                id="max_order_amount">
                            @error('max_order_amount')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->



                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="usage_limit" class="form-label">Usage Limit</label>
                            <input type="number" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}"
                                name="usage_limit" id="usage_limit" class="form-control">
                            @error('usage_limit')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="usage_limit_per_user" class="form-label">Usage Limit Per User</label>
                            <input type="number" value="{{ old('usage_limit_per_user', $coupon->usage_limit ?? '') }}"
                                name="usage_limit_per_user" id="usage_limit_per_user" class="form-control">
                            @error('usage_limit_per_user')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="applies_to_all_products" class="form-label">Applies to all products</label>
                            <select class="form-select" name="applies_to_all_products" id="applies_to_all_products"
                                required>
                                <option value="1"
                                    {{ old('applies_to_all_products', $coupon->applies_to_all_products) == '1' ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option value="0"
                                    {{ old('applies_to_all_products', $coupon->applies_to_all_products) == '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                                @error('applies_to_all_products')
                                    <p class="msg-error">{{ $message }}</p>
                                @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="applies_to_all_categories" class="form-label">Applies to all categories</label>
                            <select class="form-select" name="applies_to_all_categories" id="applies_to_all_categories"
                                required>
                                <option value="1"
                                    {{ old('applies_to_all_categories', $coupon->applies_to_all_categories) == '1' ? 'selected' : '' }}>
                                    Yes
                                </option>
                                <option value="0"
                                    {{ old('applies_to_all_categories', $coupon->applies_to_all_categories) == '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                                @error('applies_to_all_categories')
                                    <p class="msg-error">{{ $message }}</p>
                                @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="excluded_product_ids" class="form-label">Exclude Products (comma
                                separated)</label>
                            <input type="text" name="excluded_product_ids"
                                value="{{ old('excluded_product_ids', $coupon->excluded_product_ids ? implode(',', json_decode($coupon->excluded_product_ids)) : '') }}"
                                class="form-control" id="excluded_product_ids" />
                            @error('excluded_product_ids')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="excluded_category_ids" class="form-label">Exclude Categories (comma
                                separated)</label>
                            <input type="text" name="excluded_category_ids"
                                value="{{ old('excluded_category_ids', $coupon->excluded_category_ids ? implode(',', json_decode($coupon->excluded_category_ids)) : '') }}"
                                class="form-control" id="excluded_category_ids" />
                            @error('excluded_category_ids')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                @foreach (config('coupon.status') as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('status', $coupon->status ?? '') === $value ? 'selected' : '' }}>
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
                        <div class="col-md-4">
                            <label for="approval_status" class="form-label">Approval Status</label>
                            <select name="approval_status" id="approval_status" class="form-select">
                                @foreach (config('coupon.approval_status') as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('approval_status', $coupon->approval_status ?? '') === $value ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            @error('approval_status')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date"
                                value="{{ old('start_date', $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '') }}"
                                class="form-control" id="start_date" />
                            @error('start_date')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date"
                                value="{{ old('end_date', $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '') }}"
                                class="form-control" id="end_date" />
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
                    <button class="btn btn-info" type="submit">Update coupon</button>
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Form Validation-->
    </div>
@endsection
