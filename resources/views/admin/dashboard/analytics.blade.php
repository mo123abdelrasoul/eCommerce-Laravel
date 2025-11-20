@extends('admin.layouts.app')
@section('title', 'Admin Profile')

@section('content')
    <h1>Analytics Dashboard</h1>

    <canvas id="pageViewsChart"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pageViewsChart').getContext('2d');

        const labels = @json(array_map(fn($d) => $d['pageTitle'], $data));
        const values = @json(array_map(fn($d) => $d['views'], $data));

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Page Views (Last 7 Days)',
                    data: values,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
