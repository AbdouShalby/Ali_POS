@extends('layouts.app')

@section('title', __('sales.sale_details'))

@section('breadcrumb')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
            <i class="ki-duotone ki-basket fs-1 me-2">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            {{ __('sales.sale_details') }} #{{ $sale->id }}
        </h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-2">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                    <i class="ki-duotone ki-home fs-6 me-1"></i>
                    {{ __('sales.dashboard') }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('sales.index') }}" class="text-muted text-hover-primary">
                    <i class="ki-duotone ki-basket fs-6 me-1"></i>
                    {{ __('sales.all_sales') }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">{{ __('sales.sale_details') }}</li>
        </ul>
    </div>
@endsection

@section('content')
<div class="d-flex flex-column flex-lg-row gap-7 px-4 py-4">
    <!-- Sale Information Card -->
    <div class="flex-column flex-lg-row-auto w-lg-300px w-xl-350px mb-10">
        <div class="card card-flush" data-kt-sticky="true" data-kt-sticky-name="sale-details" data-kt-sticky-offset="{default: false, lg: 300}" data-kt-sticky-width="{lg: '250px', xl: '350px'}" data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
            <div class="card-header pt-7">
                <div class="card-title">
                    <span class="card-icon me-2">
                        <i class="ki-duotone ki-receipt fs-1 text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </span>
                    <h3 class="fw-bold m-0">{{ __('sales.sale_information') }}</h3>
                </div>
            </div>
            <div class="card-body pt-5">
                <div class="d-flex flex-column gap-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-semibold fs-6">{{ __('sales.sale_id') }}</div>
                        <div class="text-gray-800">#{{ $sale->id }}</div>
                    </div>

                    <div class="d-flex flex-stack">
                        <div class="fw-semibold fs-6">{{ __('sales.sale_date') }}</div>
                        <div class="text-gray-800">{{ format_date($sale->created_at) }}</div>
                    </div>

                    <div class="d-flex flex-stack">
                        <div class="fw-semibold fs-6">{{ __('sales.customer') }}</div>
                        <div class="text-gray-800">
                            <a href="{{ route('customers.show', $sale->customer_id) }}" class="text-gray-800 text-hover-primary">
                                {{ $sale->customer->name }}
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-stack">
                        <div class="fw-semibold fs-6">{{ __('sales.payment_status') }}</div>
                        <div class="text-gray-800">
                            <span class="badge badge-light-success">{{ __('sales.status_paid') }}</span>
                        </div>
                    </div>

                    <div class="separator separator-dashed my-3"></div>

                    <div class="fw-bold fs-5 mb-4">{{ __('sales.notes') }}</div>
                    <div class="text-gray-600">
                        {{ $sale->notes ?: __('sales.no_notes') }}
                    </div>
                </div>
            </div>
            <div class="card-footer pt-0">
                <div class="d-flex flex-stack">
                    <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-light btn-active-light-primary me-2">
                        <i class="ki-duotone ki-notepad-edit fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ __('sales.edit') }}
                    </a>
                    <a href="{{ route('sales.print', $sale->id) }}" class="btn btn-light btn-active-light-primary" target="_blank">
                        <i class="ki-duotone ki-printer fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ __('sales.print') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-lg-row-fluid">
        <!-- Products Card -->
        <div class="card card-flush mb-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="fw-bold m-0">{{ __('sales.sold_products') }}</h3>
                </div>
            </div>
            <div class="card-body">
                @if(!$sale->saleDetails || $sale->saleDetails->isEmpty())
                    <div class="alert alert-warning d-flex align-items-center p-5">
                        <i class="ki-duotone ki-information-5 fs-2qx me-4 text-warning">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-warning">{{ __('sales.no_products') }}</h4>
                            <span>{{ __('sales.no_products_message') }}</span>
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th class="min-w-50px">#</th>
                                    <th class="min-w-200px">{{ __('sales.product_name') }}</th>
                                    <th class="min-w-100px">{{ __('sales.quantity') }}</th>
                                    <th class="min-w-100px">{{ __('sales.unit_price') }}</th>
                                    <th class="min-w-100px text-end">{{ __('sales.total_price') }}</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach($sale->saleDetails as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ format_currency($item->unit_price) }}</td>
                                        <td class="text-end">{{ format_currency($item->total_price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Summary Card -->
        <div class="card card-flush">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="fw-bold m-0">{{ __('sales.sale_summary') }}</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex flex-column gap-8 px-5">
                    <div class="d-flex flex-stack">
                        <div class="fw-semibold fs-6">{{ __('sales.subtotal') }}</div>
                        <div class="text-gray-800">{{ format_currency($sale->subtotal) }}</div>
                    </div>

                    <div class="d-flex flex-stack">
                        <div class="fw-semibold fs-6">{{ __('sales.discount') }}</div>
                        <div class="text-gray-800">{{ format_currency($sale->discount_amount) }}</div>
                    </div>

                    <div class="d-flex flex-stack">
                        <div class="fw-semibold fs-6">{{ __('sales.tax') }} ({{ $sale->tax_percentage }}%)</div>
                        <div class="text-gray-800">{{ format_currency($sale->tax_amount) }}</div>
                    </div>

                    <div class="separator separator-dashed my-3"></div>

                    <div class="d-flex flex-stack">
                        <div class="fw-bold fs-4">{{ __('sales.total') }}</div>
                        <div class="text-gray-800 fs-4 fw-bold">{{ format_currency($sale->total_amount) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end mt-8 px-4">
    <a href="{{ route('sales.index') }}" class="btn btn-light me-3">
        <i class="ki-duotone ki-arrow-left fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        {{ __('sales.back_to_list') }}
    </a>
    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#export_modal">
        <i class="ki-duotone ki-exit-down fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        {{ __('sales.export') }}
    </button>
</div>

<!-- Export Modal -->
<div class="modal fade" id="export_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('sales.modal_export_title') }}</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column gap-5">
                    <a href="{{ route('sales.export.pdf', $sale->id) }}" class="btn btn-light-primary" target="_blank">
                        <i class="ki-duotone ki-document fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ __('sales.export_pdf') }}
                    </a>
                    <a href="{{ route('sales.export.excel', $sale->id) }}" class="btn btn-light-success">
                        <i class="ki-duotone ki-file-down fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ __('sales.export_excel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
