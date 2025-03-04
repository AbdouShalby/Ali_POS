@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="mb-4">{{ __('expenses.title') }}</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ __('expenses.date') }}</th>
                <th>{{ __('expenses.description') }}</th>
                <th>{{ __('expenses.amount') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->expense_date }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->amount }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $expenses->links() }}
    </div>
@endsection
