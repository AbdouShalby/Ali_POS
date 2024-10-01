@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>الموبايلات</h1>
        <a href="{{ route('mobiles.create') }}" class="btn btn-primary mb-3">إضافة موبايل جديد</a>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>اسم المنتج</th>
                <th>IMEI</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($mobiles as $mobile)
                <tr>
                    <td>{{ $mobile->product->name }}</td>
                    <td>{{ $mobile->imei }}</td>
                    <td>{{ $mobile->status }}</td>
                    <td>
                        <a href="{{ route('mobiles.show', $mobile->id) }}" class="btn btn-sm btn-info">عرض</a>
                        <a href="{{ route('mobiles.edit', $mobile->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('mobiles.destroy', $mobile->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا الموبايل؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
