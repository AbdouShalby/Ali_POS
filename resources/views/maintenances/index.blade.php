@extends('layouts.app')

@section('title', '- ' . __('maintenances.all_maintenance_operations'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('maintenances.all_maintenance_operations') }}</h1>
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
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="table-responsive">
                        <form action="{{ route('maintenances.index') }}" method="GET" class="d-flex flex-wrap">
                            <div style="min-width: 100%; overflow-x: auto;">
                                <div class="d-flex flex-nowrap">
                                    <input type="text" name="search" class="form-control form-control-solid w-250px ps-12 me-3" placeholder="{{ __('maintenances.search_by_customer_phone_or_device') }}" value="{{ request('search') }}"/>

                                    <div class="w-100 mw-150px me-3">
                                        <select name="status" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('maintenances.status') }}">
                                            <option value="">{{ __('maintenances.all_statuses') }}</option>
                                            <option value="in_maintenance" {{ request('status') == 'in_maintenance' ? 'selected' : '' }}>{{ __('maintenances.in_maintenance') }}</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('maintenances.completed') }}</option>
                                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ __('maintenances.delivered') }}</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success ms-3">{{ __('maintenances.search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="{{ route('maintenances.create') }}" class="btn btn-primary">{{ __('maintenances.add_new_maintenance_operation') }}</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                            <thead>
                            <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">{{ __('maintenances.customer_name') }}</th>
                                <th class="min-w-100px text-start">{{ __('maintenances.phone_number') }}</th>
                                <th class="min-w-100px text-start">{{ __('maintenances.device_type') }}</th>
                                <th class="min-w-100px text-start">{{ __('maintenances.problem_description') }}</th>
                                <th class="min-w-100px text-start">{{ __('maintenances.cost') }}</th>
                                <th class="min-w-100px text-start">{{ __('maintenances.status') }}</th>
                                <th class="min-w-100px text-start">{{ __('maintenances.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($maintenances as $maintenance)
                                <tr>
                                    <td>{{ $maintenance->customer_name }}</td>
                                    <td class="text-start">{{ $maintenance->phone_number }}</td>
                                    <td class="text-start">{{ $maintenance->device_type }}</td>
                                    <td class="text-start">{{ $maintenance->problem_description }}</td>
                                    <td class="text-start">{{ $maintenance->cost ?? __('maintenances.not_specified') }}</td>
                                    <td class="text-start">
                                        <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="in_maintenance" {{ $maintenance->status == 'in_maintenance' ? 'selected' : '' }}>{{ __('maintenances.in_maintenance') }}</option>
                                                <option value="completed" {{ $maintenance->status == 'completed' ? 'selected' : '' }}>{{ __('maintenances.completed') }}</option>
                                                <option value="delivered" {{ $maintenance->status == 'delivered' ? 'selected' : '' }}>{{ __('maintenances.delivered') }}</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-start">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary" type="button" id="actionDropdown{{ $maintenance->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ki-solid ki-abstract-14"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $maintenance->id }}">
                                                <li><a class="dropdown-item text-info" href="{{ route('maintenances.show', $maintenance->id) }}">{{ __('maintenances.show') }}</a></li>
                                                <li><a class="dropdown-item text-success" href="{{ route('maintenances.edit', $maintenance->id) }}">{{ __('maintenances.edit') }}</a></li>
                                                <li>
                                                    <form action="{{ route('maintenances.destroy', $maintenance->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">{{ __('maintenances.delete') }}</button>
                                                    </form>
                                                </li>
                                                <li><a class="dropdown-item text-bg-dark" href="{{ route('maintenances.print', $maintenance->id) }}" target="_blank">{{ __('maintenances.print_receipt') }}</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('maintenances.no_maintenance_operations_found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $maintenances->links() }}
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
        </script>
    @endsection
@endsection
