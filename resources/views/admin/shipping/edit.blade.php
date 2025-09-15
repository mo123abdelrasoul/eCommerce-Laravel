@extends('admin.layouts.app')

@section('title', 'Edit Shipping Method')

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
                        <h3 class="mb-0">Edit {{ $shipping_method->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('shipping.index', ['lang' => app()->getLocale()]) }}">Shppings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $shipping_method->name }}</li>
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
            <form form
                action="{{ route('shipping.update', ['lang' => app()->getLocale(), 'shipping' => $shipping_method->id]) }}"
                method="POST" enctype="multipart/form-data" class="needs-validation">
                @method('PUT')
                @csrf
                @if ($shipping_method->vendor_id !== null)
                    <input type="hidden" name="vendor_id" value="{{ $shipping_method->vendor_id }}" class="form-control"
                        id="vendor_id" />
                @endif
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="row g-3">
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $shipping_method->name ?? '') }}"
                                class="form-control" id="name" required />
                            @error('name')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" value="{{ old('price', $shipping_method->price ?? '') }}" name="price"
                                id="price" class="form-control" aria-label="Amount (to the nearest dollar)" required />
                            @error('price')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!--end::Col-->


                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="delivery_time" class="form-label">Delivery time</label>
                            <select name="delivery_time" id="delivery_time" class="form-select">
                                @foreach (config('shipping.delivery_times') as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('delivery_time', $shipping_method->delivery_time ?? '') === $value ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            @error('delivery_time')
                                <p class="msg-error">{{ $message }}</p>
                            @enderror
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1"
                                    {{ old('status', $shipping_method->status) == 1 ? 'selected' : '' }}>Active
                                </option>
                                <option value="0"
                                    {{ old('status', $shipping_method->status) == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('status')
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
                    <button class="btn btn-info" type="submit">Update Method</button>
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Form Validation-->
    </div>
@endsection
