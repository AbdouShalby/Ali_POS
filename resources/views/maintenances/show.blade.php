@extends('layouts.app')

@section('title', '- ' . __('maintenances.maintenance_operation_details'))

@section('content')
    <!-- Toolbar -->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('maintenances.maintenance_operation_details') }}
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
                    <li class="breadcrumb-item text-muted">{{ $maintenance->customer_name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Buttons -->
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> {{ __('maintenances.back_to_list') }}
                </a>
                <a href="{{ route('maintenances.edit', $maintenance->id) }}" class="btn btn-warning ms-3">
                    <i class="bi bi-pencil-square me-1"></i> {{ __('maintenances.edit_maintenance') }}
                </a>
            </div>

            <!-- Maintenance Details -->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="fs-3 fw-bold text-primary">{{ $maintenance->customer_name }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="fs-5 text-gray-700">
                                <strong>{{ __('maintenances.phone_number') }}:</strong> {{ $maintenance->phone_number }}
                            </p>
                            <p class="fs-5 text-gray-700">
                                <strong>{{ __('maintenances.device_type') }}:</strong> {{ $maintenance->device_type }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="fs-5 text-gray-700">
                                <strong>{{ __('maintenances.cost') }}:</strong> {{ $maintenance->cost ?? __('maintenances.not_specified') }}
                            </p>
                            <p class="fs-5 text-gray-700">
                                <strong>{{ __('maintenances.status') }}:</strong>
                                @if($maintenance->status == 'in_maintenance')
                                    <span class="badge bg-warning">{{ __('maintenances.in_maintenance') }}</span>
                                @elseif($maintenance->status == 'completed')
                                    <span class="badge bg-success">{{ __('maintenances.completed') }}</span>
                                @else
                                    <span class="badge bg-primary">{{ __('maintenances.delivered') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="fs-5 text-gray-700">
                            <strong>{{ __('maintenances.problem_description') }}:</strong>
                            {{ $maintenance->problem_description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Maintenance History -->
            <div class="card card-flush py-4 mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('maintenances.maintenance_history') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th>{{ __('maintenances.status') }}</th>
                                <th>{{ __('maintenances.date') }}</th>
                                <th class="text-end">{{ __('maintenances.updated_by') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            <tr>
                                <td>
                                    <span class="badge bg-warning">{{ __('maintenances.in_maintenance') }}</span>
                                </td>
                                <td>{{ now()->format('d/m/Y H:i A') }}</td>
                                <td class="text-end">{{ __('maintenances.unknown') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
