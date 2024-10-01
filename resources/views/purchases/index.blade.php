@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>فواتير الشراء</h1>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary mb-3">إضافة فاتورة شراء جديدة</a>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>رقم الفاتورة</th>
                <th>المورد</th>
                <th>تاريخ الشراء</th>
                <th>إجمالي المبلغ</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->invoice_number }}</td>
                    <td>{{ $purchase->supplier->name }}</td>
                    <td>{{ $purchase->purchase_date }}</td>
                    <td>{{ $purchase->total_amount }}</td>
                    <td>
                        <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-sm btn-info">عرض</a>
                        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الفاتورة؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
