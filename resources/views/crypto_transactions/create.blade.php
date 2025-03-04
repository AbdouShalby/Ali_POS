@extends('layouts.app')

@section('title', '- ' . __('Buy/Sell Cryptocurrencies'))

@section('content')
    <div class="app-container container-xxl">
        <div class="card card-flush">
            <div class="card-header">
                <h2 class="card-title">{{ __('crypto_transactions.buy_sell') }} - {{ $gateway->name }}</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('crypto_transactions.store', $gateway->id) }}" method="POST">
                    @csrf

                    <!-- الكمية -->
                    <div class="mb-4">
                        <label for="amount" class="form-label fw-bold">
                            {{ __('crypto_transactions.amount') }} ({{ __('crypto_transactions.positive_for_buy_negative_for_sell') }})
                        </label>
                        <input type="number" class="form-control form-control-solid" id="amount" name="amount" step="0.00000001" required>
                    </div>

                    <!-- نسبة العمولة -->
                    <div class="mb-4">
                        <label for="profit_percentage" class="form-label fw-bold">{{ __('crypto_transactions.profit_percentage') }} (%)</label>
                        <input type="number" class="form-control form-control-solid" id="profit_percentage" name="profit_percentage" step="0.01">
                    </div>

                    <!-- الكمية النهائية بعد حساب العمولة -->
                    <div class="mb-4">
                        <label for="final_amount" class="form-label fw-bold">{{ __('crypto_transactions.final_amount') }}</label>
                        <input type="number" class="form-control form-control-solid" id="final_amount" name="final_amount" step="0.00000001" readonly>
                    </div>

                    <!-- أزرار التنفيذ -->
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
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const amountInput = document.getElementById('amount');
            const profitPercentageInput = document.getElementById('profit_percentage');
            const finalAmountInput = document.getElementById('final_amount');

            function updateCalculations() {
                const amount = parseFloat(amountInput.value) || 0;
                const profitPercentage = parseFloat(profitPercentageInput.value) || 0;

                const profitAmount = (Math.abs(amount) * profitPercentage) / 100;

                if (amount < 0) {
                    finalAmountInput.value = (amount - profitAmount).toFixed(8);
                } else {
                    finalAmountInput.value = (amount + profitAmount).toFixed(8);
                }
            }

            amountInput.addEventListener('input', updateCalculations);
            profitPercentageInput.addEventListener('input', updateCalculations);
        });
    </script>
@endsection
