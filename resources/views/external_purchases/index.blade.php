@extends('layouts.app')

@section('title', '- ' . __('All External Purchases'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('external_purchases.all_external_purchases') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('external_purchases.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('external_purchases.all_external_purchases') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                        <i class="bi bi-check-circle-fill fs-2"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <h2 class="card-title">{{ __('external_purchases.external_purchase_list') }}</h2>
                    <div class="card-toolbar">
                        <form action="{{ route('external_purchases.index') }}" method="GET" class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('external_purchases.search_by_invoice') }}" value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary d-flex align-items-center">
                                    <i class="bi bi-search me-2"></i> {{ __('external_purchases.search') }}
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('external_purchases.create') }}" class="btn btn-primary ms-3">
                            <i class="bi bi-plus-circle"></i> {{ __('external_purchases.add_new_purchase') }}
                        </a>
                    </div>
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th>{{ __('external_purchases.invoice_number') }}</th>
                                <th>{{ __('external_purchases.description') }}</th>
                                <th>{{ __('external_purchases.amount') }}</th>
                                <th>{{ __('external_purchases.purchase_date') }}</th>
                                <th class="text-center">{{ __('external_purchases.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($externalPurchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->invoice_number }}</td>
                                    <td>{{ $purchase->description }}</td>
                                    <td>{{ number_format($purchase->amount, 2) }} {{ __('external_purchases.currency') }}</td>
                                    <td>{{ $purchase->purchase_date }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('external_purchases.show', $purchase->id) }}" class="btn btn-sm btn-info mx-1">
                                            <i class="bi bi-eye"></i> {{ __('external_purchases.view') }}
                                        </a>
                                        <a href="{{ route('external_purchases.edit', $purchase->id) }}" class="btn btn-sm btn-warning mx-1">
                                            <i class="bi bi-pencil"></i> {{ __('external_purchases.edit') }}
                                        </a>
                                        <form action="{{ route('external_purchases.destroy', $purchase->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger mx-1" onclick="return confirm('{{ __('external_purchases.confirm_delete') }}')">
                                                <i class="bi bi-trash"></i> {{ __('external_purchases.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('external_purchases.no_purchases_found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $externalPurchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
