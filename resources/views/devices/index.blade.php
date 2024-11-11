@extends('layouts.app')

@section('title', '- ' . __('All Phones'))

@section('content')
    <div class="container">
        <h1>جميع الأجهزة</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <a href="{{ route('devices.create') }}" class="btn btn-primary mb-3">إضافة جهاز جديد</a>

        <!-- نموذج الفلترة -->
        <form action="{{ route('devices.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="ابحث بالاسم، اللون، أو IMEI" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>اسم الجهاز</th>
                    <th>اللون</th>
                    <th>صحة البطارية</th>
                    <th>السعة التخزينية</th>
                    <th>IMEI</th>
                    <th>السعر</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($devices as $device)
                    <tr>
                        <td>{{ $device->name ?? 'غير محدد' }}</td>
                        <td>{{ $device->color ?? 'غير محدد' }}</td>
                        <td>{{ $device->battery ? $device->battery . '%' : 'غير محدد' }}</td>
                        <td>{{ $device->storage ? $device->storage . ' GB' : 'غير محدد' }}</td>
                        <td>{{ $device->imei ?? 'غير محدد' }}</td>
                        <td>{{ $device->price ? number_format($device->price, 2) : 'غير محدد' }}</td>
                        <td>{{ $device->condition ?? 'غير محدد' }}</td>
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
    </div>
@endsection
