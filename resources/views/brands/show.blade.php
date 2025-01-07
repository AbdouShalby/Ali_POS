@extends('layouts.app')

@section('title', '- ' . __('brands.brand_details'))

@section('content')
    <!-- Toolbar -->
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

    <!-- Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Buttons -->
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('brands.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> {{ __('brands.back_to_list') }}
                </a>
                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning ms-3">
                    <i class="bi bi-pencil-square me-1"></i> {{ __('brands.edit_brand') }}
                </a>
            </div>

            <!-- Brand Details -->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="fs-3 fw-bold text-primary">{{ $brand->name }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if($brand->description)
                        <p class="card-text fs-5 text-gray-700">{{ $brand->description }}</p>
                    @else
                        <p class="card-text fs-5 text-gray-500 fst-italic">{{ __('brands.no_description') }}</p>
                    @endif
                </div>
            </div>

            <!-- Products in Brand -->
            <div class="card card-flush py-4 mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('brands.products_in_brand') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if($brand->products->isEmpty())
                        <div class="alert alert-warning text-center mb-0">
                            {{ __('brands.no_products_in_brand') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead>
                                <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                    <th>{{ __('products.name') }}</th>
                                    <th class="text-end">{{ __('products.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                @foreach($brand->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i> {{ __('products.view') }}
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
