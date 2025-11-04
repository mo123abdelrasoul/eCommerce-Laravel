@extends('vendor.layouts.app')

@section('title', 'Withdrawls')

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
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Withdrawls</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a
                                href="{{ route('vendor.dashboard', ['lang' => app()->getLocale()]) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Withdrawls</li>
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
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3">
                            <div>
                                All Your Withdraw Requests
                            </div>

                            <a href="{{ route('vendor.withdraw.create', ['lang' => app()->getLocale()]) }}"
                                class="btn btn-success">New Request</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped text-center">
                                <thead>
                                    @if ($requests->isEmpty())
                                        <p style="padding: 15px 0 0 15px;">No Requests found.</p>
                                    @else
                                        <tr>
                                            <th>#</th>
                                            <th>Amount (EGP)</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                            <th>Requested At</th>
                                            <th>Actions</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>{{ $requests->firstItem() + $loop->index }}</td>
                                            <td>{{ number_format($request->amount, 2) }}</td>
                                            <td>
                                                @switch($request->status)
                                                    @case('approved')
                                                        <span class="badge bg-success">{{ $request->status }}</span>
                                                    @break

                                                    @case('pending')
                                                        <span class="badge bg-warning">{{ $request->status }}</span>
                                                    @break

                                                    @case('rejected')
                                                        <span class="badge bg-danger">{{ $request->status }}</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-warning">{{ $request->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $request->notes ?? 'N/A' }}</td>
                                            <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if ($request->status == 'pending')
                                                    <a href="{{ route('vendor.withdraw.edit', ['lang' => app()->getLocale(), 'withdraw' => $request->id]) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form
                                                        action="{{ route('vendor.withdraw.destroy', ['lang' => app()->getLocale(), 'withdraw' => $request->id]) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this request?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                @else
                                                    <span>No actions</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination-container d-flex justify-content-center mt-3">
                                {{ $requests->links('pagination::bootstrap-5') }}
                            </div>
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
