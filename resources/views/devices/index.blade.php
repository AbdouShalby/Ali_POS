@extends('layouts.app')

@section('title', 'جميع الأجهزة')

@section('content')
    <div class="container">
        <h1>جميع الأجهزة</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('devices.create') }}" class="btn btn-primary mb-3">إضافة جهاز جديد</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>اسم الجهاز</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($devices as $device)
                <tr>
                    <td>{{ $device->name ?? 'غير محدد' }}</td>
                    <td>
                        <a href="{{ route('devices.show', $device->id) }}" class="btn btn-info btn-sm">عرض</a>
                        <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('devices.destroy', $device->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
