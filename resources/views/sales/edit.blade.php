@extends('layouts.app')

@section('title', '- ' . __('sales.edit_sale'))

@section('content')
    <!-- Toolbar -->
    <div class="app-toolbar py-4 py-lg-6" id="kt_app_toolbar">
        <div class="app-container container-xxl d-flex flex-stack flex-wrap gap-4">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('sales.edit_sale') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('dashboard.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('sales.index') }}" class="text-muted text-hover-primary">{{ __('sales.sales') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('sales.edit_sale') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content flex-column-fluid">
        <div class="app-container container-xxl">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <strong>{{ __('sales.error') }}</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form id="edit-sale-form" action="{{ route('sales.update', $sale->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Basic Information Card -->
                <div class="card card-flush mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('sales.basic_information') }}</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-5">
                            <!-- Customer Selection -->
                            <div class="col-md-6">
                                <label class="required form-label">{{ __('sales.customer') }}</label>
                                <select name="customer_id" class="form-select" required>
                                    <option value="">{{ __('sales.select_customer') }}</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sale Date -->
                            <div class="col-md-6">
                                <label class="required form-label">{{ __('sales.sale_date') }}</label>
                                <input type="date" class="form-control" name="sale_date" value="{{ $sale->sale_date ? \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') : '' }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Card -->
                <div class="card card-flush">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('sales.products') }}</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="py-5" id="products-container">
                            @foreach($sale->saleItems as $index => $item)
                                <div class="row product-item mb-5">
                                    <div class="col-md-3">
                                        <label class="required form-label">{{ __('sales.warehouse') }}</label>
                                        <select name="products[{{ $index }}][warehouse_id]" class="form-control warehouse-select" required>
                                            <option value="">{{ __('sales.select_warehouse') }}</option>
                                            @foreach($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" {{ $item->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="required form-label">{{ __('sales.product') }}</label>
                                        <select name="products[{{ $index }}][product_id]" class="form-control product-select" required>
                                            <option value="">{{ __('sales.select_product') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="required form-label">{{ __('sales.quantity') }}</label>
                                        <input type="number" name="products[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ $item->quantity }}" min="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="required form-label">{{ __('sales.unit_price') }}</label>
                                        <input type="number" name="products[{{ $index }}][unit_price]" class="form-control unit-price-input" value="{{ $item->unit_price }}" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">{{ __('sales.total_price') }}</label>
                                        <input type="number" class="form-control total-price-display" value="{{ $item->quantity * $item->unit_price }}" readonly>
                                        <input type="hidden" name="products[{{ $index }}][total_price]" class="total-price-input" value="{{ $item->quantity * $item->unit_price }}">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-sm btn-light-danger delete-product-btn">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add Product Button -->
                        <div class="text-center">
                            <button type="button" id="add-product-btn" class="btn btn-light-primary">
                                <i class="bi bi-plus-circle fs-5 me-2"></i>
                                {{ __('sales.add_product') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-3 mt-7">
                    <a href="{{ route('sales.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left fs-5 me-2"></i>
                        {{ __('sales.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle fs-5 me-2"></i>
                        {{ __('sales.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const productsContainer = $('#products-container');
    const addProductBtn = $('#add-product-btn');
    
    let productCount = {{ $sale->saleItems->count() }};

    // إضافة منتج جديد
    addProductBtn.on('click', function() {
        const newRow = `
            <div class="row product-item mb-5">
                <div class="col-md-3">
                    <label class="required form-label">{{ __('sales.warehouse') }}</label>
                    <select name="products[${productCount}][warehouse_id]" class="form-control warehouse-select" required>
                        <option value="">{{ __('sales.select_warehouse') }}</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="required form-label">{{ __('sales.product') }}</label>
                    <select name="products[${productCount}][product_id]" class="form-control product-select" required>
                        <option value="">{{ __('sales.select_product') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="required form-label">{{ __('sales.quantity') }}</label>
                    <input type="number" name="products[${productCount}][quantity]" class="form-control quantity-input" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <label class="required form-label">{{ __('sales.unit_price') }}</label>
                    <input type="number" name="products[${productCount}][unit_price]" class="form-control unit-price-input" min="0" step="0.01" value="0" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('sales.total_price') }}</label>
                    <input type="number" class="form-control total-price-display" value="0" readonly>
                    <input type="hidden" name="products[${productCount}][total_price]" class="total-price-input" value="0">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-light-danger delete-product-btn">
                        <i class="bi bi-trash fs-5"></i>
                    </button>
                </div>
            </div>
        `;

        productsContainer.append(newRow);
        productCount++;
    });

    // معالجة تغيير المستودع
    productsContainer.on('change', '.warehouse-select', function() {
        const warehouseId = $(this).val();
        const row = $(this).closest('.product-item');
        const productSelect = row.find('.product-select');
        
        if (warehouseId) {
            console.log('Fetching products for warehouse:', warehouseId);
            
            $.ajax({
                url: `/warehouses/${warehouseId}/products`,
                method: 'GET',
                success: function(response) {
                    console.log('API Response:', response);
                    
                    productSelect.html('<option value="">{{ __('sales.select_product') }}</option>');
                    
                    if (Array.isArray(response)) {
                        response.forEach(product => {
                            console.log('Product:', product);
                            const price = product.price || 0;
                            console.log('Price:', price);
                            
                            productSelect.append(`
                                <option value="${product.id}" data-price="${price}">
                                    ${product.name} ({{ __('sales.stock') }}: ${product.stock})
                                </option>
                            `);
                        });
                    } else {
                        console.error('Invalid API response format');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    alert('خطأ في تحميل المنتجات. يرجى المحاولة مرة أخرى.');
                }
            });
        } else {
            productSelect.html('<option value="">{{ __('sales.select_product') }}</option>');
            row.find('.unit-price-input').val('0');
            calculateTotal(row);
        }
    });

    // اختيار المنتج وتحديث السعر تلقائياً
    productsContainer.on('change', '.product-select', function() {
        console.log('Product selection changed');
        
        const selectedOption = $(this).find('option:selected');
        const row = $(this).closest('.product-item');
        const unitPriceInput = row.find('.unit-price-input');
        
        console.log('Selected option:', selectedOption.val());
        console.log('Data price:', selectedOption.data('price'));
        
        if (selectedOption.length && selectedOption.val()) {
            const price = parseFloat(selectedOption.data('price')) || 0;
            console.log('Setting price to:', price);
            
            unitPriceInput.val(price.toFixed(2));
            calculateTotal(row);
        } else {
            console.log('No product selected, resetting price');
            unitPriceInput.val('0');
            calculateTotal(row);
        }
    });

    // تحديث الكمية
    productsContainer.on('input', '.quantity-input', function() {
        const row = $(this).closest('.product-item');
        calculateTotal(row);
    });

    // تحديث سعر الوحدة
    productsContainer.on('input', '.unit-price-input', function() {
        const row = $(this).closest('.product-item');
        calculateTotal(row);
    });

    // حساب السعر الإجمالي
    function calculateTotal(row) {
        const quantity = parseFloat(row.find('.quantity-input').val()) || 0;
        const unitPrice = parseFloat(row.find('.unit-price-input').val()) || 0;
        const totalPrice = (quantity * unitPrice).toFixed(2);
        
        console.log('Calculating total:', {
            quantity: quantity,
            unitPrice: unitPrice,
            totalPrice: totalPrice
        });
        
        row.find('.total-price-display').val(totalPrice);
        row.find('.total-price-input').val(totalPrice);
    }

    // حذف المنتج
    productsContainer.on('click', '.delete-product-btn', function() {
        $(this).closest('.product-item').remove();
    });

    // تهيئة المنتجات الموجودة
    $('.warehouse-select').each(function() {
        if ($(this).val()) {
            $(this).trigger('change');
        }
    });

    // تهيئة حساب الإجمالي للمنتجات الموجودة
    $('.product-item').each(function() {
        const row = $(this);
        const existingUnitPrice = parseFloat(row.find('.unit-price-input').val()) || 0;
        row.find('.unit-price-input').val(existingUnitPrice.toFixed(2));
        calculateTotal(row);
    });
});
</script>
@endsection
