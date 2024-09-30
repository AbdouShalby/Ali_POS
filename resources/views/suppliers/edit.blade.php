@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>تعديل المورد</h1>
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>اسم المورد</label>
                <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
            </div>
            <div class="form-group">
                <label>الشخص المسؤول</label>
                <input type="text" name="contact_person" class="form-control" value="{{ $supplier->contact_person }}">
            </div>
            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ $supplier->phone }}">
            </div>
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ $supplier->email }}">
            </div>
            <div class="form-group">
                <label>العنوان</label>
                <textarea name="address" class="form-control">{{ $supplier->address }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">تحديث</button>
        </form>
    </div>
@endsection
