@extends('layouts.app')

@section('title', '- ' . __('products.create_product'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('products.create_product') }}</h1>
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
                    <li class="breadcrumb-item text-muted">{{ __('products.create') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">
                @csrf
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-12">
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
                        <div id="formErrorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <span id="formErrorMessage">Please correct the errors before submitting</span>
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- بداية القسم العام -->
                    <div class="card card-flush py-4">
                        <div class="card-header mb-5">
                            <div class="card-title">
                                <h2>{{ __('products.general') }}</h2>
                            </div>
                            <div class="card-title">
                                <h2 class="me-5">{{ __('products.is_device') }}</h2>
                                <input type="checkbox" class="form-check-input me-2" id="is_mobile" name="is_mobile" {{ old('is_mobile') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_mobile">{{ __('products.yes') }}</label>
                            </div>
                        </div>
                        <div class="card-body row pt-0">
                            <div class="mb-10 col-md-5">
                                <label class="form-label">{{ __('products.name') }}
                                    <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('products.name_help_text') ?? 'Enter a descriptive product name that customers can easily understand.' }}"></i>
                                </label>
                                <input type="text" class="form-control mb-2" id="name" name="name" value="{{ old('name') }}" required>
                                <div id="nameHelp" class="form-text text-muted">{{ __('products.product_name_example') ?? 'Example: iPhone 13 Pro 128GB Graphite' }}</div>
                            </div>
                            <div class="mb-10 col-md-7">
                                <label class="form-label">{{ __('products.barcode') }}
                                    <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('products.barcode_help_text') ?? 'Enter a unique product barcode or generate one automatically. This will be used for scanning and identifying the product.' }}"></i>
                                </label>
                                <div class="input-group d-flex align-items-center">
                                    <input type="text" class="form-control mb-2" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" id="barcode" name="barcode" value="{{ old('barcode') }}" onblur="checkBarcode()" required>
                                    <button type="button" class="btn btn-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: -1px; margin-top: -7px;" id="generateBarcode">
                                        <i class="fas fa-barcode me-1"></i> {{ __('products.generate') }}
                                    </button>
                                    <button type="button" class="btn btn-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: -1px; margin-top: -7px;" id="printBarcode">
                                        <i class="fas fa-print me-1"></i> {{ __('products.print') }}
                                    </button>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <small id="barcode-feedback" class="text-danger d-none">{{ __('products.This barcode already exists!') }}</small>
                                    <small id="barcode-format-feedback" class="text-danger d-none ms-2">{{ __('products.invalid_barcode_format') }}</small>
                                    <small id="barcode-valid-feedback" class="text-success d-none">{{ __('products.valid_barcode') }}</small>
                                </div>
                            </div>
                            <div class="card py-10 mb-10">
                                <div class="card-header">
                                    <h4>{{ __('products.assign_stock_to_warehouses') }}</h4>
                                </div>
                                <div class="card-body" id="warehouse-container">
                                    @if(old('warehouses'))
                                        @foreach(old('warehouses') as $index => $warehouse)
                                            <div class="input-group mb-2 warehouse-entry">
                                                <select class="form-select" name="warehouses[{{ $index }}][id]" required>
                                                    <option value="">{{ __('products.select_warehouse') }}</option>
                                                    @foreach($warehouses as $warehouseOption)
                                                        <option value="{{ $warehouseOption->id }}" {{ $warehouse['id'] == $warehouseOption->id ? 'selected' : '' }}>
                                                            {{ $warehouseOption->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="number" class="form-control" name="warehouses[{{ $index }}][stock]" value="{{ $warehouse['stock'] }}" placeholder="{{ __('products.stock') }}" required>
                                                <input type="number" class="form-control" name="warehouses[{{ $index }}][stock_alert]" value="{{ $warehouse['stock_alert'] }}" placeholder="{{ __('products.stock_alert') }}" required>
                                                <button type="button" class="btn btn-danger remove-warehouse">{{ __('products.remove') }}</button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2 warehouse-entry">
                                            <select class="form-select" name="warehouses[0][id]" required>
                                                <option value="">{{ __('products.select_warehouse') }}</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="number" class="form-control" name="warehouses[0][stock]" placeholder="{{ __('products.stock') }}" required>
                                            <input type="number" class="form-control" name="warehouses[0][stock_alert]" placeholder="{{ __('products.stock_alert') }}" required>
                                            <button type="button" class="btn btn-danger remove-warehouse">{{ __('products.remove') }}</button>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" id="add-warehouse" class="btn btn-primary">{{ __('products.add_warehouse') }}</button>
                            </div>
                            <div class="mb-10 col-md-3">
                                <label class="form-label">{{ __('products.cost') }}
                                    <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('products.cost_help_text') ?? 'The purchase cost of the product (what you paid for it).' }}"></i>
                                </label>
                                <input type="number" class="form-control mb-2" id="cost" name="cost" step="0.01" min="0" value="{{ old('cost', 0) }}" required>
                            </div>
                            <div class="mb-10 col-md-3">
                                <label class="form-label">{{ __('products.price') }}
                                    <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('products.price_help_text') ?? 'The selling price of the product (what customers will pay).' }}"></i>
                                </label>
                                <input type="number" class="form-control mb-2" id="price" name="price" step="0.01" min="0" value="{{ old('price', 0) }}" required>
                                <div id="price-feedback" class="form-text text-danger d-none">{{ __('products.price_cost_warning') }}</div>
                            </div>
                            <div class="mb-10 col-md-3">
                                <label class="form-label">{{ __('products.wholesale_price') }}</label>
                                <input type="number" class="form-control mb-2" id="wholesale_price" name="wholesale_price" step="0.01" value="{{ old('wholesale_price', 0) }}" required>
                            </div>
                            <div class="mb-10 col-md-3">
                                <label class="form-label">{{ __('products.lowest_price_for_sale') }}</label>
                                <input type="number" class="form-control mb-2" id="min_sale_price" name="min_sale_price" step="0.01" value="{{ old('min_sale_price', 0) }}" required>
                            </div>
                            <div class="mb-10 col-md-12">
                                <label class="form-label">{{ __('products.description') }}</label>
                                <textarea class="form-control mb-2 min-h-100px" id="description" name="description">{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-10 col-md-4">
                                <label class="form-label">{{ __('products.image') }}
                                    <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('products.image_help_text') ?? 'Upload a clear image of the product. Recommended size: 500x500 pixels.' }}"></i>
                                </label>
                                <input type="file" class="form-control mb-2" id="image" name="image" accept="image/*">
                                <div class="image-preview mt-2 d-none" id="imagePreviewContainer">
                                    <img id="imagePreview" src="#" alt="Product Image Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                    <button type="button" class="btn btn-sm btn-danger mt-1" id="removeImagePreview">
                                        <i class="fas fa-times"></i> {{ __('products.remove') }}
                                    </button>
                                </div>
                            </div>
                            <div class="mb-10 col-md-4">
                                <label class="form-label">{{ __('products.category') }}</label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select me-2" id="category_id" name="category_id" required>
                                        <option value="">{{ __('products.choose_category') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                        {{ __('products.add') }}
                                    </button>
                                </div>
                            </div>

                            <div class="mb-10 col-md-4">
                                <label class="form-label">{{ __('products.brand') }}</label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select me-2" id="brand_id" name="brand_id" required>
                                        <option value="">{{ __('products.choose_brand') }}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                                        {{ __('products.add') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- نهاية القسم العام -->

                    <!-- بداية قسم تفاصيل الجهاز -->
                    <div id="device_details_section" style="display: {{ old('is_mobile') ? 'block' : 'none' }};">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('products.device_details') }}</h2>
                                </div>
                            </div>
                            <div class="card-body row pt-0">
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.color') }}</label>
                                    <input type="text" class="form-control mb-2" id="color" name="color" value="{{ old('color') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.storage') }}</label>
                                    <input type="text" class="form-control mb-2" id="storage" name="storage" value="{{ old('storage') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.battery_health') }}</label>
                                    <input type="number" class="form-control mb-2" id="battery_health" name="battery_health" min="0" max="100" value="{{ old('battery_health', 0) }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.ram') }}</label>
                                    <input type="text" class="form-control mb-2" id="ram" name="ram" value="{{ old('ram') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.condition') }}</label>
                                    <input type="text" class="form-control mb-2" id="condition" name="condition" value="{{ old('condition') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.with_box') }}</label>
                                    <select class="form-select mb-2" id="has_box" name="has_box">
                                        <option value="">{{ __('products.choose') }}</option>
                                        <option value="1" {{ old('has_box') == '1' ? 'selected' : '' }}>{{ __('products.yes') }}</option>
                                        <option value="0" {{ old('has_box') == '0' || old('has_box') === null ? 'selected' : '' }}>{{ __('products.no') }}</option>
                                    </select>
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.cpu') }}</label>
                                    <input type="text" class="form-control mb-2" id="cpu" name="cpu" value="{{ old('cpu') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.gpu') }}</label>
                                    <input type="text" class="form-control mb-2" id="gpu" name="gpu" value="{{ old('gpu') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.imei') }}</label>
                                    <input type="text" class="form-control mb-2" id="imei" name="imei" value="{{ old('imei') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.scan_id') }}
                                        <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('products.scan_id_help_text') ?? 'Upload a scanned copy of ID or proof of ownership.' }}"></i>
                                    </label>
                                    <input type="file" class="form-control" id="scan_id" name="scan_id" accept="image/*">
                                    <div class="image-preview mt-2 d-none" id="scanIdPreviewContainer">
                                        <img id="scanIdPreview" src="#" alt="ID Scan Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                        <button type="button" class="btn btn-sm btn-danger mt-1" id="removeScanIdPreview">
                                            <i class="fas fa-times"></i> {{ __('products.remove') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.scan_documents') }}
                                        <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('products.scan_documents_help_text') ?? 'Upload scanned documents related to the product.' }}"></i>
                                    </label>
                                    <input type="file" class="form-control" id="scan_documents" name="scan_documents" accept="image/*">
                                    <div class="image-preview mt-2 d-none" id="scanDocumentsPreviewContainer">
                                        <img id="scanDocumentsPreview" src="#" alt="Documents Scan Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                        <button type="button" class="btn btn-sm btn-danger mt-1" id="removeScanDocumentsPreview">
                                            <i class="fas fa-times"></i> {{ __('products.remove') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.payment_method') }}</label>
                                    <select class="form-select" id="payment_method" name="payment_method">
                                        <option value="">{{ __('products.choose_payment_method') }}</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>{{ __('products.cash') }}</option>
                                        <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>{{ __('products.credit') }}</option>
                                    </select>
                                </div>
                                <div class="mb-10 col-md-4" id="initial_payment_section" style="display: {{ old('payment_method') == 'credit' ? 'block' : 'none' }};">
                                    <label class="form-label">{{ __('products.initial_payment_amount') }}
                                        <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('products.initial_payment_help_text') }}"></i>
                                    </label>
                                    <input type="number" class="form-control mb-2" id="initial_payment" name="initial_payment" step="0.01" min="0" value="{{ old('initial_payment', 0) }}">
                                    <div class="form-text">{{ __('products.initial_payment_notice') }}</div>
                                </div>
                                <div class="mb-10 col-md-12">
                                    <label class="form-label">{{ __('products.device_description') }}</label>
                                    <textarea class="form-control mb-2 min-h-100px" id="device_description" name="device_description">{{ old('device_description') }}</textarea>
                                </div>
                                <div class="mb-10 col-md-4">
                                    <label class="form-label">{{ __('products.seller_name') }}</label>
                                    <input type="text" class="form-control" id="seller_name" name="seller_name" value="{{ Auth::user()->name }}" readonly>
                                </div>
                                <div class="mb-10 col-md-4">
                                    <label class="form-label">{{ __('products.client_type') }}</label>
                                    <select class="form-select" id="client_type" name="client_type" onchange="toggleClientSections(this.value)">
                                        <option value="">{{ __('products.choose_client_type') }}</option>
                                        <option value="customer" {{ old('client_type') == 'customer' ? 'selected' : '' }}>{{ __('products.customer') }}</option>
                                        <option value="supplier" {{ old('client_type') == 'supplier' ? 'selected' : '' }}>{{ __('products.supplier') }}</option>
                                    </select>
                                </div>
                                <div class="mb-10 col-md-4" id="customer_section" style="display: {{ old('client_type') == 'customer' ? 'block' : 'none' }};">
                                    <label class="form-label">{{ __('products.select_customer') }}</label>
                                    <div class="d-flex align-items-center">
                                        <select class="form-select me-2" id="customer_id" name="customer_id">
                                            <option value="">{{ __('products.choose_customer') }}</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                            {{ __('products.add') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-10 col-md-4" id="supplier_section" style="display: {{ old('client_type') == 'supplier' ? 'block' : 'none' }};">
                                    <label class="form-label">{{ __('products.select_supplier') }}</label>
                                    <div class="d-flex align-items-center">
                                        <select class="form-select me-2" id="supplier_id" name="supplier_id">
                                            <option value="">{{ __('products.choose_supplier') }}</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                                            {{ __('products.add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- نهاية قسم تفاصيل الجهاز -->

                    <!-- زر الحفظ -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#duplicateProductModal">
                            <i class="fas fa-copy me-1"></i> {{ __('products.duplicate_existing_product') ?? 'Duplicate Existing Product' }}
                        </button>
                        <button type="submit" id="submit-form" class="btn btn-primary">
                            <span class="indicator-label">
                                <i class="fas fa-save me-1"></i> {{ __('products.save') }}
                            </span>
                            <span class="indicator-progress">
                                {{ __('products.please_wait') ?? 'Please wait...' }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">{{ __('products.add_new_category') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="category_name" class="form-label">{{ __('products.category_name') }}</label>
                            <input type="text" class="form-control" id="category_name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('products.add') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">{{ __('products.add_new_brand') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBrandForm">
                        @csrf
                        <div class="mb-3">
                            <label for="brand_name" class="form-label">{{ __('products.brand_name') }}</label>
                            <input type="text" class="form-control" id="brand_name" name="name" required>
                            <small id="brand-error" class="text-danger d-none">{{ __('products.brand_already_exists') }}</small>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('products.add') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="printOptionsModal" tabindex="-1" aria-labelledby="printOptionsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printOptionsLabel">{{ __('products.print_options') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="paperSize">{{ __('products.select_labels_per_sheet') }}</label>
                        <select class="form-select" id="paperSize" required>
                            <option value="40">{{ __('products.40_per_sheet') }}</option>
                            <option value="30">{{ __('products.30_per_sheet') }}</option>
                            <option value="24">{{ __('products.24_per_sheet') }}</option>
                            <option value="20">{{ __('products.20_per_sheet') }}</option>
                            <option value="18">{{ __('products.18_per_sheet') }}</option>
                            <option value="14">{{ __('products.14_per_sheet') }}</option>
                            <option value="12">{{ __('products.12_per_sheet') }}</option>
                            <option value="10">{{ __('products.10_per_sheet') }}</option>
                            <option value="custom">{{ __('products.custom') }}</option>
                        </select>
                    </div>
                    <div class="form-group" id="customLabelCountContainer" style="display: none;">
                        <label for="customLabelCount">{{ __('products.enter_custom_number_of_labels_per_page_(1-40):') }}</label>
                        <input type="number" id="customLabelCount" min="1" max="40" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="labelContent" class="form-label">{{ __('products.label_content') }}</label>
                        <input type="text" class="form-control" id="labelContent" placeholder="{{ __('products.enter_content_to_appear_on_the_label') }}" value="{{ __('products.product_name_price_and_barcode') }}" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="confirmPrint">{{ __('products.print') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="addCustomerModalLabel">{{ __('products.add_new_customer') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="customer_name" class="form-label fw-bold">{{ __('products.customer_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="customer_name" name="name" required>
                            <div class="invalid-feedback" id="customer-name-error"></div>
                            <div class="form-text">{{ __('products.required_field') }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">{{ __('products.customer_phone') }}</label>
                            <input type="text" class="form-control form-control-solid" id="customer_phone" name="phone">
                            <div class="invalid-feedback" id="customer-phone-error"></div>
                            <div class="form-text">{{ __('products.optional_field') }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">{{ __('products.customer_email') }}</label>
                            <input type="email" class="form-control form-control-solid" id="customer_email" name="email">
                            <div class="invalid-feedback" id="customer-email-error"></div>
                            <div class="form-text">{{ __('products.optional_field') }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">{{ __('products.customer_address') }}</label>
                            <input type="text" class="form-control form-control-solid" id="customer_address" name="address">
                            <div class="invalid-feedback" id="customer-address-error"></div>
                            <div class="form-text">{{ __('products.optional_field') }}</div>
                        </div>
                        <div id="customer-form-errors" class="alert alert-danger mt-3 d-none">
                            <ul class="mb-0" id="customer-errors-list"></ul>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                            <button type="button" id="saveCustomer" class="btn btn-primary">
                                <span class="indicator-label">{{ __('products.save') }}</span>
                                <span class="indicator-progress d-none">
                                    {{ __('products.please_wait') }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="addSupplierModalLabel">{{ __('products.add_new_supplier') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        @csrf
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label fw-bold">{{ __('products.supplier_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="supplier_name" name="name" required>
                            <div class="invalid-feedback" id="supplier-name-error"></div>
                            <div class="form-text">{{ __('products.required_field') }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_phone" class="form-label">{{ __('products.supplier_phone') }}</label>
                            <input type="text" class="form-control form-control-solid" id="supplier_phone" name="phone">
                            <div class="invalid-feedback" id="supplier-phone-error"></div>
                            <div class="form-text">{{ __('products.optional_field') }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_email" class="form-label">{{ __('products.supplier_email') }}</label>
                            <input type="email" class="form-control form-control-solid" id="supplier_email" name="email">
                            <div class="invalid-feedback" id="supplier-email-error"></div>
                            <div class="form-text">{{ __('products.optional_field') }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_address" class="form-label">{{ __('products.supplier_address') }}</label>
                            <input type="text" class="form-control form-control-solid" id="supplier_address" name="address">
                            <div class="invalid-feedback" id="supplier-address-error"></div>
                            <div class="form-text">{{ __('products.optional_field') }}</div>
                        </div>
                        <div id="supplier-form-errors" class="alert alert-danger mt-3 d-none">
                            <ul class="mb-0" id="supplier-errors-list"></ul>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                            <button type="button" class="btn btn-primary" id="saveSupplier">
                                <span class="indicator-label">{{ __('products.save') }}</span>
                                <span class="indicator-progress d-none">
                                    {{ __('products.please_wait') }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="duplicateProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('products.duplicate_product') ?? 'Duplicate Product' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('products.search_product') ?? 'Search Product' }}</label>
                        <input type="text" class="form-control" id="productSearch" placeholder="{{ __('products.search_by_name_barcode') ?? 'Search by name or barcode' }}">
                    </div>
                    <div id="productSearchResults" class="list-group">
                        <!-- Search results will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            // Make sure jQuery is available
            if (typeof jQuery === 'undefined') {
                console.error('jQuery is required but not loaded. Please include jQuery in your page.');
                document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
            }
            
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
            @endforeach
            @endif

            document.getElementById('is_mobile').addEventListener('change', function() {
                var detailsTab = document.getElementById('detailsTab');
                detailsTab.style.display = this.checked ? 'block' : 'none';
            });

            document.addEventListener('DOMContentLoaded', function () {
                const warehouseContainer = document.getElementById('warehouse-container');
                const addWarehouseButton = document.getElementById('add-warehouse');
                let warehouseIndex = 1;

                function updateWarehouseOptions() {
                    const selectedWarehouses = Array.from(document.querySelectorAll('select[name^="warehouses"]')).map(select => select.value);
                    const allSelects = document.querySelectorAll('select[name^="warehouses"]');

                    allSelects.forEach((select) => {
                        const currentValue = select.value;
                        select.innerHTML = `
                            <option value="">{{ __('Select Warehouse') }}</option>
                        `;

                        @foreach($warehouses as $warehouse)
                        if (!selectedWarehouses.includes("{{ $warehouse->id }}") || currentValue === "{{ $warehouse->id }}") {
                            select.innerHTML += `<option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>`;
                        }
                        @endforeach

                        select.value = currentValue;
                    });
                }

                addWarehouseButton.addEventListener('click', function () {
                    const newWarehouseEntry = document.createElement('div');
                    newWarehouseEntry.classList.add('input-group', 'mb-2', 'warehouse-entry');
                    newWarehouseEntry.innerHTML = `
                        <select class="form-select" name="warehouses[${warehouseIndex}][id]" required>
                            <option value="">{{ __('Select Warehouse') }}</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                                </select>
                                <input type="number" class="form-control" name="warehouses[${warehouseIndex}][stock]" placeholder="{{ __('Stock') }}" required>
                        <input type="number" class="form-control" name="warehouses[${warehouseIndex}][stock_alert]" placeholder="{{ __('Stock Alert') }}" required>
                        <button type="button" class="btn btn-danger remove-warehouse">{{ __('Remove') }}</button>
                    `;
                    warehouseContainer.appendChild(newWarehouseEntry);

                    warehouseIndex++;
                    updateWarehouseOptions();
                });

                warehouseContainer.addEventListener('change', function (e) {
                    if (e.target.tagName === 'SELECT') {
                        updateWarehouseOptions();
                    }
                });

                warehouseContainer.addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-warehouse')) {
                        e.target.closest('.warehouse-entry').remove();
                        updateWarehouseOptions();
                    }
                });

                updateWarehouseOptions();
            });

            document.getElementById('client_type').addEventListener('change', function () {
                const customerSection = document.getElementById('customer_section');
                const supplierSection = document.getElementById('supplier_section');

                if (this.value === 'customer') {
                    customerSection.style.display = 'block';
                    supplierSection.style.display = 'none';
                } else if (this.value === 'supplier') {
                    customerSection.style.display = 'none';
                    supplierSection.style.display = 'block';
                } else {
                    customerSection.style.display = 'none';
                    supplierSection.style.display = 'none';
                }
            });

            document.getElementById('payment_method').addEventListener('change', function () {
                const clientTypeSelect = document.getElementById('client_type');
                const customerSection = document.getElementById('customer_section');
                const supplierSection = document.getElementById('supplier_section');
                const initialPaymentSection = document.getElementById('initial_payment_section');

                if (this.value === 'credit') {
                    clientTypeSelect.value = 'supplier';
                    clientTypeSelect.setAttribute('disabled', true);
                    customerSection.style.display = 'none';
                    supplierSection.style.display = 'block';
                    initialPaymentSection.style.display = 'block';
                } else {
                    clientTypeSelect.value = '';
                    clientTypeSelect.removeAttribute('disabled');
                    customerSection.style.display = 'none';
                    supplierSection.style.display = 'none';
                    initialPaymentSection.style.display = 'none';
                }
            });

            document.getElementById('saveCustomer').addEventListener('click', function () {
                const form = document.getElementById('addCustomerForm');
                const formData = new FormData(form);
                const submitButton = this;
                const customerFormErrors = document.getElementById('customer-form-errors');
                const customerErrorsList = document.getElementById('customer-errors-list');
                
                // Reset any previous errors
                customerFormErrors.classList.add('d-none');
                customerErrorsList.innerHTML = '';
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                
                // تحقق من البيانات المدخلة
                let isValid = true;
                
                const nameInput = document.getElementById('customer_name');
                if (!nameInput.value.trim()) {
                    nameInput.classList.add('is-invalid');
                    document.getElementById('customer-name-error').textContent = '{{ __("products.name_required") }}';
                    isValid = false;
                }
                
                // الهاتف غير مطلوب الآن
                const phoneInput = document.getElementById('customer_phone');
                
                // التحقق من صحة تنسيق البريد الإلكتروني إذا تم إدخاله
                const emailInput = document.getElementById('customer_email');
                if (emailInput.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
                    emailInput.classList.add('is-invalid');
                    document.getElementById('customer-email-error').textContent = '{{ __("products.email_invalid") }}';
                    isValid = false;
                }
                
                if (!isValid) return;
                
                // إظهار مؤشر التحميل
                submitButton.querySelector('.indicator-label').classList.add('d-none');
                submitButton.querySelector('.indicator-progress').classList.remove('d-none');
                submitButton.disabled = true;

                // Make AJAX request with jQuery instead of fetch
                $.ajax({
                    url: '{{ route('customers.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    success: function(data) {
                        if (data.success) {
                            const customerSelect = document.getElementById('customer_id');
                            const newOption = document.createElement('option');
                            newOption.value = data.customer.id;
                            newOption.textContent = data.customer.name;
                            newOption.selected = true;
                            customerSelect.appendChild(newOption);

                            // تحديث نوع العميل واظهار قسم العميل
                            const clientTypeSelect = document.getElementById('client_type');
                            clientTypeSelect.value = 'customer';
                            toggleClientSections('customer');

                            // إخفاء النافذة المنبثقة
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addCustomerModal'));
                            modal.hide();

                            // إعادة تعيين النموذج
                            form.reset();
                            
                            // إظهار إشعار نجاح بتنسيق محسن
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                positionClass: "toast-top-right",
                                timeOut: 3000
                            };
                            toastr.success(data.message || '{{ __("products.customer_added_successfully") }}');
                            
                            // تمييز اختيار العميل بتأثير بصري
                            customerSelect.classList.add('border-success');
                            setTimeout(() => {
                                customerSelect.classList.remove('border-success');
                            }, 2000);
                        } else {
                            toastr.error(data.message || '{{ __("products.error_saving_customer") }}');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('{{ __("products.error") }}:', error);
                        
                        // محاولة تحليل الرد كـ JSON
                        try {
                            const response = JSON.parse(xhr.responseText);
                            
                            if (response.errors) {
                                // التعامل مع أخطاء التحقق
                                customerFormErrors.classList.remove('d-none');
                                customerErrorsList.innerHTML = '';
                                
                                Object.keys(response.errors).forEach(field => {
                                    response.errors[field].forEach(message => {
                                        const li = document.createElement('li');
                                        li.textContent = message;
                                        customerErrorsList.appendChild(li);
                                    });
                                    
                                    const fieldInput = document.getElementById('customer_' + field);
                                    if (fieldInput) {
                                        fieldInput.classList.add('is-invalid');
                                        document.getElementById('customer-' + field + '-error').textContent = response.errors[field][0];
                                    }
                                });
                            } else if (response.message) {
                                toastr.error(response.message);
                            } else {
                                toastr.error('{{ __("products.something_went_wrong") }}');
                            }
                        } catch (e) {
                            // إذا لم يكن الرد JSON صالحًا، عرض خطأ عام
                            toastr.error('{{ __("products.server_error") }}');
                        }
                    },
                    complete: function() {
                        // إعادة تعيين حالة الزر
                        submitButton.querySelector('.indicator-label').classList.remove('d-none');
                        submitButton.querySelector('.indicator-progress').classList.add('d-none');
                        submitButton.disabled = false;
                    }
                });
            });

            document.getElementById('saveSupplier').addEventListener('click', function () {
                const form = document.getElementById('addSupplierForm');
                const formData = new FormData(form);
                const submitButton = this;
                const supplierFormErrors = document.getElementById('supplier-form-errors');
                const supplierErrorsList = document.getElementById('supplier-errors-list');
                
                // Reset any previous errors
                supplierFormErrors.classList.add('d-none');
                supplierErrorsList.innerHTML = '';
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                
                // التحقق من بيانات المورد المدخلة
                let isValid = true;
                
                const nameInput = document.getElementById('supplier_name');
                if (!nameInput.value.trim()) {
                    nameInput.classList.add('is-invalid');
                    document.getElementById('supplier-name-error').textContent = '{{ __("products.name_required") }}';
                    isValid = false;
                }
                
                // التحقق من صحة تنسيق البريد الإلكتروني إذا تم إدخاله
                const emailInput = document.getElementById('supplier_email');
                if (emailInput.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
                    emailInput.classList.add('is-invalid');
                    document.getElementById('supplier-email-error').textContent = '{{ __("products.email_invalid") }}';
                    isValid = false;
                }
                
                if (!isValid) return;
                
                // إظهار مؤشر التحميل
                submitButton.querySelector('.indicator-label').classList.add('d-none');
                submitButton.querySelector('.indicator-progress').classList.remove('d-none');
                submitButton.disabled = true;

                // Make AJAX request with jQuery instead of fetch
                $.ajax({
                    url: '{{ route('suppliers.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    success: function(data) {
                        if (data.success) {
                            const supplierSelect = document.getElementById('supplier_id');
                            const newOption = document.createElement('option');
                            newOption.value = data.supplier.id;
                            newOption.textContent = data.supplier.name;
                            newOption.selected = true;
                            supplierSelect.appendChild(newOption);

                            // تحديث نوع المورد واظهار قسم المورد
                            const clientTypeSelect = document.getElementById('client_type');
                            clientTypeSelect.value = 'supplier';
                            toggleClientSections('supplier');

                            // إخفاء النافذة المنبثقة
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addSupplierModal'));
                            modal.hide();

                            // إعادة تعيين النموذج
                            form.reset();
                            
                            // إظهار إشعار نجاح بتنسيق محسن
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                positionClass: "toast-top-right",
                                timeOut: 3000
                            };
                            toastr.success(data.message || '{{ __("products.supplier_added_successfully") }}');
                            
                            // تمييز اختيار المورد بتأثير بصري
                            supplierSelect.classList.add('border-success');
                            setTimeout(() => {
                                supplierSelect.classList.remove('border-success');
                            }, 2000);
                        } else {
                            toastr.error(data.message || '{{ __("products.error_saving_supplier") }}');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('{{ __("products.error") }}:', error);
                        
                        // محاولة تحليل الرد كـ JSON
                        try {
                            const response = JSON.parse(xhr.responseText);
                            
                            if (response.errors) {
                                // التعامل مع أخطاء التحقق
                                supplierFormErrors.classList.remove('d-none');
                                supplierErrorsList.innerHTML = '';
                                
                                Object.keys(response.errors).forEach(field => {
                                    response.errors[field].forEach(message => {
                                        const li = document.createElement('li');
                                        li.textContent = message;
                                        supplierErrorsList.appendChild(li);
                                    });
                                    
                                    const fieldInput = document.getElementById('supplier_' + field);
                                    if (fieldInput) {
                                        fieldInput.classList.add('is-invalid');
                                        document.getElementById('supplier-' + field + '-error').textContent = response.errors[field][0];
                                    }
                                });
                            } else if (response.message) {
                                toastr.error(response.message);
                            } else {
                                toastr.error('{{ __("products.something_went_wrong") }}');
                            }
                        } catch (e) {
                            // إذا لم يكن الرد JSON صالحًا، عرض خطأ عام
                            toastr.error('{{ __("products.server_error") }}');
                        }
                    },
                    complete: function() {
                        // إعادة تعيين حالة الزر
                        submitButton.querySelector('.indicator-label').classList.remove('d-none');
                        submitButton.querySelector('.indicator-progress').classList.add('d-none');
                        submitButton.disabled = false;
                    }
                });
            });

            document.getElementById('addBrandForm').addEventListener('submit', function (event) {
                event.preventDefault();

                const form = document.getElementById('addBrandForm');
                const formData = new FormData(form);

                fetch('{{ route('brands.store') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json', // تأكيد أن الرد سيكون JSON
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw err });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const brandSelect = document.getElementById('brand_id');
                            const newOption = document.createElement('option');
                            newOption.value = data.brand.id;
                            newOption.textContent = data.brand.name;
                            newOption.selected = true;
                            brandSelect.appendChild(newOption);

                            const modal = bootstrap.Modal.getInstance(document.getElementById('addBrandModal'));
                            modal.hide();

                            form.reset();
                        } else {
                            alert(data.message || 'Error saving brand.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'Something went wrong. Please try again.');
                    });
            });

            document.getElementById('addCategoryForm').addEventListener('submit', function (event) {
                event.preventDefault();

                const form = document.getElementById('addCategoryForm');
                const formData = new FormData(form);

                fetch('{{ route('categories.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData,
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw err });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const categorySelect = document.getElementById('category_id');
                            const newOption = document.createElement('option');
                            newOption.value = data.category.id;
                            newOption.textContent = data.category.name;
                            newOption.selected = true;
                            categorySelect.appendChild(newOption);

                            const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                            modal.hide();

                            form.reset();
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message || 'Error saving category.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            document.getElementById('paperSize').addEventListener('change', function () {
                const customLabelCountContainer = document.getElementById('customLabelCountContainer');
                if (this.value === 'custom') {
                    customLabelCountContainer.style.display = 'block';
                } else {
                    customLabelCountContainer.style.display = 'none';
                }
            });

            document.getElementById('printBarcode').addEventListener('click', function() {
                var printOptionsModal = new bootstrap.Modal(document.getElementById('printOptionsModal'));
                printOptionsModal.show();
            });

            document.getElementById('confirmPrint').addEventListener('click', function() {
                let paperSize = document.getElementById('paperSize').value;
                if (paperSize === 'custom') {
                    paperSize = document.getElementById('customLabelCount').value;
                }

                const barcodeValue = document.getElementById('barcode').value;

                if (!barcodeValue) {
                    alert('Please generate a barcode first.');
                    return;
                }

                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Print Barcode</title>
                        <style>
                            body { display: flex; flex-wrap: wrap; padding: 0; margin: 0; }
                            .label { width: calc(100% / 5); text-align: center; }
                            img { max-width: 100%; height: auto; }
                            p { font-size: 12px; margin: 0; }
                        </style>
                    </head>
                    <body>
                        ${Array.from({ length: paperSize }).map((_, index) => `
                            <div class="label">
                                <img id="barcode-"${index}" />
                            </div>
                        `).join('')}
                        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                for (let i = 0; i < ${paperSize}; i++) {
                                    JsBarcode("#barcode-" + i, "${barcodeValue}", {
                                        format: "CODE128",
                                        displayValue: true
                                    });
                                }
                                window.print();
                            });
                        <\/script>
                    </body>
                    </html>
                `);
                printWindow.document.close();

                var printOptionsModal = bootstrap.Modal.getInstance(document.getElementById('printOptionsModal'));
                printOptionsModal.hide();
            });

            function checkBarcode() {
                let barcodeInput = document.getElementById("barcode");
                let feedback = document.getElementById("barcode-feedback");
                let formatFeedback = document.getElementById("barcode-format-feedback");
                let validFeedback = document.getElementById("barcode-valid-feedback");
                let barcode = barcodeInput.value.trim();

                // إعادة تعيين جميع حالات الملاحظات
                feedback.classList.add("d-none");
                formatFeedback.classList.add("d-none");
                validFeedback.classList.add("d-none");
                barcodeInput.classList.remove("is-invalid");

                if (barcode === "") return;

                // التحقق من صحة تنسيق الباركود (8-13 رقم)
                if (!/^[0-9]{8,13}$/.test(barcode)) {
                    formatFeedback.classList.remove("d-none");
                    barcodeInput.classList.add("is-invalid");
                    return;
                }

                fetch(`{{ route('products.checkBarcode', '') }}/${barcode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            feedback.classList.remove("d-none");
                            barcodeInput.classList.add("is-invalid");
                            validFeedback.classList.add("d-none");
                        } else {
                            feedback.classList.add("d-none");
                            barcodeInput.classList.remove("is-invalid");
                            validFeedback.classList.remove("d-none");
                        }
                    })
                    .catch(error => console.error("Error checking barcode:", error));
            }

            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
                
                // Add event listener for generate barcode button
                document.getElementById('generateBarcode').addEventListener('click', function() {
                    fetch('{{ route('products.generateBarcode') }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // تحديث قيمة الباركود
                                document.getElementById('barcode').value = data.barcode;
                                
                                // إزالة كل رسائل الخطأ
                                document.getElementById('barcode').classList.remove('is-invalid');
                                document.getElementById('barcode-feedback').classList.add('d-none');
                                document.getElementById('barcode-format-feedback').classList.add('d-none');
                                
                                // إظهار رسالة نجاح
                                document.getElementById('barcode-valid-feedback').classList.remove('d-none');
                            } else {
                                console.error('Error generating barcode');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
                
                initFormValidation();
                
                initImagePreviews();
                
                initPriceCostCheck();
                
                initBarcodeValidation();

                // Initialize mobile checkbox functionality - Show/hide device details section
                const isMobileCheckbox = document.getElementById('is_mobile');
                const deviceDetailsSection = document.getElementById('device_details_section');
                const hasBoxSelect = document.getElementById('has_box');

                isMobileCheckbox.addEventListener('change', function() {
                    deviceDetailsSection.style.display = this.checked ? 'block' : 'none';
                    
                    // إذا تم تحديد "هذا جهاز" والمربع "with box" لم يتم اختياره، نضع القيمة الافتراضية "لا"
                    if (this.checked && hasBoxSelect.value === '') {
                        hasBoxSelect.value = '0';
                    }
                });

                // Initialize based on current state
                deviceDetailsSection.style.display = isMobileCheckbox.checked ? 'block' : 'none';
                
                // تعيين القيمة الافتراضية لـ has_box عند تحميل الصفحة إذا كان خيار الجهاز محددًا
                if (isMobileCheckbox.checked && hasBoxSelect.value === '') {
                    hasBoxSelect.value = '0';
                }
            });
            
            function initFormValidation() {
                const form = document.querySelector('form');
                const submitButton = document.getElementById('submit-form');
                const toastEl = document.getElementById('formErrorToast');
                const toast = new bootstrap.Toast(toastEl);
                
                // تنظيف مستمعي الأحداث السابقة للنموذج (لمنع التكرار)
                const newForm = form.cloneNode(true);
                form.parentNode.replaceChild(newForm, form);
                
                // تحديث مرجع النموذج
                const updatedForm = document.querySelector('form');
                
                // تعديل submit بطريقة احترافية وموحدة
                updatedForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // 1. إظهار مؤشر التحميل على الزر
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;
                    
                    // 2. التحقق من الحقول المطلوبة
                    const requiredFields = updatedForm.querySelectorAll('[required]');
                    let isValid = true;
                    let firstInvalidField = null;
                    let tabToActivate = null;
                    let invalidFieldsMessages = [];
                    
                    // التحقق من كل حقل مطلوب
                    requiredFields.forEach(function(field) {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('is-invalid');
                            
                            // إضافة رسالة الحقل غير الصالح
                            let fieldLabel = '';
                            const labelEl = field.closest('.mb-10')?.querySelector('.form-label');
                            if (labelEl) {
                                fieldLabel = labelEl.textContent.replace('*', '').trim();
                            } else {
                                fieldLabel = field.name.replace('_', ' ').replace(/^\w/, c => c.toUpperCase());
                            }
                            invalidFieldsMessages.push(fieldLabel);
                        }
                    });
                    
                    // التحقق من المخزن
                    const warehouseEntries = document.querySelectorAll('.warehouse-entry');
                    let hasValidWarehouse = false;
                    
                    for (const entry of warehouseEntries) {
                        const warehouseSelect = entry.querySelector('select[name^="warehouses"]');
                        const stockInput = entry.querySelector('input[name$="[stock]"]');
                        const alertInput = entry.querySelector('input[name$="[stock_alert]"]');
                        
                        if (warehouseSelect && warehouseSelect.value && 
                            stockInput && stockInput.value && 
                            alertInput && alertInput.value) {
                            hasValidWarehouse = true;
                            break;
                        }
                    }
                    
                    if (!hasValidWarehouse) {
                        invalidFieldsMessages.push('بيانات المخزن (المخزن، الكمية، والإنذار)');
                        
                        // تحديد أول حقل في أول مخزن كأول حقل مفقود إذا لم يتم تحديد حقل آخر
                        if (!firstInvalidField && warehouseEntries.length > 0) {
                            const firstWarehouse = warehouseEntries[0];
                            firstInvalidField = firstWarehouse.querySelector('select') || 
                                              firstWarehouse.querySelector('input[name$="[stock]"]') || 
                                              firstWarehouse.querySelector('input[name$="[stock_alert]"]');
                            
                            if (firstInvalidField) {
                                firstInvalidField.classList.add('is-invalid');
                            }
                        }
                    }
                    
                    // إذا كانت هناك حقول مفقودة، عرض رسالة خطأ
                    if (invalidFieldsMessages.length > 0) {
                        // عرض توست مخصص
                        const toastContainer = document.createElement('div');
                        toastContainer.className = 'position-fixed top-0 end-0 p-3';
                        toastContainer.style.zIndex = '11';
                        
                        const toastElement = document.createElement('div');
                        toastElement.className = 'toast align-items-center text-white bg-danger border-0';
                        toastElement.setAttribute('role', 'alert');
                        toastElement.setAttribute('aria-live', 'assertive');
                        toastElement.setAttribute('aria-atomic', 'true');
                        
                        // إنشاء نص الخطأ
                        let errorMessage = '<strong>يرجى استكمال الحقون التالية:</strong><ul class="mt-2 mb-0">';
                        invalidFieldsMessages.forEach(field => {
                            errorMessage += `<li>${field}</li>`;
                        });
                        errorMessage += '</ul>';
                        
                        toastElement.innerHTML = `
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    ${errorMessage}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        `;
                        
                        toastContainer.appendChild(toastElement);
                        document.body.appendChild(toastContainer);
                        
                        // عرض التوست
                        const toast = new bootstrap.Toast(toastElement, {
                            autohide: false
                        });
                        toast.show();
                        
                        // التركيز على أول حقل مفقود
                        if (firstInvalidField) {
                            // تنشيط التبويب الذي يحتوي على الحقل
                            const tabPanel = firstInvalidField.closest('.tab-pane');
                            if (tabPanel) {
                                const tabId = tabPanel.id;
                                const tabLink = document.querySelector(`a[data-bs-toggle="tab"][href="#${tabId}"]`);
                                if (tabLink) {
                                    const tab = new bootstrap.Tab(tabLink);
                                    tab.show();
                                }
                            }
                            
                            // التركيز على الحقل
                            setTimeout(() => {
                                firstInvalidField.focus();
                                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }, 300);
                        }
                        
                        // إزالة التوست عند إغلاقه
                        toastElement.addEventListener('hidden.bs.toast', function() {
                            toastContainer.remove();
                        });
                        
                        return;
                    }
                    
                    // إذا لم تكن هناك أي حقول مفقودة، قم بإرسال النموذج
                    form.submit();
                });
            }
            
            function initImagePreviews() {
                // Image preview functionality for product image
                const imageInput = document.getElementById('image');
                const imagePreview = document.getElementById('imagePreview');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                const removeImagePreviewButton = document.getElementById('removeImagePreview');
                
                if (imageInput) {
                    imageInput.addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                imagePreview.src = e.target.result;
                                imagePreviewContainer.classList.remove('d-none');
                            };
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }
                
                if (removeImagePreviewButton) {
                    removeImagePreviewButton.addEventListener('click', function() {
                        imageInput.value = '';
                        imagePreviewContainer.classList.add('d-none');
                        imagePreview.src = '#';
                    });
                }
                
                // Scan ID preview
                const scanIdInput = document.getElementById('scan_id');
                const scanIdPreview = document.getElementById('scanIdPreview');
                const scanIdPreviewContainer = document.getElementById('scanIdPreviewContainer');
                const removeScanIdPreviewButton = document.getElementById('removeScanIdPreview');
                
                if (scanIdInput) {
                    scanIdInput.addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                scanIdPreview.src = e.target.result;
                                scanIdPreviewContainer.classList.remove('d-none');
                            };
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }
                
                if (removeScanIdPreviewButton) {
                    removeScanIdPreviewButton.addEventListener('click', function() {
                        scanIdInput.value = '';
                        scanIdPreviewContainer.classList.add('d-none');
                        scanIdPreview.src = '#';
                    });
                }
                
                // Scan Documents preview
                const scanDocsInput = document.getElementById('scan_documents');
                const scanDocsPreview = document.getElementById('scanDocumentsPreview');
                const scanDocsPreviewContainer = document.getElementById('scanDocumentsPreviewContainer');
                const removeScanDocsPreviewButton = document.getElementById('removeScanDocumentsPreview');
                
                if (scanDocsInput) {
                    scanDocsInput.addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                scanDocsPreview.src = e.target.result;
                                scanDocsPreviewContainer.classList.remove('d-none');
                            };
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }
                
                if (removeScanDocsPreviewButton) {
                    removeScanDocsPreviewButton.addEventListener('click', function() {
                        scanDocsInput.value = '';
                        scanDocsPreviewContainer.classList.add('d-none');
                        scanDocsPreview.src = '#';
                    });
                }
            }
            
            function initPriceCostCheck() {
                const costInput = document.getElementById('cost');
                const priceInput = document.getElementById('price');
                const priceFeedback = document.getElementById('price-feedback');
                
                if (costInput && priceInput && priceFeedback) {
                    const validatePriceVsCost = function() {
                        const cost = parseFloat(costInput.value) || 0;
                        const price = parseFloat(priceInput.value) || 0;
                        
                        if (price < cost && price > 0) {
                            priceFeedback.classList.remove('d-none');
                            priceInput.classList.add('is-invalid');
                        } else {
                            priceFeedback.classList.add('d-none');
                            priceInput.classList.remove('is-invalid');
                        }
                    };
                    
                    costInput.addEventListener('input', validatePriceVsCost);
                    priceInput.addEventListener('input', validatePriceVsCost);
                    
                    // Initial validation
                    validatePriceVsCost();
                }
            }
            
            function initBarcodeValidation() {
                const barcodeInput = document.getElementById('barcode');
                const barcodeFeedback = document.getElementById('barcode-feedback');
                const barcodeFormatFeedback = document.getElementById('barcode-format-feedback');
                const barcodeValidFeedback = document.getElementById('barcode-valid-feedback');
                
                if (barcodeInput) {
                    barcodeInput.addEventListener('input', function() {
                        const barcode = this.value.trim();
                        
                        // إعادة تعيين جميع حالات الملاحظات
                        barcodeFeedback.classList.add('d-none');
                        barcodeFormatFeedback.classList.add('d-none');
                        barcodeValidFeedback.classList.add('d-none');
                        barcodeInput.classList.remove('is-invalid');
                        
                        // تخطي التحقق للباركود الفارغ
                        if (!barcode) return;
                        
                        // التحقق من صحة التنسيق (8-13 رقم)
                        if (!/^[0-9]{8,13}$/.test(barcode)) {
                            barcodeFormatFeedback.classList.remove('d-none');
                            barcodeInput.classList.add('is-invalid');
                            return;
                        }
                        
                        // التحقق مما إذا كان الباركود موجودًا
                        fetch(`{{ route('products.checkBarcode', '') }}/${barcode}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.exists) {
                                    barcodeFeedback.classList.remove('d-none');
                                    barcodeInput.classList.add('is-invalid');
                                    barcodeValidFeedback.classList.add('d-none');
                                } else if (data.valid_format) {
                                    barcodeFeedback.classList.add('d-none');
                                    barcodeFormatFeedback.classList.add('d-none');
                                    barcodeInput.classList.remove('is-invalid');
                                    barcodeValidFeedback.classList.remove('d-none');
                                }
                            })
                            .catch(error => console.error("Error checking barcode:", error));
                    });
                }
            }
            
            // وظيفة للتبديل بين أقسام العملاء والموردين
            function toggleClientSections(value) {
                const customerSection = document.getElementById('customer_section');
                const supplierSection = document.getElementById('supplier_section');
                
                if (value === 'customer') {
                    customerSection.style.display = 'block';
                    supplierSection.style.display = 'none';
                } else if (value === 'supplier') {
                    customerSection.style.display = 'none';
                    supplierSection.style.display = 'block';
                } else {
                    customerSection.style.display = 'none';
                    supplierSection.style.display = 'none';
                }
            }
        </script>
    @endsection

@endsection