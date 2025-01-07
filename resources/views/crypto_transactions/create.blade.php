@extends('layouts.app')

@section('title', '- ' . __('Buy/Sell Cryptocurrencies'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('crypto_transactions.buy_sell') }} - {{ $gateway->name }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('crypto_transactions.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('crypto_gateways.index') }}" class="text-muted text-hover-primary">{{ __('crypto_transactions.cryptocurrency_gateways') }}</a>
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
            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                        <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                    </span>
                    <div>
                        <h4 class="alert-heading fw-bold">{{ __('crypto_transactions.error') }}</h4>
                        <p class="mb-0">{{ $errors->first() }}</p>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <!-- الفورم الأساسي -->
                <div class="col-md-8">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <h2 class="card-title">{{ __('crypto_transactions.execute_transaction') }}</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('crypto_transactions.store', $gateway->id) }}" method="POST">
                                @csrf
                                <!-- نوع العملية -->
                                <div class="mb-10">
                                    <label for="type" class="form-label fw-bold">{{ __('crypto_transactions.type') }}</label>
                                    <select class="form-control form-control-solid" id="type" name="type" required>
                                        <option value="buy">{{ __('crypto_transactions.buy') }}</option>
                                        <option value="sell">{{ __('crypto_transactions.sell') }}</option>
                                    </select>
                                </div>

                                <!-- الكمية -->
                                <div class="mb-10">
                                    <label for="amount" class="form-label fw-bold">{{ __('crypto_transactions.amount') }}</label>
                                    <input type="number" class="form-control form-control-solid" id="amount" name="amount" step="0.00000001" required>
                                </div>

                                <!-- شامل المصاريف -->
                                <div class="mb-10 form-check">
                                    <input type="checkbox" class="form-check-input" id="includes_fees" name="includes_fees">
                                    <label class="form-check-label" for="includes_fees">{{ __('crypto_transactions.includes_fees') }}</label>
                                </div>

                                <!-- الكمية النهائية -->
                                <div class="mb-10">
                                    <label for="final_amount" class="form-label fw-bold">{{ __('crypto_transactions.final_amount') }}</label>
                                    <input type="number" class="form-control form-control-solid" id="final_amount" name="final_amount" step="0.00000001" readonly>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success me-3">
                                        <i class="bi bi-check-circle"></i> {{ __('crypto_transactions.execute') }}
                                    </button>
                                    <a href="{{ route('crypto_gateways.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> {{ __('crypto_transactions.cancel') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- آلة الحاسبة الجانبية -->
                <div class="col-md-4">
                    <div class="card card-flush">
                        <div class="card-header">
                            <h2 class="card-title">{{ __('crypto_transactions.calculator') }}</h2>
                        </div>
                        <div class="card-body">
                            <!-- النسبة -->
                            <div class="mb-10">
                                <label for="percentage" class="form-label fw-bold">{{ __('crypto_transactions.percentage') }} (%)</label>
                                <input type="number" class="form-control form-control-solid" id="percentage" name="percentage" step="0.01">
                            </div>

                            <!-- نتيجة النسبة -->
                            <div class="mb-10">
                                <label for="percentage_result" class="form-label fw-bold">{{ __('crypto_transactions.percentage_result') }}</label>
                                <input type="number" class="form-control form-control-solid" id="percentage_result" name="percentage_result" step="0.00000001" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const amountInput = document.getElementById('amount');
            const percentageInput = document.getElementById('percentage');
            const percentageResultInput = document.getElementById('percentage_result');
            const includesFeesCheckbox = document.getElementById('includes_fees');
            const finalAmountInput = document.getElementById('final_amount');
            const typeSelect = document.getElementById('type');

            function updateCalculations() {
                const amount = parseFloat(amountInput.value) || 0;
                const percentage = parseFloat(percentageInput.value) || 0;
                const type = typeSelect.value;

                const percentageResult = (amount * percentage) / 100;
                percentageResultInput.value = percentageResult.toFixed(8);

                if (includesFeesCheckbox.checked) {
                    if (type === 'buy') {
                        finalAmountInput.value = (amount + percentageResult).toFixed(8);
                    } else if (type === 'sell') {
                        finalAmountInput.value = (amount - percentageResult).toFixed(8);
                    }
                } else {
                    finalAmountInput.value = amount.toFixed(8);
                }
            }

            amountInput.addEventListener('input', updateCalculations);
            percentageInput.addEventListener('input', updateCalculations);
            includesFeesCheckbox.addEventListener('change', updateCalculations);
            typeSelect.addEventListener('change', updateCalculations);
        });
    </script>
@endsection
