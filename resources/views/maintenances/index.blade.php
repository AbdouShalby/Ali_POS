@extends('layouts.app')

@section('title', '- ' . __('maintenances.all_maintenance_operations'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('maintenances.all_maintenance_operations') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('maintenances.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('maintenances.all_maintenance_operations') }}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('maintenances.create') }}" class="btn btn-sm fw-bold btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    {{ __('maintenances.add_new_maintenance_operation') }}
                </a>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Stats Cards -->
            <div class="row g-5 g-xl-8 mb-5">
                <!-- Total Maintenance -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C;background-image:url('/assets/media/svg/shapes/wave-bg-red.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ $maintenances->total() }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('maintenances.total_maintenance') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- In Maintenance -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #20D489;background-image:url('/assets/media/svg/shapes/wave-bg-green.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ $maintenances->where('status', 'in_maintenance')->count() }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('maintenances.in_maintenance') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url('/assets/media/svg/shapes/wave-bg-purple.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ $maintenances->where('status', 'completed')->count() }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('maintenances.completed') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivered -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #009EF7;background-image:url('/assets/media/svg/shapes/wave-bg-blue.svg')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">{{ $maintenances->where('status', 'delivered')->count() }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">{{ __('maintenances.delivered') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card mb-5">
                <div class="card-body pt-5">
                    <form action="{{ route('maintenances.index') }}" method="GET" class="d-flex flex-wrap">
                        <div class="row g-5">
                            <!-- Search -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">{{ __('maintenances.search') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-search fs-2"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control" placeholder="{{ __('maintenances.search_by_customer_phone_or_device') }}" value="{{ request('search') }}"/>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">{{ __('maintenances.status') }}</label>
                                <select name="status" class="form-select" data-control="select2" data-placeholder="{{ __('maintenances.select_status') }}">
                                    <option value="">{{ __('maintenances.all_statuses') }}</option>
                                    <option value="in_maintenance" {{ request('status') == 'in_maintenance' ? 'selected' : '' }}>{{ __('maintenances.in_maintenance') }}</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('maintenances.completed') }}</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ __('maintenances.delivered') }}</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-funnel-fill me-1"></i>
                                    {{ __('maintenances.apply_filters') }}
                                </button>
                                <a href="{{ route('maintenances.index') }}" class="btn btn-light">
                                    <i class="bi bi-x-circle me-1"></i>
                                    {{ __('maintenances.clear_filters') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Maintenance Table -->
            <div class="card card-flush">
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_maintenance_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">{{ __('maintenances.customer_name') }}</th>
                                    <th class="min-w-125px">{{ __('maintenances.phone_number') }}</th>
                                    <th class="min-w-125px">{{ __('maintenances.device_type') }}</th>
                                    <th class="min-w-125px">{{ __('maintenances.problem_description') }}</th>
                                    <th class="min-w-125px">{{ __('maintenances.cost') }}</th>
                                    <th class="min-w-125px">{{ __('maintenances.status') }}</th>
                                    <th class="text-end min-w-100px">{{ __('maintenances.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @forelse($maintenances as $maintenance)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-circle symbol-35px me-3">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="bi bi-person-fill fs-2 text-primary"></i>
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-dark fw-bold text-hover-primary fs-6">{{ $maintenance->customer_name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-bold fs-6">{{ $maintenance->phone_number }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-bold fs-6">{{ $maintenance->device_type }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-bold fs-6">{{ Str::limit($maintenance->problem_description, 50) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-bold fs-6">{{ $maintenance->cost ? number_format($maintenance->cost, 2) : __('maintenances.not_specified') }}</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="customer_name" value="{{ $maintenance->customer_name }}">
                                                <input type="hidden" name="phone_number" value="{{ $maintenance->phone_number }}">
                                                <input type="hidden" name="device_type" value="{{ $maintenance->device_type }}">
                                                <input type="hidden" name="problem_description" value="{{ $maintenance->problem_description }}">
                                                <input type="hidden" name="cost" value="{{ $maintenance->cost }}">
                                                <input type="hidden" name="password" value="{{ $maintenance->password }}">
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width: 150px;">
                                                    <option value="in_maintenance" {{ $maintenance->status == 'in_maintenance' ? 'selected' : '' }} class="text-warning">{{ __('maintenances.in_maintenance') }}</option>
                                                    <option value="completed" {{ $maintenance->status == 'completed' ? 'selected' : '' }} class="text-success">{{ __('maintenances.completed') }}</option>
                                                    <option value="delivered" {{ $maintenance->status == 'delivered' ? 'selected' : '' }} class="text-info">{{ __('maintenances.delivered') }}</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end flex-shrink-0">
                                                <a href="{{ route('maintenances.show', $maintenance->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('maintenances.show') }}">
                                                    <i class="bi bi-eye-fill fs-2"></i>
                                                </a>
                                                <a href="{{ route('maintenances.edit', $maintenance->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('maintenances.edit') }}">
                                                    <i class="bi bi-pencil-fill fs-2"></i>
                                                </a>
                                                <form action="{{ route('maintenances.destroy', $maintenance->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('maintenances.delete') }}" onclick="return confirm('{{ __('maintenances.confirm_delete') }}')">
                                                        <i class="bi bi-trash-fill fs-2"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('maintenances.print', $maintenance->id) }}" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" data-bs-toggle="tooltip" title="{{ __('maintenances.print_receipt') }}">
                                                    <i class="bi bi-printer-fill fs-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bi bi-inbox fs-2x text-gray-400 mb-3"></i>
                                                <span class="text-gray-600 fs-6">{{ __('maintenances.no_maintenance_operations_found') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <div class="d-flex align-items-center">
                            <span class="text-gray-600 fs-6 me-2">{{ __('Showing') }} {{ $maintenances->firstItem() ?? 0 }} {{ __('to') }} {{ $maintenances->lastItem() ?? 0 }} {{ __('of') }} {{ $maintenances->total() }} {{ __('entries') }}</span>
                        </div>
                        <div class="d-flex justify-content-end">
                            {{ $maintenances->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            @if(session('success'))
            toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
            toastr.error("{{ session('error') }}");
            @endif

            @if(session('info'))
            toastr.info("{{ session('info') }}");
            @endif

            @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
            @endif

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        </script>
    @endsection
@endsection
