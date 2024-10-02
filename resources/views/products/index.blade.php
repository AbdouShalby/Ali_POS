@extends('layouts.app')

@section('title', 'قائمة المنتجات')

@section('content')
    <div class="container">
        <h1 class="mb-4">قائمة المنتجات</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> إضافة منتج جديد
        </a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>اسم المنتج</th>
                    <th>الوصف</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>العلامة التجارية</th>
                    <th>القسم</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ Str::limit($product->description, 50) }}</td>
                        <td>{{ number_format($product->price, 2) }} جنيه</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->brand->name ?? 'غير محدد' }}</td>
                        <td>{{ $product->category->name ?? 'غير محدد' }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> عرض
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> تعديل
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
