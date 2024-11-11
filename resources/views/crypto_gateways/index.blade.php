@extends('layouts.app')

@section('title', '- ' . __('Cryptocurrency Gateways'))

@section('content')
    <div class="container">
        <h1 class="mb-4">بوابات العملات المشفرة</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('crypto_gateways.create') }}" class="btn btn-primary mb-3">إضافة بوابة جديدة</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>الاسم</th>
                <th>الرصيد</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gateways as $gateway)
                <tr>
                    <td>{{ $gateway->name }}</td>
                    <td>{{ number_format($gateway->balance, 8) }}</td>
                    <td>
                        <a href="{{ route('crypto_transactions.create', $gateway->id) }}" class="btn btn-success btn-sm">بيع/شراء</a>
                        <a href="{{ route('crypto_gateways.edit', $gateway->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('crypto_gateways.destroy', $gateway->id) }}" method="POST" style="display:inline;">
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
