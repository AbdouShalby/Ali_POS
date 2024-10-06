@extends('layouts.app')

@section('title', 'جميع عمليات البيع والشراء')

@section('content')
    <div class="container">
        <h1 class="mb-4">جميع عمليات البيع والشراء</h1>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>البوابة</th>
                <th>نوع العملية</th>
                <th>الكمية</th>
                <th>شامل المصاريف</th>
                <th>تاريخ العملية</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->cryptoGateway->name }}</td>
                    <td>{{ $transaction->type == 'buy' ? 'شراء' : 'بيع' }}</td>
                    <td>{{ number_format($transaction->amount, 8) }}</td>
                    <td>{{ $transaction->includes_fees ? 'نعم' : 'لا' }}</td>
                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $transactions->links() }}
    </div>
@endsection
