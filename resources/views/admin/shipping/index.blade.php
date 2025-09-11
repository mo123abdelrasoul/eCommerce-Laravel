@extends('admin.layouts.app')

@section('title', 'Shipping Methods')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Shipping Methods</h1>
            <a href="{{ route('shipping.create', ['lang' => app()->getLocale()]) }}" class="btn btn-primary">Add New
                Method</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($shipping_methods->isEmpty())
            <div class="alert alert-info">No shipping methods found.</div>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Method Name</th>
                        <th>Price</th>
                        <th>Vendor</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipping_methods as $method)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $method->name }}</td>
                            <td>${{ number_format($method->price, 2) }}</td>
                            <td>
                                @if ($method->vendor)
                                    {{ $method->vendor->name }}
                                @else
                                    <span class="badge bg-secondary">Admin</span>
                                @endif
                            </td>
                            @if ($method->status == 1)
                                <td>Active</td>
                            @else
                                <td>In Active</td>
                            @endif
                            <td>
                                <a href="{{ route('shipping.edit', ['lang' => app()->getLocale(), 'shipping' => $method->id]) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form
                                    action="{{ route('shipping.destroy', ['lang' => app()->getLocale(), 'shipping' => $method->id]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this method?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
