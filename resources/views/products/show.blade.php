@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <p><strong>البراند:</strong> {{ $product->brand ? $product->brand->name : 'غير محدد' }}</p>
        <p><strong>القسم:</strong> {{ $product->category ? $product->category->name : 'غير محدد' }}</p>
        <p><strong>السعر:</strong> {{ $product->price }}</p>
        <p><strong>الكمية:</strong> {{ $product->quantity }}</p>
        <p><strong>الوصف:</strong> {{ $product->description }}</p>
        <p><strong>QR Code:</strong></p>
        @if($product->qr_code)
            <img src="{{ asset($product->qr_code) }}" alt="QR Code">
        @endif
        <br>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">العودة إلى قائمة المنتجات</a>
    </div>
@endsection
