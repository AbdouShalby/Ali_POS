@extends('layouts.app')

@section('title', 'تعديل وحدة')

@section('content')
    <div class="container">
        <h1 class="mb-4">تعديل الوحدة: {{ $unit->name }}</h1>

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

        <form action="{{ route('units.update', $unit->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">اسم الوحدة</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $unit->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="short_name" class="form-label">الاسم المختصر</label>
                <input type="text" class="form-control" id="short_name" name="short_name" value="{{ old('short_name', $unit->short_name) }}">
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> تحديث
            </button>
            <a href="{{ route('units.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
    </div>
@endsection