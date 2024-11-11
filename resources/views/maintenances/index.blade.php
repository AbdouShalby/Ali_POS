@extends('layouts.app')

@section('title', '- ' . __('All Maintenance Operations'))

@section('content')
    <div class="container">
        <h1>جميع عمليات الصيانة</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <a href="{{ route('maintenances.create') }}" class="btn btn-primary mb-3">إضافة عملية صيانة جديدة</a>

        <!-- نموذج الفلترة -->
        <form action="{{ route('maintenances.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="ابحث بالعميل، الهاتف، أو الجهاز" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">كل الحالات</option>
                        <option value="in_maintenance" {{ request('status') == 'in_maintenance' ? 'selected' : '' }}>في الصيانة</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>مسلمة</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </div>
        </form>

        <!-- جدول عرض عمليات الصيانة -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>العميل</th>
                <th>رقم الهاتف</th>
                <th>نوع الجهاز</th>
                <th>المشكلة</th>
                <th>التكلفة</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($maintenances as $maintenance)
                <tr>
                    <td>{{ $maintenance->customer_name }}</td>
                    <td>{{ $maintenance->phone_number }}</td>
                    <td>{{ $maintenance->device_type }}</td>
                    <td>{{ $maintenance->problem_description }}</td>
                    <td>{{ $maintenance->cost ?? 'غير محددة' }}</td>
                    <td>
                        <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="in_maintenance" {{ $maintenance->status == 'in_maintenance' ? 'selected' : '' }}>في الصيانة</option>
                                <option value="completed" {{ $maintenance->status == 'completed' ? 'selected' : '' }}>مكتملة</option>
                                <option value="delivered" {{ $maintenance->status == 'delivered' ? 'selected' : '' }}>مسلمة</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('maintenances.show', $maintenance->id) }}" class="btn btn-info btn-sm">عرض</a>
                        <a href="{{ route('maintenances.edit', $maintenance->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <a href="{{ route('maintenances.print', $maintenance->id) }}" class="btn btn-secondary btn-sm" target="_blank">طباعة الإيصال</a>
                        <form action="{{ route('maintenances.destroy', $maintenance->id) }}" method="POST" style="display:inline;">
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
