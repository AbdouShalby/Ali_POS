@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>إضافة منتج جديد</h1>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>اسم المنتج</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>الوصف</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>السعر</label>
                <input type="number" name="price" step="0.01" class="form-control" required>
            </div>
            <div class="form-group">
                <label>الكمية</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="form-group">
                <label>البراند</label>
                <select name="brand_id" class="form-control">
                    <option value="">اختر البراند</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>القسم</label>
                <select name="category_id" class="form-control">
                    <option value="">اختر القسم</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">حفظ</button>
        </form>
    </div>
@endsection
