@extends('layouts.app')

@section('title', '- ' . __('customers.add_customer'))

@section('content')
    <!-- Toolbar -->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('customers.add_customer') }}
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
                    <li class="breadcrumb-item text-muted">{{ __('customers.add_customer') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Error Alert -->
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                        <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                    </span>
                    <div>
                        <h4 class="alert-heading fw-bold">{{ __('customers.error') }}</h4>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Create Form -->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <h2 class="card-title">{{ __('customers.add_customer_details') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <!-- Name Field -->
                        <div class="mb-10">
                            <label for="name" class="form-label fw-bold">{{ __('customers.name') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-solid"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-10">
                            <label for="email" class="form-label fw-bold">{{ __('customers.email') }}</label>
                            <input
                                type="email"
                                class="form-control form-control-solid"
                                id="email"
                                name="email"
                                value="{{ old('email') }}">
                        </div>

                        <!-- Phone Field -->
                        <div class="mb-10">
                            <label for="phone" class="form-label fw-bold">{{ __('customers.phone') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-solid"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}">
                        </div>

                        <!-- Address Field -->
                        <div class="mb-10">
                            <label for="address" class="form-label fw-bold">{{ __('customers.address') }}</label>
                            <textarea
                                class="form-control form-control-solid"
                                id="address"
                                name="address"
                                rows="2">{{ old('address') }}</textarea>
                        </div>

                        <!-- Notes Field -->
                        <div class="mb-10">
                            <label for="notes" class="form-label fw-bold">{{ __('customers.notes') }}</label>
                            <textarea
                                class="form-control form-control-solid"
                                id="notes"
                                name="notes"
                                rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-3">
                                <i class="bi bi-check-circle"></i> {{ __('customers.save') }}
                            </button>
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> {{ __('customers.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
