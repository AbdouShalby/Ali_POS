@extends('layouts.app')

@section('title', '- ' . __('purchases.purchase_details'))

@section('content')
    <!-- Toolbar -->
    <div class="app-toolbar py-4 py-lg-6" id="kt_app_toolbar">
        <div class="app-container container-xxl d-flex flex-stack flex-wrap gap-4">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-2 flex-column justify-content-center my-0">
                    {{ __('purchases.purchase_details') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('dashboard.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('purchases.index') }}" class="text-muted text-hover-primary">{{ __('purchases.purchases') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('purchases.purchase_details') }}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil-square fs-5 me-2"></i>
                    {{ __('purchases.edit_purchase') }}
                </a>
                <a href="{{ route('purchases.print', $purchase->id) }}" class="btn btn-sm btn-info" target="_blank">
                    <i class="bi bi-printer fs-5 me-2"></i>
                    {{ __('purchases.print_invoice') }}
                </a>
                <button type="button" onclick="deletePurchase({{ $purchase->id }})" class="btn btn-sm btn-danger">
                    <i class="bi bi-trash fs-5 me-2"></i>
                    {{ __('purchases.delete_purchase') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content flex-column-fluid" id="kt_app_content">
        <div class="app-container container-xxl">
            <div class="row g-7">
                <!-- Purchase Information -->
                <div class="col-xl-4">
                    <div class="card card-flush h-100">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('purchases.basic_information') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-column gap-5">
                                <div class="d-flex flex-row">
                                    <div class="d-flex align-items-center me-5">
                                        <i class="bi bi-receipt fs-3 text-primary me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="text-gray-400 fs-7">{{ __('purchases.invoice_number') }}</div>
                                        <div class="text-gray-800 fs-6 fw-bold">{{ $purchase->invoice_number }}</div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="d-flex align-items-center me-5">
                                        <i class="bi bi-calendar-date fs-3 text-primary me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="text-gray-400 fs-7">{{ __('purchases.purchase_date') }}</div>
                                        <div class="text-gray-800 fs-6 fw-bold">{{ date('Y-m-d', strtotime($purchase->purchase_date)) }}</div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="d-flex align-items-center me-5">
                                        <i class="bi bi-person fs-3 text-primary me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="text-gray-400 fs-7">{{ __('purchases.supplier_name') }}</div>
                                        <a href="{{ route('suppliers.show', $purchase->supplier_id) }}" class="text-gray-800 fs-6 fw-bold text-hover-primary">
                                            {{ $purchase->supplier->name }}
                                        </a>
                                    </div>
                                </div>

                                @if($purchase->notes)
                                <div class="d-flex flex-row">
                                    <div class="d-flex align-items-center me-5">
                                        <i class="bi bi-sticky fs-3 text-primary me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="text-gray-400 fs-7">{{ __('purchases.notes') }}</div>
                                        <div class="text-gray-800 fs-6 fw-bold">{{ $purchase->notes }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase Details -->
                <div class="col-xl-8">
                    <!-- Purchase Summary -->
                    @php
                        $subtotal = 0;
                        foreach($purchase->purchaseItems as $item) {
                            $subtotal += $item->quantity * $item->price;
                        }
                        $tax_amount = $subtotal * ($purchase->tax_percentage / 100);
                        $total_amount = $subtotal + $tax_amount - ($purchase->discount_amount ?? 0);
                    @endphp
                    <div class="card card-flush mb-7">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('purchases.purchase_summary') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-5 g-xl-8">
                                <!-- Subtotal -->
                                <div class="col-xl-4">
                                    <div class="card card-dashed h-100">
                                        <div class="card-body d-flex justify-content-between flex-column">
                                            <div class="d-flex flex-column">
                                                <span class="fs-7 text-gray-400 mb-1">{{ __('purchases.subtotal') }}</span>
                                                <span class="fs-2hx fw-bold text-gray-800">{{ number_format($subtotal, 2) }}</span>
                                            </div>
                                            <div class="d-flex align-items-center flex-column mt-3">
                                                <div class="d-flex align-items-center fs-7 fw-bold text-gray-400">
                                                    {{ __('purchases.before_tax_discount') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tax -->
                                <div class="col-xl-4">
                                    <div class="card card-dashed h-100">
                                        <div class="card-body d-flex justify-content-between flex-column">
                                            <div class="d-flex flex-column">
                                                <span class="fs-7 text-gray-400 mb-1">{{ __('purchases.tax_amount') }}</span>
                                                <span class="fs-2hx fw-bold text-gray-800">{{ number_format($tax_amount, 2) }}</span>
                                            </div>
                                            <div class="d-flex align-items-center flex-column mt-3">
                                                <div class="d-flex align-items-center fs-7 fw-bold text-gray-400">
                                                    {{ $purchase->tax_percentage }}% {{ __('purchases.tax_rate') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="col-xl-4">
                                    <div class="card card-dashed h-100">
                                        <div class="card-body d-flex justify-content-between flex-column">
                                            <div class="d-flex flex-column">
                                                <span class="fs-7 text-gray-400 mb-1">{{ __('purchases.total_amount') }}</span>
                                                <span class="fs-2hx fw-bold text-gray-800">{{ number_format($total_amount, 2) }}</span>
                                            </div>
                                            <div class="d-flex align-items-center flex-column mt-3">
                                                <div class="d-flex align-items-center fs-7 fw-bold text-gray-400">
                                                    {{ __('purchases.final_amount') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products List -->
                    <div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">{{ __('purchases.products_list') }}</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted">
                                            <th class="min-w-150px">{{ __('purchases.product_name') }}</th>
                                            <th class="min-w-140px">{{ __('purchases.quantity') }}</th>
                                            <th class="min-w-120px">{{ __('purchases.unit_price') }}</th>
                                            <th class="min-w-100px text-end">{{ __('purchases.total_price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($purchase->purchaseItems as $item)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('products.show', $item->product_id) }}" class="text-gray-800 text-hover-primary fw-bold">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->price, 2) }}</td>
                                                <td class="text-end fw-bold">{{ number_format($item->quantity * $item->price, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="bi bi-cart-x fs-3x text-gray-400 mb-3"></i>
                                                        <div class="fs-6 fw-bold text-gray-800 mb-1">{{ __('purchases.no_items') }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h2 class="fw-bold m-0">{{ __('purchases.delete_purchase') }}</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i>
                    </div>
                </div>
                <div class="modal-body text-center py-8">
                    <form id="kt_modal_delete_form" class="form" action="{{ route('purchases.destroy', $purchase->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="mb-10">
                            <i class="bi bi-exclamation-triangle text-warning fs-5x mb-7"></i>
                            <div class="text-gray-800 fs-2x fw-bold mb-3">{{ __('purchases.delete_confirmation') }}</div>
                            <div class="text-muted fs-6">
                                {{ __('purchases.delete_warning') }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                {{ __('purchases.cancel') }}
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>
                                {{ __('purchases.delete') }}
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
    function deletePurchase(id) {
        const modal = document.getElementById('deleteModal');
        new bootstrap.Modal(modal).show();
    }
</script>
@endpush
