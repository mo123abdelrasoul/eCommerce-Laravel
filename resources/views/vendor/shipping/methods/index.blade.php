@extends('vendor.layouts.app')

@section('title', __('My Shipping Methods'))

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">{{ __('My Shipping Methods') }}</h4>
            <a href="{{ route('vendor.dashboard', app()->getLocale()) }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> {{ __('Back to Dashboard') }}
            </a>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Shipping Methods Form --}}
        <form action="{{ route('vendor.shipping.methods.store', app()->getLocale()) }}" method="POST">
            @csrf
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-3">{{ __('Select which shipping methods you offer and set your own rates.') }}
                    </p>

                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">{{ __('Select') }}</th>
                                <th scope="col">{{ __('Method Name') }}</th>
                                <th scope="col">{{ __('Delivery Time (days)') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shipping_methods as $method)
                                @php
                                    $vendor_method = $vendor_methods->firstWhere('id', $method->id);
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="methods[{{ $method->id }}][enabled]" value="1"
                                            {{ $vendor_method ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $method->name }}</td>
                                    <td>{{ $method->delivery_time }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        {{ __('No shipping methods available at the moment.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> {{ __('Save Changes') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
