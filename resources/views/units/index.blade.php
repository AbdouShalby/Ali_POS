@extends('layouts.app')

@section('title', 'قائمة الوحدات')

@section('content')
    <div class="container">
        <h1 class="mb-4">قائمة الوحدات</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <a href="{{ route('units.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> إضافة وحدة جديدة
        </a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>اسم الوحدة</th>
                    <th>الاسم المختصر</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($units as $unit)
                    <tr>
                        <td>{{ $unit->name }}</td>
                        <td>{{ $unit->short_name }}</td>
                        <td>
                            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> تعديل
                            </a>
                            <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الوحدة؟')">
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
