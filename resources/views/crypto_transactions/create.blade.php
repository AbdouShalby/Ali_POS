@extends('layouts.app')

@section('title', 'تنفيذ عملية بيع/شراء')

@section('content')
    <div class="container">
        <h1 class="mb-4">تنفيذ عملية بيع/شراء - {{ $gateway->name }}</h1>

        <p><strong>الرصيد الحالي:</strong> {{ number_format($gateway->balance, 8) }}</p>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="row">
            <!-- الفورم الأساسي -->
            <div class="col-md-8">
                <form action="{{ route('crypto_transactions.store', $gateway->id) }}" method="POST">
                    @csrf

                    <!-- نوع العملية -->
                    <div class="mb-3">
                        <label for="type" class="form-label">نوع العملية</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="buy">شراء</option>
                            <option value="sell">بيع</option>
                        </select>
                    </div>

                    <!-- الكمية -->
                    <div class="mb-3">
                        <label for="amount" class="form-label">الكمية</label>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.00000001" required>
                    </div>

                    <!-- شامل المصاريف -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="includes_fees" name="includes_fees">
                        <label class="form-check-label" for="includes_fees">شامل المصاريف</label>
                    </div>

                    <!-- الكمية النهائية -->
                    <div class="mb-3">
                        <label for="final_amount" class="form-label">الكمية النهائية</label>
                        <input type="number" class="form-control" id="final_amount" name="final_amount" step="0.00000001" readonly>
                    </div>

                    <button type="submit" class="btn btn-success">تنفيذ العملية</button>
                    <a href="{{ route('crypto_gateways.index') }}" class="btn btn-secondary">إلغاء</a>
                </form>
            </div>

            <!-- آلة الحاسبة الجانبية -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <strong>آلة حساب النسبة</strong>
                    </div>
                    <div class="card-body">
                        <!-- النسبة -->
                        <div class="mb-3">
                            <label for="percentage" class="form-label">النسبة (%)</label>
                            <input type="number" class="form-control" id="percentage" name="percentage" step="0.01">
                        </div>

                        <!-- نتيجة النسبة -->
                        <div class="mb-3">
                            <label for="percentage_result" class="form-label">نتيجة النسبة</label>
                            <input type="number" class="form-control" id="percentage_result" name="percentage_result" step="0.00000001" readonly>
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

            // Function to update percentage result and final amount
            function updateCalculations() {
                const amount = parseFloat(amountInput.value) || 0;
                const percentage = parseFloat(percentageInput.value) || 0;

                // Calculate percentage result
                const percentageResult = (amount * percentage) / 100;
                percentageResultInput.value = percentageResult.toFixed(8);

                // Calculate final amount based on whether fees are included or not
                if (includesFeesCheckbox.checked) {
                    finalAmountInput.value = (amount - percentageResult).toFixed(8);
                } else {
                    finalAmountInput.value = (amount + percentageResult).toFixed(8);
                }
            }

            // Add event listeners
            amountInput.addEventListener('input', updateCalculations);
            percentageInput.addEventListener('input', updateCalculations);
            includesFeesCheckbox.addEventListener('change', updateCalculations);
        });
    </script>
@endsection
