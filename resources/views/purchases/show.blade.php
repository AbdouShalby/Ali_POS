@extends('layouts.app')

@section('title', 'تفاصيل عملية الشراء')

@section('content')
    <div class="container">
        <h1 class="mb-4">تفاصيل عملية الشراء</h1>
        <div class="card">
            <div class="card-header">
                رقم الفاتورة: {{ $purchase->invoice_number }}
            </div>
            <div class="card-body">
                <h5 class="card-title">معلومات الشراء</h5>
                <p class="card-text"><strong>المورد:</strong> {{ $purchase->supplier->name ?? 'غير محدد' }}</p>
                <p class="card-text"><strong>تاريخ الشراء:</strong> {{ $purchase->purchase_date }}</p>
                <p class="card-text"><strong>الإجمالي:</strong> {{ number_format($purchase->total_amount, 2) }} جنيه</p>
                <!-- يمكنك عرض تفاصيل المنتجات المشتراة هنا -->
                <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-warning mt-3">
                    <i class="bi bi-pencil-square"></i> تعديل
                </a>
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary mt-3">
                    <i class="bi bi-arrow-left"></i> العودة إلى القائمة
                </a>
            </div>
        </div>
    </div>
@endsection
