@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>تعديل الموبايل</h1>
        <form action="{{ route('mobiles.update', $mobile->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>اسم المنتج</label>
                <select name="product_id" class="form-control" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $mobile->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>IMEI</label>
                <input type="text" name="imei" class="form-control" value="{{ $mobile->imei }}" required>
            </div>
            <div class="form-group">
                <label>الحالة</label>
                <select name="status" class="form-control" required>
                    <option value="جديد" {{ $mobile->status == 'جديد' ? 'selected' : '' }}>جديد</option>
                    <option value="مستعمل" {{ $mobile->status == 'مستعمل' ? 'selected' : '' }}>مستعمل</option>
                </select>
            </div>
            <div class="form-group">
                <label>المواصفات</label>
                <textarea name="specifications" class="form-control">{{ $mobile->specifications }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">تحديث</button>
        </form>
    </div>
@endsection
