@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">لوحة التحكم</h1>
            </div>
        </div>

        <!-- البطاقات الإحصائية -->
        <div class="row">
            <!-- بطاقة المنتجات -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('products.index') }}" class="text-white text-decoration-none">
                            <i class="bi bi-box-seam me-2"></i> عدد المنتجات
                        </a>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0" id="productCount">{{ $totalProducts }}</h5>
                        <button class="btn btn-sm btn-light copy-btn" data-clipboard-text="{{ $totalProducts }}" title="نسخ">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- بطاقة رصيد العملات المشفرة -->
            <div class="col-md-3">
                <div class="card text-white bg-dark mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('crypto_gateways.index') }}" class="text-white text-decoration-none">
                            <i class="bi bi-currency-bitcoin me-2"></i> إجمالي رصيد العملات المشفرة
                        </a>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0" id="cryptoBalance">{{ number_format($totalCryptoBalance, 2) }}</h5>
                        <button class="btn btn-sm btn-light copy-btn" data-clipboard-text="{{ number_format($totalCryptoBalance, 2) }}" title="نسخ">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- بطاقة إجمالي المبيعات -->
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('sales.index') }}" class="text-white text-decoration-none">
                            <i class="bi bi-cash me-2"></i> إجمالي المبيعات
                        </a>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0" id="totalSales">{{ number_format($totalSales, 2) }}</h5>
                        <button class="btn btn-sm btn-light copy-btn" data-clipboard-text="{{ number_format($totalSales, 2) }}" title="نسخ">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- بطاقة إجمالي المشتريات -->
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('purchases.index') }}" class="text-white text-decoration-none">
                            <i class="bi bi-cart me-2"></i> إجمالي المشتريات
                        </a>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0" id="totalPurchases">{{ number_format($totalPurchases, 2) }}</h5>
                        <button class="btn btn-sm btn-light copy-btn" data-clipboard-text="{{ number_format($totalPurchases, 2) }}" title="نسخ">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- بطاقة إجمالي المشتريات -->
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('external_purchases.index') }}" class="text-white text-decoration-none">
                            <i class="bi bi-cart me-2"></i> إجمالي المشتريات الخارجية
                        </a>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0" id="totalPurchases">{{ number_format($totalExternalPurchases, 2) }}</h5>
                        <button class="btn btn-sm btn-light copy-btn" data-clipboard-text="{{ number_format($totalExternalPurchases, 2) }}" title="نسخ">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- بطاقة الأقسام -->
            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('categories.index') }}" class="text-white text-decoration-none">
                            <i class="bi bi-list-ul me-2"></i> عدد الأقسام
                        </a>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0" id="totalCategories">{{ $totalCategories }}</h5>
                        <button class="btn btn-sm btn-light copy-btn" data-clipboard-text="{{ $totalCategories }}" title="نسخ">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- بطاقة الهواتف في الصيانة -->
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('maintenances.index') }}" class="text-white text-decoration-none">
                            <i class="bi bi-tools me-2"></i> عدد الهواتف في الصيانة
                        </a>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0" id="phonesInMaintenance">{{ $phonesInMaintenance }}</h5>
                        <button class="btn btn-sm btn-light copy-btn" data-clipboard-text="{{ $phonesInMaintenance }}" title="نسخ">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- بطاقة رصيد الخزنة -->
            <div class="col-md-3">
                <div class="card text-white bg-dark mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <i class="bi bi-piggy-bank me-2"></i> رصيد الخزنة
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0" id="cashBalance">{{ number_format($cashBalance, 2) }}</h5>
                        <button class="btn btn-sm btn-light copy-btn" data-clipboard-text="{{ number_format($cashBalance, 2) }}" title="نسخ">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast للنسخ -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="copyToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        تم النسخ بنجاح!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- أكثر 10 منتجات مبيعًا -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>أكثر 10 منتجات مبيعًا</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>إجمالي الكمية المباعة</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($topSellingProducts as $item)
                        <tr>
                            <td>{{ $item->product ? $item->product->name : 'غير محدد' }}</td>
                            <td>{{ $item->total_quantity }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- المنتجات الأقل كمية -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>المنتجات الأقل كمية (أقل من 5)</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>اسم المنتج</th>
                        <th>الكمية المتبقية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($veryLowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->quantity }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- آخر 10 أجهزة في الصيانة -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>آخر 10 أجهزة في الصيانة</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>الجهاز</th>
                        <th>الحالة</th>
                        <th>تاريخ الاستلام</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($latestMaintenances as $maintenance)
                        <tr>
                            <td>{{ $maintenance->device_name }}</td>
                            <td>{{ $maintenance->status }}</td>
                            <td>{{ $maintenance->received_date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- آخر 10 مبيعات -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>آخر 10 مبيعات</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>العميل</th>
                        <th>التاريخ</th>
                        <th>إجمالي الفاتورة</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($latestSales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->customer->name ?? 'غير محدد' }}</td>
                            <td>{{ $sale->sale_date }}</td>
                            <td>{{ number_format($sale->total_amount, 2) }} جنيه</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- آخر 10 مشتريات -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>آخر 10 مشتريات</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>المورد</th>
                        <th>التاريخ</th>
                        <th>إجمالي الفاتورة</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($latestPurchases as $purchase)
                        <tr>
                            <td>{{ $purchase->id }}</td>
                            <td>{{ $purchase->supplier->name ?? 'غير محدد' }}</td>
                            <td>{{ $purchase->purchase_date }}</td>
                            <td>{{ number_format($purchase->total_amount, 2) }} جنيه</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- آخر 5 أقسام -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>آخر 5 أقسام</h3>
                <ul class="list-group">
                    @foreach($latestCategories as $category)
                        <li class="list-group-item">{{ $category->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- آخر 10 عمليات شراء في العملات المشفرة -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>آخر 10 عمليات شراء في العملات المشفرة</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>رقم العملية</th>
                        <th>بوابة الدفع</th>
                        <th>المبلغ</th>
                        <th>تاريخ العملية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($latestCryptoBuys as $buy)
                        <tr>
                            <td>{{ $buy->id }}</td>
                            <td>{{ $buy->cryptoGateway->name ?? 'غير محدد' }}</td>
                            <td>{{ number_format($buy->amount, 8) }}</td>
                            <td>{{ $buy->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- آخر 10 عمليات بيع في العملات المشفرة -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>آخر 10 عمليات بيع في العملات المشفرة</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>رقم العملية</th>
                        <th>بوابة الدفع</th>
                        <th>المبلغ</th>
                        <th>تاريخ العملية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($latestCryptoSells as $sell)
                        <tr>
                            <td>{{ $sell->id }}</td>
                            <td>{{ $sell->cryptoGateway->name ?? 'غير محدد' }}</td>
                            <td>{{ number_format($sell->amount, 8) }}</td>
                            <td>{{ $sell->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- آخر 5 عملاء -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>آخر 5 عملاء</h3>
                <ul class="list-group">
                    @foreach($latestCustomers as $customer)
                        <li class="list-group-item">{{ $customer->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- آخر 5 موردين -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>آخر 5 موردين</h3>
                <ul class="list-group">
                    @foreach($latestSuppliers as $supplier)
                        <li class="list-group-item">{{ $supplier->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var clipboard = new ClipboardJS('.copy-btn');

                clipboard.on('success', function(e) {
                    e.clearSelection();
                    // عرض Toast عند النسخ
                    var toastEl = document.getElementById('copyToast');
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                });

                clipboard.on('error', function(e) {
                    console.error('فشل النسخ:', e);
                });
            });
        </script>
    @endsection
@endsection
