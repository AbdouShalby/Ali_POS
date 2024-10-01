@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>المنتجات</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">إضافة منتج جديد</a>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>الاسم</th>
                <th>البراند</th>
                <th>القسم</th>
                <th>السعر</th>
                <th>الكمية</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->brand ? $product->brand->name : 'غير محدد' }}</td>
                    <td>{{ $product->category ? $product->category->name : 'غير محدد' }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">عرض</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
