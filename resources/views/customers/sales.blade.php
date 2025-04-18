@extends('layouts.app')

@section('title', ' - ' . $customer->name . ' - ' . __('reports.sales_report'))

@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/custom/apexcharts/apexcharts.css') }}" rel="stylesheet" type="text/css" />
<style>
    .stats-card {
        transition: all 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.08);
    }
    .chart-container {
        height: 350px;
    }
</style>
@endsection

@section('content')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">{{ $customer->name }} - {{ __('reports.sales_report') }}</h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('customers.sales.export.pdf', $customer->id) }}" class="btn btn-sm btn-light-primary me-2">
                <i class="bi bi-file-pdf"></i> {{ __('reports.export_pdf') }}
            </a>
            <a href="{{ route('customers.sales.export.excel', $customer->id) }}" class="btn btn-sm btn-light-success">
                <i class="bi bi-file-excel"></i> {{ __('reports.export_excel') }}
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Filters -->
        <div class="mb-7">
            <form action="{{ route('customers.sales', $customer->id) }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">{{ __('reports.from_date') }}</label>
                    <input type="date" class="form-control" name="from" value="{{ request('from') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('reports.to_date') }}</label>
                    <input type="date" class="form-control" name="to" value="{{ request('to') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('reports.payment_method') }}</label>
                    <select class="form-select" name="payment_method">
                        <option value="">{{ __('reports.all') }}</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>{{ __('reports.cash') }}</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>{{ __('reports.card') }}</option>
                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>{{ __('reports.bank_transfer') }}</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> {{ __('reports.search') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-5 g-xl-8 mb-8">
            <div class="col-xl-3">
                <div class="card bg-light-primary stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label bg-primary">
                                    <i class="bi bi-receipt-cutoff text-white fs-2x"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1">{{ __('reports.number_of_sales') }}</h4>
                                <span class="text-primary fs-1 fw-bold">{{ $totalSales }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card bg-light-success stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label bg-success">
                                    <i class="bi bi-cash-coin text-white fs-2x"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1">{{ __('reports.total_amount') }}</h4>
                                <span class="text-success fs-1 fw-bold">{{ number_format($totalAmount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card bg-light-info stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label bg-info">
                                    <i class="bi bi-percent text-white fs-2x"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1">{{ __('reports.total_tax') }}</h4>
                                <span class="text-info fs-1 fw-bold">{{ number_format($totalTax, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card bg-light-warning stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label bg-warning">
                                    <i class="bi bi-tag text-white fs-2x"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1">{{ __('reports.total_discount') }}</h4>
                                <span class="text-warning fs-1 fw-bold">{{ number_format($totalDiscount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="card mb-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">{{ __('reports.daily_sales') }}</span>
                </h3>
            </div>
            <div class="card-body">
                <div id="daily_sales_chart" class="chart-container"></div>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="card">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">{{ __('reports.sales_report') }}</span>
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="sales_table">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-100px">{{ __('reports.invoice_number') }}</th>
                                <th class="min-w-150px">{{ __('reports.date_time') }}</th>
                                <th class="min-w-150px">{{ __('reports.warehouse_name') }}</th>
                                <th class="min-w-100px">{{ __('reports.payment_method') }}</th>
                                <th class="min-w-100px">{{ __('reports.tax') }}</th>
                                <th class="min-w-100px">{{ __('reports.discount') }}</th>
                                <th class="min-w-100px">{{ __('reports.total') }}</th>
                                <th class="min-w-100px">{{ __('reports.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $sale->warehouse ? $sale->warehouse->name : '-' }}</td>
                                <td>
                                    @if($sale->payment_method == 'cash')
                                        <span class="badge badge-light-success">{{ __('reports.cash') }}</span>
                                    @elseif($sale->payment_method == 'card')
                                        <span class="badge badge-light-primary">{{ __('reports.card') }}</span>
                                    @elseif($sale->payment_method == 'bank_transfer')
                                        <span class="badge badge-light-info">{{ __('reports.bank_transfer') }}</span>
                                    @else
                                        <span class="badge badge-light-dark">{{ $sale->payment_method }}</span>
                                    @endif
                                </td>
                                <td>{{ number_format($sale->tax, 2) }}</td>
                                <td>{{ number_format($sale->discount, 2) }}</td>
                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('pos.receipt', $sale->id) }}" class="btn btn-icon btn-light-primary btn-sm me-1" target="_blank" title="{{ __('reports.print') }}">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    <button type="button" class="btn btn-icon btn-light-info btn-sm view-products" data-sale-id="{{ $sale->id }}" title="{{ __('reports.view') }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    {{ $sales->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Modal -->
<div class="modal fade" id="sale_products_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('reports.product_details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-150px">{{ __('reports.product') }}</th>
                                <th class="min-w-100px">{{ __('reports.quantity') }}</th>
                                <th class="min-w-100px">{{ __('reports.price') }}</th>
                                <th class="min-w-100px">{{ __('reports.total_price') }}</th>
                            </tr>
                        </thead>
                        <tbody id="products_list">
                            <!-- Will be filled by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('reports.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('plugins/custom/apexcharts/apexcharts.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        if ($('#sales_table').length > 0) {
            $('#sales_table').DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: true,
                language: {
                    url: '{{ app()->getLocale() == "ar" ? asset("plugins/custom/datatables/i18n/Arabic.json") : asset("plugins/custom/datatables/i18n/English.json") }}'
                }
            });
        }

        // View Products
        $('.view-products').on('click', function() {
            const saleId = $(this).data('sale-id');
            
            $('#products_list').html(`<tr><td colspan="4" class="text-center">${'{{ __("reports.loading") }}'}</td></tr>`);
            $('#sale_products_modal').modal('show');
            
            $.ajax({
                url: '{{ route("sales.products", ":id") }}'.replace(':id', saleId),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let html = '';
                    
                    if (response && response.success && response.products && response.products.length > 0) {
                        response.products.forEach(function(product) {
                            const quantity = parseFloat(product.pivot.quantity) || 0;
                            const price = parseFloat(product.pivot.price) || 0;
                            const total = quantity * price;
                            
                            html += `
                                <tr>
                                    <td>${product.name || ''}</td>
                                    <td>${quantity}</td>
                                    <td>${price.toFixed(2)}</td>
                                    <td>${total.toFixed(2)}</td>
                                </tr>
                            `;
                        });
                    } else {
                        html = `<tr><td colspan="4" class="text-center">${'{{ __("reports.no_products") }}'}</td></tr>`;
                    }
                    
                    $('#products_list').html(html);
                },
                error: function() {
                    $('#products_list').html(`<tr><td colspan="4" class="text-center text-danger">${'{{ __("reports.error_loading") }}'}</td></tr>`);
                }
            });
        });

        // Daily Sales Chart
        const dailySalesData = @json($dailySales);
        const dailySalesDates = dailySalesData.map(item => item.date).reverse();
        const dailySalesAmounts = dailySalesData.map(item => item.total_amount).reverse();
        const dailySalesCounts = dailySalesData.map(item => item.count).reverse();

        const dailySalesChart = new ApexCharts(document.querySelector("#daily_sales_chart"), {
            series: [{
                name: '{{ __("reports.total_sales_amount") }}',
                type: 'column',
                data: dailySalesAmounts
            }, {
                name: '{{ __("reports.number_of_transactions") }}',
                type: 'line',
                data: dailySalesCounts
            }],
            chart: {
                height: 350,
                type: 'line',
                stacked: false,
                toolbar: {
                    show: true
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [1, 4]
            },
            xaxis: {
                categories: dailySalesDates,
            },
            yaxis: [{
                title: {
                    text: '{{ __("reports.total_sales_amount") }}',
                    style: {
                        fontSize: '12px'
                    }
                }
            }, {
                opposite: true,
                title: {
                    text: '{{ __("reports.number_of_transactions") }}',
                    style: {
                        fontSize: '12px'
                    }
                }
            }],
            tooltip: {
                shared: true,
                intersect: false,
                x: {
                    show: true
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center'
            }
        });
        dailySalesChart.render();
    });
</script>
@endsection 