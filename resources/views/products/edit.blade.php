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
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row">
                @csrf
                @method('PUT')

                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-12">
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">{{ __('products.general') }}</a>
                        </li>
                        <li class="nav-item" id="detailsTab" style="display: {{ $product->mobileDetail ? 'block' : 'none' }};">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_details">{{ __('products.details') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-12">
                                <div class="card card-flush py-4">
                                    <div class="card-header mb-5">
                                        <div class="card-title">
                                            <h2>{{ __('products.general') }}</h2>
                                        </div>
                                        <div class="card-title">
                                            <h2 class="me-5">{{ __('products.is_device') }}</h2>
                                            <input type="checkbox" class="form-check-input me-2" id="is_mobile" name="is_mobile" {{ $product->mobileDetail ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_mobile">{{ __('products.yes') }}</label>
                                        </div>
                                    </div>
                                    <div class="card-body row pt-0">
                                        <!-- Name -->
                                        <div class="mb-10 col-md-5">
                                            <label class="form-label">{{ __('products.name') }}</label>
                                            <input type="text" class="form-control mb-2" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                        </div>
                                        <!-- Barcode -->
                                        <div class="mb-10 col-md-7">
                                            <label class="form-label">{{ __('products.barcode') }}</label>
                                            <div class="input-group d-flex align-items-center">
                                                <input type="text" class="form-control mb-2" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}" readonly required>
                                            </div>
                                        </div>
                                        <!-- Warehouses -->
                                        <div class="card py-10 mb-10">
                                            <div class="card-header">
                                                <h4>{{ __('products.assign_stock_to_warehouses') }}</h4>
                                            </div>
                                            <div class="card-body" id="warehouse-container">
                                                @foreach($product->warehouses as $index => $warehouse)
                                                    <div class="input-group mb-2 warehouse-entry">
                                                        <select class="form-select" name="warehouses[{{ $index }}][id]" required>
                                                            <option value="">{{ __('products.select_warehouse') }}</option>
                                                            @foreach($warehouses as $availableWarehouse)
                                                                <option value="{{ $availableWarehouse->id }}" {{ $warehouse->id == $availableWarehouse->id ? 'selected' : '' }}>
                                                                    {{ $availableWarehouse->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" class="form-control" name="warehouses[{{ $index }}][stock]" placeholder="{{ __('products.stock') }}" value="{{ $warehouse->pivot->stock }}" required>
                                                        <input type="number" class="form-control" name="warehouses[{{ $index }}][stock_alert]" placeholder="{{ __('products.stock_alert') }}" value="{{ $warehouse->pivot->stock_alert }}" required>
                                                        <button type="button" class="btn btn-danger remove-warehouse" data-warehouse-id="{{ $warehouse->id }}" data-product-id="{{ $product->id }}">{{ __('products.remove') }}</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" id="add-warehouse" class="btn btn-primary">{{ __('products.add_warehouse') }}</button>
                                        </div>
                                        <!-- Cost -->
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.cost') }}</label>
                                            <input type="number" class="form-control mb-2" id="cost" name="cost" value="{{ old('cost', $product->cost) }}" step="0.01" required>
                                        </div>
                                        <!-- Price -->
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.price') }}</label>
                                            <input type="number" class="form-control mb-2" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" required>
                                        </div>
                                        <!-- Wholesale Price -->
                                        <div class="mb-5 col-md-3">
                                            <label class="form-label">{{ __('products.wholesale_price') }}</label>
                                            <input type="number" class="form-control" id="wholesale_price" name="wholesale_price" value="{{ old('wholesale_price', $product->wholesale_price) }}" required>
                                        </div>
                                        <!-- Minimum Sale Price -->
                                        <div class="mb-5 col-md-3">
                                            <label class="form-label">{{ __('products.lowest_price_for_sale') }}</label>
                                            <input type="number" class="form-control" id="min_sale_price" name="min_sale_price" value="{{ old('min_sale_price', $product->min_sale_price) }}" required>
                                        </div>
                                        <!-- Description -->
                                        <div class="mb-5 col-md-12">
                                            <label class="form-label">{{ __('products.description') }}</label>
                                            <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                        <!-- Image -->
                                        <div class="mb-5 col-md-4">
                                            <label class="form-label">{{ __('products.image') }}</label>
                                            <div class="image-upload-container position-relative">
                                                <input type="file" class="form-control" id="image" name="image">
                                                @if($product->image)
                                                    <div class="image-preview mt-3">
                                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                                             class="img-thumbnail"
                                                             style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                        <div class="image-actions text-center mt-2">
                                                            <button type="button" class="btn btn-danger btn-sm delete-image" data-image-type="image" data-product-id="{{ $product->id }}">{{ __('products.delete') }}</button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="text-muted mt-2">{{ __('products.no_image_uploaded') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-5 col-md-4">
                                            <label class="form-label">{{ __('products.category') }}</label>
                                            <select class="form-select" id="category_id" name="category_id" required>
                                                <option value="">{{ __('products.choose_category') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-5 col-md-4">
                                            <label class="form-label">{{ __('products.brand') }}</label>
                                            <select class="form-select" id="brand_id" name="brand_id" required>
                                                <option value="">{{ __('products.choose_brand') }}</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_ecommerce_add_product_details" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>{{ __('products.device_details') }}</h2>
                                        </div>
                                    </div>
                                    <div class="card-body row pt-0">
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.color') }}</label>
                                            <input type="text" class="form-control mb-2" id="color" name="color"
                                                   value="{{ old('color', $product->mobileDetail->color ?? '') }}">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.storage') }}</label>
                                            <input type="text" class="form-control mb-2" id="storage" name="storage"
                                                   value="{{ old('storage', $product->mobileDetail->storage ?? '') }}">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.battery_health') }}</label>
                                            <input type="number" class="form-control mb-2" id="battery_health" name="battery_health"
                                                   value="{{ old('battery_health', $product->mobileDetail->battery_health ?? '') }}">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.ram') }}</label>
                                            <input type="text" class="form-control mb-2" id="ram" name="ram"
                                                   value="{{ old('ram', $product->mobileDetail->ram ?? '') }}">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.cpu') }}</label>
                                            <input type="text" class="form-control mb-2" id="cpu" name="cpu"
                                                   value="{{ old('cpu', $product->mobileDetail->cpu ?? '') }}">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.gpu') }}</label>
                                            <input type="text" class="form-control mb-2" id="gpu" name="gpu"
                                                   value="{{ old('gpu', $product->mobileDetail->gpu ?? '') }}">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.condition') }}</label>
                                            <input type="text" class="form-control mb-2" id="condition" name="condition"
                                                   value="{{ old('condition', $product->mobileDetail->condition ?? '') }}">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.with_box') }}</label>
                                            <select class="form-select mb-2" id="has_box" name="has_box">
                                                <option value="1" {{ old('has_box', $product->mobileDetail->has_box ?? '') == 1 ? 'selected' : '' }}>
                                                    {{ __('products.yes') }}
                                                </option>
                                                <option value="0" {{ old('has_box', $product->mobileDetail->has_box ?? '') == 0 ? 'selected' : '' }}>
                                                    {{ __('products.no') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-10 col-md-12">
                                            <label class="form-label">{{ __('products.device_description') }}</label>
                                            <textarea class="form-control mb-2 min-h-100px" id="device_description" name="device_description">{{ old('device_description', $product->mobileDetail->device_description ?? '') }}</textarea>
                                        </div>

                                        <div class="mb-10 col-md-4">
                                            <label class="form-label">{{ __('products.payment_method') }}</label>
                                            <select class="form-select" id="payment_method" name="payment_method">
                                                <option value="">{{ __('products.choose_payment_method') }}</option>
                                                <option value="cash" {{ old('payment_method', $product->payment_method) === 'cash' ? 'selected' : '' }}>
                                                    {{ __('products.cash') }}
                                                </option>
                                                <option value="credit" {{ old('payment_method', $product->payment_method) === 'credit' ? 'selected' : '' }}>
                                                    {{ __('products.credit') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-5 col-md-4">
                                            <label class="form-label">{{ __('products.scan_id') }}</label>
                                            <div class="image-upload-container position-relative">
                                                <input type="file" class="form-control" id="scan_id" name="scan_id">
                                                @if($product->scan_id)
                                                    <div class="image-preview mt-3">
                                                        <img src="{{ Storage::url($product->scan_id) }}" alt="{{ __('products.scan_id') }}"
                                                             class="img-thumbnail"
                                                             style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                        <div class="image-actions text-center mt-2">
                                                            <button type="button" class="btn btn-danger btn-sm delete-image" data-image-type="scan_id" data-product-id="{{ $product->id }}">
                                                                {{ __('products.delete') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="text-muted mt-2">{{ __('products.no_image_uploaded') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-5 col-md-4">
                                            <label class="form-label">{{ __('products.scan_documents') }}</label>
                                            <div class="image-upload-container position-relative">
                                                <input type="file" class="form-control" id="scan_documents" name="scan_documents">
                                                @if($product->scan_documents)
                                                    <div class="image-preview mt-3">
                                                        <img src="{{ Storage::url($product->scan_documents) }}" alt="{{ __('products.scan_documents') }}"
                                                             class="img-thumbnail"
                                                             style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                                        <div class="image-actions text-center mt-2">
                                                            <button type="button" class="btn btn-danger btn-sm delete-image" data-image-type="scan_documents" data-product-id="{{ $product->id }}">
                                                                {{ __('products.delete') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="text-muted mt-2">{{ __('products.no_image_uploaded') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-10 col-md-4">
                                            <label class="form-label">{{ __('products.client_type') }}</label>
                                            <select class="form-select" id="client_type" name="client_type">
                                                <option value="">{{ __('products.choose_client_type') }}</option>
                                                <option value="customer" {{ old('client_type', $product->client_type) === 'customer' ? 'selected' : '' }}>
                                                    {{ __('products.customer') }}
                                                </option>
                                                <option value="supplier" {{ old('client_type', $product->client_type) === 'supplier' ? 'selected' : '' }}>
                                                    {{ __('products.supplier') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-10 col-md-4" id="customer_section" style="display: none;">
                                            <label class="form-label">{{ __('products.select_customer') }}</label>
                                            <select class="form-select" id="customer_id" name="customer_id">
                                                <option value="">{{ __('products.choose_customer') }}</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ old('customer_id', $product->customer_id) == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-10 col-md-4" id="supplier_section" style="display: none;">
                                            <label class="form-label">{{ __('products.select_supplier') }}</label>
                                            <select class="form-select" id="supplier_id" name="supplier_id">
                                                <option value="">{{ __('products.choose_supplier') }}</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

            document.addEventListener('DOMContentLoaded', function () {
                const addWarehouseButton = document.getElementById('add-warehouse');
                const warehouseContainer = document.getElementById('warehouse-container');
                let warehouseIndex = {{ count($product->warehouses) }};

                addWarehouseButton.addEventListener('click', function () {
                    const newEntry = document.createElement('div');
                    newEntry.classList.add('input-group', 'mb-2', 'warehouse-entry');

                    newEntry.innerHTML = `
            <select class="form-select" name="warehouses[${warehouseIndex}][id]" required>
                <option value="">{{ __('products.select_warehouse') }}</option>
                @foreach($warehouses as $availableWarehouse)
                    <option value="{{ $availableWarehouse->id }}">{{ $availableWarehouse->name }}</option>
                @endforeach
                    </select>
                    <input type="number" class="form-control" name="warehouses[${warehouseIndex}][stock]" placeholder="{{ __('products.stock') }}" required>
            <input type="number" class="form-control" name="warehouses[${warehouseIndex}][stock_alert]" placeholder="{{ __('products.stock_alert') }}" required>
            <button type="button" class="btn btn-danger remove-warehouse">{{ __('products.remove') }}</button>
        `;

                    warehouseContainer.appendChild(newEntry);

                    warehouseIndex++;

                    newEntry.querySelector('.remove-warehouse').addEventListener('click', function () {
                        newEntry.remove();
                    });
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                const removeButtons = document.querySelectorAll('.remove-warehouse');

                removeButtons.forEach((button) => {
                    button.addEventListener('click', function () {
                        const warehouseId = this.getAttribute('data-warehouse-id');
                        const productId = this.getAttribute('data-product-id');
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        if (confirm('Are you sure you want to remove this warehouse?')) {
                            fetch(`/products/${productId}/remove-warehouse/${warehouseId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json',
                                },
                            })
                                .then((response) => response.json())
                                .then((data) => {
                                    if (data.success) {
                                        alert(data.message);
                                        location.reload();
                                    } else {
                                        alert(data.message || 'Error removing warehouse.');
                                    }
                                })
                                .catch((error) => console.error('Error:', error));
                        }
                    });
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                const paymentMethodSelect = document.getElementById('payment_method');
                const clientTypeSelect = document.getElementById('client_type');
                const customerSection = document.getElementById('customer_section');
                const supplierSection = document.getElementById('supplier_section');

                // Function to toggle client type based on payment method
                function toggleClientTypeBasedOnPayment() {
                    if (paymentMethodSelect.value === 'credit') {
                        clientTypeSelect.value = 'supplier';
                        clientTypeSelect.setAttribute('disabled', true);
                        customerSection.style.display = 'none';
                        supplierSection.style.display = 'block';
                    } else {
                        clientTypeSelect.removeAttribute('disabled');
                        clientTypeSelect.value = '';
                        customerSection.style.display = 'none';
                        supplierSection.style.display = 'none';
                    }
                }

                toggleClientTypeBasedOnPayment();

                paymentMethodSelect.addEventListener('change', toggleClientTypeBasedOnPayment);
            });

            document.addEventListener('DOMContentLoaded', function () {
                const deleteButtons = document.querySelectorAll('.delete-image');

                deleteButtons.forEach((button) => {
                    button.addEventListener('click', function () {
                        const imageType = this.getAttribute('data-image-type');
                        const productId = this.getAttribute('data-product-id');
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        if (confirm('Are you sure you want to delete this image?')) {
                            fetch(`/products/${productId}/delete-image`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    image_type: imageType,
                                }),
                            })
                                .then((response) => response.json())
                                .then((data) => {
                                    if (data.success) {
                                        alert(data.message);
                                        location.reload(); // Reload to reflect changes
                                    } else {
                                        alert(data.message || 'Error deleting image.');
                                    }
                                })
                                .catch((error) => console.error('Error:', error));
                        }
                    });
                });
            });

        </script>
    @endsection
@endsection
