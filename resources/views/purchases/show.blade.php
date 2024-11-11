@extends('layouts.app')

@section('title', '- ' . __('Purchase Details'))

@section('content')
    <div class="container">
        <h1 class="mb-4">تفاصيل عملية الشراء</h1>

        <div class="card mb-4">
            <div class="card-header">
                <h5>معلومات الفاتورة</h5>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>رقم الفاتورة:</strong> {{ $purchase->invoice_number }}</p>
                <p class="card-text"><strong>المورد:</strong> {{ $purchase->supplier->name ?? 'غير محدد' }}</p>
                <p class="card-text"><strong>تاريخ الشراء:</strong> {{ $purchase->purchase_date }}</p>
                <p class="card-text"><strong>الإجمالي:</strong> {{ number_format($purchase->total_amount, 2) }} جنيه</p>
                @if($purchase->invoice_file)
                    <p class="card-text"><strong>ملف الفاتورة:</strong>
                        <a href="{{ asset('invoices/' . $purchase->invoice_file) }}" target="_blank" class="btn btn-primary btn-sm">
                            عرض الفاتورة
                        </a>
                    </p>
                @endif
            </div>
        </div>

        @if($purchase->purchaseItems->isNotEmpty())
            <div class="card mb-4">
                <div class="card-header">
                    <h5>المنتجات المشتراة</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>اسم المنتج</th>
                            <th>الكمية</th>
                            <th>السعر (لكل وحدة)</th>
                            <th>الإجمالي</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($purchase->purchaseItems as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'غير متاح' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 2) }} جنيه</td>
                                <td>{{ number_format($item->quantity * $item->price, 2) }} جنيه</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">الإجمالي الكلي:</th>
                            <th>{{ number_format($purchase->total_amount, 2) }} جنيه</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                لا توجد منتجات مضافة لهذه الفاتورة.
            </div>
        @endif

        <!-- أزرار التحكم -->
        <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-warning mt-3">
            <i class="bi bi-pencil-square"></i> تعديل
        </a>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> العودة إلى القائمة
        </a>
    </div>
@endsection
