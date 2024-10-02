@extends('layouts.app')

@section('title', 'تعديل عملية شراء')

@section('content')
    <div class="container">
        <h1 class="mb-4">تعديل عملية الشراء رقم {{ $purchase->id }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>خطأ!</strong> يرجى تصحيح الأخطاء التالية:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="supplier_id" class="form-label">المورد</label>
                <select class="form-select" id="supplier_id" name="supplier_id" required>
                    <option value="">اختر المورد</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="product_id" class="form-label">المنتج</label>
                <select class="form-select" id="product_id" name="product_id" required>
                    <option value="">اختر المنتج</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $purchase->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">الكمية</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $purchase->quantity) }}" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">السعر</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $purchase->price) }}" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="purchase_date" class="form-label">تاريخ الشراء</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}" required>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> تحديث
            </button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
    </div>
@endsection
