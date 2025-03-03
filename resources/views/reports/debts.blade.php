@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">{{ __('reports.debts_report') }}</h3>

        <form method="GET" class="mb-3 row">
            <div class="col-md-4">
                <label>{{ __('reports.from') }}</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-4">
                <label>{{ __('reports.to') }}</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">{{ __('reports.filter') }}</button>
            </div>
        </form>

        <div class="mb-3 row">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('reports.debts.export.pdf') }}" class="btn btn-danger mx-1">
                    <i class="fas fa-file-pdf"></i> {{ __('reports.export_pdf') }}
                </a>
                <a href="{{ route('reports.debts.export.excel') }}" class="btn btn-success mx-1">
                    <i class="fas fa-file-excel"></i> {{ __('reports.export_excel') }}
                </a>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ __('reports.date') }}</th>
                <th>{{ __('reports.customer') }}</th>
                <th>{{ __('reports.amount') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($debts as $debt)
                <tr>
                    <td>{{ $debt->created_at->format('Y-m-d') }}</td>
                    <td>{{ $debt->customer->name ?? __('reports.unknown') }}</td>
                    <td>${{ number_format($debt->amount, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $debts->links() }}
    </div>
@endsection
