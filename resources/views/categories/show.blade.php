@extends('layouts.app')

@section('title', '- ' . __('categories.details'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('categories.details') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('categories.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('categories.index') }}" class="text-muted text-hover-primary">{{ __('categories.all_categories') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $category->name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ __('categories.back_to_list') }}
                </a>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning ms-3">
                    <i class="bi bi-pencil-square"></i> {{ __('categories.edit_category') }}
                </a>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ $category->name }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text fs-5">{{ $category->description }}</p>
                </div>
            </div>

            <div class="card card-flush py-4 mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('categories.products_in_category') }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if($category->products->isEmpty())
                        <div class="alert alert-warning text-center mb-0">
                            {{ __('categories.no_products_in_category') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead>
                                <tr>
                                    <th>{{ __('products.name') }}</th>
                                    <th class="text-end">{{ __('products.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($category->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
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
