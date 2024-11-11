@extends('layouts.app')

@section('title', '- ' . __('Create Product'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('Create Product') }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('products.index') }}" class="text-muted text-hover-primary">{{ __('All Products') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('Create') }}</li>
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
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">{{ __('General') }}</a>
                        </li>
                        <li class="nav-item" id="detailsTab" style="display: none;">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_details">{{ __('Details') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-12">
                                <div class="card card-flush py-4">
                                    <div class="card-header mb-5">
                                        <div class="card-title">
                                            <h2>{{ __('General') }}</h2>
                                        </div>
                                        <div class="card-title">
                                            <h2 class="me-5">{{ __('Is This A Device?') }}</h2>
                                            <input type="checkbox" class="form-check-input me-2" id="is_mobile" name="is_mobile">
                                            <label class="form-check-label" for="is_mobile">{{ __('Yes') }}</label>
                                        </div>
                                    </div>
                                    <div class="card-body row pt-0">
                                        <div class="mb-10 col-md-4">
                                            <label class="form-label">{{ __('Name') }}</label>
                                            <input type="text" class="form-control mb-2" id="name" name="name" required>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Code') }}</label>
                                            <input type="text" class="form-control mb-2" id="code" name="code" required>
                                        </div>
                                        <div class="mb-10 col-md-5">
                                            <label class="form-label">{{ __('Barcode') }}</label>
                                            <div class="input-group d-flex align-items-center">
                                                <input type="text" class="form-control mb-2" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" id="barcode" name="barcode" required>
                                                <button type="button" class="btn btn-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: -1px; margin-top: -7px;" id="generateBarcode">{{ __('Generate') }}</button>
                                                <button type="button" class="btn btn-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: -1px; margin-top: -7px;" id="printBarcode">{{ __('Print') }}</button>
                                            </div>
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('Stock') }}</label>
                                            <input type="number" class="form-control mb-2" id="quantity" name="quantity" required>
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('Stock Alert') }}</label>
                                            <input type="number" class="form-control mb-2" id="stock_alert" name="stock_alert" required>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Cost') }}</label>
                                            <input type="number" class="form-control mb-2" id="cost" name="cost" step="0.01" required>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Price') }}</label>
                                            <input type="number" class="form-control mb-2" id="price" name="price" step="0.01" required>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Wholesale Price') }}</label>
                                            <input type="number" class="form-control mb-2" id="wholesale_price" name="wholesale_price" step="0.01" required>
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Lowest Price For Sale') }}</label>
                                            <input type="number" class="form-control mb-2" id="min_sale_price" name="min_sale_price" step="0.01" required>
                                        </div>
                                        <div class="mb-10 col-md-12">
                                            <label class="form-label">{{ __('Description') }}</label>
                                            <textarea class="form-control mb-2 min-h-100px" id="description" name="description"></textarea>
                                        </div>
                                        <div class="mb-10 col-md-4">
                                            <label class="form-label">{{ __('Image') }}</label>
                                            <input type="file" class="form-control mb-2" id="image" name="image" step="0.01" required>
                                        </div>
                                        <div class="mb-10 col-md-4">
                                            <label class="form-label d-block">{{ __('Category') }}</label>
                                            <select class="form-select w-75 d-inline-block" id="category_id" name="category_id" required>
                                                <option value="">{{ __('Choose Category') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-primary" style="margin-top: -2px;" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                                {{ __('Add') }}
                                            </button>
                                        </div>
                                        <div class="mb-10 col-md-4">
                                            <label class="form-label d-block">{{ __('Brand') }}</label>
                                            <select class="form-select w-75 d-inline-block" id="brand_id" name="brand_id" required>
                                                <option value="">{{ __('Choose Brand') }}</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-primary" style="margin-top: -2px;" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                                                {{ __('Add') }}
                                            </button>
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
                                            <h2>{{ __('Device Details') }}</h2>
                                        </div>
                                    </div>
                                    <div class="card-body row pt-0">
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Color') }}</label>
                                            <input type="text" class="form-control mb-2" id="color" name="color">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Storage') }}</label>
                                            <input type="text" class="form-control mb-2" id="storage" name="storage">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Battery Health') }}</label>
                                            <input type="number" class="form-control mb-2" id="battery_health" name="battery_health" min="0" max="100">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('RAM') }}</label>
                                            <input type="text" class="form-control mb-2" id="ram" name="ram">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('CPU') }}</label>
                                            <input type="text" class="form-control mb-2" id="cpu" name="cpu">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('GPU') }}</label>
                                            <input type="text" class="form-control mb-2" id="gpu" name="gpu">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Condition') }}</label>
                                            <input type="text" class="form-control mb-2" id="condition" name="condition">
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('With Box') }}</label>
                                            <select class="form-select mb-2" id="has_box" name="has_box">
                                                <option value="">{{ __('Choose') }}</option>
                                                <option value="1">{{ __('Yes') }}</option>
                                                <option value="0">{{ __('No') }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-10 col-md-12">
                                            <label class="form-label">{{ __('Device Description') }}</label>
                                            <textarea class="form-control mb-2 min-h-100px" id="device_description" name="device_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success me-3">{{ __('Save') }}</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            document.getElementById('is_mobile').addEventListener('change', function() {
                var detailsTab = document.getElementById('detailsTab');
                detailsTab.style.display = this.checked ? 'block' : 'none';
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

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">{{ __('Add New Category') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="category_name" class="form-label">{{ __('Category Name') }}</label>
                            <input type="text" class="form-control" id="category_name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">{{ __('Add New Brand') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBrandForm">
                        @csrf
                        <div class="mb-3">
                            <label for="brand_name" class="form-label">{{ __('Brand Name') }}</label>
                            <input type="text" class="form-control" id="brand_name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="printOptionsModal" tabindex="-1" aria-labelledby="printOptionsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printOptionsLabel">Print Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="paperSize">Select Labels per Sheet</label>
                        <select class="form-select" id="paperSize" required>
                            <option value="40">40 per sheet (A4)</option>
                            <option value="30">30 per sheet (A4)</option>
                            <option value="24">24 per sheet (A4)</option>
                            <option value="20">20 per sheet (A4)</option>
                            <option value="18">18 per sheet (A4)</option>
                            <option value="14">14 per sheet (A4)</option>
                            <option value="12">12 per sheet (A4)</option>
                            <option value="10">10 per sheet (A4)</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    <div class="form-group" id="customLabelCountContainer" style="display: none;">
                        <label for="customLabelCount">Enter custom number of labels per page (1-40):</label>
                        <input type="number" id="customLabelCount" min="1" max="40" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="labelContent" class="form-label">Label Content</label>
                        <input type="text" class="form-control" id="labelContent" placeholder="Enter content to appear on the label" value="Product Name, Price, and Barcode" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPrint">Print</button>
                </div>
            </div>
        </div>
    </div>

@endsection
