@extends('layouts.app')

@section('title', 'تفاصيل عملية الصيانة')

@section('content')
    <div class="container">
        <h1>تفاصيل عملية الصيانة</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>اسم العميل:</strong> {{ $maintenance->customer_name }}</p>
                <p><strong>رقم الهاتف:</strong> {{ $maintenance->phone_number }}</p>
                <p><strong>نوع الجهاز:</strong> {{ $maintenance->device_type }}</p>
                <p><strong>المشكلة:</strong> {{ $maintenance->problem_description }}</p>
                <p><strong>التكلفة:</strong> {{ $maintenance->cost ?? 'غير محددة' }}</p>
                <p><strong>كلمة السر:</strong> {{ $maintenance->password ?? 'غير محددة' }}</p>
                <p><strong>الحالة:</strong>
                    {{ $maintenance->status == 'in_maintenance' ? 'في الصيانة' : ($maintenance->status == 'completed' ? 'مكتملة' : 'مسلمة') }}
                </p>
            </div>
        </div>

        <a href="{{ route('maintenances.index') }}" class="btn btn-secondary mt-3">العودة إلى القائمة</a>
    </div>
@endsection
