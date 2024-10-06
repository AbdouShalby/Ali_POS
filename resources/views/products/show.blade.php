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
                @if($product->image)
                    <img src="{{ asset('images/products/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid mb-3">
                @endif
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>كود المنتج:</strong> {{ $product->code }}</li>
                    <li class="list-group-item"><strong>القسم:</strong> {{ $product->category->name ?? 'غير محدد' }}</li>
                    <li class="list-group-item"><strong>العلامة التجارية:</strong> {{ $product->brand->name ?? 'غير محدد' }}</li>
                    <li class="list-group-item"><strong>الكمية:</strong> {{ $product->quantity }}</li>
                    <li class="list-group-item"><strong>تنبيه المخزون:</strong> {{ $product->stock_alert }}</li>
                    <li class="list-group-item"><strong>التكلفة:</strong> {{ number_format($product->cost, 2) }} جنيه</li>
                    <li class="list-group-item"><strong>سعر البيع:</strong> {{ number_format($product->price, 2) }} جنيه</li>
                    <li class="list-group-item"><strong>سعر الجملة:</strong> {{ number_format($product->wholesale_price, 2) }} جنيه</li>
                    <li class="list-group-item"><strong>أقل سعر للبيع:</strong> {{ number_format($product->min_sale_price, 2) }} جنيه</li>
                    <li class="list-group-item"><strong>الوصف:</strong> {{ $product->description }}</li>
                </ul>

                @if($product->mobileDetail)
                    <hr>
                    <h4>تفاصيل الموبايل</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>اللون:</strong> {{ $product->mobileDetail->color }}</li>
                        <li class="list-group-item"><strong>المساحة:</strong> {{ $product->mobileDetail->storage }}</li>
                        <li class="list-group-item"><strong>صحة البطارية:</strong> {{ $product->mobileDetail->battery_health }}%</li>
                        <li class="list-group-item"><strong>الرام:</strong> {{ $product->mobileDetail->ram }}</li>
                        <li class="list-group-item"><strong>معالج الرسوم:</strong> {{ $product->mobileDetail->gpu }}</li>
                        <li class="list-group-item"><strong>المعالج:</strong> {{ $product->mobileDetail->cpu }}</li>
                        <li class="list-group-item"><strong>حالة الجهاز:</strong> {{ $product->mobileDetail->condition }}</li>
                        <li class="list-group-item"><strong>وصف الجهاز:</strong> {{ $product->mobileDetail->device_description }}</li>
                        <li class="list-group-item"><strong>هل توجد علبة:</strong> {{ $product->mobileDetail->has_box ? 'نعم' : 'لا' }}</li>
                    </ul>
                @endif

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
