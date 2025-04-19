@extends('layouts.app')

@section('title', __('crypto_gateways.cryptocurrency_gateways'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('crypto_gateways.cryptocurrency_gateways') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('crypto_gateways.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('crypto_gateways.gateway_list') }}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('crypto_gateways.create') }}" class="btn btn-sm fw-bold btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    {{ __('crypto_gateways.add_new_gateway') }}
                </a>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                        <i class="bi bi-check-circle-fill fs-2"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <i class="bi bi-x fs-1 text-success"></i>
                    </button>
                </div>
            @endif

            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <i class="bi bi-search fs-2"></i>
                            </span>
                            <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="{{ __('crypto_gateways.search_placeholder') }}" />
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_gateways_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">{{ __('crypto_gateways.name') }}</th>
                                    <th class="min-w-125px">{{ __('crypto_gateways.balance') }}</th>
                                    <th class="text-end min-w-100px">{{ __('crypto_gateways.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($gateways as $gateway)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-35px me-3">
                                                <span class="symbol-label bg-light-primary">
                                                    <i class="bi bi-currency-bitcoin fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <span class="text-dark fw-bold text-hover-primary fs-6">{{ $gateway->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-bold fs-6">{{ number_format($gateway->balance, 8) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end flex-shrink-0">
                                            <a href="{{ route('crypto_transactions.create', $gateway->id) }}" class="btn btn-icon btn-bg-light btn-active-color-success btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('crypto_gateways.buy_sell') }}">
                                                <i class="bi bi-currency-exchange"></i>
                                            </a>
                                            <a href="{{ route('crypto_gateways.edit', $gateway->id) }}" class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('crypto_gateways.edit') }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('crypto_gateways.destroy', $gateway->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" onclick="return confirm('{{ __('crypto_gateways.confirm_delete') }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('crypto_gateways.delete') }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">{{ __('crypto_gateways.no_gateways') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // تفعيل tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // تفعيل البحث في الجدول
        var KTGatewaysTable = function () {
            var table = document.querySelector('#kt_gateways_table');
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

        // تهيئة الجدول عند تحميل الصفحة
        KTUtil.onDOMContentLoaded(function () {
            KTGatewaysTable.init();
        });
    </script>
@endsection
