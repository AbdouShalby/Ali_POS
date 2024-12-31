@extends('layouts.app')

@section('title', '- ' . __('Sale Details'))

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ __('Sale Details') }} #{{ $sale->id }}</h1>

        <!-- تفاصيل البيع -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Sale Information') }}</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>{{ __('Customer') }}:</strong>
                        {{ $sale->customer ? $sale->customer->name : __('No Customer') }}
                    </li>
                    <li class="list-group-item">
                        <strong>{{ __('Sale Date') }}:</strong>
                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}
                    </li>
                    <li class="list-group-item">
                        <strong>{{ __('Notes') }}:</strong>
                        {{ $sale->notes ? $sale->notes : __('No Notes') }}
                    </li>
                    <li class="list-group-item">
                        <strong>{{ __('Total Amount') }}:</strong>
                        {{ number_format($sale->total_amount, 2) }} {{ __('EGP') }}
                    </li>
                </ul>
            </div>
        </div>

        <!-- تفاصيل المنتجات المباعة -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Sold Products Details') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Unit Price') }}</th>
                            <th>{{ __('Total Price') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sale->saleItems as $item)
                            <tr>
                                <td>{{ $item->product->id }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 2) }} {{ __('EGP') }}</td>
                                <td>{{ number_format($item->quantity * $item->price, 2) }} {{ __('EGP') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('No Products Found') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- أزرار التحكم -->
        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> {{ __('Edit') }}
            </a>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> {{ __('Back to List') }}
            </a>
        </div>
    </div>
@endsection
