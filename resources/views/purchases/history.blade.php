@extends('layouts.app')

@section('title', 'تاريخ المشتريات')

@section('content')
    <div class="container">
        <h1 class="mb-4">تاريخ المشتريات</h1>

        <form action="{{ route('purchases.history') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="date" name="from_date" class="form-control" placeholder="من تاريخ" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="to_date" class="form-control" placeholder="إلى تاريخ" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="ابحث برقم الفاتورة أو اسم المورد" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>رقم الفاتورة</th>
                    <th>المورد</th>
                    <th>تاريخ الشراء</th>
                    <th>الإجمالي</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->invoice_number }}</td>
                        <td>{{ $purchase->supplier ? $purchase->supplier->name : 'غير محدد' }}</td>
                        <td>{{ $purchase->purchase_date }}</td>
                        <td>{{ number_format($purchase->total_amount, 2) }} جنيه</td>
                        <td>
                            <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-info btn-sm">عرض</a>
                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                            <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">لا توجد مشتريات في الفترة المحددة.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
