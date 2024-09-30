@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>إضافة مورد جديد</h1>
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>اسم المورد</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>الشخص المسؤول</label>
                <input type="text" name="contact_person" class="form-control">
            </div>
            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>العنوان</label>
                <textarea name="address" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">حفظ</button>
        </form>
    </div>
@endsection
