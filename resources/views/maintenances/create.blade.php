@extends('layouts.app')

@section('title', '- ' . __('Create Maintenance Operation'))

@section('content')
    <div class="container">
        <h1>إضافة عملية صيانة جديدة</h1>

        <form action="{{ route('maintenances.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="customer_name" class="form-label">اسم العميل</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">رقم الهاتف</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>

            <div class="mb-3">
                <label for="device_type" class="form-label">نوع الجهاز</label>
                <input type="text" class="form-control" id="device_type" name="device_type" required>
            </div>

            <div class="mb-3">
                <label for="problem_description" class="form-label">المشكلة</label>
                <textarea class="form-control" id="problem_description" name="problem_description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="cost" class="form-label">التكلفة</label>
                <input type="number" step="0.01" class="form-control" id="cost" name="cost">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">كلمة سر (اختياري)</label>
                <input type="text" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary">إضافة</button>
        </form>
    </div>
@endsection
