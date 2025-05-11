@extends('layouts.app')

@section('title', '- ' . __('dashboard.dashboard'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('dashboard.dashboard') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('dashboard.dashboard') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Stats Cards -->
            <div class="row g-5 g-xl-8 mb-5">
                <!-- Total Sales -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C;background-image:url('/assets/media/svg/shapes/wave-bg-red.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ number_format($totalSales, 2) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('dashboard.total_sales') }}</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-white opacity-75 fw-semibold fs-6">{{ __('dashboard.today_sales') }}</span>
                                    <span class="text-white fw-bold fs-6">{{ number_format($todaySales, 2) }}</span>
                                </div>
                            </div>
                        </div>
                                    </div>
                                </div>

                <!-- Total Purchases -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #20D489;background-image:url('/assets/media/svg/shapes/wave-bg-green.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ number_format($totalPurchases, 2) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('dashboard.total_purchases') }}</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-white opacity-75 fw-semibold fs-6">{{ __('dashboard.today_purchases') }}</span>
                                    <span class="text-white fw-bold fs-6">{{ number_format($todayPurchases, 2) }}</span>
                                </div>
                            </div>
                        </div>
                                    </div>
                                </div>

                <!-- Total Profit -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url('/assets/media/svg/shapes/wave-bg-purple.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ number_format($totalProfit, 2) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('dashboard.total_profit') }}</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-white opacity-75 fw-semibold fs-6">{{ __('dashboard.today_profit') }}</span>
                                    <span class="text-white fw-bold fs-6">{{ number_format($todayProfit, 2) }}</span>
                                </div>
                            </div>
                        </div>
                                    </div>
                                </div>

                <!-- Total Expenses -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #009EF7;background-image:url('/assets/media/svg/shapes/wave-bg-blue.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ number_format($totalExpenses, 2) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('dashboard.total_expenses') }}</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-white opacity-75 fw-semibold fs-6">{{ __('dashboard.today_expenses') }}</span>
                                    <span class="text-white fw-bold fs-6">{{ number_format($todayExpenses, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-5 g-xl-8 mb-5">
                <!-- Sales Chart -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ __('dashboard.sales_chart') }}</span>
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('dashboard.last_30_days') }}</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="w-100">
                                <div id="kt_charts_widget_1_chart" style="height: 350px"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchases Chart -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ __('dashboard.purchases_chart') }}</span>
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('dashboard.last_30_days') }}</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="w-100">
                                <div id="kt_charts_widget_2_chart" style="height: 350px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tables Row -->
            <div class="row g-5 g-xl-8">
                <!-- Latest Sales -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ __('dashboard.latest_sales') }}</span>
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('dashboard.last_10_sales') }}</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_latest_sales_table">
                                        <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">{{ __('dashboard.invoice_number') }}</th>
                                            <th class="min-w-125px">{{ __('dashboard.customer') }}</th>
                                            <th class="min-w-125px">{{ __('dashboard.amount') }}</th>
                                            <th class="min-w-125px">{{ __('dashboard.date') }}</th>
                                        </tr>
                                        </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @forelse($latestSales as $sale)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('sales.show', $sale->id) }}" class="text-dark fw-bold text-hover-primary fs-6">{{ $sale->invoice_number }}</a>
                                                </td>
                                                <td>{{ $sale->customer->name ?? '-' }}</td>
                                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                                <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="bi bi-inbox fs-2x text-gray-400 mb-3"></i>
                                                        <span class="text-gray-600 fs-6">{{ __('dashboard.no_sales_found') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Purchases -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ __('dashboard.latest_purchases') }}</span>
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">{{ __('dashboard.last_10_purchases') }}</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_latest_purchases_table">
                                        <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">{{ __('dashboard.invoice_number') }}</th>
                                            <th class="min-w-125px">{{ __('dashboard.supplier') }}</th>
                                            <th class="min-w-125px">{{ __('dashboard.amount') }}</th>
                                            <th class="min-w-125px">{{ __('dashboard.date') }}</th>
                                        </tr>
                                        </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @forelse($latestPurchases as $purchase)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="text-dark fw-bold text-hover-primary fs-6">{{ $purchase->invoice_number }}</a>
                                                </td>
                                                <td>{{ $purchase->supplier->name }}</td>
                                                <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                                <td>{{ $purchase->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="bi bi-inbox fs-2x text-gray-400 mb-3"></i>
                                                        <span class="text-gray-600 fs-6">{{ __('dashboard.no_purchases_found') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            // Initialize ApexCharts
            var options1 = {
                series: [{
                    name: 'Sales',
                    data: @json($salesData)
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    area: {
                        fillTo: 'end'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: @json($salesDates),
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#A1A5B7',
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#A1A5B7',
                            fontSize: '12px'
                        }
                    }
                },
                grid: {
                    borderColor: '#F1F1F1',
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val.toFixed(2);
                        }
                    }
                }
            };

            var options2 = {
                series: [{
                    name: 'Purchases',
                    data: @json($purchasesData)
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    area: {
                        fillTo: 'end'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: @json($purchasesDates),
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#A1A5B7',
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#A1A5B7',
                            fontSize: '12px'
                        }
                    }
                },
                grid: {
                    borderColor: '#F1F1F1',
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val.toFixed(2);
                        }
                    }
                }
            };

            var chart1 = new ApexCharts(document.querySelector("#kt_charts_widget_1_chart"), options1);
            var chart2 = new ApexCharts(document.querySelector("#kt_charts_widget_2_chart"), options2);

            chart1.render();
            chart2.render();
        </script>
    @endsection
@endsection
