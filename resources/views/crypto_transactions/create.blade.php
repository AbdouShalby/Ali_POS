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

            <button type="submit" class="btn btn-success">تنفيذ العملية</button>
            <a href="{{ route('crypto_gateways.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
