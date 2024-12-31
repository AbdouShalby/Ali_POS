@extends('layouts.app')

@section('title', '- ' . __('sales.all_sales'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('sales.all_sales') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('sales.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('sales.all_sales') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-5">
                <form action="{{ route('sales.index') }}" method="GET" class="d-flex align-items-center w-50">
                    <input type="text" name="search" class="form-control me-3" placeholder="{{ __('sales.search_placeholder') }}" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">{{ __('sales.search') }}</button>
                </form>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> {{ __('sales.add_new_sale') }}
                </a>
            </div>

            <div class="card card-flush">
                <div class="card-header">
                    <h2>{{ __('sales.sales_list') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr>
                                <th>{{ __('sales.sale_number') }}</th>
                                <th>{{ __('sales.customer_name') }}</th>
                                <th>{{ __('sales.total_products') }}</th>
                                <th>{{ __('sales.total_amount') }}</th>
                                <th class="text-end">{{ __('sales.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($sales as $sale)
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->customer ? $sale->customer->name : __('sales.no_customer') }}</td>
                                    <td>{{ $sale->saleItems->count() }}</td>
                                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> {{ __('sales.view') }}
                                        </a>
                                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> {{ __('sales.edit') }}
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('sales.confirm_delete') }}')">
                                                <i class="bi bi-trash"></i> {{ __('sales.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('sales.no_sales_found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
