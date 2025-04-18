@extends('layouts.app')

@section('title', '- ' . __('reports.sales_report'))

@section('content')
    <!-- Toolbar -->
    <div class="app-toolbar py-3 py-lg-6">
        <div class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('reports.sales_report') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('dashboard.Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('reports.reports') }}</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('reports.sales_report') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content flex-column-fluid">
        <div class="app-container container-xxl">
            <!-- Filter Card -->
            <div class="card card-flush mb-7">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('reports.filter_options') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <!-- Date Range -->
                        <div class="col-md-4">
                            <label class="form-label">{{ __('reports.from_date') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar-date fs-4"></i>
                                </span>
                                <input type="date" 
                                       class="form-control" 
                                       name="from" 
                                       value="{{ request('from') }}"
                                       placeholder="{{ __('reports.select_date') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('reports.to_date') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar-date fs-4"></i>
                                </span>
                                <input type="date" 
                                       class="form-control" 
                                       name="to" 
                                       value="{{ request('to') }}"
                                       placeholder="{{ __('reports.select_date') }}">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-2"></i>
                                {{ __('reports.apply_filter') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sales Report Card -->
            <div class="card card-flush">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <!-- Search -->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="bi bi-search fs-3 position-absolute ms-5"></i>
                            <input type="text" 
                                   class="form-control form-control-solid w-250px ps-12" 
                                   id="search-input"
                                   placeholder="{{ __('reports.search_sales') }}">
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <!-- Export Buttons -->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('reports.sales.export.excel') }}" 
                               class="btn btn-light-success me-3">
                                <i class="bi bi-file-earmark-excel me-2"></i>
                                {{ __('reports.export_excel') }}
                            </a>
                            <a href="{{ route('reports.sales.export.pdf') }}" 
                               class="btn btn-light-danger">
                                <i class="bi bi-file-earmark-pdf me-2"></i>
                                {{ __('reports.export_pdf') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th>{{ __('reports.date') }}</th>
                                    <th>{{ __('reports.invoice_number') }}</th>
                                    <th>{{ __('reports.customer') }}</th>
                                    <th>{{ __('reports.payment_method') }}</th>
                                    <th>{{ __('reports.amount') }}</th>
                                    <th>{{ __('reports.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $sale->invoice_number ?? 'INV-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $sale->customer->name ?? __('reports.unknown') }}</td>
                                        <td>
                                            <span class="badge badge-light-{{ $sale->payment_method == 'cash' ? 'success' : ($sale->payment_method == 'card' ? 'info' : 'warning') }}">
                                                {{ __('reports.' . $sale->payment_method) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($sale->total_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('sales.show', $sale->id) }}" 
                                               class="btn btn-icon btn-light-primary btn-sm me-1"
                                               data-bs-toggle="tooltip"
                                               title="{{ __('reports.view_details') }}">
                                                <i class="bi bi-eye-fill fs-4"></i>
                                            </a>
                                            <a href="{{ route('sales.print', $sale->id) }}" 
                                               class="btn btn-icon btn-light-info btn-sm"
                                               data-bs-toggle="tooltip"
                                               title="{{ __('reports.print_invoice') }}">
                                                <i class="bi bi-printer-fill fs-4"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">{{ __('reports.no_sales_found') }}</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end pt-7">
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltips
        [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function(element) {
            return new bootstrap.Tooltip(element);
        });

        // Search functionality
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                const searchText = e.target.value.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr');

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchText) ? '' : 'none';
                });
            });
        }
    });
</script>
@endsection
