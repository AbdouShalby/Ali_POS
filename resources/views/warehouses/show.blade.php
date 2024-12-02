@extends('layouts.app')

@section('title', '- ' . __('warehouses.details'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ $warehouse->name }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('warehouses.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('warehouses.all_warehouses') }}</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $warehouse->name }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('warehouses.details') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-10">
                        <label class="form-label">{{ __('warehouses.name') }}</label>
                        <input type="text" class="form-control mb-2" value="{{ $warehouse->name }}" readonly>
                    </div>
                    <div class="mb-10">
                        <label class="form-label">{{ __('warehouses.location') }}</label>
                        <input type="text" class="form-control mb-2" value="{{ $warehouse->location }}" readonly>
                    </div>
                    <div class="mb-10">
                        <label class="form-label">{{ __('warehouses.description') }}</label>
                        <textarea class="form-control mb-2" readonly>{{ $warehouse->description }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card card-flush py-4 mt-4">
                @if($warehouse->products->isEmpty())
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('warehouses.no_products') }}</h2>
                        </div>
                    </div>
                @else
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('warehouses.products') }}</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead>
                                <tr>
                                    <th>{{ __('products.name') }}</th>
                                    <th>{{ __('products.stock') }}</th>
                                    <th>{{ __('products.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($warehouse->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->pivot->stock }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">{{ __('products.view') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('warehouses.index') }}" class="btn btn-dark">{{ __('warehouses.back') }}</a>
            </div>
        </div>
    </div>
@endsection
