@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>العملاء</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">إضافة عميل جديد</a>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>الاسم</th>
                <th>رقم الهاتف</th>
                <th>البريد الإلكتروني</th>
                <th>العنوان</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا العميل؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
