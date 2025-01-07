@extends('layouts.app')

@section('title', __('Transaction Details'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('Transaction Details') }}
                </h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card card-flush">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Transaction Details') }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Date:') }}</strong> {{ $transaction->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>{{ __('Transaction Type:') }}</strong> {{ $transaction->transaction_type }}</p>
                    <p><strong>{{ __('Amount:') }}</strong>
                        <span class="{{ $transaction->amount < 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($transaction->amount, 2) }}
                        </span>
                    </p>
                    <p><strong>{{ __('Balance:') }}</strong> {{ number_format($transaction->balance, 2) }}</p>
                    <p><strong>{{ __('Description:') }}</strong> {{ $transaction->description }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
