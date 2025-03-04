@extends('layouts.app')

@section('title', '- ' . __('crypto_transactions.today_transactions'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('crypto_transactions.today_transactions') }}
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
                        {{ __('crypto_transactions.today_transactions') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Search & Filter -->
            <div class="card card-flush shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">{{ __('crypto_transactions.transactions_list') }}</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-rounded border gy-5 gs-5 align-middle">
                            <thead class="table-light text-gray-800 fw-bold">
                            <tr>
                                <th class="text-start">{{ __('crypto_transactions.gateway') }}</th>
                                <th class="text-center">{{ __('crypto_transactions.amount') }}</th>
                                <th class="text-center">{{ __('crypto_transactions.profit_percentage') }}</th>
                                <th class="text-center">{{ __('crypto_transactions.profit_amount') }}</th>
                                <th class="text-end">{{ __('crypto_transactions.date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td class="text-start fw-semibold">{{ $transaction->cryptoGateway->name }}</td>
                                    <td class="text-center {{ $transaction->amount < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $transaction->profit_percentage ? number_format($transaction->profit_percentage, 2) . '%' : '-' }}
                                    </td>
                                    <td class="text-center">{{ number_format($transaction->profit_amount, 2) }}</td>
                                    <td class="text-end">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        {{ $transactions->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* تحسينات الجدول */
        .table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .text-success {
            color: #28a745 !important;
            font-weight: bold;
        }
        .text-danger {
            color: #dc3545 !important;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }
        @media (max-width: 576px) {
            th, td {
                font-size: 12px;
                padding: 6px;
            }
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
@endsection
