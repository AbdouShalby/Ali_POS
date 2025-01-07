@extends('layouts.app')

@section('title', '- ' . __('Cryptocurrency Gateway Details'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('crypto_gateways.gateway_details') }}: {{ $gateway->name }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('crypto_gateways.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('crypto_gateways.index') }}" class="text-muted text-hover-primary">{{ __('crypto_gateways.cryptocurrency_gateways') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('crypto_gateways.gateway_details') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Details Card -->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <h2 class="card-title">{{ __('crypto_gateways.gateway_details') }}</h2>
                </div>
                <div class="card-body">
                    <div class="mb-10">
                        <label class="form-label fw-bold">{{ __('crypto_gateways.name') }}:</label>
                        <p class="form-control-plaintext">{{ $gateway->name }}</p>
                    </div>
                    <div class="mb-10">
                        <label class="form-label fw-bold">{{ __('crypto_gateways.balance') }}:</label>
                        <p class="form-control-plaintext">{{ number_format($gateway->balance, 8) }}</p>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('crypto_gateways.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> {{ __('crypto_gateways.back_to_list') }}
                    </a>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="card card-flush mt-5">
                <div class="card-header">
                    <h2 class="card-title">{{ __('crypto_gateways.transactions') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th>{{ __('crypto_gateways.type') }}</th>
                                <th>{{ __('crypto_gateways.amount') }}</th>
                                <th>{{ __('crypto_gateways.includes_fees') }}</th>
                                <th>{{ __('crypto_gateways.date') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @foreach($gateway->transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->type == 'buy' ? __('crypto_gateways.buy') : __('crypto_gateways.sell') }}</td>
                                    <td>{{ number_format($transaction->amount, 8) }}</td>
                                    <td>{{ $transaction->includes_fees ? __('crypto_gateways.yes') : __('crypto_gateways.no') }}</td>
                                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
