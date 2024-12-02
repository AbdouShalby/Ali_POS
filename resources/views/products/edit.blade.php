@extends('layouts.app')

@section('title', '- ' . __('products.edit_product'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('products.edit_product') }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('products.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('products.index') }}" class="text-muted text-hover-primary">{{ __('products.all_products') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('products.edit') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">
                @csrf
                @method('PUT')

                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-12">
                    <!-- Tabs -->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">{{ __('products.general') }}</a>
                        </li>
                        <li class="nav-item" id="detailsTab" style="display: {{ $product->mobileDetail ? 'block' : 'none' }};">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_details">{{ __('products.details') }}</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- General Tab -->
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tabpanel">
                            @include('products.partials.general', ['product' => $product, 'categories' => $categories, 'brands' => $brands, 'warehouses' => $warehouses])
                        </div>

                        <!-- Details Tab -->
                        <div class="tab-pane fade" id="kt_ecommerce_add_product_details" role="tabpanel">
                            @include('products.partials.details', ['mobileDetail' => $product->mobileDetail])
                        </div>
                    </div>

                    <!-- Save and Cancel Buttons -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success me-3">{{ __('products.save') }}</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">{{ __('products.cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isMobileCheckbox = document.getElementById('is_mobile');
                const detailsTab = document.getElementById('detailsTab');
                const detailsContent = document.getElementById('kt_ecommerce_add_product_details');

                isMobileCheckbox.addEventListener('change', function () {
                    const isChecked = this.checked;
                    detailsTab.style.display = isChecked ? 'block' : 'none';
                    detailsContent.style.display = isChecked ? 'block' : 'none';
                });

                if (isMobileCheckbox.checked) {
                    detailsTab.style.display = 'block';
                    detailsContent.style.display = 'block';
                } else {
                    detailsTab.style.display = 'none';
                    detailsContent.style.display = 'none';
                }
            });
        </script>
    @endsection
@endsection
