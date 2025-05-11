@extends('layouts.app')

@section('title', '- ' . __('suppliers.supplier_details'))

@section('content')
    <!-- Toolbar -->
    <div class="app-toolbar py-4 py-lg-6" id="kt_app_toolbar">
        <div class="app-container container-xxl d-flex flex-stack flex-wrap gap-4">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-2 flex-column justify-content-center my-0">
                    {{ $supplier->name }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('suppliers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('suppliers.index') }}" class="text-muted text-hover-primary">{{ __('suppliers.all_suppliers') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('suppliers.supplier_details') }}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil-square fs-5 me-2"></i>
                    {{ __('suppliers.edit') }}
                </a>
                <button type="button" onclick="deleteSupplier({{ $supplier->id }})" class="btn btn-sm btn-danger">
                    <i class="bi bi-trash fs-5 me-2"></i>
                    {{ __('suppliers.delete') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content flex-column-fluid" id="kt_app_content">
        <div class="app-container container-xxl">
            <div class="row g-7">
                <!-- Supplier Information -->
                <div class="col-xl-4">
                    <div class="card card-flush h-100">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('suppliers.basic_information') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-center flex-column mb-5">
                                <div class="symbol symbol-100px symbol-circle mb-7">
                                    <span class="symbol-label fs-1 fw-bold text-primary bg-light-primary">
                                        {{ strtoupper(substr($supplier->name, 0, 1)) }}
                                    </span>
                                </div>
                                <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">
                                    {{ $supplier->name }}
                                </a>
                                <div class="fs-5 fw-semibold text-muted mb-6">{{ __('suppliers.id') }}: {{ $supplier->id }}</div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="d-flex flex-column gap-5">
                                @if($supplier->phone)
                                <div class="d-flex flex-row">
                                    <div class="d-flex align-items-center me-5">
                                        <i class="bi bi-telephone-fill fs-3 text-primary me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="text-gray-400 fs-7">{{ __('suppliers.phone') }}</div>
                                        <a href="tel:{{ $supplier->phone }}" class="text-gray-800 fs-6 fw-bold">{{ $supplier->phone }}</a>
                                    </div>
                                </div>
                                @endif

                                @if($supplier->email)
                                <div class="d-flex flex-row">
                                    <div class="d-flex align-items-center me-5">
                                        <i class="bi bi-envelope-fill fs-3 text-primary me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="text-gray-400 fs-7">{{ __('suppliers.email') }}</div>
                                        <a href="mailto:{{ $supplier->email }}" class="text-gray-800 fs-6 fw-bold">{{ $supplier->email }}</a>
                                    </div>
                                </div>
                                @endif

                                @if($supplier->address)
                                <div class="d-flex flex-row">
                                    <div class="d-flex align-items-center me-5">
                                        <i class="bi bi-geo-alt-fill fs-3 text-primary me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="text-gray-400 fs-7">{{ __('suppliers.address') }}</div>
                                        <div class="text-gray-800 fs-6 fw-bold">{{ $supplier->address }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics & Recent Purchases -->
                <div class="col-xl-8">
                    <!-- Statistics -->
                    <div class="card card-flush mb-7">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('suppliers.statistics') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-5 g-xl-8">
                                <!-- Total Purchases -->
                                <div class="col-xl-4">
                                    <div class="card card-dashed h-100">
                                        <div class="card-body d-flex justify-content-between flex-column">
                                            <div class="d-flex flex-column">
                                                <span class="fs-7 text-gray-400 mb-1">{{ __('suppliers.total_purchases') }}</span>
                                                <span class="fs-2hx fw-bold text-gray-800">{{ number_format($statistics['total_purchases'], 2) }}</span>
                                            </div>
                                            <div class="d-flex align-items-center flex-column mt-3">
                                                <div class="d-flex align-items-center fs-7 fw-bold text-gray-400">
                                                    {{ $statistics['purchases_count'] }} {{ __('suppliers.purchases') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Last Purchase -->
                                <div class="col-xl-4">
                                    <div class="card card-dashed h-100">
                                        <div class="card-body d-flex justify-content-between flex-column">
                                            <div class="d-flex flex-column">
                                                <span class="fs-7 text-gray-400 mb-1">{{ __('suppliers.last_purchase') }}</span>
                                                @if($statistics['last_purchase'])
                                                    @php
                                                        $lastPurchaseTotal = 0;
                                                        foreach ($statistics['last_purchase']->purchaseItems as $item) {
                                                            $lastPurchaseTotal += $item->quantity * $item->price;
                                                        }
                                                    @endphp
                                                    <span class="fs-2hx fw-bold text-gray-800">{{ number_format($lastPurchaseTotal, 2) }}</span>
                                                    <div class="d-flex align-items-center flex-column mt-3">
                                                        <div class="d-flex align-items-center fs-7 fw-bold text-gray-400">
                                                            {{ $statistics['last_purchase']->created_at->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="fs-2hx fw-bold text-gray-400">{{ __('suppliers.no_purchases') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Average Purchase -->
                                <div class="col-xl-4">
                                    <div class="card card-dashed h-100">
                                        <div class="card-body d-flex justify-content-between flex-column">
                                            <div class="d-flex flex-column">
                                                <span class="fs-7 text-gray-400 mb-1">{{ __('suppliers.average_purchase') }}</span>
                                                <span class="fs-2hx fw-bold text-gray-800">{{ number_format($statistics['average_purchase'], 2) }}</span>
                                            </div>
                                            <div class="d-flex align-items-center flex-column mt-3">
                                                <div class="d-flex align-items-center fs-7 fw-bold text-gray-400">
                                                    {{ __('suppliers.per_purchase') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Purchases -->
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('suppliers.purchase_history') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted">
                                            <th class="min-w-150px">{{ __('suppliers.invoice_number') }}</th>
                                            <th class="min-w-140px">{{ __('suppliers.date') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.total_items') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.total_amount') }}</th>
                                            <th class="min-w-100px text-end">{{ __('suppliers.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($purchases as $purchase)
                                            @php
                                                $totalItems = $purchase->purchaseItems->sum('quantity');
                                                $totalAmount = 0;
                                                foreach ($purchase->purchaseItems as $item) {
                                                    $totalAmount += $item->quantity * $item->price;
                                                }
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="#" class="text-dark fw-bold text-hover-primary fs-6">
                                                                {{ $purchase->invoice_number ?? 'N/A' }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $purchase->created_at->format('Y-m-d') }}
                                                </td>
                                                <td>
                                                    {{ $totalItems }}
                                                </td>
                                                <td>
                                                    {{ number_format($totalAmount, 2) }}
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <i class="bi bi-eye fs-3"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">{{ __('suppliers.no_purchases_found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $purchases->links() }}
                        </div>
                    </div>
                    
                    <!-- المنتجات المشتراة من المورد -->
                    <div class="card card-flush mt-7">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('suppliers.supplier_products') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="min-w-150px">{{ __('suppliers.product_name') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.payment_method') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.cost') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.price') }}</th>
                                            <th class="min-w-100px text-end">{{ __('suppliers.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($product->image)
                                                            <div class="symbol symbol-45px me-5">
                                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" />
                                                            </div>
                                                        @endif
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="{{ route('products.show', $product->id) }}" class="text-dark fw-bold text-hover-primary fs-6">
                                                                {{ $product->name }}
                                                            </a>
                                                            <span class="text-muted fw-semibold text-muted d-block fs-7">
                                                                {{ $product->barcode }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($product->payment_method == 'cash')
                                                        <span class="badge badge-success">{{ __('suppliers.cash') }}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ __('suppliers.credit') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($product->cost, 2) }}</td>
                                                <td>{{ number_format($product->price, 2) }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <i class="bi bi-eye fs-3"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">{{ __('suppliers.no_products_found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $products->links() }}
                            @endif
                        </div>
                    </div>

                    <!-- الديون والمدفوعات -->
                    <div class="card card-flush mt-7">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('suppliers.debts_and_payments') }}</span>
                            </h3>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#add_payment_modal">
                                    <i class="bi bi-plus-circle fs-7 me-1"></i>{{ __('suppliers.add_payment') }}
                                </button>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-wrap flex-stack mb-7">
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <div class="d-flex flex-wrap">
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $totalDebt }}">{{ number_format($totalDebt, 2) }}</div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-400">{{ __('suppliers.total_debt') }}</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $totalPaid }}">{{ number_format($totalPaid, 2) }}</div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-400">{{ __('suppliers.total_paid') }}</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $totalRemaining }}">{{ number_format($totalRemaining, 2) }}</div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-400">{{ __('suppliers.total_remaining') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="min-w-150px">{{ __('suppliers.product') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.amount') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.paid') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.remaining') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.status') }}</th>
                                            <th class="min-w-100px text-end">{{ __('suppliers.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($debts as $debt)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="{{ route('products.show', $debt->product_id) }}" class="text-dark fw-bold text-hover-primary fs-6">
                                                                {{ $debt->product->name ?? __('suppliers.product_not_available') }}
                                                            </a>
                                                            <span class="text-muted fw-semibold text-muted d-block fs-7">
                                                                {{ $debt->created_at->format('Y-m-d') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($debt->amount, 2) }}</td>
                                                <td>{{ number_format($debt->paid, 2) }}</td>
                                                <td>{{ number_format($debt->remaining, 2) }}</td>
                                                <td>
                                                    @if($debt->status == 'paid')
                                                        <span class="badge badge-success">{{ __('suppliers.paid') }}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ __('suppliers.unpaid') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('suppliers.payment_history', $debt->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="{{ __('suppliers.payment_history') }}">
                                                        <i class="bi bi-clock-history fs-3"></i>
                                                    </a>
                                                    @if($debt->status != 'paid')
                                                        <a href="{{ route('suppliers.payments', $debt->id) }}" class="btn btn-icon btn-bg-light btn-active-color-success btn-sm" title="{{ __('suppliers.add_payment') }}">
                                                            <i class="bi bi-cash-coin fs-3"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">{{ __('suppliers.no_debts_found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($debts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $debts->links() }}
                            @endif
                        </div>
                    </div>

                    <!-- سجل المدفوعات -->
                    <div class="card card-flush mt-7">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('suppliers.payment_history_all') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="min-w-120px">{{ __('suppliers.payment_date') }}</th>
                                            <th class="min-w-120px">{{ __('suppliers.amount') }}</th>
                                            <th class="min-w-150px">{{ __('suppliers.product') }}</th>
                                            <th class="min-w-200px">{{ __('suppliers.note') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->payment_date }}</td>
                                                <td>{{ number_format($payment->amount, 2) }}</td>
                                                <td>
                                                    @if($payment->debt && $payment->debt->product)
                                                        <a href="{{ route('products.show', $payment->debt->product_id) }}" class="text-dark fw-bold text-hover-primary fs-6">
                                                            {{ $payment->debt->product->name }}
                                                        </a>
                                                    @else
                                                        {{ __('suppliers.product_not_available') }}
                                                    @endif
                                                </td>
                                                <td>{{ $payment->note ?? __('suppliers.no_note') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">{{ __('suppliers.no_payments_found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($payments instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $payments->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إضافة دفعة Modal -->
    <div class="modal fade" id="add_payment_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('suppliers.add_payment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('suppliers.record_bulk_payment', $supplier->id) }}" method="POST" id="add_payment_form">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-5">
                            <label for="payment_amount" class="form-label required">{{ __('suppliers.payment_amount') }}</label>
                            <input type="number" id="payment_amount" name="amount" class="form-control form-control-lg" step="0.01" min="0.01" required />
                        </div>
                        <div class="mb-5">
                            <label for="payment_date" class="form-label required">{{ __('suppliers.payment_date') }}</label>
                            <input type="date" id="payment_date" name="payment_date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}" required />
                        </div>
                        <div class="mb-5">
                            <label for="payment_note" class="form-label">{{ __('suppliers.payment_note') }}</label>
                            <textarea id="payment_note" name="note" class="form-control form-control-lg" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('suppliers.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="add_payment_submit">
                            <span class="indicator-label">{{ __('suppliers.submit') }}</span>
                            <span class="indicator-progress">{{ __('suppliers.please_wait') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
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
                    <form id="kt_modal_delete_form" class="form" action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
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

@section('scripts')
<script>
    function deleteSupplier(id) {
        const modal = document.getElementById('deleteModal');
        new bootstrap.Modal(modal).show();
    }

    // تحديث الخزنة عندما يتم إضافة دفعة جديدة
    document.addEventListener('DOMContentLoaded', function () {
        const addPaymentForm = document.getElementById('add_payment_form');
        if (addPaymentForm) {
            addPaymentForm.addEventListener('submit', function() {
                const submitButton = document.getElementById('add_payment_submit');
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
            });
        }
    });
</script>
@endsection
