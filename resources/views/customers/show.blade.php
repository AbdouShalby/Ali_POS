@extends('layouts.app')

@section('title', 'تفاصيل العميل')

@section('content')
    <div class="container">
        <h1 class="mb-4">تفاصيل العميل</h1>
        <div class="card">
            <div class="card-header">
                {{ $customer->name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">معلومات الاتصال</h5>
                <p class="card-text"><strong>البريد الإلكتروني:</strong> {{ $customer->email ?? 'غير متوفر' }}</p>
                <p class="card-text"><strong>رقم الهاتف:</strong> {{ $customer->phone ?? 'غير متوفر' }}</p>
                <p class="card-text"><strong>العنوان:</strong> {{ $customer->address ?? 'غير متوفر' }}</p>
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning mt-3">
                    <i class="bi bi-pencil-square"></i> تعديل
                </a>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary mt-3">
                    <i class="bi bi-arrow-left"></i> العودة إلى القائمة
                </a>
            </div>
        </div>
    </div>
@endsection
