@extends('layouts.app')

@section('title', 'جميع عمليات الصيانة')

@section('content')
    <div class="container">
        <h1>جميع عمليات الصيانة</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('maintenances.create') }}" class="btn btn-primary mb-3">إضافة عملية صيانة جديدة</a>

        <form action="{{ route('maintenances.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">كل الحالات</option>
                        <option value="in_maintenance" {{ request('status') == 'in_maintenance' ? 'selected' : '' }}>في الصيانة</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>مسلمة</option>
                    </select>
                </div>
            </div>
        </form>

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
                        {{ $maintenance->status == 'in_maintenance' ? 'في الصيانة' : ($maintenance->status == 'completed' ? 'مكتملة' : 'مسلمة') }}
                    </td>
                    <td>
                        <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()">
                                <option value="in_maintenance" {{ $maintenance->status == 'in_maintenance' ? 'selected' : '' }}>في الصيانة</option>
                                <option value="completed" {{ $maintenance->status == 'completed' ? 'selected' : '' }}>مكتملة</option>
                                <option value="delivered" {{ $maintenance->status == 'delivered' ? 'selected' : '' }}>مسلمة</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
