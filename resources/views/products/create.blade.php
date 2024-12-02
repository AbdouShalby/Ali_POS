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
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">{{ __('products.general') }}</a>
                        </li>
                        <li class="nav-item" id="detailsTab" style="display: none;">
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
                                            <input type="checkbox" class="form-check-input me-2" id="is_mobile" name="is_mobile">
                                            <label class="form-check-label" for="is_mobile">{{ __('products.yes') }}</label>
                                        </div>
                                    </div>
                                    <div class="card-body row pt-0">
                                        <div class="mb-10 col-md-5">
                                            <label class="form-label">{{ __('products.name') }}</label>
                                            <input type="text" class="form-control mb-2" id="name" name="name" required>
                                        </div>
                                        <div class="mb-10 col-md-7">
                                            <label class="form-label">{{ __('products.barcode') }}</label>
                                            <div class="input-group d-flex align-items-center">
                                                <input type="text" class="form-control mb-2" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" id="barcode" name="barcode" readonly required>
                                                <button type="button" class="btn btn-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: -1px; margin-top: -7px;" id="generateBarcode">{{ __('products.generate') }}</button>
                                                <button type="button" class="btn btn-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: -1px; margin-top: -7px;" id="printBarcode">{{ __('products.print') }}</button>
                                            </div>
                                        </div>
                                        <div class="mb-10 col-md-4">
                                            <label class="form-label">{{ __('products.stock') }}</label>
                                            <input type="number" class="form-control mb-2" id="quantity" name="quantity" value="1" required>
                                        </div>
                                        <div class="mb-10 col-md-4">
                                            <label class="form-label">{{ __('products.stock_alert') }}</label>
                                            <input type="number" class="form-control mb-2" id="stock_alert" name="stock_alert" value="1" required>
                                        </div>
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <h2>{{ __('products.warehouse_stock') }}</h2>
                                            </div>
                                            <div class="card-body row pt-0">
                                                @foreach($warehouses as $warehouse)
                                                    <div class="mb-10 col-md-4">
                                                        <label class="form-label">{{ $warehouse->name }}</label>
                                                        <input type="number" class="form-control mb-2" name="warehouses[{{ $warehouse->id }}]"
                                                               value="{{ old('warehouses.' . $warehouse->id, $product->warehouses->find($warehouse->id)->pivot->stock ?? 0) }}"
                                                               placeholder="{{ __('products.stock_in_warehouse') }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.cost') }}</label>
                                            <input type="number" class="form-control mb-2" id="cost" name="cost" step="0.01" value="0" required>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.price') }}</label>
                                            <input type="number" class="form-control mb-2" id="price" name="price" step="0.01" value="0" required>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.wholesale_price') }}</label>
                                            <input type="number" class="form-control mb-2" id="wholesale_price" name="wholesale_price" step="0.01" value="0" required>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.lowest_price_for_sale') }}</label>
                                            <input type="number" class="form-control mb-2" id="min_sale_price" name="min_sale_price" step="0.01" value="0" required>
                                        </div>
                                        <div class="mb-10 col-md-12">
                                            <label class="form-label">{{ __('products.description') }}</label>
                                            <textarea class="form-control mb-2 min-h-100px" id="description" name="description"></textarea>
                                        </div>
                                        <div class="mb-10 col-md-4">
                                            <label class="form-label">{{ __('products.image') }}</label>
                                            <input type="file" class="form-control mb-2" id="image" name="image">
                                        </div>
                                        <div class="mb-10 col-md-4">
                                            <label class="form-label">{{ __('products.category') }}</label>
                                            <div class="d-flex align-items-center">
                                                <select class="form-select me-2" id="category_id" name="category_id" required>
                                                    <option value="">{{ __('products.choose_category') }}</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                                                    {{ __('products.add') }}
                                                </button>
                                            </div>
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
                                            <input type="text" class="form-control mb-2" id="color" name="color">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.storage') }}</label>
                                            <input type="text" class="form-control mb-2" id="storage" name="storage">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.battery_health') }}</label>
                                            <input type="number" class="form-control mb-2" id="battery_health" name="battery_health" min="0" max="100" value="0">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.ram') }}</label>
                                            <input type="text" class="form-control mb-2" id="ram" name="ram">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.cpu') }}</label>
                                            <input type="text" class="form-control mb-2" id="cpu" name="cpu">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.gpu') }}</label>
                                            <input type="text" class="form-control mb-2" id="gpu" name="gpu">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.condition') }}</label>
                                            <input type="text" class="form-control mb-2" id="condition" name="condition">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.with_box') }}</label>
                                            <select class="form-select mb-2" id="has_box" name="has_box">
                                                <option value="">{{ __('products.choose') }}</option>
                                                <option value="1">{{ __('products.yes') }}</option>
                                                <option value="0">{{ __('products.no') }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-10 col-md-12">
                                            <label class="form-label">{{ __('products.device_description') }}</label>
                                            <textarea class="form-control mb-2 min-h-100px" id="device_description" name="device_description"></textarea>
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('products.payment_method') }}</label>
                                            <select class="form-select" id="payment_method" name="payment_method">
                                                <option value="">{{ __('products.choose_payment_method') }}</option>
                                                <option value="cash">{{ __('products.cash') }}</option>
                                                <option value="credit">{{ __('products.credit') }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('products.seller_name') }}</label>
                                            <input type="text" class="form-control" id="seller_name" name="seller_name" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('products.scan_id') }}</label>
                                            <input type="file" class="form-control" id="scan_id" name="scan_id">
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('products.scan_documents') }}</label>
                                            <input type="file" class="form-control" id="scan_documents" name="scan_documents">
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('products.client_type') }}</label>
                                            <select class="form-select" id="client_type" name="client_type">
                                                <option value="">{{ __('products.choose_client_type') }}</option>
                                                <option value="customer">{{ __('products.customer') }}</option>
                                                <option value="supplier">{{ __('products.supplier') }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-10 col-md-6" id="customer_section" style="display: none;">
                                            <label class="form-label">{{ __('products.select_customer') }}</label>
                                            <div class="d-flex align-items-center">
                                                <select class="form-select me-2" id="customer_id" name="customer_id">
                                                    <option value="">{{ __('products.choose_customer') }}</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                                    {{ __('products.add') }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-10 col-md-6" id="supplier_section" style="display: none;">
                                            <label class="form-label">{{ __('products.select_supplier') }}</label>
                                            <div class="d-flex align-items-center">
                                                <select class="form-select me-2" id="supplier_id" name="supplier_id">
                                                    <option value="">{{ __('products.choose_supplier') }}</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">{{ __('products.add_new_customer') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">{{ __('products.customer_name') }}</label>
                            <input type="text" class="form-control" id="customer_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">{{ __('products.customer_phone') }}</label>
                            <input type="text" class="form-control" id="customer_phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">{{ __('products.customer_email') }}</label>
                            <input type="email" class="form-control" id="customer_email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">{{ __('products.customer_address') }}</label>
                            <input type="text" class="form-control" id="customer_address" name="address">
                        </div>
                        <button type="button" id="saveCustomer" class="btn btn-primary">{{ __('products.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">{{ __('products.add_new_supplier') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        @csrf
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">{{ __('products.supplier_name') }}</label>
                            <input type="text" class="form-control" id="supplier_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_phone" class="form-label">{{ __('products.supplier_phone') }}</label>
                            <input type="text" class="form-control" id="supplier_phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="supplier_email" class="form-label">{{ __('products.supplier_email') }}</label>
                            <input type="email" class="form-control" id="supplier_email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="supplier_address" class="form-label">{{ __('products.supplier_address') }}</label>
                            <input type="text" class="form-control" id="supplier_address" name="address">
                        </div>
                        <button type="button" class="btn btn-primary" id="saveSupplier">{{ __('products.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.getElementById('is_mobile').addEventListener('change', function() {
                var detailsTab = document.getElementById('detailsTab');
                detailsTab.style.display = this.checked ? 'block' : 'none';
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

            document.getElementById('saveCustomer').addEventListener('click', function () {
                const form = document.getElementById('addCustomerForm');
                const formData = new FormData(form);

                fetch('{{ route('customers.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const customerSelect = document.getElementById('customer_id');
                            const newOption = document.createElement('option');
                            newOption.value = data.customer.id;
                            newOption.textContent = data.customer.name;
                            newOption.selected = true;
                            customerSelect.appendChild(newOption);

                            const modal = bootstrap.Modal.getInstance(document.getElementById('addCustomerModal'));
                            modal.hide();

                            form.reset();
                        } else {
                            console.error(data.message || 'Error saving customer.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            document.getElementById('saveSupplier').addEventListener('click', function () {
                const form = document.getElementById('addSupplierForm');
                const formData = new FormData(form);

                fetch('{{ route('suppliers.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const supplierSelect = document.getElementById('supplier_id');
                            const newOption = document.createElement('option');
                            newOption.value = data.supplier.id;
                            newOption.textContent = data.supplier.name;
                            newOption.selected = true;
                            supplierSelect.appendChild(newOption);

                            const modal = bootstrap.Modal.getInstance(document.getElementById('addSupplierModal'));
                            modal.hide();

                            form.reset();
                        } else {
                            console.error(data.message || 'Error saving supplier.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            document.getElementById('addBrandForm').addEventListener('submit', function (event) {
                event.preventDefault();

                const form = document.getElementById('addBrandForm');
                const formData = new FormData(form);

                fetch('{{ route('brands.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                    .then(response => response.json())
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
                    .catch(error => console.error('Error:', error));
            });

            document.getElementById('addCategoryForm').addEventListener('submit', function (event) {
                event.preventDefault();

                const form = document.getElementById('addCategoryForm');
                const formData = new FormData(form);

                fetch('{{ route('categories.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                    .then(response => response.json())
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
                        } else {
                            alert(data.message || 'Error saving category.');
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

            document.getElementById('generateBarcode').addEventListener('click', function() {
                fetch('{{ route("products.generateBarcode") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('barcode').value = data.barcode;
                        } else {
                            alert('Error generating barcode.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
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
                                <img id="barcode-${index}" />
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
        </script>
    @endsection

@endsection
