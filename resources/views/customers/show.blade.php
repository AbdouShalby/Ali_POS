@extends('layouts.app')

@section('title', __('customers.customer_details'))

@section('breadcrumb')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
            <i class="ki-duotone ki-profile-user fs-1 me-2">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            {{ __('customers.customer_details') }}
        </h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-2">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                    <i class="ki-duotone ki-home fs-6 me-1"></i>
                    {{ __('customers.dashboard') }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('customers.index') }}" class="text-muted text-hover-primary">
                    <i class="ki-duotone ki-profile-users fs-6 me-1"></i>
                    {{ __('customers.all_customers') }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">{{ __('customers.customer_details') }}</li>
        </ul>
    </div>
@endsection

@section('content')
<div class="d-flex flex-column flex-lg-row gap-7">
    <!-- Customer Information Card -->
    <div class="flex-column flex-lg-row-auto w-lg-300px w-xl-350px mb-10">
        <div class="card card-flush" data-kt-sticky="true" data-kt-sticky-name="customer-details" data-kt-sticky-offset="{default: false, lg: 300}" data-kt-sticky-width="{lg: '250px', xl: '350px'}" data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
            <div class="card-header pt-7">
                <div class="card-title">
                    <span class="card-icon me-2">
                        <i class="ki-duotone ki-profile-circle fs-1 text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </span>
                    <h3 class="fw-bold m-0">{{ __('customers.basic_information') }}</h3>
                </div>
            </div>
            <div class="card-body pt-5">
                <div class="d-flex flex-center flex-column mb-10">
                    <div class="symbol symbol-100px symbol-circle mb-7">
                        <span class="symbol-label bg-light-primary text-primary fs-1 fw-bold">
                            {{ substr($customer->name, 0, 1) }}
                        </span>
                    </div>
                    <a class="fs-2 text-gray-800 text-hover-primary fw-bold mb-1">
                        {{ $customer->name }}
                    </a>
                    <div class="fs-6 fw-semibold text-gray-400 mb-2">
                        {{ __('customers.customer_id') }}: #{{ $customer->id }}
                    </div>
                </div>

                <div class="d-flex flex-stack fs-4 py-3">
                    <div class="fw-bold rotate">
                        <i class="ki-duotone ki-address-book fs-3 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ __('customers.contact_details') }}
                    </div>
                </div>

                <div class="separator separator-dashed my-3"></div>

                <div class="pb-5 fs-6">
                    <div class="fw-bold mt-5">{{ __('customers.email') }}</div>
                    <div class="text-gray-600">
                        <a class="text-gray-600 text-hover-primary">
                            <i class="ki-duotone ki-sms fs-5 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ $customer->email ?: __('customers.not_available') }}
                        </a>
                    </div>

                    <div class="fw-bold mt-5">{{ __('customers.phone') }}</div>
                    <div class="text-gray-600">
                        <a class="text-gray-600 text-hover-primary">
                            <i class="ki-duotone ki-phone fs-5 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ $customer->phone ?: __('customers.not_available') }}
                        </a>
                    </div>

                    <div class="fw-bold mt-5">{{ __('customers.address') }}</div>
                    <div class="text-gray-600">
                        <i class="ki-duotone ki-geolocation fs-5 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ $customer->address ?: __('customers.not_available') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-lg-row-fluid">
        <!-- Statistics -->
        <div class="row g-5 g-xl-8 mb-8">
            <div class="col-xl-4">
                <div class="card card-xl-stretch mb-xl-8">
                    <div class="card-body p-0">
                        <div class="d-flex flex-stack card-p flex-grow-1">
                            <div class="symbol symbol-50px symbol-circle me-2">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-basket fs-2x text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="d-flex flex-column text-end">
                                <span class="text-dark fw-bold fs-2">{{ $total_purchases }}</span>
                                <span class="text-muted fw-semibold mt-1">{{ __('customers.total_purchases') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card card-xl-stretch mb-xl-8">
                    <div class="card-body p-0">
                        <div class="d-flex flex-stack card-p flex-grow-1">
                            <div class="symbol symbol-50px symbol-circle me-2">
                                <div class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-dollar fs-2x text-success">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="d-flex flex-column text-end">
                                <span class="text-dark fw-bold fs-2">{{ format_currency($average_purchase) }}</span>
                                <span class="text-muted fw-semibold mt-1">{{ __('customers.average_purchase') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card card-xl-stretch mb-xl-8">
                    <div class="card-body p-0">
                        <div class="d-flex flex-stack card-p flex-grow-1">
                            <div class="symbol symbol-50px symbol-circle me-2">
                                <div class="symbol-label bg-light-info">
                                    <i class="ki-duotone ki-calendar fs-2x text-info">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="d-flex flex-column text-end">
                                <span class="text-dark fw-bold fs-2">{{ format_date($last_purchase) }}</span>
                                <span class="text-muted fw-semibold mt-1">{{ __('customers.last_purchase') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase History -->
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title align-items-center">
                    <i class="ki-duotone ki-purchase fs-2 me-2 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <h3 class="fw-bold m-0">{{ __('customers.purchase_history') }}</h3>
                </div>
            </div>
            <div class="card-body">
                @if($purchases->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th>{{ __('customers.purchase_date') }}</th>
                                    <th>{{ __('customers.total_amount') }}</th>
                                    <th class="text-end">{{ __('customers.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach($purchases as $purchase)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-calendar-tick fs-2 me-2 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                {{ format_date($purchase->created_at) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-dollar fs-2 me-2 text-success">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                {{ format_currency($purchase->total_amount) }}
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('sales.show', $purchase->id) }}" 
                                               class="btn btn-sm btn-light btn-active-light-primary me-2"
                                               data-bs-toggle="tooltip"
                                               title="{{ __('customers.view_details') }}">
                                                <i class="ki-duotone ki-eye fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </a>
                                            <a href="{{ route('sales.print', $purchase->id) }}" 
                                               class="btn btn-sm btn-light btn-active-light-primary"
                                               target="_blank"
                                               data-bs-toggle="tooltip"
                                               title="{{ __('customers.print_receipt') }}">
                                                <i class="ki-duotone ki-printer fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10">
                        <i class="ki-duotone ki-basket-ok fs-4x text-muted mb-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="text-muted fw-semibold fs-5">{{ __('customers.no_purchases') }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection
