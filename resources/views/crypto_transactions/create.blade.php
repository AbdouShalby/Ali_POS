@extends('layouts.app')

@section('title', __('crypto_transactions.buy_sell'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('crypto_transactions.buy_sell') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('crypto_transactions.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('crypto_gateways.index') }}" class="text-muted text-hover-primary">{{ __('crypto_transactions.gateways') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('crypto_transactions.buy_sell') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                        <i class="bi bi-exclamation-circle-fill fs-2"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-flush">
                <div class="card-header">
                    <h2 class="card-title">{{ __('crypto_transactions.transaction_details') }} - {{ $gateway->name }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('crypto_transactions.store', ['gatewayId' => $gateway->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="crypto_gateway_id" value="{{ $gateway->id }}">

                        <div class="row mb-5">
                            <!-- نوع المعاملة -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('crypto_transactions.type') }}</label>
                                    <select class="form-select form-select-solid" id="type" name="type" required>
                                        <option value="buy">{{ __('crypto_transactions.buy') }}</option>
                                        <option value="sell">{{ __('crypto_transactions.sell') }}</option>
                                    </select>
                                    <div class="invalid-feedback">{{ __('crypto_transactions.required_field') }}</div>
                                </div>
                            </div>

                            <!-- الكمية -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('crypto_transactions.amount') }}</label>
                                    <input type="number" class="form-control form-control-solid" id="amount" name="amount" step="0.00000001" required>
                                    <div class="invalid-feedback">{{ __('crypto_transactions.required_field') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <!-- نسبة العمولة -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required fw-semibold fs-6 mb-2">{{ __('crypto_transactions.profit_percentage') }} (%)</label>
                                    <input type="number" class="form-control form-control-solid" id="profit_percentage" name="profit_percentage" step="0.01" required>
                                    <div class="invalid-feedback">{{ __('crypto_transactions.required_field') }}</div>
                                </div>
                            </div>

                            <!-- الكمية النهائية -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-semibold fs-6 mb-2">{{ __('crypto_transactions.final_amount') }}</label>
                                    <input type="number" class="form-control form-control-solid bg-light" id="final_amount" name="final_amount" step="0.00000001" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <!-- مبلغ العمولة -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-semibold fs-6 mb-2">{{ __('crypto_transactions.profit_amount') }}</label>
                                    <input type="number" class="form-control form-control-solid bg-light" id="profit_amount" name="profit_amount" step="0.00000001" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار التنفيذ -->
                        <div class="d-flex justify-content-end mt-5">
                            <a href="{{ route('crypto_gateways.index') }}" class="btn btn-light me-3">
                                <i class="bi bi-arrow-left"></i> {{ __('crypto_transactions.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> {{ __('crypto_transactions.execute') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const amountInput = document.getElementById('amount');
            const profitPercentageInput = document.getElementById('profit_percentage');
            const finalAmountInput = document.getElementById('final_amount');
            const profitAmountInput = document.getElementById('profit_amount');

            function updateCalculations() {
                const type = typeSelect.value;
                const amount = parseFloat(amountInput.value) || 0;
                const profitPercentage = parseFloat(profitPercentageInput.value) || 0;

                const profitAmount = (Math.abs(amount) * Math.abs(profitPercentage)) / 100;
                profitAmountInput.value = profitAmount.toFixed(8);

                if (type === 'buy') {
                    if (profitPercentage > 0) {
                        finalAmountInput.value = (amount + profitAmount).toFixed(8);
                    } else {
                        finalAmountInput.value = (amount - profitAmount).toFixed(8);
                    }
                } else { // sell
                    if (profitPercentage > 0) {
                        finalAmountInput.value = (amount + profitAmount).toFixed(8);
                    } else {
                        finalAmountInput.value = (amount - profitAmount).toFixed(8);
                    }
                }
            }

            typeSelect.addEventListener('change', updateCalculations);
            amountInput.addEventListener('input', updateCalculations);
            profitPercentageInput.addEventListener('input', updateCalculations);
        });
    </script>
@endsection
