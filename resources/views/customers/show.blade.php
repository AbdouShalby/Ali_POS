@extends('layouts.app')

@section('title', '- ' . __('customers.customer_details'))

@section('content')
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

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card card-flush">
                <div class="card-header">
                    <h2>{{ __('customers.customer_information') }}</h2>
                </div>
                <div class="card-body row pt-0">
                    <div class="mb-10 col-md-6">
                        <label class="form-label fw-bold">{{ __('customers.name') }}:</label>
                        <p class="form-control-plaintext">{{ $customer->name }}</p>
                    </div>
                    <div class="mb-10 col-md-6">
                        <label class="form-label fw-bold">{{ __('customers.email') }}:</label>
                        <p class="form-control-plaintext">{{ $customer->email ?? __('customers.not_available') }}</p>
                    </div>
                    <div class="mb-10 col-md-6">
                        <label class="form-label fw-bold">{{ __('customers.phone') }}:</label>
                        <p class="form-control-plaintext">{{ $customer->phone ?? __('customers.not_available') }}</p>
                    </div>
                    <div class="mb-10 col-md-6">
                        <label class="form-label fw-bold">{{ __('customers.address') }}:</label>
                        <p class="form-control-plaintext">{{ $customer->address ?? __('customers.not_available') }}</p>
                    </div>
                    <div class="mb-10 col-md-12">
                        <label class="form-label fw-bold">{{ __('customers.notes') }}:</label>
                        <p class="form-control-plaintext">{{ $customer->notes ?? __('customers.not_available') }}</p>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning me-3">
                        <i class="bi bi-pencil-square"></i> {{ __('customers.edit') }}
                    </a>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> {{ __('customers.back_to_list') }}
                    </a>
                </div>
            </div>

            <div class="card card-flush mt-10">
                <div class="card-header">
                    <h2>{{ __('customers.customer_purchases') }}</h2>
                </div>
                <div class="card-body">
                    @if($customer->sales->isEmpty())
                        <div class="alert alert-warning text-center">
                            {{ __('customers.no_purchases') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <thead>
                                <tr>
                                    <th>{{ __('customers.product_name') }}</th>
                                    <th>{{ __('customers.quantity') }}</th>
                                    <th>{{ __('customers.total_price') }}</th>
                                    <th>{{ __('customers.purchase_date') }}</th>
                                </tr>
                                </thead>
                                <tbody>
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
