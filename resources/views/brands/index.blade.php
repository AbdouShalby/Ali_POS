@extends('layouts.app')

@section('title', 'قائمة العلامات التجارية')

@section('content')
    <div class="container">
        <h1 class="mb-4">قائمة العلامات التجارية</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> إضافة علامة تجارية جديدة
        </a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>اسم العلامة التجارية</th>
                    <th>الوصف</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($brands as $brand)
                    <tr>
                        <td>{{ $brand->name }}</td>
                        <td>{{ Str::limit($brand->description, 50) }}</td>
                        <td>
                            <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> عرض
                            </a>
                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> تعديل
                            </a>
                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه العلامة التجارية؟')">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
