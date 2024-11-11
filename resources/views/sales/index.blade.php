@extends('layouts.app')

@section('title', '- ' . __('All Sales'))

@section('content')
    <div class="container">
        <h1 class="mb-4">مبيعات اليوم</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <form action="{{ route('sales.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="ابحث برقم البيع أو اسم العميل" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </div>
        </form>

        <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> إضافة عملية بيع جديدة
        </a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>رقم البيع</th>
                    <th>العميل</th>
                    <th>عدد المنتجات</th>
                    <th>الإجمالي</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->customer ? $sale->customer->name : 'لا يوجد عميل' }}</td>
                        <td>{{ $sale->saleItems->count() }}</td>
                        <td>{{ number_format($sale->total_amount, 2) }} </td>
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
                        <td colspan="6" class="text-center">لا توجد مبيعات لليوم.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
