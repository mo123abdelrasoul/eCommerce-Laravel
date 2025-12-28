@extends('vendor.layouts.app')

@section('title', 'Vendor Shipping Rates')

@section('content')
    <div class="container py-4">
        <h4 class="mb-4">Manage Shipping Rates</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There were some errors with your input:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendor.rates.store', app()->getLocale()) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Region</th>
                            <th>Method</th>
                            <th>Min Weight (g)</th>
                            <th>Max Weight (g)</th>
                            <th>Rate (EGP)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="rates-table">
                        @forelse ($rates as $index => $rate)
                            <tr>
                                <td>
                                    <select name="rates[{{ $index }}][region]" class="form-select">
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}"
                                                {{ $rate->shipping_region_id == $region->id ? 'selected' : '' }}>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="rates[{{ $index }}][method]" class="form-select">
                                        @foreach ($methods as $method)
                                            <option value="{{ $method->id }}"
                                                {{ $rate->shipping_method_id == $method->id ? 'selected' : '' }}>
                                                {{ $method->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" step="0.01" name="rates[{{ $index }}][min_weight]"
                                        class="form-control" value="{{ $rate->min_weight }}"></td>
                                <td><input type="number" step="0.01" name="rates[{{ $index }}][max_weight]"
                                        class="form-control" value="{{ $rate->max_weight }}"></td>
                                <td><input type="number" step="0.01" name="rates[{{ $index }}][rate]"
                                        class="form-control" value="{{ $rate->rate }}"></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <select name="rates[0][region]" class="form-select">
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="rates[0][method]" class="form-select">
                                        @foreach ($methods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" step="0.01" name="rates[0][min_weight]" class="form-control">
                                </td>
                                <td><input type="number" step="0.01" name="rates[0][max_weight]" class="form-control">
                                </td>
                                <td><input type="number" step="0.01" name="rates[0][rate]" class="form-control"></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <button type="button" id="add-row" class="btn btn-secondary mt-2">Add Row</button>
            <button type="submit" class="btn btn-primary mt-2"><i class="bi bi-save"></i>
                {{ __('Save Changes') }}</button>
        </form>
    </div>

    <script>
        document.getElementById('add-row').addEventListener('click', function() {
            const table = document.getElementById('rates-table');
            const index = table.rows.length;
            const newRow = table.rows[0].cloneNode(true);

            newRow.querySelectorAll('select, input').forEach(el => {
                const name = el.name.replace(/\d+/, index);
                el.name = name;
                el.value = '';
            });

            table.appendChild(newRow);
        });

        document.addEventListener('click', e => {
            if (e.target.classList.contains('remove-row')) {
                if (document.querySelectorAll('#rates-table tr').length > 0) {
                    e.target.closest('tr').remove();
                }
            }
        });
    </script>
@endsection
