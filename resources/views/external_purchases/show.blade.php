@extends('layouts.app')

@section('title', '- ' . __('External Purchase Details'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('external_purchases.external_purchase_details') }}: {{ $externalPurchase->invoice_number }}
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
                    <li class="breadcrumb-item text-muted">{{ __('external_purchases.external_purchase_details') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Details Card -->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <h2 class="card-title">{{ __('external_purchases.external_purchase_details') }}</h2>
                </div>
                <div class="card-body">
                    <div class="mb-10">
                        <label class="form-label fw-bold">{{ __('external_purchases.invoice_number') }}:</label>
                        <p class="form-control-plaintext">{{ $externalPurchase->invoice_number }}</p>
                    </div>
                    <div class="mb-10">
                        <label class="form-label fw-bold">{{ __('external_purchases.description') }}:</label>
                        <p class="form-control-plaintext">{{ $externalPurchase->description }}</p>
                    </div>
                    <div class="mb-10">
                        <label class="form-label fw-bold">{{ __('external_purchases.amount') }}:</label>
                        <p class="form-control-plaintext">{{ number_format($externalPurchase->amount, 2) }} {{ __('external_purchases.currency') }}</p>
                    </div>
                    <div class="mb-10">
                        <label class="form-label fw-bold">{{ __('external_purchases.purchase_date') }}:</label>
                        <p class="form-control-plaintext">{{ $externalPurchase->purchase_date }}</p>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('external_purchases.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> {{ __('external_purchases.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
