@extends('layouts.app')

@section('title', '- ' . __('maintenances.create_maintenance_operation'))

@section('content')
    <!-- Toolbar -->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('maintenances.create_maintenance_operation') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('maintenances.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('maintenances.index') }}" class="text-muted text-hover-primary">{{ __('maintenances.all_maintenance_operations') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('maintenances.create_maintenance_operation') }}</li>
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
                        <h4 class="alert-heading fw-bold">{{ __('maintenances.error') }}</h4>
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
                    <h2 class="card-title">{{ __('maintenances.create_maintenance_operation') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('maintenances.store') }}" method="POST">
                        @csrf
                        <!-- Customer Name Field -->
                        <div class="mb-10">
                            <label for="customer_name" class="form-label fw-bold">{{ __('maintenances.customer_name') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-solid"
                                id="customer_name"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                required>
                        </div>

                        <!-- Phone Number Field -->
                        <div class="mb-10">
                            <label for="phone_number" class="form-label fw-bold">{{ __('maintenances.phone_number') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-solid"
                                id="phone_number"
                                name="phone_number"
                                value="{{ old('phone_number') }}"
                                required>
                        </div>

                        <!-- Device Type Field -->
                        <div class="mb-10">
                            <label for="device_type" class="form-label fw-bold">{{ __('maintenances.device_type') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-solid"
                                id="device_type"
                                name="device_type"
                                value="{{ old('device_type') }}"
                                required>
                        </div>

                        <!-- Problem Description Field -->
                        <div class="mb-10">
                            <label for="problem_description" class="form-label fw-bold">{{ __('maintenances.problem_description') }}</label>
                            <textarea
                                class="form-control form-control-solid"
                                id="problem_description"
                                name="problem_description"
                                rows="3"
                                required>{{ old('problem_description') }}</textarea>
                        </div>

                        <!-- Cost Field -->
                        <div class="mb-10">
                            <label for="cost" class="form-label fw-bold">{{ __('maintenances.cost') }}</label>
                            <input
                                type="number"
                                step="0.01"
                                class="form-control form-control-solid"
                                id="cost"
                                name="cost"
                                value="{{ old('cost') }}">
                        </div>

                        <!-- Password Field -->
                        <div class="mb-10">
                            <label for="password" class="form-label fw-bold">{{ __('maintenances.password') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-solid"
                                id="password"
                                name="password"
                                value="{{ old('password') }}">
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-3">
                                <i class="bi bi-check-circle"></i> {{ __('maintenances.save') }}
                            </button>
                            <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> {{ __('maintenances.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
