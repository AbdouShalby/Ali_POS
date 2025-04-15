@extends('layouts.app')

@section('title', ' - تقرير المبيعات المفصل')

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
    .payment-method-card {
        border-radius: 8px;
        overflow: hidden;
    }
    .payment-method-card .card-body {
        padding: 1.5rem;
    }
    .chart-container {
        height: 350px;
    }
</style>
@endsection

@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">{{ __('تقرير المبيعات المفصل') }}</h3>
        </div>
        <div class="card-toolbar">
            <div class="dropdown me-2">
                <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                    <li><a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ route('language.switch', ['locale' => 'ar']) }}">العربية</a></li>
                    <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('language.switch', ['locale' => 'en']) }}">English</a></li>
                </ul>
            </div>
            <a href="{{ route('reports.sales.export.pdf') }}" class="btn btn-sm btn-light-primary me-2">
                <i class="bi bi-file-pdf"></i> تصدير PDF
            </a>
            <a href="{{ route('reports.sales.export.excel') }}" class="btn btn-sm btn-light-success">
                <i class="bi bi-file-excel"></i> تصدير Excel
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <!-- فلاتر البحث -->
        <div class="mb-7">
            <form action="{{ route('reports.detailed_sales') }}" method="GET" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" class="form-control" name="from" value="{{ request('from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" class="form-control" name="to" value="{{ request('to') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">طريقة الدفع</label>
                    <select class="form-select" name="payment_method">
                        <option value="">الكل</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>نقداً</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>بطاقة ائتمان</option>
                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">المستودع</label>
                    <select class="form-select" name="warehouse_id">
                        <option value="">الكل</option>
                        @foreach(\App\Models\Warehouse::all() as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">العميل</label>
                    <select class="form-select" name="customer_id">
                        <option value="">الكل</option>
                        @foreach(\App\Models\Customer::all() as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> بحث
                    </button>
                </div>
            </form>
        </div>

        <!-- بطاقات الإحصائيات -->
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
                                <h4 class="mb-1">إجمالي المبيعات</h4>
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
                                <h4 class="mb-1">إجمالي المبلغ</h4>
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
                                <h4 class="mb-1">إجمالي الضريبة</h4>
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
                                <h4 class="mb-1">إجمالي الخصم</h4>
                                <span class="text-warning fs-1 fw-bold">{{ number_format($totalDiscount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الرسوم البيانية -->
        <div class="row g-5 g-xl-8 mb-8">
            <div class="col-xl-6">
                <div class="card card-xl-stretch mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">المبيعات حسب طريقة الدفع</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="payment_methods_chart" class="chart-container"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card card-xl-stretch mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">المبيعات اليومية</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="daily_sales_chart" class="chart-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- تفاصيل المبيعات حسب طريقة الدفع -->
        <div class="row g-5 g-xl-8 mb-8">
            @foreach($paymentMethodStats as $stat)
            <div class="col-xl-4">
                <div class="card payment-method-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-5">
                            <div class="symbol symbol-40px me-4">
                                @if($stat->payment_method == 'cash')
                                <div class="symbol-label fs-2 bg-light-success text-success">
                                    <i class="bi bi-cash"></i>
                                </div>
                                @elseif($stat->payment_method == 'card')
                                <div class="symbol-label fs-2 bg-light-primary text-primary">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                                @else
                                <div class="symbol-label fs-2 bg-light-info text-info">
                                    <i class="bi bi-bank"></i>
                                </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    @if($stat->payment_method == 'cash')
                                        نقداً
                                    @elseif($stat->payment_method == 'card')
                                        بطاقة ائتمان
                                    @elseif($stat->payment_method == 'bank_transfer')
                                        تحويل بنكي
                                    @else
                                        {{ $stat->payment_method }}
                                    @endif
                                </h4>
                                <span class="text-muted">طريقة الدفع</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">عدد المبيعات</span>
                            <span class="fw-bold">{{ $stat->count }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">إجمالي المبلغ</span>
                            <span class="fw-bold">{{ number_format($stat->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- جدول المبيعات -->
        <div class="card">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">قائمة المبيعات</span>
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="sales_table">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-100px">رقم الفاتورة</th>
                                <th class="min-w-150px">التاريخ</th>
                                <th class="min-w-150px">العميل</th>
                                <th class="min-w-150px">المستودع</th>
                                <th class="min-w-100px">طريقة الدفع</th>
                                <th class="min-w-100px">الضريبة</th>
                                <th class="min-w-100px">الخصم</th>
                                <th class="min-w-100px">الإجمالي</th>
                                <th class="min-w-100px">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $sale->customer ? $sale->customer->name : 'بدون عميل' }}</td>
                                <td>{{ $sale->warehouse ? $sale->warehouse->name : '-' }}</td>
                                <td>
                                    @if($sale->payment_method == 'cash')
                                        <span class="badge badge-light-success">نقداً</span>
                                    @elseif($sale->payment_method == 'card')
                                        <span class="badge badge-light-primary">بطاقة ائتمان</span>
                                    @elseif($sale->payment_method == 'bank_transfer')
                                        <span class="badge badge-light-info">تحويل بنكي</span>
                                    @else
                                        <span class="badge badge-light-dark">{{ $sale->payment_method }}</span>
                                    @endif
                                </td>
                                <td>{{ number_format($sale->tax, 2) }}</td>
                                <td>{{ number_format($sale->discount, 2) }}</td>
                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('pos.receipt', $sale->id) }}" class="btn btn-icon btn-light-primary btn-sm me-1" target="_blank">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    <button type="button" class="btn btn-icon btn-light-info btn-sm view-products" data-sale-id="{{ $sale->id }}">
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

<!-- Modal لعرض منتجات البيع -->
<div class="modal fade" id="sale_products_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل المنتجات</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-150px">المنتج</th>
                                <th class="min-w-100px">الكمية</th>
                                <th class="min-w-100px">السعر</th>
                                <th class="min-w-100px">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody id="products_list">
                            <!-- سيتم ملء هذا الجزء بواسطة جافاسكريبت -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
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
        // إعداد جدول المبيعات
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

        // عرض منتجات البيع
        $('.view-products').on('click', function() {
            const saleId = $(this).data('sale-id');
            
            // إظهار رسالة تحميل
            $('#products_list').html('<tr><td colspan="4" class="text-center">جاري التحميل...</td></tr>');
            
            // فتح النافذة المنبثقة
            $('#sale_products_modal').modal('show');
            
            // جلب بيانات المنتجات
            $.ajax({
                url: '{{ route("sales.products", ":id") }}'.replace(':id', saleId),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let html = '';
                    
                    if (response && response.success && response.products && response.products.length > 0) {
                        response.products.forEach(function(product) {
                            // التأكد من أن القيم رقمية
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
                        html = '<tr><td colspan="4" class="text-center">لا توجد منتجات</td></tr>';
                    }
                    
                    $('#products_list').html(html);
                },
                error: function() {
                    $('#products_list').html('<tr><td colspan="4" class="text-center text-danger">حدث خطأ أثناء تحميل البيانات</td></tr>');
                }
            });
        });

        // رسم بياني للمبيعات حسب طريقة الدفع
        const paymentMethodsData = @json($paymentMethodStats);
        const paymentMethodsLabels = paymentMethodsData.map(item => {
            if (item.payment_method === 'cash') return 'نقداً';
            if (item.payment_method === 'card') return 'بطاقة ائتمان';
            if (item.payment_method === 'bank_transfer') return 'تحويل بنكي';
            return item.payment_method;
        });
        
        const paymentMethodsValues = paymentMethodsData.map(item => parseFloat(item.total_amount));
        
        const paymentMethodsChart = new ApexCharts(document.querySelector("#payment_methods_chart"), {
            series: paymentMethodsValues,
            chart: {
                type: 'donut',
                height: 350
            },
            labels: paymentMethodsLabels,
            colors: ['#50CD89', '#009EF7', '#7239EA'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        });
        
        paymentMethodsChart.render();

        // رسم بياني للمبيعات اليومية
        const dailySalesData = @json($dailySales);
        const dailySalesDates = dailySalesData.map(item => item.date);
        const dailySalesAmounts = dailySalesData.map(item => parseFloat(item.total_amount));
        const dailySalesCounts = dailySalesData.map(item => parseInt(item.count));
        
        const dailySalesChart = new ApexCharts(document.querySelector("#daily_sales_chart"), {
            series: [{
                name: 'إجمالي المبيعات',
                type: 'column',
                data: dailySalesAmounts
            }, {
                name: 'عدد المبيعات',
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
            yaxis: [
                {
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#50CD89'
                    },
                    labels: {
                        style: {
                            colors: '#50CD89',
                        }
                    },
                    title: {
                        text: "إجمالي المبيعات",
                        style: {
                            color: '#50CD89',
                        }
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                {
                    seriesName: 'عدد المبيعات',
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#009EF7'
                    },
                    labels: {
                        style: {
                            colors: '#009EF7',
                        }
                    },
                    title: {
                        text: "عدد المبيعات",
                        style: {
                            color: '#009EF7',
                        }
                    },
                }
            ],
            tooltip: {
                fixed: {
                    enabled: true,
                    position: 'topLeft',
                    offsetY: 30,
                    offsetX: 60
                },
            },
            legend: {
                horizontalAlign: 'center',
                offsetX: 40
            }
        });
        
        dailySalesChart.render();
    });
</script>
@endsection
