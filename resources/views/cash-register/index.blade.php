@extends('layouts.app')

@section('title', __('Cash Register'))

@section('content')
    <!-- Page Toolbar -->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('Cash Register Overview') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                            <i class="bi bi-house-door me-1"></i> {{ __('cash_register.Dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('Cash Register') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!-- Totals Summary -->
            @php
                $todayTotals = \App\Models\CashRegister::getTodayTotals();
                $overallTotals = \App\Models\CashRegister::getOverallTotals();
            @endphp

            <div class="row g-5 mb-5">
                <!-- Today's Income -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <span class="svg-icon svg-icon-3x text-success mb-3">
                                <i class="bi bi-arrow-down-circle-fill"></i>
                            </span>
                            <h4 class="text-success fw-bold">{{ __('Total Income Today') }}</h4>
                            <p class="fs-4 fw-semibold">{{ number_format($todayTotals['total_in'], 2) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Today's Expenses -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <span class="svg-icon svg-icon-3x text-danger mb-3">
                                <i class="bi bi-arrow-up-circle-fill"></i>
                            </span>
                            <h4 class="text-danger fw-bold">{{ __('Total Expenses Today') }}</h4>
                            <p class="fs-4 fw-semibold">{{ number_format($todayTotals['total_out'], 2) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Today's Net Total -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <span class="svg-icon svg-icon-3x text-primary mb-3">
                                <i class="bi bi-wallet-fill"></i>
                            </span>
                            <h4 class="text-primary fw-bold">{{ __('Net Total Today') }}</h4>
                            <p class="fs-4 fw-semibold">{{ number_format($todayTotals['net_total'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-5 mb-5">
                <!-- Overall Income -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <span class="svg-icon svg-icon-3x text-success mb-3">
                                <i class="bi bi-graph-up-arrow"></i>
                            </span>
                            <h4 class="text-success fw-bold">{{ __('Total Income Overall') }}</h4>
                            <p class="fs-4 fw-semibold">{{ number_format($overallTotals['total_in'], 2) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Overall Expenses -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <span class="svg-icon svg-icon-3x text-danger mb-3">
                                <i class="bi bi-graph-down-arrow"></i>
                            </span>
                            <h4 class="text-danger fw-bold">{{ __('Total Expenses Overall') }}</h4>
                            <p class="fs-4 fw-semibold">{{ number_format($overallTotals['total_out'], 2) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Overall Net Balance -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <span class="svg-icon svg-icon-3x text-primary mb-3">
                                <i class="bi bi-piggy-bank-fill"></i>
                            </span>
                            <h4 class="text-primary fw-bold">{{ __('Net Balance') }}</h4>
                            <p class="fs-4 fw-semibold">{{ number_format($overallTotals['net_balance'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Log -->
            <div class="card card-flush">
                <div class="card-header">
                    <h2 class="card-title fw-bold">{{ __('Transactions Log') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-hover align-middle gy-5">
                            <thead class="text-gray-400 fw-bold fs-7 text-uppercase">
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Transaction Type') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Description') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $transaction->transaction_type }}</td>
                                    <td class="{{ $transaction->amount < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td>{{ number_format($transaction->balance, 2) }}</td>
                                    <td>{{ $transaction->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('No transactions found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
