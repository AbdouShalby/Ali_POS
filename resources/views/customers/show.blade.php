@extends('layouts.app')

@section('title', '- ' . __('customers.customer_details'))

@section('content')
    <!-- Toolbar -->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('customers.customer_details') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('customers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('customers.index') }}" class="text-muted text-hover-primary">{{ __('customers.all_customers') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $customer->name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Buttons -->
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> {{ __('customers.back_to_list') }}
                </a>
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning ms-3">
                    <i class="bi bi-pencil-square me-1"></i> {{ __('customers.edit_customer') }}
                </a>
            </div>

            <!-- Customer Details -->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="fs-3 fw-bold text-primary">{{ $customer->name }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">{{ __('customers.email') }}:</label>
                            <p class="form-control-plaintext">{{ $customer->email ?? __('customers.not_available') }}</p>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">{{ __('customers.phone') }}:</label>
                            <p class="form-control-plaintext">{{ $customer->phone ?? __('customers.not_available') }}</p>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">{{ __('customers.address') }}:</label>
                            <p class="form-control-plaintext">{{ $customer->address ?? __('customers.not_available') }}</p>
                        </div>
                        <div class="col-md-12 mb-5">
                            <label class="form-label fw-bold">{{ __('customers.notes') }}:</label>
                            <p class="form-control-plaintext">{{ $customer->notes ?? __('customers.not_available') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Purchases -->
            <div class="card card-flush py-4 mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('customers.customer_purchases') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if($customer->sales->isEmpty())
                        <div class="alert alert-warning text-center mb-0">
                            {{ __('customers.no_purchases') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead>
                                <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                    <th>{{ __('customers.product_name') }}</th>
                                    <th>{{ __('customers.quantity') }}</th>
                                    <th>{{ __('customers.total_price') }}</th>
                                    <th>{{ __('customers.purchase_date') }}</th>
                                </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                @foreach($customer->sales as $sale)
                                    <tr>
                                        <td>{{ $sale->product->name }}</td>
                                        <td>{{ $sale->quantity }}</td>
                                        <td>{{ $sale->total_price }}</td>
                                        <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
