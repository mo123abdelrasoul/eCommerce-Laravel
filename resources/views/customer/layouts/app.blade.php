@php
    $layout = Auth::guard('web')->check() ? 'common.layouts.frontend' : 'common.layouts.adminlte';
@endphp
@extends($layout)
@if (Auth::guard('web')->check())
    @section('layout-header')
        @include('customer.layouts.header')
    @endsection

    @section('layout-cart')
        @include('customer.layouts.cart')
    @endsection

    @section('layout-footer')
        @include('customer.layouts.footer')
    @endsection
@endif
