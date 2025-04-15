@extends('layouts.app')

@section('title', '- ' . __('products.product_details'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('products.all_products') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('products.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('products.all_products') }}</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $product->name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="d-flex justify-content-end">
                <a href="{{ route('products.index') }}" class="btn btn-dark me-5">{{ __('products.back') }}</a>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning me-5">{{ __('products.edit') }}</a>
            </div>
            <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row">
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <div class="card card-flush py-3">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('products.product_image') }}</h2>
                            </div>
                        </div>
                        <div class="card-body text-center pt-0">
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                @if(empty($product->image))
                                    <div class="image-input-wrapper w-150px h-150px" id="noImageLottie"></div>
                                @else
                                    <div class="image-input-wrapper w-150px h-150px" style="background-image: url({{ asset('storage/' . $product->image) }})"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($product->barcode)
                        <div class="card card-flush py-3">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('products.product_barcode') }}</h2>
                                </div>
                            </div>
                            <div class="card-body text-center pt-0">
                                <div class="d-inline-block mw-150px overflow-hidden text-center">
                                    {!! (new \Picqer\Barcode\BarcodeGeneratorHTML())->getBarcode($product->barcode, \Picqer\Barcode\BarcodeGeneratorHTML::TYPE_CODE_128) !!}
                                </div>
                                <div class="mt-2">
                                    <strong>{{ $product->barcode }}</strong>
                                </div>
                                <div class="mt-3">
                                    <button id="printBarcode" type="button" class="btn btn-icon btn-primary">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($product->qrcode)
                        <div class="card card-flush py-3">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('products.product_qrcode') }}</h2>
                                </div>
                            </div>
                            <div class="card-body text-center pt-0">
                                <div class="d-inline-block mw-150px overflow-hidden text-center" style="border: 2px solid #ddd; padding: 10px; border-radius: 10px;">
                                    <img id="qrcode-image" src="{{ asset('storage/' . $product->qrcode) }}" alt="QR Code" style="max-width: 100%; height: auto;">
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-icon btn-primary me-2" onclick="downloadQRCode()">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button id="printQRButton" type="button" class="btn btn-icon btn-secondary">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card card-flush py-3">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('products.category') }}</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->category->name ?? __('products.empty_field') }}" readonly />
                        </div>
                    </div>
                    <div class="card card-flush py-3">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('products.brand') }}</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->brand->name ?? __('products.empty_field') }}" readonly />
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">{{ __('products.general_information') }}</a>
                        </li>
                        @if($product->mobileDetail && !empty($product->mobileDetail->id))
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_advanced">{{ __('products.device_details') }}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_warehouses">{{ __('products.warehouses') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>{{ __('products.general_information') }}</h2>
                                        </div>
                                    </div>
                                    <div class="card-body row pt-0">
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('products.name') }}</label>
                                            <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->name }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('products.barcode') }}</label>
                                            <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->barcode }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.product_cost') }}</label>
                                            <input type="number" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->cost }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.product_price') }}</label>
                                            <input type="number" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->price }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.wholesale_price') }}</label>
                                            <input type="number" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->wholesale_price }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('products.minimum_sale_price') }}</label>
                                            <input type="number" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->min_sale_price }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-12">
                                            <label class="form-label">{{ __('products.product_description') }}</label>
                                            <textarea class="form-control mb-2 min-h-100px" placeholder="{{ __('products.empty_field') }}" readonly>{{ $product->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($product->mobileDetail && !empty($product->mobileDetail->id))
                            <div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
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
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->mobileDetail->color }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('products.storage') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->mobileDetail->storage }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('products.battery_health') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ number_format($product->mobileDetail->battery_health, 0) }}%" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('products.ram') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->mobileDetail->ram }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('products.cpu') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->mobileDetail->cpu }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('products.gpu') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->mobileDetail->gpu }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('products.condition') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->mobileDetail->condition }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('products.with_box') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('products.empty_field') }}" value="{{ $product->mobileDetail->has_box ? __('products.yes') : __('products.no') }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-12">
                                                <label class="form-label">{{ __('products.device_description') }}</label>
                                                <textarea class="form-control mb-2 min-h-100px" placeholder="{{ __('products.empty_field') }}" readonly>{{ $product->mobileDetail->device_description }}</textarea>
                                            </div>
                                            
                                            @if($product->scan_id)
                                            <div class="mb-10 col-md-6">
                                                <label class="form-label">{{ __('products.scan_id') }}</label>
                                                <div class="border rounded p-3 text-center">
                                                    <img src="{{ asset('storage/' . $product->scan_id) }}" alt="{{ __('products.scan_id') }}" class="img-fluid mb-2" style="max-height: 200px;">
                                                    <div class="mt-2">
                                                        <a href="{{ asset('storage/' . $product->scan_id) }}" class="btn btn-sm btn-primary" download>
                                                            <i class="fas fa-download me-1"></i> {{ __('products.download') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            @if($product->scan_documents)
                                            <div class="mb-10 col-md-6">
                                                <label class="form-label">{{ __('products.scan_documents') }}</label>
                                                <div class="border rounded p-3 text-center">
                                                    <img src="{{ asset('storage/' . $product->scan_documents) }}" alt="{{ __('products.scan_documents') }}" class="img-fluid mb-2" style="max-height: 200px;">
                                                    <div class="mt-2">
                                                        <a href="{{ asset('storage/' . $product->scan_documents) }}" class="btn btn-sm btn-primary" download>
                                                            <i class="fas fa-download me-1"></i> {{ __('products.download') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="tab-pane fade" id="kt_ecommerce_add_product_warehouses" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>{{ __('products.warehouse_details') }}</h2>
                                        </div>
                                    </div>
                                    <div class="card-body row pt-0">
                                        <div class="col-md-12">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-150px">{{ __('products.warehouse_name') }}</th>
                                                    <th class="min-w-100px">{{ __('products.stock') }}</th>
                                                    <th class="min-w-100px">{{ __('products.stock_alert') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
                                                @foreach($product->warehouses as $warehouse)
                                                    <tr>
                                                        <td>{{ $warehouse->name }}</td>
                                                        <td>{{ $warehouse->pivot->stock }}</td>
                                                        <td>{{ $warehouse->pivot->stock_alert }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('noImageLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/no-image.json') }}"
                });
            });

            function downloadQRCode() {
                const qrImage = document.getElementById('qrcode-image');
                const link = document.createElement('a');
                link.href = qrImage.src;
                link.download = 'qrcode.png';
                link.click();
            }

            document.getElementById('printQRButton').addEventListener('click', function () {
                const qrImage = document.getElementById('qrcode-image');

                if (!qrImage) {
                    alert("QR Code image not found!");
                    return;
                }

                const printWindow = window.open('', '_blank');
                printWindow.document.open();
                printWindow.document.write(`
        <html>
            <head>
                <title>Print QR Code</title>
                <style>
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                        padding: 0;
                        background-color: #fff;
                    }
                    img {
                        max-width: 300px;
                        height: auto;
                        display: block;
                        margin: auto;
                    }
                    p { font-size: 12px; margin: 0; }
                </style>
            </head>
            <body>
                <img src="${qrImage.src}" alt="QR Code">
                <script>
                    window.onload = function() {
                        window.print();
                    };
                <\/script>
            </body>
        </html>
    `);
                printWindow.document.close();
            });

            document.getElementById('printBarcode').addEventListener('click', function() {
                const barcodeValue = "{{ $product->barcode }}";
                if (!barcodeValue) {
                    alert("{{ __('products.barcode_not_found') }}");
                    return;
                }
                
                const printOptionsModal = new bootstrap.Modal(document.getElementById('printOptionsModal'));
                printOptionsModal.show();
            });

            document.getElementById('printOptionsModal').addEventListener('shown.bs.modal', function () {
                const paperSizeSelect = document.getElementById('paperSize');
                const customLabelCountContainer = document.getElementById('customLabelCountContainer');

                paperSizeSelect.addEventListener('change', function () {
                    if (paperSizeSelect.value === 'custom') {
                        customLabelCountContainer.style.display = 'block';
                    } else {
                        customLabelCountContainer.style.display = 'none';
                    }
                });
            });

            document.getElementById('confirmPrint').addEventListener('click', function () {
                const paperSizeSelect = document.getElementById('paperSize');
                const customLabelCount = document.getElementById('customLabelCount');
                let paperSize = paperSizeSelect.value;
                
                if (paperSize === 'custom') {
                    if (customLabelCount.value === '' || customLabelCount.value < 1 || customLabelCount.value > 40) {
                        alert("{{ __('products.please_enter_valid_custom_label_count') }}");
                        return;
                    }
                    paperSize = customLabelCount.value;
                }

                const barcodeValue = "{{ $product->barcode }}";
                const productName = "{{ $product->name }}";
                const productPrice = "{{ $product->price }}";

                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Print Barcode</title>
                        <style>
                            body { display: flex; flex-wrap: wrap; padding: 0; margin: 0; }
                            .label { 
                                width: calc(100% / ${Math.ceil(Math.sqrt(paperSize))}); 
                                text-align: center; 
                                padding: 10px;
                                box-sizing: border-box;
                            }
                            img { max-width: 100%; height: auto; }
                            p { font-size: 12px; margin: 0; }
                        </style>
                    </head>
                    <body>
                        ${Array.from({ length: parseInt(paperSize) }).map((_, index) => `
                            <div class="label">
                                <p>${productName}</p>
                                <img id="barcode-${index}" />
                                <p>${productPrice}</p>
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

                // Cerrar el modal después de imprimir
                const printOptionsModal = bootstrap.Modal.getInstance(document.getElementById('printOptionsModal'));
                printOptionsModal.hide();
            });

            document.getElementById('paperSize').addEventListener('change', function () {
                const customLabelCountContainer = document.getElementById('customLabelCountContainer');
                if (this.value === 'custom') {
                    customLabelCountContainer.style.display = 'block';
                } else {
                    customLabelCountContainer.style.display = 'none';
                }
            });
        </script>
    @endsection
@endsection
