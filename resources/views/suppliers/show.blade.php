@extends('layouts.app')

@section('title', 'تفاصيل المورد')

@section('content')
    <div class="container">
        <h1 class="mb-4">تفاصيل المورد</h1>
        <div class="card">
            <div class="card-header">
                {{ $supplier->name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">معلومات الاتصال</h5>
                <p class="card-text"><strong>البريد الإلكتروني:</strong> {{ $supplier->email ?? 'غير متوفر' }}</p>
                <p class="card-text"><strong>رقم الهاتف:</strong> {{ $supplier->phone ?? 'غير متوفر' }}</p>
                <p class="card-text"><strong>العنوان:</strong> {{ $supplier->address ?? 'غير متوفر' }}</p>
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning mt-3">
                    <i class="bi bi-pencil-square"></i> تعديل
                </a>
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary mt-3">
                    <i class="bi bi-arrow-left"></i> العودة إلى القائمة
                </a>
            </div>
        </div>
    </div>
@endsection
