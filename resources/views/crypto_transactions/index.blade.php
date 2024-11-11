@extends('layouts.app')

@section('title', '- ' . __('Today Buying and Selling Transactions'))

@section('content')
    <div class="container">
        <h1 class="mb-4">عمليات البيع والشراء لليوم</h1>

        <form action="{{ route('crypto_transactions.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="ابحث باسم البوابة أو الكمية" value="{{ request('search') }}">
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
    </div>
@endsection
