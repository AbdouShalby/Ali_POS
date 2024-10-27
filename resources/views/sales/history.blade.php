@extends('layouts.app')

@section('title', 'تاريخ المبيعات')

@section('content')
    <div class="container">
        <h1 class="mb-4">تاريخ المبيعات</h1>

        <form action="{{ route('sales.history') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="date" name="from_date" class="form-control" placeholder="من تاريخ" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="to_date" class="form-control" placeholder="إلى تاريخ" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="ابحث برقم البيع أو اسم العميل" value="{{ request('search') }}">
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
                    <th>رقم البيع</th>
                    <th>العميل</th>
                    <th>عدد المنتجات</th>
                    <th>الإجمالي</th>
                    <th>تاريخ البيع</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->customer ? $sale->customer->name : 'لا يوجد عميل' }}</td>
                        <td>{{ $sale->saleItems->count() }}</td>
                        <td>{{ number_format($sale->total_amount, 2) }} جنيه</td>
                        <td>{{ $sale->sale_date }}</td>
                        <td>
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info btn-sm">عرض</a>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">لا توجد مبيعات.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
