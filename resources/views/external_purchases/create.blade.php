@extends('layouts.app')

@section('title', 'إضافة شراء خارجي جديد')

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة شراء خارجي جديد</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('external_purchases.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="invoice_number" class="form-label">رقم الفاتورة</label>
                <input type="text" class="form-control" id="invoice_number" name="invoice_number" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">الوصف</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>

            <div class="mb-3">
                <label for="purchase_date" class="form-label">تاريخ الشراء</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date" required>
            </div>

            <button type="submit" class="btn btn-primary">إضافة</button>
            <a href="{{ route('external_purchases.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
