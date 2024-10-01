@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>تفاصيل فاتورة الشراء</h1>
        <p><strong>رقم الفاتورة:</strong> {{ $purchase->invoice_number }}</p>
        <p><strong>المورد:</strong> {{ $purchase->supplier->name }}</p>
        <p><strong>تاريخ الشراء:</strong> {{ $purchase->purchase_date }}</p>
        <p><strong>إجمالي المبلغ:</strong> {{ $purchase->total_amount }}</p>
        <p><strong>ملاحظات:</strong> {{ $purchase->notes }}</p>

        <h3>المنتجات</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>الإجمالي</th>
            </tr>
            </thead>
            <tbody>
            @foreach($purchase->purchaseItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->quantity * $item->price }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('purchases.index') }}" class="btn btn-primary mt-3">العودة إلى قائمة الفواتير</a>
    </div>
@endsection
