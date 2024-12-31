@extends('layouts.app')

@section('title', '- ' . __('brands.brand_details'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('brands.brand_details') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('brands.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('brands.index') }}" class="text-muted text-hover-primary">{{ __('brands.all_brands') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $brand->name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="d-flex justify-content-end">
                <a href="{{ route('brands.index') }}" class="btn btn-secondary me-5">{{ __('brands.back_to_list') }}</a>
                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning me-5">{{ __('brands.edit_brand') }}</a>
            </div>
            <div class="card mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ $brand->name }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $brand->description }}</p>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('brands.products_in_brand') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if($brand->products->isEmpty())
                        <div class="alert alert-warning text-center">{{ __('brands.no_products_in_brand') }}</div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead>
                                <tr>
                                    <th>{{ __('products.name') }}</th>
                                    <th>{{ __('products.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($brand->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
                                                {{ __('products.view') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
