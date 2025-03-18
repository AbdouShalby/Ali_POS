@extends('layouts.app')

@section('title', '- ' . __('suppliers.payment_history'))

@section('content')
    <div class="container mt-5">
        <h2>{{ __('suppliers.payment_history_for') }} {{ optional($debt->product)->name ?? __('suppliers.product_not_available') }}</h2>
        <a href="{{ route('suppliers.show', $debt->supplier_id) }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> {{ __('Back to Supplier') }}
        </a>

        @if($payments->isEmpty())
            <p class="text-center">{{ __('No payment history found.') }}</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>{{ __('Amount Paid') }}</th>
                    <th>{{ __('Payment Date') }}</th>
                    <th>{{ __('Notes') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>{{ $payment->note ?? __('No Notes') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
