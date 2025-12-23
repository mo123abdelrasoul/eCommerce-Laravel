@extends('admin.layouts.app')

@section('title', 'Customer Chats')

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
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Customer Chats</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', app()->getLocale()) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Chats</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-12">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3">
                            <form action="{{ route('admin.customer-chats.index', ['lang' => app()->getLocale()]) }}"
                                method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search by customer name..." style="width: 300px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-striped text-center">
                                <thead>
                                    @if ($chats->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Chats found.</p>
                                    @else
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>Last Message</th>
                                            <th>Last Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chats as $index => $chat)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $chat['customer']->name }}</td>
                                            <td>{{ Str::limit($chat['last_message'], 50) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($chat['updated_at'])->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admin.customer-chats.show', ['lang' => app()->getLocale(), 'customer_chat' => $chat['user_id']]) }}"
                                                    class="btn btn-info btn-sm">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>

                            {{-- pagination placeholder --}}
                            {{-- <div class="pagination-container d-flex justify-content-center mt-3">
                                {{ $chats->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
