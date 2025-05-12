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

                    <!-- General Section -->
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
                                        @foreach(old('warehouses') as $index => $warehouseData)
                                            <div class="input-group mb-2 warehouse-entry">
                                                <select class="form-select" name="warehouses[{{ $index }}][id]" required>
                                                    <option value="">{{ __('products.select_warehouse') }}</option>
                                                    @foreach($warehouses as $warehouseOption)
                                                        <option value="{{ $warehouseOption->id }}" {{ ($warehouseData['id'] ?? null) == $warehouseOption->id ? 'selected' : '' }}>
                                                            {{ $warehouseOption->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="number" class="form-control" name="warehouses[{{ $index }}][stock]" value="{{ $warehouseData['stock'] ?? '' }}" placeholder="{{ __('products.stock') }}" required>
                                                <input type="number" class="form-control" name="warehouses[{{ $index }}][stock_alert]" value="{{ $warehouseData['stock_alert'] ?? '' }}" placeholder="{{ __('products.stock_alert') }}" required>
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
                                <label class="form-label">{{ __('products.cost') }}</label>
                                <input type="number" class="form-control mb-2" id="cost" name="cost" step="0.01" min="0" value="{{ old('cost', 0) }}" required>
                            </div>
                            <div class="mb-10 col-md-3">
                                <label class="form-label">{{ __('products.price') }}</label>
                                <input type="number" class="form-control mb-2" id="price" name="price" step="0.01" min="0" value="{{ old('price', 0) }}">
                                <div id="price-feedback" class="form-text text-danger d-none">{{ __('products.price_cost_warning') }}</div>
                            </div>
                            <div class="mb-10 col-md-3">
                                <label class="form-label">{{ __('products.wholesale_price') }}</label>
                                <input type="number" class="form-control mb-2" id="wholesale_price" name="wholesale_price" step="0.01" value="{{ old('wholesale_price', 0) }}">
                            </div>
                            <div class="mb-10 col-md-3">
                                <label class="form-label">{{ __('products.lowest_price_for_sale') }}</label>
                                <input type="number" class="form-control mb-2" id="min_sale_price" name="min_sale_price" step="0.01" value="{{ old('min_sale_price', 0) }}">
                            </div>
                            <div class="mb-10 col-md-12">
                                <label class="form-label">{{ __('products.description') }}</label>
                                <textarea class="form-control mb-2 min-h-100px" id="description" name="description">{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-10 col-md-4">
                                <label class="form-label">{{ __('products.image') }}</label>
                                <div class="image-upload-container position-relative">
                                    <input type="file" class="form-control mb-2" id="image" name="image" accept="image/*">
                                    <div class="image-preview mt-2 d-none" id="new_image_preview_display_container">
                                        <img id="new_image_preview_display" src="#" alt="New Product Image Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                        <button type="button" class="btn btn-sm btn-danger mt-1" id="cancel_new_image_selection">{{ __('products.cancel') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-10 col-md-4">
                                <label class="form-label">{{ __('products.category') }}</label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select me-2" id="category_id" name="category_id">
                                        <option value="">{{ __('products.choose_category') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">{{ __('products.add') }}</button>
                                </div>
                            </div>
                            <div class="mb-10 col-md-4">
                                <label class="form-label">{{ __('products.brand') }}</label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select me-2" id="brand_id" name="brand_id">
                                        <option value="">{{ __('products.choose_brand') }}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">{{ __('products.add') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End General Section -->

                    <!-- Device Details Section -->
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
                                        <option value="0" {{ old('has_box', '0') == '0' ? 'selected' : '' }}>{{ __('products.no') }}</option>
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
                                    <label class="form-label">{{ __('products.scan_id') }}</label>
                                    <div class="image-upload-container position-relative">
                                        <input type="file" class="form-control mb-2" id="scan_id" name="scan_id" accept="image/*">
                                        <div class="image-preview mt-2 d-none" id="new_scan_id_preview_display_container">
                                            <img id="new_scan_id_preview_display" src="#" alt="New Scan ID Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                            <button type="button" class="btn btn-sm btn-danger mt-1" id="cancel_new_scan_id_selection">{{ __('products.cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.scan_documents') }}</label>
                                     <div class="image-upload-container position-relative">
                                        <input type="file" class="form-control mb-2" id="scan_documents" name="scan_documents" accept="image/*,application/pdf">
                                        <div class="image-preview mt-2 d-none" id="new_scan_documents_preview_display_container">
                                            <img id="new_scan_documents_preview_display" src="#" alt="New Scan Documents Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                            <span id="new_scan_documents_file_name_display" class="d-none"></span> {{-- For PDF name --}}
                                            <button type="button" class="btn btn-sm btn-danger mt-1" id="cancel_new_scan_documents_selection">{{ __('products.cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-10 col-md-12">
                                    <label class="form-label">{{ __('products.device_description') }}</label>
                                    <textarea class="form-control mb-2 min-h-100px" id="device_description" name="device_description">{{ old('device_description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Device Details Section -->

                    <!-- Save Button -->
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

    {{-- Modals for Add Category, Brand, Customer, Supplier, Print Options, Duplicate Product --}}
    {{-- These modals are kept as they might be used independently or for other functionalities --}}
    @include('products.partials.add_category_modal')
    @include('products.partials.add_brand_modal')
    @include('products.partials.print_options_modal')
    {{-- @include('products.partials.add_customer_modal') --}} {{-- Commented out as product is not directly linked to customer --}}
    {{-- @include('products.partials.add_supplier_modal') --}} {{-- Commented out as product is not directly linked to supplier --}}
    @include('products.partials.duplicate_product_modal')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tooltip initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize mobile checkbox functionality - Show/hide device details section
        const isMobileCheckbox = document.getElementById('is_mobile');
        const deviceDetailsSection = document.getElementById('device_details_section');
        const hasBoxSelect = document.getElementById('has_box');

        if (isMobileCheckbox && deviceDetailsSection) {
            function toggleDeviceDetails() {
                deviceDetailsSection.style.display = isMobileCheckbox.checked ? 'block' : 'none';
                if (isMobileCheckbox.checked && hasBoxSelect && hasBoxSelect.value === '') {
                    hasBoxSelect.value = '0'; // Default to 'No' if 'is_mobile' is checked and 'has_box' is empty
                }
            }
            isMobileCheckbox.addEventListener('change', toggleDeviceDetails);
            toggleDeviceDetails(); // Initial check on page load
        }

        // Warehouse management
        const warehouseContainer = document.getElementById('warehouse-container');
        const addWarehouseButton = document.getElementById('add-warehouse');
        let warehouseIndex = warehouseContainer ? warehouseContainer.querySelectorAll('.warehouse-entry').length : 0;

        if (addWarehouseButton && warehouseContainer) {
            addWarehouseButton.addEventListener('click', function () {
                const newEntry = document.createElement('div');
                newEntry.classList.add('input-group', 'mb-2', 'warehouse-entry');
                newEntry.innerHTML = `
                    <select class="form-select" name="warehouses[${warehouseIndex}][id]" required>
                        <option value="">{{ __('products.select_warehouse') }}</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" class="form-control" name="warehouses[${warehouseIndex}][stock]" placeholder="{{ __('products.stock') }}" required>
                    <input type="number" class="form-control" name="warehouses[${warehouseIndex}][stock_alert]" placeholder="{{ __('products.stock_alert') }}" required>
                    <button type="button" class="btn btn-danger remove-warehouse">{{ __('products.remove') }}</button>
                `;
                warehouseContainer.appendChild(newEntry);
                newEntry.querySelector('.remove-warehouse').addEventListener('click', function() {
                    this.closest('.warehouse-entry').remove();
                });
                warehouseIndex++;
            });

            warehouseContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-warehouse')) {
                    e.target.closest('.warehouse-entry').remove();
                }
            });
        }

        // Barcode generation and checking
        const generateBarcodeBtn = document.getElementById('generateBarcode');
        const barcodeInput = document.getElementById('barcode');
        const barcodeFeedback = document.getElementById("barcode-feedback");
        const barcodeFormatFeedback = document.getElementById("barcode-format-feedback");
        const barcodeValidFeedback = document.getElementById("barcode-valid-feedback");

        if (generateBarcodeBtn && barcodeInput) {
            generateBarcodeBtn.addEventListener('click', function() {
                fetch('{{ route('products.generateBarcode') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            barcodeInput.value = data.barcode;
                            checkBarcode(); // Validate the newly generated barcode
                        } else { console.error('Error generating barcode'); }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }

        window.checkBarcode = function() { // Made global for onblur
            if (!barcodeInput || !barcodeFeedback || !barcodeFormatFeedback || !barcodeValidFeedback) return;
            let barcode = barcodeInput.value.trim();

            barcodeFeedback.classList.add("d-none");
            barcodeFormatFeedback.classList.add("d-none");
            barcodeValidFeedback.classList.add("d-none");
            barcodeInput.classList.remove("is-invalid", "is-valid");

            if (barcode === "") return;

            if (!/^[0-9]{8,13}$/.test(barcode)) {
                barcodeFormatFeedback.textContent = '{{ __("products.invalid_barcode_format_message") }}'; // Specific message
                barcodeFormatFeedback.classList.remove("d-none");
                barcodeInput.classList.add("is-invalid");
                return;
            }

            fetch(`{{ route('products.checkBarcode', '') }}/${barcode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        barcodeFeedback.textContent = data.message || '{{ __("products.This barcode already exists!") }}';
                        barcodeFeedback.classList.remove("d-none");
                        barcodeInput.classList.add("is-invalid");
                    } else if (data.valid_format === false) { // Should be caught by regex but good to double check
                        barcodeFormatFeedback.textContent = data.message || '{{ __("products.invalid_barcode_format_message") }}';
                        barcodeFormatFeedback.classList.remove("d-none");
                        barcodeInput.classList.add("is-invalid");
                    } else {
                        barcodeValidFeedback.textContent = data.message || '{{ __("products.valid_barcode") }}';
                        barcodeValidFeedback.classList.remove("d-none");
                        barcodeInput.classList.add("is-valid");
                    }
                })
                .catch(error => console.error("Error checking barcode:", error));
        }
        if(barcodeInput) barcodeInput.addEventListener('input', checkBarcode);


        // Price vs Cost Check
        const costInput = document.getElementById('cost');
        const priceInput = document.getElementById('price');
        const priceFeedback = document.getElementById('price-feedback');

        if (costInput && priceInput && priceFeedback) {
            const validatePriceVsCost = function() {
                const cost = parseFloat(costInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                if (price > 0 && cost > 0 && price < cost) { // Only show warning if price is entered and less than cost
                    priceFeedback.classList.remove('d-none');
                    priceInput.classList.add('is-invalid');
                } else {
                    priceFeedback.classList.add('d-none');
                    priceInput.classList.remove('is-invalid');
                }
            };
            costInput.addEventListener('input', validatePriceVsCost);
            priceInput.addEventListener('input', validatePriceVsCost);
            validatePriceVsCost(); // Initial check
        }

        // Unified Image/File Preview Logic
        function setupImagePreviewLogic(inputId, newImagePreviewId, cancelNewImageButtonId, newFileNameDisplayId) {
            const fileInput = document.getElementById(inputId);
            const newPreviewImg = document.getElementById(newImagePreviewId);
            const newPreviewWrapper = newPreviewImg ? newPreviewImg.parentElement : null;
            const cancelNewImageBtn = document.getElementById(cancelNewImageButtonId);
            const newFileNameDisplay = newFileNameDisplayId ? document.getElementById(newFileNameDisplayId) : null;

            if (fileInput) {
                fileInput.addEventListener('change', function(event) {
                    if (event.target.files && event.target.files[0]) {
                        const file = event.target.files[0];
                        if (newPreviewImg && newPreviewWrapper) {
                            if (file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    newPreviewImg.src = e.target.result;
                                    newPreviewImg.classList.remove('d-none');
                                    if(newFileNameDisplay) newFileNameDisplay.classList.add('d-none');
                                }
                                reader.readAsDataURL(file);
                            } else if (newFileNameDisplay) {
                                newPreviewImg.classList.add('d-none');
                                newPreviewImg.src = '#';
                                newFileNameDisplay.textContent = file.name;
                                newFileNameDisplay.classList.remove('d-none');
                            }
                            newPreviewWrapper.classList.remove('d-none');
                        }
                    } else {
                        if (newPreviewWrapper) newPreviewWrapper.classList.add('d-none');
                        if (newPreviewImg) { newPreviewImg.src = '#'; newPreviewImg.classList.remove('d-none'); }
                        if (newFileNameDisplay) { newFileNameDisplay.textContent = ''; newFileNameDisplay.classList.add('d-none'); }
                    }
                });
            }

            if (cancelNewImageBtn) {
                cancelNewImageBtn.addEventListener('click', function() {
                    fileInput.value = '';
                    if (newPreviewWrapper) newPreviewWrapper.classList.add('d-none');
                    if (newPreviewImg) { newPreviewImg.src = '#'; newPreviewImg.classList.remove('d-none'); }
                    if (newFileNameDisplay) { newFileNameDisplay.textContent = ''; newFileNameDisplay.classList.add('d-none'); }
                });
            }
        }

        setupImagePreviewLogic('image', 'new_image_preview_display', 'cancel_new_image_selection');
        setupImagePreviewLogic('scan_id', 'new_scan_id_preview_display', 'cancel_new_scan_id_selection');
        setupImagePreviewLogic('scan_documents', 'new_scan_documents_preview_display', 'cancel_new_scan_documents_selection', 'new_scan_documents_file_name_display');

        // AJAX for Modals (Add Category, Brand, Customer, Supplier)
        // Simplified, ensure these routes exist and controllers handle JSON responses.
        function setupModalForm(formId, url, selectToUpdateId, modalId, itemName) {
            const form = document.getElementById(formId);
            if (!form) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;
                submitButton.innerHTML = '{{ __("products.saving") }} <span class="spinner-border spinner-border-sm"></span>';
                submitButton.disabled = true;

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data[itemName]) {
                        const selectElement = document.getElementById(selectToUpdateId);
                        if (selectElement) {
                            const option = new Option(data[itemName].name, data[itemName].id, true, true);
                            selectElement.appendChild(option);
                            selectElement.dispatchEvent(new Event('change')); // For select2 or other libraries to update
                        }
                        var modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
                        if (modal) modal.hide();
                        form.reset();
                        toastr.success(data.message || itemName.charAt(0).toUpperCase() + itemName.slice(1) + ' added successfully.');
                    } else {
                        toastr.error(data.message || 'Error saving ' + itemName + '. ' + (data.error || ''));
                        if(data.errors){
                            let errorMsg = '';
                            for(const field in data.errors){
                                errorMsg += data.errors[field].join('\n') + '\n';
                            }
                            toastr.error(errorMsg);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An unexpected error occurred.');
                })
                .finally(() => {
                    submitButton.innerHTML = originalButtonText;
                    submitButton.disabled = false;
                });
            });
        }

        setupModalForm('addCategoryForm', '{{ route("categories.store") }}', 'category_id', 'addCategoryModal', 'category');
        setupModalForm('addBrandForm', '{{ route("brands.store") }}', 'brand_id', 'addBrandModal', 'brand');
        // Customer and Supplier modals are present but their direct integration with Product form was removed.
        // If they are to be used for general creation, their AJAX can be kept.
        // The selectToUpdateId might not be relevant anymore for customer/supplier on this specific product form.
        // setupModalForm('addCustomerForm', '{{ route("customers.store") }}', 'customer_id', 'addCustomerModal', 'customer');
        // setupModalForm('addSupplierForm', '{{ route("suppliers.store") }}', 'supplier_id', 'addSupplierModal', 'supplier');

        // Print Barcode Modal Logic
        const printBarcodeBtn = document.getElementById('printBarcode');
        if(printBarcodeBtn) {
            printBarcodeBtn.addEventListener('click', function() {
                var printOptionsModalEl = document.getElementById('printOptionsModal');
                if(printOptionsModalEl){
                    var printOptionsModal = new bootstrap.Modal(printOptionsModalEl);
                    printOptionsModal.show();
                }
            });
        }

        const confirmPrintBtn = document.getElementById('confirmPrint');
        if(confirmPrintBtn){
            confirmPrintBtn.addEventListener('click', function() {
                let paperSize = document.getElementById('paperSize').value;
                if (paperSize === 'custom') {
                    paperSize = document.getElementById('customLabelCount').value;
                }
                const barcodeValue = document.getElementById('barcode').value;
                if (!barcodeValue) {
                    toastr.error('{{ __("products.barcode_not_entered") }}');
                    return;
                }
                if (!paperSize || paperSize < 1) {
                    toastr.error('{{ __("products.invalid_label_count") }}');
                    return;
                }
                // Simplified print content - actual implementation might vary
                const printWindow = window.open('', '_blank');
                printWindow.document.write('<html><head><title>Print Barcode</title></head><body>');
                for(let i=0; i< parseInt(paperSize); i++) {
                    printWindow.document.write(`<div style="text-align:center; margin:10px;"><svg id="barcode-${i}"></svg></div>`);
                }
                printWindow.document.write('<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>');
                printWindow.document.write('<script>document.addEventListener("DOMContentLoaded", function() {');
                for(let i=0; i< parseInt(paperSize); i++) {
                    printWindow.document.write(`JsBarcode("#barcode-${i}", "${barcodeValue}", { format: "CODE128", displayValue: true, textMargin: 0, fontSize: 14, margin: 10 });`);
                }
                printWindow.document.write('window.print(); window.close(); });<\/script></body></html>');
                printWindow.document.close();
                var modal = bootstrap.Modal.getInstance(document.getElementById('printOptionsModal'));
                if(modal) modal.hide();
            });
        }
        const paperSizeSelect = document.getElementById('paperSize');
        if(paperSizeSelect){
            paperSizeSelect.addEventListener('change', function () {
                document.getElementById('customLabelCountContainer').style.display = this.value === 'custom' ? 'block' : 'none';
            });
        }

        // Form submission validation (simplified, main validation is server-side)
        const mainForm = document.querySelector('form.form.d-flex');
        if(mainForm){
            mainForm.addEventListener('submit', function(e){
                const submitButton = document.getElementById('submit-form');
                if(submitButton){
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;
                }
            });
        }

    });

    // --- Duplicate Product Modal Logic ---
    const duplicateModalEl = document.getElementById('duplicateProductModal');
    const productSearchInput = document.getElementById('productSearchModalInput');
    const productSearchResultsDiv = document.getElementById('productSearchResultsModal');
    let duplicateModalInstance = null;

    if (duplicateModalEl) {
        duplicateModalInstance = new bootstrap.Modal(duplicateModalEl);

        if (productSearchInput && productSearchResultsDiv) {
            let searchTimeout;
            productSearchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value.trim();
                if (searchTerm.length >= 2) {
                    searchTimeout = setTimeout(() => {
                        fetch(`{{ route('products.search') }}?term=${encodeURIComponent(searchTerm)}`)
                            .then(response => response.json())
                            .then(data => {
                                productSearchResultsDiv.innerHTML = ''; // Clear previous results
                                if (data.length > 0) {
                                    data.forEach(product => {
                                        const item = document.createElement('a');
                                        item.href = '#';
                                        item.classList.add('list-group-item', 'list-group-item-action');
                                        item.textContent = `${product.name} (${product.barcode || 'N/A'}) - Price: ${product.price}`;
                                        item.dataset.productId = product.id;
                                        item.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            fetchProductForDuplication(this.dataset.productId);
                                        });
                                        productSearchResultsDiv.appendChild(item);
                                    });
                                } else {
                                    productSearchResultsDiv.innerHTML = `<p class="text-muted p-3">{{ __("products.no_products_found") }}</p>`;
                                }
                            })
                            .catch(error => console.error('Error searching products:', error));
                    }, 300); // Debounce search
                } else {
                    productSearchResultsDiv.innerHTML = '';
                }
            });
        }
    }

    function fetchProductForDuplication(productId) {
        fetch(`{{ url('products') }}/${productId}/duplicate`) // Using url() helper for flexibility
            .then(response => response.json())
            .then(data => {
                if (data.success && data.product) {
                    populateFormWithProductData(data.product, data.mobile_details);
                    if(duplicateModalInstance) {
                        duplicateModalEl.addEventListener('hidden.bs.modal', function () {
                            // Focus an element on the main form after modal is fully hidden
                            const nameInput = document.getElementById('name');
                            if (nameInput) nameInput.focus();
                        }, { once: true }); // Ensure this listener runs only once
                        duplicateModalInstance.hide();
                    }
                    toastr.info('{{ __("products.form_populated_for_duplication") }}', '{{ __("products.review_and_save") }}');
                } else {
                    toastr.error(data.message || '{{ __("products.error_fetching_product_for_duplication") }}');
                }
            })
            .catch(error => {
                console.error('Error fetching product for duplication:', error);
                toastr.error('{{ __("products.error_fetching_product_for_duplication") }}');
            });
    }

    function populateFormWithProductData(product, mobileDetails) {
        // Populate main product fields
        document.getElementById('name').value = product.name + ' (Copy)'; // Add suffix to indicate copy
        document.getElementById('cost').value = product.cost || 0;
        document.getElementById('price').value = product.price || 0;
        document.getElementById('wholesale_price').value = product.wholesale_price || 0;
        document.getElementById('min_sale_price').value = product.min_sale_price || 0;
        document.getElementById('description').value = product.description || '';

        if (product.category_id) {
            document.getElementById('category_id').value = product.category_id;
        }
        if (product.brand_id) {
            document.getElementById('brand_id').value = product.brand_id;
        }

        document.getElementById('barcode').value = '';
        if (document.getElementById('generateBarcode')) document.getElementById('generateBarcode').click(); // Attempt to generate new barcode
        else checkBarcode(); // Or just re-validate if generate button not present

        document.getElementById('image').value = '';
        const newImagePreviewContainer = document.getElementById('new_image_preview_display_container');
        const newImagePreview = document.getElementById('new_image_preview_display');
        if (newImagePreviewContainer && newImagePreview) {
            newImagePreviewContainer.classList.add('d-none');
            newImagePreview.src = '#';
        }

        const warehouseContainer = document.getElementById('warehouse-container');
        if (warehouseContainer) {
            // Clear existing and add one empty default entry if needed
            warehouseContainer.innerHTML = '';
            const addWarehouseBtn = document.getElementById('add-warehouse');
            if(product.warehouses && product.warehouses.length > 0){
                 product.warehouses.forEach((wh_data, index) => {
                    if(addWarehouseBtn) addWarehouseButton.click(); // Simulate click to add entry
                    // Then fill the newly added entry - this part is complex as fields are dynamically created
                    // For simplicity, we are clearing and user re-adds.
                    // A more advanced implementation would re-populate these.
                 });
            } else {
                 // If no warehouses from source, ensure at least one empty entry is present if that's the default form state
                 // This might already be handled by the form's default rendering
            }
        }

        const isMobileCheckbox = document.getElementById('is_mobile');
        const deviceDetailsSection = document.getElementById('device_details_section');

        if (product.is_mobile && mobileDetails) {
            isMobileCheckbox.checked = true;

            document.getElementById('color').value = mobileDetails.color || '';
            document.getElementById('storage').value = mobileDetails.storage || '';
            document.getElementById('battery_health').value = mobileDetails.battery_health || 0;
            document.getElementById('ram').value = mobileDetails.ram || '';
            document.getElementById('condition').value = mobileDetails.condition || '';
            document.getElementById('has_box').value = mobileDetails.has_box ? '1' : '0';
            document.getElementById('cpu').value = mobileDetails.cpu || '';
            document.getElementById('gpu').value = mobileDetails.gpu || '';
            document.getElementById('device_description').value = mobileDetails.device_description || '';

            document.getElementById('scan_id').value = '';
            const newScanIdPreviewContainer = document.getElementById('new_scan_id_preview_display_container');
            const newScanIdPreview = document.getElementById('new_scan_id_preview_display');
            if (newScanIdPreviewContainer && newScanIdPreview) {
                newScanIdPreviewContainer.classList.add('d-none');
                newScanIdPreview.src = '#';
            }

            document.getElementById('scan_documents').value = '';
            const newScanDocsPreviewContainer = document.getElementById('new_scan_documents_preview_display_container');
            const newScanDocsPreview = document.getElementById('new_scan_documents_preview_display');
            const newScanDocsFileName = document.getElementById('new_scan_documents_file_name_display');
            if (newScanDocsPreviewContainer && newScanDocsPreview) {
                newScanDocsPreviewContainer.classList.add('d-none');
                newScanDocsPreview.src = '#';
                if(newScanDocsFileName) newScanDocsFileName.classList.add('d-none');
            }

        } else {
            isMobileCheckbox.checked = false;
        }

        // Trigger change on is_mobile to ensure dependent UI (device_details_section) updates
        if(isMobileCheckbox) {
            const event = new Event('change', { bubbles: true });
            isMobileCheckbox.dispatchEvent(event);
        }
    }
</script>
@endsection
