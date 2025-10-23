@extends('common.layouts.adminlte')
@if (Auth::guard('admins')->check())
    @section('layout-header')
        @include('common.layouts.partials.adminlte-header', ['guard' => 'admins'])
    @endsection

    @section('layout-sidebar')
        @include('common.layouts.partials.sidebar')
    @endsection

    @section('layout-footer')
        @include('common.layouts.footer')
    @endsection
@endif
