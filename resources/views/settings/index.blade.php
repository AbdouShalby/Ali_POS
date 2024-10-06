@extends('layouts.app')

@section('title', 'إعدادات النظام')

@section('content')
    <div class="container">
        <h1 class="mb-4">إعدادات النظام</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('settings.create') }}" class="btn btn-primary mb-3">إضافة إعداد جديد</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>المفتاح (Key)</th>
                <th>القيمة (Value)</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($settings as $setting)
                <tr>
                    <td>{{ $setting->key }}</td>
                    <td>{{ $setting->value }}</td>
                    <td>
                        <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('settings.destroy', $setting->id) }}" method="POST" style="display:inline;">
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
