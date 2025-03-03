@extends('layouts.app')

@section('title', '- ' . __('dashboard.Dashboard'))

@section('content')

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="row g-5 gx-xl-12 mb-5 mb-xl-12">
                <div class="col-xxl-12">
                    <div class="row g-5 my-5 gx-xl-12 justify-content-center">
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #FBE7C6">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('products.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.All Products') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="productsLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="productCount">{{ $totalProducts . ' ' . __('dashboard.Products')}}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ $totalProducts }}" title="{{ __('dashboard.Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #A0E7E5">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('warehouses.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.All Products Stock') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="productsStockLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="productStockCount">{{ $totalProductsStock . ' ' . __('dashboard.Products')}}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ $totalProductsStock }}" title="{{ __('dashboard.Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #B4F8C8">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('crypto_gateways.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.Total Cryptocurrency Balance') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="cryptoLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="cryptoBalance">{{ number_format($totalCryptoBalance, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($totalCryptoBalance, 2) }}" title="{{ __('dashboard.Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #FFAEBC">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('suppliers.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.Total Suppliers') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="totalSuppliers" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="totalSuppliers">{{ $totalSuppliers }} {{ __('dashboard.Suppliers') }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ $totalSuppliers }}" title="{{ __('dashboard.Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #FBE7C6">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('sales.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.Total Sales') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="salesLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="totalSales">${{ number_format($totalSales, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($totalSales, 2) }}" title="{{ __('dashboard.Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #A0E7E5">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('purchases.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.Total Purchases') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="purchasesLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="totalPurchases">${{ number_format($totalPurchases, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($totalPurchases, 2) }}" title="{{ __('dashboard.Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #B4F8C8">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('external_purchases.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.Total External Purchases') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="externalProductsLottie" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="externalProductsLottie">${{ number_format($totalExternalPurchases, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($totalExternalPurchases, 2) }}" title="{{ __('dashboard.Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #FFAEBC">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('maintenances.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.Total Phones in Maintenance') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="totalPhonesInMaintenance" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="totalPhonesInMaintenance">{{ $phonesInMaintenance }} {{ __('dashboard.Phones') }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ $phonesInMaintenance }}" title="{{ __('dashboard.Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #FBE7C6">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <a href="{{ route('maintenances.index') }}" class="text-white text-decoration-none text-center">
                                            <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.Phones in Maintenance') }}</span>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="phonesInMaintenance" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center">{{ $maintenanceInProgress  }} {{ __('dashboard.Phones In Progress') }}</span>
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center">{{ $maintenanceCompleted  }} {{ __('dashboard.Phones Completed') }}</span>
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center">{{ $maintenancePending  }} {{ __('dashboard.Phones Pending') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #A0E7E5">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.Total Debt') }}</span>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="totalDebt" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="totalDebt">${{ number_format($totalDebt, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($totalDebt, 2) }}" title="{{ __('dashboard.Copy') }}">
                                            Copy <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-flush h-xl-100" style="background-color: #B4F8C8">
                                <div class="card-header flex-nowrap pt-5">
                                    <h3 class="card-title align-items-center flex-column m-auto">
                                        <span class="card-label fw-bold fs-4 text-gray-800">{{ __('dashboard.Total Cash Balance') }}</span>
                                    </h3>
                                </div>
                                <div class="card-body text-center pt-5 m-auto">
                                    <div id="cashBalance" style="height: 150px; width: 150px; margin-bottom: 10px;"></div>
                                    <div class="text-start">
                                        <span class="d-block fw-bold fs-1 text-gray-800 text-center" id="cashBalance">${{ number_format($cashBalance, 2) }}</span>
                                        <button class="btn btn-sm btn-light copy-btn d-block w-100" data-clipboard-text="{{ number_format($cashBalance, 2) }}" title="{{ __('dashboard.Copy') }}">
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
                                    {{ __('dashboard.Copy completed successfully!') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5 g-xl-12">
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Top 10 Selling Products') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                @if($topSellingProducts->isEmpty())
                                    <div class="text-center text-gray-500 fs-6 mt-5">
                                        {{ __('dashboard.There Are No Products Sold Yet') }}
                                    </div>
                                @else
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                        <tr class="border-bottom-1">
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Product') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Total Quantity Sold') }}</th>
                                            <th class="p-0 min-w-50px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($topSellingProducts as $item)
                                            <tr>
                                                <td class="ps-0">
                                                    <a href="{{ route('products.show', $item->product->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $item->product ? $item->product->name : 'Undefined' }}</a>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $item->total_quantity }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('products.show', $item->product->id) }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                        <i class="ki-duotone ki-arrow-right fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Lowest Stock Products (Less Than 5)') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
{{--                                @if($veryLowStockProducts->isEmpty())--}}
{{--                                    <div class="text-center text-gray-500 fs-6 mt-5">--}}
{{--                                        {{ __('dashboard.No Products With Low Stock') }}--}}
{{--                                    </div>--}}
{{--                                @else--}}
{{--                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">--}}
{{--                                        <thead>--}}
{{--                                        <tr class="border-bottom-1">--}}
{{--                                            <th class="p-0 min-w-175px">{{ __('dashboard.Product') }}</th>--}}
{{--                                            <th class="p-0 min-w-175px">{{ __('dashboard.Remaining Stock') }}</th>--}}
{{--                                            <th class="p-0 min-w-50px"></th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}
{{--                                        @foreach($veryLowStockProducts as $product)--}}
{{--                                            <tr>--}}
{{--                                                <td class="ps-0">--}}
{{--                                                    <a href="{{ route('products.show', $product->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $product->name }}</a>--}}
{{--                                                </td>--}}
{{--                                                <td class="ps-0">--}}
{{--                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $product->quantity }}</span>--}}
{{--                                                </td>--}}
{{--                                                <td class="text-end">--}}
{{--                                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                        <i class="ki-duotone ki-arrow-right fs-2">--}}
{{--                                                            <span class="path1"></span>--}}
{{--                                                            <span class="path2"></span>--}}
{{--                                                        </i>--}}
{{--                                                    </a>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                @endif--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5 g-xl-12 my-1">
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Latest 10 Devices In Maintenance') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                @if($latestMaintenances->isEmpty())
                                    <div class="text-center text-gray-500 fs-6 mt-5">
                                        {{ __('dashboard.There Are No Phones For Maintenance') }}
                                    </div>
                                @else
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                        <tr class="border-bottom-1">
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Customer Name') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Customer Phone') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Device Type') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Status') }}</th>
                                            <th class="p-0 min-w-50px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestMaintenances as $maintenance)
                                            <tr>
                                                <td class="ps-0">
                                                    <a href="{{ route('maintenances.show', $maintenance->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $maintenance->customer_name }}</a>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $maintenance->phone_number }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $maintenance->device_type }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $maintenance->status }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('maintenances.show', $maintenance->id) }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                        <i class="ki-duotone ki-arrow-right fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Latest 10 Sales') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                @if($latestSales->isEmpty())
                                    <div class="text-center text-gray-500 fs-6 mt-5">
                                        {{ __('dashboard.There Are No Products Sold Yet') }}
                                    </div>
                                @else
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                        <tr class="border-bottom-1">
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Invoice ID') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Customer Name') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Total') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Date') }}</th>
                                            <th class="p-0 min-w-50px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestSales as $sale)
                                            <tr>
                                                <td class="ps-0">
                                                    <a href="{{ route('sales.show', $sale->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $sale->id }}</a>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $sale->customer->name ?? 'Undefined' }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ number_format($sale->total_amount, 2) }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $sale->sale_date }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                        <i class="ki-duotone ki-arrow-right fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5 g-xl-12 my-1">
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Latest 10 Purchases') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                @if($latestPurchases->isEmpty())
                                    <div class="text-center text-gray-500 fs-6 mt-5">
                                        {{ __('dashboard.There Are No Purchases Yet') }}
                                    </div>
                                @else
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                        <tr class="border-bottom-1">
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Invoice ID') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Supplier') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Total') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Date') }}</th>
                                            <th class="p-0 min-w-50px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestPurchases as $purchase)
                                            <tr>
                                                <td class="ps-0">
                                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $purchase->id }}</a>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $purchase->supplier->name ?? 'Undefined' }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ number_format($purchase->total_amount, 2) }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $purchase->purchase_date }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                        <i class="ki-duotone ki-arrow-right fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Latest 5 Categories') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                @if($latestCategories->isEmpty())
                                    <div class="text-center text-gray-500 fs-6 mt-5">
                                        {{ __('dashboard.There Are No Categories Yet') }}
                                    </div>
                                @else
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                        <tr class="border-bottom-1">
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Category') }}</th>
                                            <th class="p-0 min-w-50px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestCategories as $category)
                                            <tr>
                                                <td class="ps-0">
                                                    <a href="{{ route('categories.show', $category->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $category->name }}</a>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                        <i class="ki-duotone ki-arrow-right fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5 g-xl-12 my-1">
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Latest 10 Cryptocurrency Purchases') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                @if($latestCryptoBuys->isEmpty())
                                    <div class="text-center text-gray-500 fs-6 mt-5">
                                        {{ __('dashboard.There Are No Purchases Yet') }}
                                    </div>
                                @else
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                        <tr class="border-bottom-1">
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Transaction Number') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Payment Gateway') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Amount') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Date') }}</th>
                                            <th class="p-0 min-w-50px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestCryptoBuys as $buy)
                                            <tr>
                                                <td class="ps-0">
                                                    <a href="{{ route('crypto_transactions.history') }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $buy->id }}</a>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $buy->cryptoGateway->name ?? 'Undefined' }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ number_format($buy->amount, 8) }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $buy->created_at->format('Y-m-d H:i') }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('crypto_transactions.history') }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                        <i class="ki-duotone ki-arrow-right fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Latest 10 Cryptocurrency Sales') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                @if($latestCryptoSells->isEmpty())
                                    <div class="text-center text-gray-500 fs-6 mt-5">
                                        {{ __('dashboard.There Are No Purchases Yet') }}
                                    </div>
                                @else
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                        <tr class="border-bottom-1">
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Transaction Number') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Payment Gateway') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Amount') }}</th>
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Date') }}</th>
                                            <th class="p-0 min-w-50px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestCryptoSells as $sell)
                                            <tr>
                                                <td class="ps-0">
                                                    <a href="{{ route('crypto_transactions.history') }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $sell->id }}</a>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $sell->cryptoGateway->name ?? 'Undefined' }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ number_format($sell->amount, 8) }}</span>
                                                </td>
                                                <td class="ps-0">
                                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $sell->created_at->format('Y-m-d H:i') }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('crypto_transactions.history') }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                        <i class="ki-duotone ki-arrow-right fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5 g-xl-12 my-1">
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Latest 5 Customers') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                @if($latestCustomers->isEmpty())
                                    <div class="text-center text-gray-500 fs-6 mt-5">
                                        {{ __('dashboard.There Are No Customers Yet') }}
                                    </div>
                                @else
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                        <tr class="border-bottom-1">
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Customer Name') }}</th>
                                            <th class="p-0 min-w-50px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestCustomers as $customer)
                                            <tr>
                                                <td class="ps-0">
                                                    <a href="{{ route('customers.show', $customer->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $customer->name }}</a>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                        <i class="ki-duotone ki-arrow-right fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7 m-auto">
                            <h4 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('dashboard.Latest 5 Suppliers') }}</span>
                            </h4>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                @if($latestSuppliers->isEmpty())
                                    <div class="text-center text-gray-500 fs-6 mt-5">
                                        {{ __('dashboard.There Are No Suppliers Yet') }}
                                    </div>
                                @else
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <thead>
                                        <tr class="border-bottom-1">
                                            <th class="p-0 min-w-175px">{{ __('dashboard.Suppliers Name') }}</th>
                                            <th class="p-0 min-w-50px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestSuppliers as $supplier)
                                            <tr>
                                                <td class="ps-0">
                                                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $supplier->name }}</a>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                        <i class="ki-duotone ki-arrow-right fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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
                lottie.loadAnimation({
                    container: document.getElementById('productsStockLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/products-stock.json') }}"
                });
                lottie.loadAnimation({
                    container: document.getElementById('cryptoLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/crypto.json') }}"
                });
                lottie.loadAnimation({
                    container: document.getElementById('salesLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/sales.json') }}"
                });
                lottie.loadAnimation({
                    container: document.getElementById('purchasesLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/purchases.json') }}"
                });
                lottie.loadAnimation({
                    container: document.getElementById('externalProductsLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/external_purchases.json') }}"
                });
                lottie.loadAnimation({
                    container: document.getElementById('totalSuppliers'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/suppliers.json') }}"
                });
                lottie.loadAnimation({
                    container: document.getElementById('totalPhonesInMaintenance'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/phones_in_maintenance.json') }}"
                });
                lottie.loadAnimation({
                    container: document.getElementById('phonesInMaintenance'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/maintenances.json') }}"
                });
                lottie.loadAnimation({
                    container: document.getElementById('totalDebt'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/debt.json') }}"
                });
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
                    console.error('{{ __('dashboard.Copy failed') }}:', e);
                });
            });
        </script>
    @endsection
@endsection
