@extends('layouts.app')

@section('title', '- ' . __('suppliers.supplier_details'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('suppliers.supplier_details') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('suppliers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('suppliers.index') }}" class="text-muted text-hover-primary">{{ __('suppliers.all_suppliers') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $supplier->name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary me-3">
                        <i class="bi bi-arrow-left"></i> {{ __('suppliers.back_to_list') }}
                    </a>
                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> {{ __('suppliers.edit_supplier') }}
                    </a>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ $supplier->name }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-envelope-fill text-primary me-3 fs-4"></i>
                                <span><strong>{{ __('suppliers.email') }}:</strong> {{ $supplier->email ?? __('suppliers.not_available') }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-telephone-fill text-success me-3 fs-4"></i>
                                <span><strong>{{ __('suppliers.phone') }}:</strong> {{ $supplier->phone ?? __('suppliers.not_available') }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-geo-alt-fill text-danger me-3 fs-4"></i>
                                <span><strong>{{ __('suppliers.address') }}:</strong> {{ $supplier->address ?? __('suppliers.not_available') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-card-text text-warning me-3 fs-4"></i>
                                <span><strong>{{ __('suppliers.notes') }}:</strong> {{ $supplier->notes ?? __('suppliers.not_available') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('suppliers.supplier_products') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('suppliers.show', $supplier->id) }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('suppliers.search_by_name') }}" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">{{ __('suppliers.filter') }}</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                            <tr>
                                <th>{{ __('products.name') }}</th>
                                <th>{{ __('products.quantity') }}</th>
                                <th>{{ __('products.price') }}</th>
                                <th>{{ __('products.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $item)
                                <tr>
                                    <td>{{ optional($item->product)->name ?? __('products.undefined') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 2) }}</td>
                                    <td>
                                        @if(optional($item->product)->id)
                                            <a href="{{ route('products.show', $item->product->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> {{ __('products.view') }}
                                            </a>
                                        @else
                                            <span class="text-muted">{{ __('products.undefined') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('suppliers.debts') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if($debts->isEmpty())
                        <p class="text-center">{{ __('suppliers.no_debts_found') }}</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead>
                                <tr>
                                    <th>{{ __('suppliers.product') }}</th>
                                    <th>{{ __('suppliers.amount') }}</th>
                                    <th>{{ __('suppliers.paid') }}</th>
                                    <th>{{ __('suppliers.remaining') }}</th>
                                    <th>{{ __('suppliers.date') }}</th>
                                    <th>{{ __('suppliers.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($debts as $debt)
                                    <tr>
                                        <td>{{ optional($debt->product)->name ?? __('suppliers.product_not_available') }}</td>
                                        <td>{{ number_format($debt->amount, 2) }}</td>
                                        <td>{{ number_format($debt->paid, 2) }}</td>
                                        <td>{{ number_format($debt->remaining, 2) }}</td>
                                        <td>{{ $debt->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('debt.payments', $debt->id) }}" class="btn btn-primary btn-sm">
                                                {{ __('Record Payment') }}
                                            </a>

                                            @if($debt->payments()->exists())
                                                <a href="{{ route('debt.paymentHistory', $debt->id) }}" class="btn btn-info btn-sm">
                                                    {{ __('View Payment History') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $debts->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
