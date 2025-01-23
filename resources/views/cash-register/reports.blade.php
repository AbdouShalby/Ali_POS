@extends('layouts.app')

@section('title', __('Cash Register Reports'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('Cash Register Reports') }}
                </h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">

            <form action="{{ route('cash-register.reports') }}" method="GET" class="mb-5">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="{{ __('Start Date') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="{{ __('End Date') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-control">
                            <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>{{ __('All Transactions') }}</option>
                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>{{ __('Income') }}</option>
                            <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>{{ __('Expenses') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> {{ __('Generate Report') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="bg-light-success p-5 rounded">
                        <h4>{{ __('Total Income') }}</h4>
                        <p class="fs-4 fw-semibold">{{ number_format($totalIncome, 2) }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light-danger p-5 rounded">
                        <h4>{{ __('Total Expenses') }}</h4>
                        <p class="fs-4 fw-semibold">{{ number_format($totalExpense, 2) }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light-primary p-5 rounded">
                        <h4>{{ __('Net Total') }}</h4>
                        <p class="fs-4 fw-semibold">{{ number_format($netTotal, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="card card-flush">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Transactions Log') }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-hover align-middle gy-5">
                            <thead class="text-gray-400 fw-bold fs-7 text-uppercase">
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Transaction Type') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Description') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $transaction->transaction_type }}</td>
                                    <td class="{{ $transaction->amount < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td>{{ number_format($transaction->balance, 2) }}</td>
                                    <td>{{ $transaction->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('No transactions found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
