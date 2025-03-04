@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="mb-4">{{ __('payments.title') }}</h3>
        <a href="{{ route('accounting.payments.create') }}" class="btn btn-primary mb-3">{{ __('payments.add') }}</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ __('payments.date') }}</th>
                <th>{{ __('payments.amount') }}</th>
                <th>{{ __('payments.type') }}</th>
                <th>{{ __('payments.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->payment_type }}</td>
                    <td>
                        <form action="{{ route('accounting.payments.destroy', $payment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('payments.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $payments->links() }}
    </div>
@endsection
