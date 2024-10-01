@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>البراندات</h1>
        <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">إضافة براند جديد</a>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>الاسم</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($brands as $brand)
                <tr>
                    <td>{{ $brand->name }}</td>
                    <td>
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا البراند؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
