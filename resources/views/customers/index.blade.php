@extends('layouts.app')

@section('title', '- ' . __('customers.all_customers'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('customers.all_customers') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('customers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('customers.all_customers') }}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    {{ __('customers.add_new_customer') }}
                </a>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center p-5 mb-5">
                    <i class="bi bi-check-circle-fill fs-2 text-success me-3"></i>
                    <div class="flex-grow-1">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row g-5 g-xl-8 mb-5">
                <div class="col-xl-4">
                    <div class="card bg-light-primary card-xl-stretch mb-xl-8">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-primary">
                                        <i class="bi bi-people text-inverse-primary fs-2x"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1">{{ __('customers.total_customers') }}</h4>
                                    <span class="fs-2hx fw-bold text-gray-900">{{ $customers->total() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card bg-light-success card-xl-stretch mb-xl-8">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-success">
                                        <i class="bi bi-currency-dollar text-inverse-success fs-2x"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1">{{ __('customers.total_sales') }}</h4>
                                    <span class="fs-2hx fw-bold text-gray-900">{{ number_format($totalSales ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card bg-light-warning card-xl-stretch mb-xl-8">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-warning">
                                        <i class="bi bi-graph-up text-inverse-warning fs-2x"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1">{{ __('customers.average_purchase') }}</h4>
                                    <span class="fs-2hx fw-bold text-gray-900">{{ number_format($averagePurchase ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative">
                            <i class="bi bi-search fs-2 position-absolute ms-4"></i>
                            <input type="text" 
                                data-kt-filter="search" 
                                class="form-control form-control-solid w-250px ps-12" 
                                placeholder="{{ __('customers.search_by_name') }}"
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div class="w-200px">
                            <select class="form-select" data-kt-filter="order">
                                <option value="">{{ __('customers.sort_by') }}</option>
                                <option value="name">{{ __('customers.name') }}</option>
                                <option value="email">{{ __('customers.email') }}</option>
                                <option value="created_at">{{ __('customers.date_added') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">{{ __('customers.name') }}</th>
                                <th class="min-w-125px">{{ __('customers.email') }}</th>
                                <th class="min-w-125px">{{ __('customers.phone') }}</th>
                                <th class="min-w-125px">{{ __('customers.address') }}</th>
                                <th class="text-end min-w-100px">{{ __('customers.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        @forelse($customers as $customer)
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="symbol symbol-circle symbol-40px overflow-hidden me-3">
                                        <div class="symbol-label bg-light-primary">
                                            <i class="bi bi-person-circle fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('customers.show', $customer->id) }}" class="text-gray-800 text-hover-primary mb-1">{{ $customer->name }}</a>
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">
                                            {{ __('customers.id') }}: #{{ $customer->id }}
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $customer->email ?? __('customers.not_available') }}</td>
                                <td>{{ $customer->phone ?? __('customers.not_available') }}</td>
                                <td>{{ $customer->address ?? __('customers.not_available') }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('customers.view') }}">
                                            <i class="bi bi-eye-fill fs-4"></i>
                                        </a>
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('customers.edit') }}">
                                            <i class="bi bi-pencil-fill fs-4"></i>
                                        </a>
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" 
                                                    onclick="return confirm('{{ __('customers.confirm_delete') }}')"
                                                    data-bs-toggle="tooltip" 
                                                    title="{{ __('customers.delete') }}">
                                                <i class="bi bi-trash-fill fs-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">{{ __('customers.no_customers_found') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-6">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // تفعيل tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // البحث في الجدول
    var searchInput = document.querySelector('[data-kt-filter="search"]');
    var timer;
    searchInput.addEventListener('keyup', function(e) {
        clearTimeout(timer);
        timer = setTimeout(function() {
            var searchValue = e.target.value;
            window.location.href = '{{ route('customers.index') }}?search=' + searchValue;
        }, 500);
    });

    // الترتيب
    var orderSelect = document.querySelector('[data-kt-filter="order"]');
    orderSelect.addEventListener('change', function(e) {
        var orderValue = e.target.value;
        if (orderValue) {
            window.location.href = '{{ route('customers.index') }}?order=' + orderValue;
        }
    });
</script>
@endpush
