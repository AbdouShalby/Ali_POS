@extends('layouts.app')

@section('title', __('suppliers.debts') . ' - ' . $supplier->name)

@section('content')
    <div class="container">
        <h1>{{ __('suppliers.debts') }} - {{ $supplier->name }}</h1>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ __('suppliers.amount') }}</th>
                <th>{{ __('suppliers.note') }}</th>
                <th>{{ __('suppliers.date') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($debts as $debt)
                <tr>
                    <td>{{ number_format($debt->amount, 2) }}</td>
                    <td>{{ $debt->note }}</td>
                    <td>{{ $debt->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">{{ __('suppliers.no_debts_found') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
