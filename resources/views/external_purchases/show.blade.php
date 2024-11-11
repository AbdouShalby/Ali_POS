@extends('layouts.app')

@section('title', '- ' . __('External Purchase Details'))

@section('content')
    <div class="container">
        <h1 class="mb-4">عرض تفاصيل الشراء الخارجي: {{ $externalPurchase->invoice_number }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">رقم الفاتورة: {{ $externalPurchase->invoice_number }}</h5>
                <p class="card-text"><strong>الوصف:</strong> {{ $externalPurchase->description }}</p>
                <p class="card-text"><strong>المبلغ:</strong> {{ number_format($externalPurchase->amount, 2) }} جنيه</p>
                <p class="card-text"><strong>تاريخ الشراء:</strong> {{ $externalPurchase->purchase_date }}</p>
            </div>
        </div>

        <a href="{{ route('external_purchases.index') }}" class="btn btn-secondary mt-3">العودة إلى القائمة</a>
    </div>
@endsection
