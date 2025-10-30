@extends('common.layouts.adminlte')
@if (Auth::guard('vendors')->check())
    @section('layout-header')
        @include('common.layouts.partials.adminlte-header', ['guard' => 'vendors'])
    @endsection

    @section('layout-sidebar')
        @include('common.layouts.partials.vendor-sidebar')
    @endsection

    @section('layout-footer')
        @include('common.layouts.footer')
    @endsection
@endif
