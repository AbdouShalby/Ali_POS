@extends('layouts.app')

@section('title', '- ' . __('products.edit_product'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('products.edit_product') }}
                </h1>
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
        <div id="kt_app_content_container" class="app-container container-xxl pb-0">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row mb-0 pb-0">
                @csrf
                @method('PUT')

                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-12">
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
                        <div id="formErrorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <span id="formErrorMessage">{{ __('products.please_correct_errors') }}</span>
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
                                            <input type="checkbox" class="form-check-input me-2" id="is_mobile" name="is_mobile" {{ old('is_mobile', $product->is_mobile) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_mobile">{{ __('products.yes') }}</label>
                                        </div>
                                    </div>
                                    <div class="card-body row pt-0">
                                        <div class="mb-10 col-md-5">
                                            <label class="form-label">{{ __('products.name') }}</label>
                                            <input type="text" class="form-control mb-2" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                        </div>
                                        <div class="mb-10 col-md-7">
                                            <label class="form-label">{{ __('products.barcode') }}</label>
                                            <div class="input-group d-flex align-items-center">
                                                <input type="text" class="form-control mb-2" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}" onblur="checkBarcode()" required>
                                                <button type="button" class="btn btn-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: -1px; margin-top: -7px;" id="generateBarcode">{{ __('products.generate') }}</button>
                                                <button type="button" class="btn btn-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: -1px; margin-top: -7px;" id="printBarcode">{{ __('products.print') }}</button>
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
                                                @php $oldWarehouses = old('warehouses', $product->warehouses->map(function($wh) { return ['id' => $wh->id, 'stock' => $wh->pivot->stock, 'stock_alert' => $wh->pivot->stock_alert]; })->toArray()); @endphp
                                                @if(!empty($oldWarehouses))
                                                    @foreach($oldWarehouses as $index => $warehouseData)
                                                    <div class="input-group mb-2 warehouse-entry">
                                                        <select class="form-select" name="warehouses[{{ $index }}][id]" required>
                                                            <option value="">{{ __('products.select_warehouse') }}</option>
                                                            @foreach($warehouses as $availableWarehouse)
                                                                <option value="{{ $availableWarehouse->id }}" {{ ($warehouseData['id'] ?? null) == $availableWarehouse->id ? 'selected' : '' }}>
                                                                    {{ $availableWarehouse->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" class="form-control" name="warehouses[{{ $index }}][stock]" placeholder="{{ __('products.stock') }}" value="{{ $warehouseData['stock'] ?? '' }}" required>
                                                        <input type="number" class="form-control" name="warehouses[{{ $index }}][stock_alert]" placeholder="{{ __('products.stock_alert') }}" value="{{ $warehouseData['stock_alert'] ?? '' }}" required>
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
                                            <input type="number" class="form-control mb-2" id="cost" name="cost" value="{{ old('cost', $product->cost) }}" step="0.01" min="0" required>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.price') }}</label>
                                            <input type="number" class="form-control mb-2" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0">
                                            <div id="price-feedback" class="form-text text-danger d-none">{{ __('products.price_cost_warning') }}</div>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.wholesale_price') }}</label>
                                            <input type="number" class="form-control mb-2" id="wholesale_price" name="wholesale_price" value="{{ old('wholesale_price', $product->wholesale_price) }}" step="0.01" min="0">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.lowest_price_for_sale') }}</label>
                                            <input type="number" class="form-control mb-2" id="min_sale_price" name="min_sale_price" value="{{ old('min_sale_price', $product->min_sale_price) }}" step="0.01" min="0">
                                        </div>
                                        <div class="mb-10 col-md-12">
                                            <label class="form-label">{{ __('products.description') }}</label>
                                            <textarea class="form-control mb-2 min-h-100px" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                        <div class="mb-10 col-md-4">
                                            <label class="form-label">{{ __('products.image') }}</label>
                                            <div class="image-upload-container position-relative">
                                                <input type="file" class="form-control mb-2" id="image" name="image" accept="image/*">
                                                <div id="image_preview_container_current" class="image-preview-current-wrapper {{ !$product->image ? 'd-none' : '' }}">
                                                    @if($product->image)
                                                        <input type="hidden" name="existing_image" value="{{ $product->image }}">
                                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail current-image-preview" style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                        <div class="form-check form-check-inline mt-2">
                                                            <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                                            <label class="form-check-label" for="remove_image">{{ __('products.remove_current_image') }}</label>
                                                        </div>
                                                    @endif
                                                </div>
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
                                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
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
                    <div id="device_details_section" style="display: {{ old('is_mobile', $product->is_mobile) ? 'block' : 'none' }};">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('products.device_details') }}</h2>
                                </div>
                            </div>
                            <div class="card-body row pt-0">
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.color') }}</label>
                                    <input type="text" class="form-control mb-2" id="color" name="color" value="{{ old('color', $product->mobileDetail->color ?? '') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.storage') }}</label>
                                    <input type="text" class="form-control mb-2" id="storage" name="storage" value="{{ old('storage', $product->mobileDetail->storage ?? '') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.battery_health') }}</label>
                                    <input type="number" class="form-control mb-2" id="battery_health" name="battery_health" min="0" max="100" value="{{ old('battery_health', $product->mobileDetail->battery_health ?? 0) }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.ram') }}</label>
                                    <input type="text" class="form-control mb-2" id="ram" name="ram" value="{{ old('ram', $product->mobileDetail->ram ?? '') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.condition') }}</label>
                                    <input type="text" class="form-control mb-2" id="condition" name="condition" value="{{ old('condition', $product->mobileDetail->condition ?? '') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.with_box') }}</label>
                                    <select class="form-select mb-2" id="has_box" name="has_box">
                                        <option value="">{{ __('products.choose') }}</option>
                                        <option value="1" {{ old('has_box', $product->mobileDetail->has_box ?? '') == '1' ? 'selected' : '' }}>{{ __('products.yes') }}</option>
                                        <option value="0" {{ old('has_box', ($product->mobileDetail->has_box ?? '0')) == '0' ? 'selected' : '' }}>{{ __('products.no') }}</option>
                                    </select>
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.cpu') }}</label>
                                    <input type="text" class="form-control mb-2" id="cpu" name="cpu" value="{{ old('cpu', $product->mobileDetail->cpu ?? '') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.gpu') }}</label>
                                    <input type="text" class="form-control mb-2" id="gpu" name="gpu" value="{{ old('gpu', $product->mobileDetail->gpu ?? '') }}">
                                </div>
                                <div class="mb-10 col-md-2">
                                    <label class="form-label">{{ __('products.scan_id') }}</label>
                                    <div class="image-upload-container position-relative">
                                        <input type="file" class="form-control mb-2" id="scan_id" name="scan_id" accept="image/*">
                                        <div id="scan_id_preview_container_current" class="image-preview-current-wrapper {{ !($product->mobileDetail && $product->mobileDetail->scan_id) ? 'd-none' : '' }}">
                                            @if($product->mobileDetail && $product->mobileDetail->scan_id)
                                                <input type="hidden" name="existing_scan_id" value="{{ $product->mobileDetail->scan_id }}">
                                                <img src="{{ Storage::url($product->mobileDetail->scan_id) }}" alt="ID Scan" class="img-thumbnail current-image-preview" style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                <div class="form-check form-check-inline mt-2">
                                                    <input class="form-check-input" type="checkbox" id="remove_scan_id" name="remove_scan_id" value="1">
                                                    <label class="form-check-label" for="remove_scan_id">{{ __('products.remove_current_image') }}</label>
                                                </div>
                                            @endif
                                        </div>
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
                                        <div id="scan_documents_preview_container_current" class="image-preview-current-wrapper {{ !($product->mobileDetail && $product->mobileDetail->scan_documents) ? 'd-none' : '' }}">
                                            @if($product->mobileDetail && $product->mobileDetail->scan_documents)
                                                <input type="hidden" name="existing_scan_documents" value="{{ $product->mobileDetail->scan_documents }}">
                                                @php
                                                    $filePath = $product->mobileDetail->scan_documents;
                                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                @endphp
                                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ Storage::url($filePath) }}" alt="Documents Scan" class="img-thumbnail current-image-preview" style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                @else
                                                    <p><a href="{{ Storage::url($filePath) }}" target="_blank">{{ basename($filePath) }}</a></p>
                                                @endif
                                                <div class="form-check form-check-inline mt-2">
                                                    <input class="form-check-input" type="checkbox" id="remove_scan_documents" name="remove_scan_documents" value="1">
                                                    <label class="form-check-label" for="remove_scan_documents">{{ __('products.remove_current_image') }}</label>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="image-preview mt-2 d-none" id="new_scan_documents_preview_display_container">
                                            <img id="new_scan_documents_preview_display" src="#" alt="New Scan Documents Preview" class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                                            <span id="new_scan_documents_file_name_display" class="d-none"></span>
                                            <button type="button" class="btn btn-sm btn-danger mt-1" id="cancel_new_scan_documents_selection">{{ __('products.cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-10 col-md-12">
                                    <label class="form-label">{{ __('products.device_description') }}</label>
                                    <textarea class="form-control mb-2 min-h-100px" id="device_description" name="device_description">{{ old('device_description', $product->mobileDetail->device_description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Device Details Section -->

                    <!-- Save Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" id="submit-form" class="btn btn-primary">
                            <span class="indicator-label">{{ __('products.save') }}</span>
                            <span class="indicator-progress">{{ __('products.please_wait') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modals --}}
    @include('products.partials.add_category_modal')
    @include('products.partials.add_brand_modal')
    @include('products.partials.print_options_modal')
    {{-- Customer and Supplier modals are commented out as their direct link to the product on this form was removed. --}}
    {{-- @include('products.partials.add_customer_modal') --}}
    {{-- @include('products.partials.add_supplier_modal') --}}
    {{-- Assuming duplicate_product_modal is still needed and its partial will be created --}}
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

        // Initialize mobile checkbox functionality
        const isMobileCheckbox = document.getElementById('is_mobile');
        const deviceDetailsSection = document.getElementById('device_details_section');
        const hasBoxSelect = document.getElementById('has_box');

        if (isMobileCheckbox && deviceDetailsSection) {
            function toggleDeviceDetails() {
                deviceDetailsSection.style.display = isMobileCheckbox.checked ? 'block' : 'none';
                 if (isMobileCheckbox.checked && hasBoxSelect && hasBoxSelect.value === '') {
                    hasBoxSelect.value = '0'; // Default to 'No' 
                }
            }
            isMobileCheckbox.addEventListener('change', toggleDeviceDetails);
            toggleDeviceDetails(); // Initial check
        }

        // Warehouse management
        const warehouseContainer = document.getElementById('warehouse-container');
        const addWarehouseButton = document.getElementById('add-warehouse');
        let warehouseIdx = warehouseContainer ? warehouseContainer.querySelectorAll('.warehouse-entry').length : 0;

        if(addWarehouseButton && warehouseContainer){
            addWarehouseButton.addEventListener('click', function () {
                const newEntry = document.createElement('div');
                newEntry.classList.add('input-group', 'mb-2', 'warehouse-entry');
                newEntry.innerHTML = `
                    <select class="form-select" name="warehouses[${warehouseIdx}][id]" required>
                        <option value="">{{ __('products.select_warehouse') }}</option>
                        @foreach($warehouses as $availableWarehouse)
                            <option value="{{ $availableWarehouse->id }}">{{ $availableWarehouse->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" class="form-control" name="warehouses[${warehouseIdx}][stock]" placeholder="{{ __('products.stock') }}" required>
                    <input type="number" class="form-control" name="warehouses[${warehouseIdx}][stock_alert]" placeholder="{{ __('products.stock_alert') }}" required>
                    <button type="button" class="btn btn-danger remove-warehouse">{{ __('products.remove') }}</button>
                `;
                warehouseContainer.appendChild(newEntry);
                newEntry.querySelector('.remove-warehouse').addEventListener('click', function() { this.closest('.warehouse-entry').remove(); });
                warehouseIdx++;
            });

            warehouseContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-warehouse') && e.target.closest('.warehouse-entry').querySelector('select[name^="warehouses"]').value !== '') {
                     // This is an existing warehouse entry from the server, handle with AJAX delete if needed or just remove from form
                     // For now, just removing from form. Actual detachment is handled server-side on update or via dedicated button if implemented.
                     // To implement AJAX delete here, you'd need the product_id and warehouse_id
                     // and call the ProductController@removeWarehouse route.
                     if(confirm("{{ __('products.confirm_remove_warehouse_from_product') }}")){
                        e.target.closest('.warehouse-entry').remove();
                     }
                } else if (e.target.classList.contains('remove-warehouse')) {
                    e.target.closest('.warehouse-entry').remove(); // For newly added entries not yet saved
                }
            });
        }

        // Barcode generation and checking (similar to create.blade.php)
        const generateBarcodeBtn = document.getElementById('generateBarcode');
        const barcodeInput = document.getElementById('barcode');
        const barcodeFeedback = document.getElementById("barcode-feedback");
        const barcodeFormatFeedback = document.getElementById("barcode-format-feedback");
        const barcodeValidFeedback = document.getElementById("barcode-valid-feedback");
        const currentProductId = "{{ $product->id }}";

        if (generateBarcodeBtn && barcodeInput) {
            generateBarcodeBtn.addEventListener('click', function() {
                 fetch('{{ route('products.generateBarcode') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            barcodeInput.value = data.barcode;
                            checkBarcode();
                        } else { console.error('Error generating barcode'); }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }

        window.checkBarcode = function() {
            if (!barcodeInput || !barcodeFeedback || !barcodeFormatFeedback || !barcodeValidFeedback) return;
            let barcode = barcodeInput.value.trim();
            
            barcodeFeedback.classList.add("d-none");
            barcodeFormatFeedback.classList.add("d-none");
            barcodeValidFeedback.classList.add("d-none");
            barcodeInput.classList.remove("is-invalid", "is-valid");

            if (barcode === "") return;

            if (!/^[0-9]{8,13}$/.test(barcode)) {
                barcodeFormatFeedback.textContent = '{{ __("products.invalid_barcode_format_message") }}';
                barcodeFormatFeedback.classList.remove("d-none");
                barcodeInput.classList.add("is-invalid");
                return;
            }
            fetch(`{{ url('products/check-barcode') }}/${barcode}?product_id=${currentProductId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        barcodeFeedback.textContent = data.message || '{{ __("products.This barcode already exists!") }}';
                        barcodeFeedback.classList.remove("d-none");
                        barcodeInput.classList.add("is-invalid");
                    } else if (data.valid_format === false) {
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
        };
        if(barcodeInput) barcodeInput.addEventListener('input', checkBarcode); // Check on input as well
        checkBarcode(); // Initial check on page load for existing barcode

        // Price vs Cost Check
        const costInput = document.getElementById('cost');
        const priceInput = document.getElementById('price');
        const priceFeedback = document.getElementById('price-feedback');
        if (costInput && priceInput && priceFeedback) {
            const validatePriceVsCost = function() {
                const cost = parseFloat(costInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                if (price > 0 && cost > 0 && price < cost) {
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
        function setupImagePreviewLogic(inputId, currentImagePreviewContainerId, newImagePreviewId, cancelNewImageButtonId, removeCurrentImageCheckboxId, newFileNameDisplayId) {
            const fileInput = document.getElementById(inputId);
            const currentImageContainer = currentImagePreviewContainerId ? document.getElementById(currentImagePreviewContainerId) : null;
            const newPreviewImg = document.getElementById(newImagePreviewId);
            const newPreviewWrapper = newPreviewImg ? newPreviewImg.parentElement : null;
            const cancelNewImageBtn = document.getElementById(cancelNewImageButtonId);
            const removeCurrentImageChk = removeCurrentImageCheckboxId ? document.getElementById(removeCurrentImageCheckboxId) : null;
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
                            if (currentImageContainer) {
                                currentImageContainer.classList.add('d-none');
                            }
                            if (removeCurrentImageChk) {
                                removeCurrentImageChk.checked = false;
                            }
                        }
                    } else {
                        if (newPreviewWrapper) newPreviewWrapper.classList.add('d-none');
                        if (newPreviewImg) { newPreviewImg.src = '#'; newPreviewImg.classList.remove('d-none'); }
                        if (newFileNameDisplay) { newFileNameDisplay.textContent = ''; newFileNameDisplay.classList.add('d-none'); }
                        if (currentImageContainer) currentImageContainer.classList.remove('d-none');
                    }
                });
            }

            if (cancelNewImageBtn) {
                cancelNewImageBtn.addEventListener('click', function() {
                    fileInput.value = '';
                    if (newPreviewWrapper) newPreviewWrapper.classList.add('d-none');
                    if (newPreviewImg) { newPreviewImg.src = '#'; newPreviewImg.classList.remove('d-none'); }
                    if (newFileNameDisplay) { newFileNameDisplay.textContent = ''; newFileNameDisplay.classList.add('d-none'); }
                    if (currentImageContainer) currentImageContainer.classList.remove('d-none');
                });
            }

            if (removeCurrentImageChk && currentImageContainer) {
                removeCurrentImageChk.addEventListener('change', function() {
                    if (this.checked) {
                        if (fileInput.value) {
                            fileInput.value = '';
                            if (newPreviewWrapper) newPreviewWrapper.classList.add('d-none');
                            if (newPreviewImg) { newPreviewImg.src = '#'; newPreviewImg.classList.remove('d-none'); }
                            if (newFileNameDisplay) { newFileNameDisplay.textContent = ''; newFileNameDisplay.classList.add('d-none'); }
                        }
                        // When checked, the current image container should remain visible to show it's marked for removal,
                        // or you can add a specific style to indicate removal.
                        // currentImageContainer.classList.remove('d-none'); 
                    }
                });
            }
        }
        
        setupImagePreviewLogic('image','image_preview_container_current', 'new_image_preview_display', 'cancel_new_image_selection', 'remove_image');
        setupImagePreviewLogic('scan_id', 'scan_id_preview_container_current', 'new_scan_id_preview_display', 'cancel_new_scan_id_selection', 'remove_scan_id');
        setupImagePreviewLogic('scan_documents', 'scan_documents_preview_container_current', 'new_scan_documents_preview_display', 'cancel_new_scan_documents_selection', 'remove_scan_documents', 'new_scan_documents_file_name_display');

        // AJAX for Modals (Add Category, Brand)
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
                            selectElement.dispatchEvent(new Event('change'));
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

        // Print Barcode Modal Logic (similar to create.blade.php)
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
</script>
@endsection

    <style>
        #kt_ecommerce_add_product_details:not(.show) {
            display: none !important;
            height: 0 !important;
            overflow: hidden !important;
        }
    </style>

@endsection
