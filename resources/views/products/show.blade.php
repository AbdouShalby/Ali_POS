@extends('layouts.app')

@section('title', 'تفاصيل المنتج')

@section('content')
    <div class="container">
        <h1 class="mb-4">تفاصيل المنتج</h1>
        <div class="card">
            <div class="card-header">
                {{ $product->name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">الوصف</h5>
                <p class="card-text">{{ $product->description }}</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>السعر:</strong> {{ number_format($product->price, 2) }} جنيه</li>
                    <li class="list-group-item"><strong>الكمية:</strong> {{ $product->quantity }}</li>
                    <li class="list-group-item"><strong>العلامة التجارية:</strong> {{ $product->brand->name ?? 'غير محدد' }}</li>
                    <li class="list-group-item"><strong>القسم:</strong> {{ $product->category->name ?? 'غير محدد' }}</li>
                </ul>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning mt-3">
                    <i class="bi bi-pencil-square"></i> تعديل
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">
                    <i class="bi bi-arrow-left"></i> العودة إلى القائمة
                </a>
            </div>
        </div>
    </div>
@endsection
