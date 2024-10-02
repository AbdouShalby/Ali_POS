@extends('layouts.app')

@section('title', 'تفاصيل عملية البيع')

@section('content')
    <div class="container">
        <h1 class="mb-4">تفاصيل عملية البيع رقم {{ $sale->id }}</h1>
        <div class="card">
            <div class="card-header">
                تفاصيل البيع
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>العميل:</strong> {{ $sale->customer->name }}</li>
                    <li class="list-group-item"><strong>المنتج:</strong> {{ $sale->product->name }}</li>
                    <li class="list-group-item"><strong>الكمية:</strong> {{ $sale->quantity }}</li>
                    <li class="list-group-item"><strong>السعر:</strong> {{ number_format($sale->price, 2) }} جنيه</li>
                    <li class="list-group-item"><strong>تاريخ البيع:</strong> {{ $sale->sale_date->format('Y-m-d') }}</li>
                </ul>
                <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning mt-3">
                    <i class="bi bi-pencil-square"></i> تعديل
                </a>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-3">
                    <i class="bi bi-arrow-left"></i> العودة إلى القائمة
                </a>
            </div>
        </div>
    </div>
@endsection
