@extends('layouts.app')

@section('title', '- ' . __('suppliers.all_suppliers'))

@section('content')
    <!-- Toolbar -->
    <div class="app-toolbar py-4 py-lg-6" id="kt_app_toolbar">
        <div class="app-container container-xxl d-flex flex-stack flex-wrap gap-4">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-2 flex-column justify-content-center my-0">
                    {{ __('suppliers.all_suppliers') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('suppliers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('suppliers.all_suppliers') }}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary d-flex align-items-center">
                    <i class="bi bi-plus-circle fs-5 me-2"></i>
                    {{ __('suppliers.add_supplier') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content flex-column-fluid" id="kt_app_content">
        <div class="app-container container-xxl">
            <!-- Search and Filters -->
            <div class="card mb-7">
                <div class="card-body">
                    <form id="kt_search_form" class="form">
                        <div class="row g-8">
                            <div class="col-lg-5">
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-search fs-4 text-gray-500"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-solid ps-3" 
                                        placeholder="{{ __('suppliers.search_placeholder') }}" 
                                        name="search" value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <select class="form-select form-select-solid" name="status" data-control="select2" data-placeholder="{{ __('suppliers.all_statuses') }}">
                                    <option value="">{{ __('suppliers.all_statuses') }}</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                        {{ __('suppliers.active') }}
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        {{ __('suppliers.inactive') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <select class="form-select form-select-solid" name="sort" data-control="select2" data-placeholder="{{ __('suppliers.sort_by') }}">
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                        {{ __('suppliers.sort_by_name_asc') }}
                                    </option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                        {{ __('suppliers.sort_by_name_desc') }}
                                    </option>
                                    <option value="created_desc" {{ request('sort') == 'created_desc' ? 'selected' : '' }}>
                                        {{ __('suppliers.sort_by_date_desc') }}
                                    </option>
                                    <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}>
                                        {{ __('suppliers.sort_by_date_asc') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" class="btn btn-icon btn-primary w-100 h-100">
                                    <i class="bi bi-funnel fs-4"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Suppliers Table -->
            <div class="card">
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle">
                            <thead>
                                <tr class="fs-6 fw-bold text-gray-800 border-bottom border-gray-200">
                                    <th class="w-25px pe-2"></th>
                                    <th class="min-w-200px">{{ __('suppliers.name') }}</th>
                                    <th class="min-w-150px">{{ __('suppliers.phone') }}</th>
                                    <th class="min-w-150px">{{ __('suppliers.email') }}</th>
                                    <th class="min-w-100px text-end pe-4">{{ __('suppliers.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-700">
                                @forelse($suppliers as $supplier)
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-40px symbol-circle">
                                                <span class="symbol-label bg-light-primary text-primary fw-bold">
                                                    {{ strtoupper(substr($supplier->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <a href="{{ route('suppliers.show', $supplier->id) }}" 
                                                    class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1">
                                                    {{ $supplier->name }}
                                                </a>
                                                <span class="text-muted fw-semibold">{{ __('suppliers.id') }}: {{ $supplier->id }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-telephone fs-4 text-gray-500 me-2"></i>
                                                <a href="tel:{{ $supplier->phone }}" class="text-gray-700 text-hover-primary">
                                                    {{ $supplier->phone }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-envelope fs-4 text-gray-500 me-2"></i>
                                                <a href="mailto:{{ $supplier->email }}" class="text-gray-700 text-hover-primary">
                                                    {{ $supplier->email }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end flex-shrink-0 gap-2">
                                                <a href="{{ route('suppliers.show', $supplier->id) }}" 
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="{{ __('suppliers.view_details') }}">
                                                    <i class="bi bi-eye-fill fs-4"></i>
                                                </a>
                                                <a href="{{ route('suppliers.edit', $supplier->id) }}" 
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="{{ __('suppliers.edit') }}">
                                                    <i class="bi bi-pencil-fill fs-4"></i>
                                                </a>
                                                <button type="button" 
                                                    class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm"
                                                    onclick="deleteSupplier({{ $supplier->id }})"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="{{ __('suppliers.delete') }}">
                                                    <i class="bi bi-trash-fill fs-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center py-8">
                                                <i class="bi bi-people fs-1 text-gray-400 mb-5"></i>
                                                <h3 class="fs-2x fw-bold text-gray-800 mb-2">{{ __('suppliers.no_suppliers_found') }}</h3>
                                                <div class="fs-6 text-gray-600">{{ __('suppliers.try_different_search') }}</div>
                                                <a href="{{ route('suppliers.create') }}" class="btn btn-primary mt-5">
                                                    <i class="bi bi-plus-circle me-2"></i>
                                                    {{ __('suppliers.add_supplier') }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($suppliers->hasPages())
                    <div class="card-footer py-5">
                        <div class="d-flex justify-content-center">
                            {{ $suppliers->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h2 class="fw-bold m-0">{{ __('suppliers.delete_supplier') }}</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i>
                    </div>
                </div>
                <div class="modal-body text-center py-8">
                    <form id="kt_modal_delete_form" class="form" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="mb-10">
                            <i class="bi bi-exclamation-triangle text-warning fs-5x mb-7"></i>
                            <div class="text-gray-800 fs-2x fw-bold mb-3">{{ __('suppliers.delete_confirmation') }}</div>
                            <div class="text-muted fs-6">
                                {{ __('suppliers.delete_warning') }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                {{ __('suppliers.cancel') }}
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>
                                {{ __('suppliers.delete') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Initialize Select2
    $('select[data-control="select2"]').select2({
        minimumResultsForSearch: -1
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover'
        })
    });

    // Delete supplier function
    function deleteSupplier(id) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('kt_modal_delete_form');
        form.action = `/suppliers/${id}`;
        new bootstrap.Modal(modal).show();
    }

    // Form validation
    var form = document.getElementById('kt_search_form');
    var validator = FormValidation.formValidation(form, {
        fields: {
            'search': {
                validators: {
                    regexp: {
                        regexp: /^[a-zA-Z0-9\s\-\_\.]+$/,
                        message: '{{ __("suppliers.invalid_search") }}'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.row > div',
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    });

    // Auto submit form on change
    $('select[name="status"], select[name="sort"]').change(function() {
        $('#kt_search_form').submit();
    });
</script>
@endpush
