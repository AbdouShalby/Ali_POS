@extends('layouts.app')

@section('title', '- ' . __('Dashboard'))

@section('content')

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="row g-5 gx-xl-12 mb-5 mb-xl-12">
                <div class="col-xxl-12">
                    <div class="row g-5 my-5 gx-xl-12">
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #F6E5CA">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('products.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('All Products') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="productsLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="productCount">{{ $totalProducts . ' ' . __('Products')}}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ $totalProducts }}" title="{{ __('Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #F3D6EF">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('crypto_gateways.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('Total Cryptocurrency Balance') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="cryptoLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="cryptoBalance">{{ number_format($totalCryptoBalance, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($totalCryptoBalance, 2) }}" title="{{ __('Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #BFDDE3">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('sales.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('Total Sales') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="salesLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="totalSales">${{ number_format($totalSales, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($totalSales, 2) }}" title="{{ __('Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #9deeb7">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('purchases.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('Total Purchases') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="purchasesLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="totalPurchases">${{ number_format($totalPurchases, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($totalPurchases, 2) }}" title="{{ __('Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-5 gx-xl-12">
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #F6E5CA">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('external_purchases.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('Total External Purchases') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="externalProductsLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="externalProductsLottie">${{ number_format($totalExternalPurchases, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($totalExternalPurchases, 2) }}" title="{{ __('Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #F3D6EF">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('suppliers.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('Total Suppliers') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="totalSuppliers" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="totalSuppliers">{{ $totalSuppliers }} {{ __('Suppliers') }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ $totalSuppliers }}" title="{{ __('Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #BFDDE3">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('maintenances.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('Phones in Maintenance') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="phonesInMaintenance" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="phonesInMaintenance">{{ $phonesInMaintenance }} {{ __('Phones') }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ $phonesInMaintenance }}" title="{{ __('Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #9deeb7">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <span class="card-label fw-bold fs-4 text-gray-800">{{ __('Total Cash Balance') }}</span>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="cashBalance" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="cashBalance">${{ number_format($cashBalance, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($cashBalance, 2) }}" title="{{ __('Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                        <div id="copyToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ __('Copy completed successfully!') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5 g-xl-10">
                <div class="col-xxl-8">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Latest Activity</span>
                                <span class="text-gray-500 mt-1 fw-semibold fs-7">Updated 37 minutes ago</span>
                            </h4>
                            <div class="card-toolbar">
                                <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-flex btn-sm btn-light d-flex align-items-center px-4">
                                    <div class="text-gray-600 fw-bold">Loading date range...</div>
                                    <i class="ki-duotone ki-calendar-8 text-gray-500 lh-0 fs-2 ms-2 me-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                </div>
                                <!--end::Daterangepicker-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr class="border-bottom-0">
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-175px"></th>
                                        <th class="p-0 min-w-175px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-50px"></th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-40px">
																			<span class="symbol-label bg-light-info">
																				<i class="ki-duotone ki-abstract-24 fs-2x text-info">
																					<span class="path1"></span>
																					<span class="path2"></span>
																				</i>
																			</span>
                                            </div>
                                        </td>
                                        <td class="ps-0">
                                            <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">Insurance</a>
                                            <span class="text-muted fw-semibold d-block fs-7">Personal Health</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">BTC Wallet</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Personal Account</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">23 Jan, 22</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Last Payment</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">-0.0024 BTC</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Balance</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                <i class="ki-duotone ki-arrow-right fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-40px">
																			<span class="symbol-label bg-light-success">
																				<i class="ki-duotone ki-flask fs-2x text-success">
																					<span class="path1"></span>
																					<span class="path2"></span>
																				</i>
																			</span>
                                            </div>
                                        </td>
                                        <td class="ps-0">
                                            <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">Annette Black</a>
                                            <span class="text-muted fw-semibold d-block fs-7">Zuid Area</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">ETH Wallet</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Personal Account</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">04 Feb, 22</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Last Payment</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">-0.346 ETH</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Balance</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                <i class="ki-duotone ki-arrow-right fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-40px">
																			<span class="symbol-label bg-light-danger">
																				<i class="ki-duotone ki-abstract-33 fs-2x text-danger">
																					<span class="path1"></span>
																					<span class="path2"></span>
																				</i>
																			</span>
                                            </div>
                                        </td>
                                        <td class="ps-0">
                                            <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">Esther Howard</a>
                                            <span class="text-muted fw-semibold d-block fs-7">Zuid Area</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">BTC Wallet</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Personal Account</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">18 Feb, 22</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Last Payment</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">-0.00081 BTC</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Balance</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                <i class="ki-duotone ki-arrow-right fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-40px">
																			<span class="symbol-label bg-light-primary">
																				<i class="ki-duotone ki-abstract-47 fs-2x text-primary">
																					<span class="path1"></span>
																					<span class="path2"></span>
																				</i>
																			</span>
                                            </div>
                                        </td>
                                        <td class="ps-0">
                                            <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">Guy Hawkins</a>
                                            <span class="text-muted fw-semibold d-block fs-7">Zuid Area</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">DOGE Wallet</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Personal Account</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">01 Apr, 22</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Last Payment</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">-456.34 DOGE</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Balance</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                <i class="ki-duotone ki-arrow-right fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-40px">
																			<span class="symbol-label bg-light-warning">
																				<i class="ki-duotone ki-technology-2 fs-2x text-warning">
																					<span class="path1"></span>
																					<span class="path2"></span>
																				</i>
																			</span>
                                            </div>
                                        </td>
                                        <td class="ps-0">
                                            <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">Marvin McKinney</a>
                                            <span class="text-muted fw-semibold d-block fs-7">Zuid Area</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">BTC Wallet</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Personal Account</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">26 May, 22</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Last Payment</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold d-block fs-6">-0.000039 BTC</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">Balance</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                <i class="ki-duotone ki-arrow-right fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('productsLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/products.json') }}"
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('cryptoLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/crypto.json') }}"
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('salesLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/sales.json') }}"
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('purchasesLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/purchases.json') }}"
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('externalProductsLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/external_purchases.json') }}"
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('totalSuppliers'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/suppliers.json') }}"
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('phonesInMaintenance'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/maintenances.json') }}"
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('cashBalance'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/cash.json') }}"
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var clipboard = new ClipboardJS('.copy-btn');

                clipboard.on('success', function(e) {
                    e.clearSelection();
                    var toastEl = document.getElementById('copyToast');
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                });

                clipboard.on('error', function(e) {
                    console.error('{{ __('Copy failed') }}:', e);
                });
            });
        </script>
    @endsection
@endsection
