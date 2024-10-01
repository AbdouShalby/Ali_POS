@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>تعديل العميل</h1>
        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>اسم العميل</label>
                <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
            </div>
            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
            </div>
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
            </div>
            <div class="form-group">
                <label>العنوان</label>
                <textarea name="address" class="form-control">{{ $customer->address }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">تحديث</button>
        </form>
    </div>
@endsection
