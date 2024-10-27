@extends('layouts.app')

@section('title', 'تعديل عملية الصيانة')

@section('content')
    <div class="container">
        <h1>تعديل عملية الصيانة</h1>

        <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="customer_name" class="form-label">اسم العميل</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $maintenance->customer_name }}" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">رقم الهاتف</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $maintenance->phone_number }}" required>
            </div>

            <div class="mb-3">
                <label for="device_type" class="form-label">نوع الجهاز</label>
                <input type="text" class="form-control" id="device_type" name="device_type" value="{{ $maintenance->device_type }}" required>
            </div>

            <div class="mb-3">
                <label for="problem_description" class="form-label">المشكلة</label>
                <textarea class="form-control" id="problem_description" name="problem_description" required>{{ $maintenance->problem_description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="cost" class="form-label">التكلفة</label>
                <input type="number" step="0.01" class="form-control" id="cost" name="cost" value="{{ $maintenance->cost }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">كلمة السر</label>
                <input type="text" class="form-control" id="password" name="password" value="{{ $maintenance->password }}">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">الحالة</label>
                <select class="form-select" id="status" name="status">
                    <option value="in_maintenance" {{ $maintenance->status == 'in_maintenance' ? 'selected' : '' }}>في الصيانة</option>
                    <option value="completed" {{ $maintenance->status == 'completed' ? 'selected' : '' }}>مكتملة</option>
                    <option value="delivered" {{ $maintenance->status == 'delivered' ? 'selected' : '' }}>مسلمة</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">تحديث</button>
            <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
