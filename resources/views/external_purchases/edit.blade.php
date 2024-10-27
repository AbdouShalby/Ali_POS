@extends('layouts.app')

@section('title', 'تعديل الشراء الخارجي')

@section('content')
    <div class="container">
        <h1 class="mb-4">تعديل الشراء الخارجي: {{ $externalPurchase->invoice_number }}</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('external_purchases.update', $externalPurchase->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="invoice_number" class="form-label">رقم الفاتورة</label>
                <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ $externalPurchase->invoice_number }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">الوصف</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $externalPurchase->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ $externalPurchase->amount }}" required>
            </div>

            <div class="mb-3">
                <label for="purchase_date" class="form-label">تاريخ الشراء</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ $externalPurchase->purchase_date }}" required>
            </div>

            <button type="submit" class="btn btn-success">تحديث</button>
            <a href="{{ route('external_purchases.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
