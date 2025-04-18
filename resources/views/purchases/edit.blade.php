@extends('layouts.app')

@section('title', '- ' . __('purchases.edit_purchase'))

@section('content')
    <!-- Toolbar -->
    <div class="app-toolbar py-3 py-lg-6">
        <div class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('purchases.edit_purchase') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('dashboard.Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('purchases.index') }}" class="text-muted text-hover-primary">{{ __('purchases.purchases') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('purchases.edit_purchase') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content flex-column-fluid">
        <div class="app-container container-xxl">
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                    <i class="bi bi-exclamation-circle fs-2hx text-danger me-4"></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-danger">{{ __('purchases.error') }}</h4>
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <i class="bi bi-x fs-1 text-danger"></i>
                    </button>
                </div>
            @endif

            <form id="kt_purchase_edit_form" action="{{ route('purchases.update', $purchase->id) }}" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                @method('PUT')
                
                <!-- Basic Info Card -->
                <div class="card card-flush mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('purchases.basic_information') }}</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <!-- Invoice Number -->
                            <div class="col-md-6 mb-7">
                                <label class="required form-label">{{ __('purchases.invoice_number') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-receipt fs-4"></i>
                                    </span>
                                    <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" 
                                           name="invoice_number" value="{{ old('invoice_number', $purchase->invoice_number) }}" required readonly
                                           placeholder="{{ __('purchases.invoice_number') }}" />
                                </div>
                                @error('invoice_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Purchase Date -->
                            <div class="col-md-6 mb-7">
                                <label class="required form-label">{{ __('purchases.purchase_date') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-calendar-date fs-4"></i>
                                    </span>
                                    <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                           name="purchase_date" value="{{ old('purchase_date', \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d')) }}" required />
                                </div>
                                @error('purchase_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Supplier -->
                            <div class="col-md-6 mb-7">
                                <label class="required form-label">{{ __('purchases.supplier_name') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-badge fs-4"></i>
                                    </span>
                                    <select class="form-select @error('supplier_id') is-invalid @enderror" name="supplier_id" required>
                                        <option value="">{{ __('purchases.select_supplier') }}</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('supplier_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Invoice File -->
                            <div class="col-md-6 mb-7">
                                <label class="form-label">{{ __('purchases.invoice_file') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-file-earmark-text fs-4"></i>
                                    </span>
                                    <input type="file" class="form-control @error('invoice_file') is-invalid @enderror" 
                                           name="invoice_file" accept=".pdf,.jpeg,.jpg,.png" />
                                </div>
                                @if($purchase->invoice_file)
                                    <div class="d-flex align-items-center mt-2">
                                        <i class="bi bi-paperclip me-2"></i>
                                        <a href="{{ asset('/invoices/' . $purchase->invoice_file) }}" target="_blank" class="text-hover-primary">
                                            {{ __('purchases.view_current_file') }}
                                        </a>
                                    </div>
                                @endif
                                @error('invoice_file')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Card -->
                <div class="card card-flush mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('purchases.products_list') }}</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="products-container">
                            @foreach ($purchase->purchaseItems as $index => $item)
                                <div class="product-item card card-dashed mb-5" data-index="{{ $index }}">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ __('purchases.product') }} #{{ $index + 1 }}</h3>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-product">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <label class="required form-label">{{ __('purchases.product_name') }}</label>
                                                <select class="form-select product-select" name="products[{{ $index }}][product_id]" required>
                                                    <option value="">{{ __('purchases.select_product') }}</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" 
                                                                data-price="{{ $product->purchase_price }}"
                                                                data-unit="{{ $product->unit }}"
                                                                {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="required form-label">{{ __('purchases.quantity') }}</label>
                                                <input type="number" 
                                                       class="form-control quantity" 
                                                       name="products[{{ $index }}][quantity]" 
                                                       value="{{ $item->quantity }}"
                                                       min="1" 
                                                       required />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="required form-label">{{ __('purchases.unit_price') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" 
                                                           class="form-control unit-price" 
                                                           name="products[{{ $index }}][price]" 
                                                           value="{{ $item->price }}"
                                                           step="0.01"
                                                           min="0"
                                                           required />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">{{ __('purchases.total_price') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" 
                                                           class="form-control total-price" 
                                                           value="{{ $item->quantity * $item->price }}"
                                                           readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Add Product Button - Moved to bottom -->
                        <div class="text-center mt-5">
                            <button type="button" class="btn btn-light-primary" id="add-product-btn">
                                <i class="bi bi-plus-circle me-2"></i>
                                {{ __('purchases.add_product') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-light">
                        <i class="bi bi-x me-2"></i>
                        {{ __('purchases.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check me-2"></i>
                        {{ __('purchases.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    // Initialize after DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize variables
        const productsContainer = document.getElementById('products-container');
        const addProductBtn = document.getElementById('add-product-btn');
        
        // Add Product Button Click Handler
        if (addProductBtn) {
            addProductBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Add product button clicked');
                addNewProduct();
            });
        }

        // Remove Product Button Click Handler - Using Event Delegation
        document.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-product');
            if (removeBtn) {
                e.preventDefault();
                console.log('Remove product button clicked');
                const productRow = removeBtn.closest('.product-item');
                if (productRow) {
                    productRow.remove();
                    updateProductNumbers();
                    calculateAllTotals();
                }
            }
        });

        // Product Select Change Handler - Using Event Delegation
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                console.log('Product select changed');
                const selectedOption = e.target.options[e.target.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                const row = e.target.closest('.product-item');
                if (row && price) {
                    const priceInput = row.querySelector('.unit-price');
                    if (priceInput) {
                        priceInput.value = price;
                        calculateRowTotal(row);
                    }
                }
            }
        });

        // Quantity and Price Change Handler - Using Event Delegation
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity') || e.target.classList.contains('unit-price')) {
                console.log('Quantity or price changed');
                const row = e.target.closest('.product-item');
                if (row) {
                    calculateRowTotal(row);
                }
            }
        });

        // Function to add new product
        function addNewProduct() {
            const index = document.querySelectorAll('.product-item').length;
            console.log('Adding new product with index:', index);

            const template = `
                <div class="product-item card card-dashed mb-5" data-index="${index}">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('purchases.product') }} #${index + 1}</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-icon btn-light-danger remove-product">
                                <i class="bi bi-trash fs-5"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <label class="required form-label">{{ __('purchases.product_name') }}</label>
                                <select class="form-select product-select" name="products[${index}][product_id]" required>
                                    <option value="">{{ __('purchases.select_product') }}</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                                data-price="{{ $product->purchase_price }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="required form-label">{{ __('purchases.quantity') }}</label>
                                <input type="number" 
                                       class="form-control quantity" 
                                       name="products[${index}][quantity]" 
                                       value="1"
                                       min="1" 
                                       required />
                            </div>
                            <div class="col-md-3">
                                <label class="required form-label">{{ __('purchases.unit_price') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           class="form-control unit-price" 
                                           name="products[${index}][price]" 
                                           step="0.01"
                                           min="0"
                                           required />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('purchases.total_price') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           class="form-control total-price" 
                                           readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            productsContainer.insertAdjacentHTML('beforeend', template);
            console.log('New product row added');
        }

        // Calculate total for a single row
        function calculateRowTotal(row) {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
            const total = quantity * unitPrice;
            
            const totalInput = row.querySelector('.total-price');
            if (totalInput) {
                totalInput.value = total.toFixed(2);
                console.log('Row total calculated:', total);
            }
            
            calculateAllTotals();
        }

        // Calculate all totals
        function calculateAllTotals() {
            let total = 0;
            document.querySelectorAll('.total-price').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            
            const totalField = document.getElementById('total_amount');
            if (totalField) {
                totalField.value = total.toFixed(2);
                console.log('Total amount updated:', total);
            }
        }

        // Update product numbers
        function updateProductNumbers() {
            document.querySelectorAll('.product-item').forEach((item, index) => {
                // Update title
                const title = item.querySelector('.card-title');
                if (title) {
                    title.textContent = `{{ __('purchases.product') }} #${index + 1}`;
                }
                
                // Update data index
                item.setAttribute('data-index', index);
                
                // Update input names
                const productSelect = item.querySelector('.product-select');
                const quantityInput = item.querySelector('.quantity');
                const priceInput = item.querySelector('.unit-price');
                
                if (productSelect) productSelect.name = `products[${index}][product_id]`;
                if (quantityInput) quantityInput.name = `products[${index}][quantity]`;
                if (priceInput) priceInput.name = `products[${index}][price]`;
            });
            console.log('Product numbers updated');
        }

        // Initialize existing rows
        document.querySelectorAll('.product-item').forEach(row => {
            calculateRowTotal(row);
        });
        console.log('Initialization complete');
    });
</script>
@endsection
