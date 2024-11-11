@extends('layouts.app')

@section('title', '- ' . __('Create Brand'))

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة علامة تجارية جديدة</h1>

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

        <form action="{{ route('brands.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">اسم العلامة التجارية</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">الوصف</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> حفظ
            </button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
    </div>
@endsection
