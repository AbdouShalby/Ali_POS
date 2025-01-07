@extends('layouts.app')

@section('title', __('Cash Register Log'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('Cash Register Log') }}
                </h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Search Form -->
            <form action="{{ route('cash-register.log') }}" method="GET" class="mb-5">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control" placeholder="{{ __('Select Date') }}" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="transaction_type" class="form-control">
                            <option value="">{{ __('All Transaction Types') }}</option>
                            <option value="Product Sale" {{ request('transaction_type') == 'Product Sale' ? 'selected' : '' }}>
                                {{ __('Product Sale') }}
                            </option>
                            <option value="Crypto Purchase" {{ request('transaction_type') == 'Crypto Purchase' ? 'selected' : '' }}>
                                {{ __('Crypto Purchase') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="min_amount" class="form-control" placeholder="{{ __('Min Amount') }}" value="{{ request('min_amount') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="max_amount" class="form-control" placeholder="{{ __('Max Amount') }}" value="{{ request('max_amount') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> {{ __('Search') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Transactions Table -->
            <div class="card card-flush">
                <div class="card-header">
                    <h2 class="card-title">{{ __('Transactions Log') }}</h2>
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
                    <div class="d-flex justify-content-end mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
