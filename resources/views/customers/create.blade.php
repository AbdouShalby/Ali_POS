@extends('layouts.app')

@section('title', '- ' . __('Create Customer'))

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة عميل جديد</h1>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>خطأ!</strong> يرجى تصحيح الأخطاء التالية:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">اسم العميل</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">رقم الهاتف</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">العنوان</label>
                <textarea class="form-control" id="address" name="address" rows="2">{{ old('address') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> حفظ
            </button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
    </div>
@endsection
