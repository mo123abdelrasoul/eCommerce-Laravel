@extends('admin.layouts.app')
@section('title', 'Edit Order')

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
                        <h3 class="mb-0">Edit Order: {{ $order->order_number }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.orders.index', app()->getLocale()) }}">Orders</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $order->order_number }}</li>
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
            <form form action="{{ route('admin.orders.update', ['order' => $order->id, 'lang' => app()->getLocale()]) }}"
                method="POST" enctype="multipart/form-data" class="needs-validation">
                @method('PUT')
                @csrf
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="row g-3">
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                @foreach (config('order.status') as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('status', $order->status ?? '') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
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
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select">
                                @foreach (config('order.payment_method') as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('payment_method', $order->payment_method ?? '') === $value ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-select">
                                @foreach (config('order.payment_status') as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('payment_status', $order->payment_status ?? '') === $value ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            @error('payment_status')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="shipping_cost" class="form-label">Shipping Cost</label>
                            <input type="text" name="shipping_cost" id="shipping_cost"
                                value="{{ old('shipping_cost', $order->shipping_cost ?? '') }}" class="form-control">
                            @error('shipping_cost')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label for="discount_amount" class="form-label">discount</label>
                            <input type="text" name="discount_amount" id="discount_amount"
                                value="{{ old('discount_amount', $order->discount_amount ?? '') }}" class="form-control">
                            @error('discount_amount')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-12">

                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $order->notes ?? '') }}</textarea>
                            @error('notes')
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
                    <button class="btn btn-info" type="submit">Update order</button>
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Form Validation-->
    </div>
@endsection
