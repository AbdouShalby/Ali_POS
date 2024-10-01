@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>تفاصيل الموبايل</h1>
        <p><strong>اسم المنتج:</strong> {{ $mobile->product->name }}</p>
        <p><strong>IMEI:</strong> {{ $mobile->imei }}</p>
        <p><strong>الحالة:</strong> {{ $mobile->status }}</p>
        <p><strong>المواصفات:</strong> {{ $mobile->specifications }}</p>
        <a href="{{ route('mobiles.index') }}" class="btn btn-primary mt-3">العودة إلى قائمة الموبايلات</a>
    </div>
@endsection
