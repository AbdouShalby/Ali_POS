@extends('layouts.app')

@section('title', 'المشتريات الخارجية')

@section('content')
    <div class="container">
        <h1 class="mb-4">المشتريات الخارجية</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('external_purchases.create') }}" class="btn btn-primary mb-3">إضافة شراء خارجي جديد</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>رقم الفاتورة</th>
                <th>الوصف</th>
                <th>المبلغ</th>
                <th>تاريخ الشراء</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($externalPurchases as $purchase)
                <tr>
                    <td>{{ $purchase->invoice_number }}</td>
                    <td>{{ $purchase->description }}</td>
                    <td>{{ number_format($purchase->amount, 2) }} جنيه</td>
                    <td>{{ $purchase->purchase_date }}</td>
                    <td>
                        <a href="{{ route('external_purchases.show', $purchase->id) }}" class="btn btn-info btn-sm">عرض</a>
                        <a href="{{ route('external_purchases.edit', $purchase->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('external_purchases.destroy', $purchase->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
