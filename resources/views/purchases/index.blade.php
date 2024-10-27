@extends('layouts.app')

@section('title', 'مشتريات اليوم')

@section('content')
    <div class="container">
        <h1 class="mb-4">مشتريات اليوم</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <form action="{{ route('purchases.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="ابحث برقم الفاتورة أو المورد" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </div>
        </form>

        <a href="{{ route('purchases.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> إضافة عملية شراء جديدة
        </a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>رقم الفاتورة</th>
                    <th>المورد</th>
                    <th>الإجمالي</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->invoice_number }}</td>
                        <td>{{ $purchase->supplier->name ?? 'غير محدد' }}</td>
                        <td>{{ number_format($purchase->total_amount, 2) }} </td>
                        <td>
                            <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> عرض
                            </a>
                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> تعديل
                            </a>
                            <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف عملية الشراء هذه؟')">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">لا توجد مشتريات لليوم.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
