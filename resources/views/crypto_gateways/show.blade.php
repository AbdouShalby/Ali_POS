@extends('layouts.app')

@section('title', 'تفاصيل بوابة العملات المشفرة')

@section('content')
    <div class="container">
        <h1 class="mb-4">تفاصيل بوابة العملات المشفرة: {{ $gateway->name }}</h1>

        <p><strong>الرصيد:</strong> {{ number_format($gateway->balance, 8) }}</p>

        <h3>العمليات</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>النوع</th>
                <th>الكمية</th>
                <th>شامل المصاريف</th>
                <th>التاريخ</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gateway->transactions as $transaction)
                <tr>
                    <td>{{ $transaction->type == 'buy' ? 'شراء' : 'بيع' }}</td>
                    <td>{{ number_format($transaction->amount, 8) }}</td>
                    <td>{{ $transaction->includes_fees ? 'نعم' : 'لا' }}</td>
                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('crypto_gateways.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
    </div>
@endsection
