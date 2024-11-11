@extends('layouts.app')

@section('title', '- ' . __('All Products'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('All Products') }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('All Products') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control form-control-solid w-250px ps-12" placeholder="{{ __('Search by Name') }}" value="{{ request('search') }}" data-kt-ecommerce-product-filter="search"/>

                                <input type="text" name="barcode" class="form-control form-control-solid w-150px ms-3" placeholder="{{ __('Barcode') }}" value="{{ request('barcode') }}"/>

                                <input type="number" name="selling_price" class="form-control form-control-solid w-150px ms-3" placeholder="{{ __('Selling Price') }}" value="{{ request('selling_price') }}" step="0.01"/>

                                <div class="w-100 mw-150px ms-3">
                                    <select name="category" class="form-select form-select-solid" data-control="select2" data-placeholder="Category">
                                        <option value="0">{{ __('All Categories') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="w-100 mw-150px ms-3">
                                    <select name="brand" class="form-select form-select-solid" data-control="select2" data-placeholder="Brand">
                                        <option value="0">{{ __('All Brands') }}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success ms-3">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                            <thead>
                            <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">{{ __('Name') }}</th>
                                <th class="min-w-100px text-start">{{ __('Barcode') }}</th>
                                <th class="min-w-100px text-start">{{ __('Category') }}</th>
                                <th class="min-w-100px text-start">{{ __('Brand') }}</th>
                                <th class="min-w-100px text-start">{{ __('Stock') }}</th>
                                <th class="min-w-100px text-start">{{ __('Selling Price') }}</th>
                                <th class="min-w-100px text-start">{{ __('Lowest Price For Sale') }}</th>
                                <th class="min-w-100px text-start">{{ __('Device?') }}</th>
                                <th class="min-w-100px text-start">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($products as $product)
                                <tr>
                                    <td><a href="{{ route('products.show', $product->id) }}" class="text-gray-800 text-hover-primary">{{ $product->name }}</a></td>
                                    <td class="text-start">{{ $product->barcode }}</td>
                                    <td class="text-start">{{ $product->category->name ?? __('Undefined') }}</td>
                                    <td class="text-start">{{ $product->brand->name ?? __('Undefined') }}</td>
                                    <td class="text-start">
                                        @if($product->quantity <= $product->stock_alert)
                                            <span class="badge badge-light-warning">{{ __('Low Stock') }}</span>
                                            <span class="fw-bold text-warning ms-3">{{ $product->quantity }}</span>
                                        @else
                                            {{ $product->quantity }}
                                        @endif
                                    </td>
                                    <td class="text-start">{{ number_format($product->price, 2) }}</td>
                                    <td class="text-start">{{ number_format($product->min_sale_price, 2) }}</td>
                                    <td class="text-start">{{ $product->mobileDetail ? __('Yes') : __('No') }}</td>
                                    <td class="text-start">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary" type="button" id="actionDropdown{{ $product->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ki-solid ki-abstract-14"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $product->id }}">
                                                <li><a class="dropdown-item text-info" href="{{ route('products.show', $product->id) }}">Show</a></li>
                                                <li><a class="dropdown-item text-success" href="{{ route('products.edit', $product->id) }}">Edit</a></li>
                                                <li>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                    </form>
                                                </li>
                                                @if($product->mobileDetail)
                                                    <li><button class="dropdown-item text-bg-dark" type="button" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $product->id }}">Device Details</button></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                @if($product->mobileDetail)
                                    <div class="modal fade" id="detailsModal{{ $product->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailsModalLabel{{ $product->id }}">{{ __('Device Details') }} - {{ $product->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul>
                                                        <li><strong>{{ __('Color') }}:</strong> {{ $product->mobileDetail->color }}</li>
                                                        <li><strong>{{ __('Storage') }}:</strong> {{ $product->mobileDetail->storage }}</li>
                                                        <li><strong>{{ __('Battery Health') }}:</strong> {{ $product->mobileDetail->battery_health }}%</li>
                                                        <li><strong>{{ __('Ram') }}:</strong> {{ $product->mobileDetail->ram }}</li>
                                                        <li><strong>{{ __('GPU') }}:</strong> {{ $product->mobileDetail->gpu }}</li>
                                                        <li><strong>{{ __('CPU') }}:</strong> {{ $product->mobileDetail->cpu }}</li>
                                                        <li><strong>{{ __('Status') }}:</strong> {{ $product->mobileDetail->condition }}</li>
                                                        <li><strong>{{ __('Description') }}:</strong> {{ $product->mobileDetail->device_description }}</li>
                                                        <li><strong>{{ __('With Box') }}:</strong> {{ $product->mobileDetail->has_box ? __('Yes') : __('No') }}</li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">{{ __('No Products Found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
