@extends('layouts.app')

@section('title', 'إضافة عملية شراء جديدة')

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة عملية شراء جديدة</h1>

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

        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="invoice_number" class="form-label">رقم الفاتورة</label>
                <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" required>
            </div>
            <div class="mb-3">
                <label for="supplier_id" class="form-label">المورد</label>
                <select class="form-select" id="supplier_id" name="supplier_id">
                    <option value="">اختر المورد</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="purchase_date" class="form-label">تاريخ الشراء</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') ?? date('Y-m-d') }}" required>
            </div>
            <!-- يمكنك إضافة حقول لمنتجات الشراء هنا -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> حفظ
            </button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
    </div>
@endsection
