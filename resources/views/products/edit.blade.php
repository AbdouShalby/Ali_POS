@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>تعديل المنتج</h1>
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>اسم المنتج</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>
            <div class="form-group">
                <label>الوصف</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>
            <div class="form-group">
                <label>السعر</label>
                <input type="number" name="price" step="0.01" class="form-control" value="{{ $product->price }}" required>
            </div>
            <div class="form-group">
                <label>الكمية</label>
                <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" required>
            </div>
            <div class="form-group">
                <label>البراند</label>
                <select name="brand_id" class="form-control">
                    <option value="">اختر البراند</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>القسم</label>
                <select name="category_id" class="form-control">
                    <option value="">اختر القسم</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">تحديث</button>
        </form>
    </div>
@endsection
