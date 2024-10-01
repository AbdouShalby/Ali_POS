@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>إضافة موبايل جديد</h1>
        <form action="{{ route('mobiles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>اسم المنتج</label>
                <select name="product_id" class="form-control" required>
                    <option value="">اختر المنتج</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>IMEI</label>
                <input type="text" name="imei" class="form-control" required>
            </div>
            <div class="form-group">
                <label>الحالة</label>
                <select name="status" class="form-control" required>
                    <option value="جديد">جديد</option>
                    <option value="مستعمل">مستعمل</option>
                </select>
            </div>
            <div class="form-group">
                <label>المواصفات</label>
                <textarea name="specifications" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">حفظ</button>
        </form>
    </div>
@endsection
