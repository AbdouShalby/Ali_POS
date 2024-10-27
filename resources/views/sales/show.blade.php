@extends('layouts.app')

@section('title', 'تفاصيل عملية البيع')

@section('content')
    <div class="container">
        <h1 class="mb-4">تفاصيل عملية البيع رقم {{ $sale->id }}</h1>

        <!-- كارت تفاصيل البيع -->
        <div class="card mb-3">
            <div class="card-header">
                تفاصيل البيع
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>العميل:</strong> {{ $sale->customer ? $sale->customer->name : 'لا يوجد عميل' }}</li>
                    <li class="list-group-item"><strong>تاريخ البيع:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}</li>
                    <li class="list-group-item"><strong>ملاحظات:</strong> {{ $sale->notes ? $sale->notes : 'لا توجد ملاحظات' }}</li>
                    <li class="list-group-item"><strong>الإجمالي:</strong> {{ number_format($sale->total_amount, 2) }} جنيه</li>
                </ul>
            </div>
        </div>

        <!-- كارت تفاصيل المنتجات المباعة -->
        <div class="card">
            <div class="card-header">
                تفاصيل المنتجات المباعة
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>رقم المنتج</th>
                        <th>اسم المنتج</th>
                        <th>الكمية</th>
                        <th>السعر (للوحدة)</th>
                        <th>الإجمالي</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sale->saleItems as $item)
                        <tr>
                            <td>{{ $item->product->id }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }} جنيه</td>
                            <td>{{ number_format($item->quantity * $item->price, 2) }} جنيه</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- أزرار تعديل والعودة -->
        <div class="mt-3">
            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> تعديل
            </a>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> العودة إلى القائمة
            </a>
        </div>
    </div>
@endsection
