@extends('layouts.app')

@section('title', __('Cash Register Charts'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('Cash Register Charts') }}
                </h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Monthly Income and Expenses') }}</h3>
                </div>
                <div class="card-body">
                    <canvas id="incomeExpensesChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('incomeExpensesChart').getContext('2d');

            const chartData = {
                labels: @json($months),
                datasets: [
                    {
                        label: '{{ __('Total Income') }}',
                        data: @json($income),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true,
                    },
                    {
                        label: '{{ __('Total Expenses') }}',
                        data: @json($expenses),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: true,
                    },
                ],
            };

            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: '{{ __('Monthly Income and Expenses') }}',
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: '{{ __('Month') }}',
                            },
                        },
                        y: {
                            title: {
                                display: true,
                                text: '{{ __('Amount') }}',
                            },
                            beginAtZero: true,
                        },
                    },
                },
            });
        });
    </script>
@endsection
