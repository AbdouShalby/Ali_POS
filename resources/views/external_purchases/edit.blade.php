@extends('layouts.app')

@section('title', '- ' . __('Edit External Purchase'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('external_purchases.edit_external_purchase') }}: {{ $externalPurchase->invoice_number }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('external_purchases.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('external_purchases.index') }}" class="text-muted text-hover-primary">{{ __('external_purchases.all_external_purchases') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('external_purchases.edit_external_purchase') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Error Alert -->
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                        <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                    </span>
                    <div>
                        <h4 class="alert-heading fw-bold">{{ __('external_purchases.error') }}</h4>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Edit Form -->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <h2 class="card-title">{{ __('external_purchases.edit_external_purchase') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('external_purchases.update', $externalPurchase->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Invoice Number Field -->
                        <div class="mb-10">
                            <label for="invoice_number" class="form-label fw-bold">{{ __('external_purchases.invoice_number') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-solid"
                                id="invoice_number"
                                name="invoice_number"
                                value="{{ old('invoice_number', $externalPurchase->invoice_number) }}"
                                required>
                        </div>

                        <!-- Description Field -->
                        <div class="mb-10">
                            <label for="description" class="form-label fw-bold">{{ __('external_purchases.description') }}</label>
                            <textarea
                                class="form-control form-control-solid"
                                id="description"
                                name="description"
                                rows="3"
                                required>{{ old('description', $externalPurchase->description) }}</textarea>
                        </div>

                        <!-- Amount Field -->
                        <div class="mb-10">
                            <label for="amount" class="form-label fw-bold">{{ __('external_purchases.amount') }}</label>
                            <input
                                type="number"
                                step="0.01"
                                class="form-control form-control-solid"
                                id="amount"
                                name="amount"
                                value="{{ old('amount', $externalPurchase->amount) }}"
                                required>
                        </div>

                        <!-- Purchase Date Field -->
                        <div class="mb-10">
                            <label for="purchase_date" class="form-label fw-bold">{{ __('external_purchases.purchase_date') }}</label>
                            <input
                                type="date"
                                class="form-control form-control-solid"
                                id="purchase_date"
                                name="purchase_date"
                                value="{{ old('purchase_date', $externalPurchase->purchase_date) }}"
                                required>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-3">
                                <i class="bi bi-check-circle"></i> {{ __('external_purchases.update') }}
                            </button>
                            <a href="{{ route('external_purchases.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> {{ __('external_purchases.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
