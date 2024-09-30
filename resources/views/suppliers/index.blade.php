@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>الموردون</h1>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">إضافة مورد جديد</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>الاسم</th>
                <th>الشخص المسؤول</th>
                <th>رقم الهاتف</th>
                <th>البريد الإلكتروني</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>
                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
