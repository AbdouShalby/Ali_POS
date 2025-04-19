@extends('layouts.app')

@section('title', __('crypto_transactions.transaction_history'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('crypto_transactions.transaction_history') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                            {{ __('crypto_transactions.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        {{ __('crypto_transactions.transaction_history') }}
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('crypto_transactions.index') }}" class="btn btn-sm fw-bold btn-primary">
                    <i class="bi bi-calendar-check me-1"></i>
                    {{ __('crypto_transactions.today_transactions') }}
                </a>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Filter Card -->
            <div class="card mb-5">
                <div class="card-body pt-5">
                    <form id="filter-form" method="GET" action="{{ route('crypto_transactions.history') }}">
                        <div class="row g-5">
                            <!-- Date Range -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">{{ __('crypto_transactions.date_range') }}</label>
                                <div class="input-group">
                                    <input type="text" name="date_range" class="form-control" placeholder="{{ __('crypto_transactions.select_date_range') }}" id="kt_daterangepicker" readonly />
                                    <span class="input-group-text">
                                        <i class="bi bi-calendar3"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Gateway Filter -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">{{ __('crypto_transactions.gateway') }}</label>
                                <select name="gateway" class="form-select" data-control="select2" data-placeholder="{{ __('crypto_transactions.select_gateway') }}">
                                    <option value="">{{ __('crypto_transactions.all_gateways') }}</option>
                                    @foreach($gateways as $gateway)
                                        <option value="{{ $gateway->id }}" {{ request('gateway') == $gateway->id ? 'selected' : '' }}>
                                            {{ $gateway->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Transaction Type -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">{{ __('crypto_transactions.type') }}</label>
                                <select name="type" class="form-select" data-control="select2" data-placeholder="{{ __('crypto_transactions.select_type') }}">
                                    <option value="">{{ __('crypto_transactions.all_types') }}</option>
                                    <option value="buy" {{ request('type') == 'buy' ? 'selected' : '' }}>{{ __('crypto_transactions.buy') }}</option>
                                    <option value="sell" {{ request('type') == 'sell' ? 'selected' : '' }}>{{ __('crypto_transactions.sell') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-funnel-fill me-1"></i>
                                {{ __('crypto_transactions.apply_filters') }}
                            </button>
                            <a href="{{ route('crypto_transactions.history') }}" class="btn btn-light">
                                <i class="bi bi-x-circle me-1"></i>
                                {{ __('crypto_transactions.clear_filters') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-5 g-xl-8 mb-5">
                <!-- Total Filtered Transactions -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C;background-image:url('/assets/media/svg/shapes/wave-bg-red.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ $totalTransactions }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('crypto_transactions.filtered_transactions') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Buy Amount -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #20D489;background-image:url('/assets/media/svg/shapes/wave-bg-green.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ number_format($totalBuyAmount, 2) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('crypto_transactions.total_buy_amount') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Sell Amount -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url('/assets/media/svg/shapes/wave-bg-purple.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ number_format($totalSellAmount, 2) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('crypto_transactions.total_sell_amount') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Profit -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #009EF7;background-image:url('/assets/media/svg/shapes/wave-bg-blue.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ number_format($totalProfit, 2) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('crypto_transactions.total_profit') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <i class="bi bi-search fs-2"></i>
                            </span>
                            <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="{{ __('crypto_transactions.search_placeholder') }}" />
                        </div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="bi bi-cloud-download me-1"></i>
                            {{ __('crypto_transactions.export') }}
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="{{ route('crypto_transactions.export', ['format' => 'excel'] + request()->all()) }}" class="menu-link px-3">
                                    <i class="bi bi-file-earmark-excel me-2"></i>
                                    {{ __('crypto_transactions.export_excel') }}
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="{{ route('crypto_transactions.export', ['format' => 'pdf'] + request()->all()) }}" class="menu-link px-3">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>
                                    {{ __('crypto_transactions.export_pdf') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_transactions_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">{{ __('crypto_transactions.gateway') }}</th>
                                    <th class="min-w-125px">{{ __('crypto_transactions.type') }}</th>
                                    <th class="min-w-125px">{{ __('crypto_transactions.amount') }}</th>
                                    <th class="min-w-125px">{{ __('crypto_transactions.profit_percentage') }}</th>
                                    <th class="min-w-125px">{{ __('crypto_transactions.profit_amount') }}</th>
                                    <th class="min-w-125px">{{ __('crypto_transactions.final_amount') }}</th>
                                    <th class="text-end min-w-100px">{{ __('crypto_transactions.date') }}</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-35px me-3">
                                                <span class="symbol-label bg-light-primary">
                                                    <i class="bi bi-currency-bitcoin fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <span class="text-dark fw-bold text-hover-primary fs-6">{{ $transaction->cryptoGateway->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($transaction->type == 'buy')
                                            <span class="badge badge-light-success">{{ __('crypto_transactions.buy') }}</span>
                                        @else
                                            <span class="badge badge-light-danger">{{ __('crypto_transactions.sell') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold {{ $transaction->amount < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($transaction->amount, 8) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $transaction->profit_percentage }}%</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ number_format($transaction->profit_amount, 8) }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ number_format($transaction->final_amount, 8) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold">{{ $transaction->created_at->format('Y-m-d H:i') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        {{ $transactions->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // تهيئة محدد التاريخ
        var KTDateRangePicker = function () {
            var picker;

            var init = function () {
                var element = document.querySelector("#kt_daterangepicker");
                
                picker = $(element).daterangepicker({
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment(),
                    ranges: {
                        'اليوم': [moment(), moment()],
                        'أمس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'آخر 7 أيام': [moment().subtract(6, 'days'), moment()],
                        'آخر 30 يوم': [moment().subtract(29, 'days'), moment()],
                        'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
                        'الشهر الماضي': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    locale: {
                        format: 'YYYY-MM-DD',
                        applyLabel: "{{ __('crypto_transactions.apply') }}",
                        cancelLabel: "{{ __('crypto_transactions.cancel') }}",
                        fromLabel: "{{ __('crypto_transactions.from') }}",
                        toLabel: "{{ __('crypto_transactions.to') }}",
                        customRangeLabel: "{{ __('crypto_transactions.custom_range') }}",
                    }
                });
            }

            return {
                init: function () {
                    init();
                }
            };
        }();

        // تفعيل البحث في الجدول
        var KTTransactionsTable = function () {
            var table = document.querySelector('#kt_transactions_table');
            var searchInput = document.querySelector('[data-kt-filter="search"]');

            var initSearch = () => {
                searchInput.addEventListener('keyup', function (e) {
                    var value = e.target.value.toLowerCase();
                    var rows = table.querySelectorAll('tbody tr');

                    rows.forEach((row) => {
                        var matches = false;
                        var cells = row.querySelectorAll('td');

                        cells.forEach((cell) => {
                            if (cell.textContent.toLowerCase().indexOf(value) > -1) {
                                matches = true;
                            }
                        });

                        if (matches) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            return {
                init: function () {
                    initSearch();
                }
            };
        }();

        // تهيئة الصفحة
        KTUtil.onDOMContentLoaded(function () {
            KTDateRangePicker.init();
            KTTransactionsTable.init();
        });
    </script>
@endsection
