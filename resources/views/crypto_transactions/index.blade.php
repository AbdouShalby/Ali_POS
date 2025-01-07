@extends('layouts.app')

@section('title', '- ' . __('Today Buying and Selling Transactions'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('crypto_transactions.today_transactions') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('crypto_transactions.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('crypto_transactions.today_transactions') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Search Form -->
            <form action="{{ route('crypto_transactions.index') }}" method="GET" class="mb-5">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-solid" placeholder="{{ __('crypto_transactions.search_placeholder') }}" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> {{ __('crypto_transactions.search') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Transactions Table -->
            <div class="card card-flush">
                <div class="card-header">
                    <h2 class="card-title">{{ __('crypto_transactions.transactions_list') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th>#</th>
                                <th>{{ __('crypto_transactions.gateway') }}</th>
                                <th>{{ __('crypto_transactions.type') }}</th>
                                <th>{{ __('crypto_transactions.amount') }}</th>
                                <th>{{ __('crypto_transactions.includes_fees') }}</th>
                                <th>{{ __('crypto_transactions.date') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->cryptoGateway->name }}</td>
                                    <td>{{ $transaction->type == 'buy' ? __('crypto_transactions.buy') : __('crypto_transactions.sell') }}</td>
                                    <td>{{ number_format($transaction->amount, 8) }}</td>
                                    <td>{{ $transaction->includes_fees ? __('crypto_transactions.yes') : __('crypto_transactions.no') }}</td>
                                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
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
