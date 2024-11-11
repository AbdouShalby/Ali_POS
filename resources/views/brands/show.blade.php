@extends('layouts.app')

@section('title', '- ' . __('Brand Details'))

@section('content')
    <div class="container">
        <h1 class="mb-4">تفاصيل العلامة التجارية</h1>
        <div class="card">
            <div class="card-header">
                {{ $brand->name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">الوصف</h5>
                <p class="card-text">{{ $brand->description }}</p>
                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning mt-3">
                    <i class="bi bi-pencil-square"></i> تعديل
                </a>
                <a href="{{ route('brands.index') }}" class="btn btn-secondary mt-3">
                    <i class="bi bi-arrow-left"></i> العودة إلى القائمة
                </a>
            </div>
        </div>
    </div>
@endsection
