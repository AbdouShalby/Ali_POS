@extends('layouts.app')

@section('title', '- ' . __('sales.edit_sale'))

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ __('sales.edit_sale') }} #{{ $sale->id }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ __('sales.error') }}</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('sales.update', $sale->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- اختيار العميل -->
            <div class="mb-4">
                <label for="customer_id" class="form-label">{{ __('sales.customer') }}</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">{{ __('sales.select_customer') }}</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- تاريخ البيع -->
            <div class="mb-4">
                <label for="sale_date" class="form-label">{{ __('sales.sale_date') }}</label>
                <input type="date" class="form-control" name="sale_date" value="{{ $sale->sale_date ? \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') : '' }}" required>
            </div>

            <!-- المنتجات -->
            <h5 class="mb-4">{{ __('sales.products') }}</h5>
            <div id="products-container">
                @foreach($sale->saleItems as $index => $item)
                    <div class="row product-item mb-3">
                        <div class="col-md-4">
                            <label for="warehouse_id" class="form-label">{{ __('sales.warehouse') }}</label>
                            <select name="products[{{ $index }}][warehouse_id]" class="form-select warehouse-select" data-index="{{ $index }}" required>
                                <option value="">{{ __('sales.select_warehouse') }}</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ $item->product->warehouses->contains($warehouse->id) ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="product_id" class="form-label">{{ __('sales.product') }}</label>
                            <select name="products[{{ $index }}][product_id]" class="form-select product-select" data-index="{{ $index }}" required>
                                <option value="">{{ __('sales.select_product') }}</option>
                                @foreach($item->product->warehouses as $warehouse)
                                    <option value="{{ $item->product->id }}" {{ $item->product_id == $item->product->id ? 'selected' : '' }}>
                                        {{ $item->product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="quantity" class="form-label">{{ __('sales.quantity') }}</label>
                            <input type="number" name="products[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <label for="price" class="form-label">{{ __('sales.price') }}</label>
                            <input type="number" name="products[{{ $index }}][price]" class="form-control" value="{{ $item->price }}" min="0" step="0.01" required>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-product-btn" class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle"></i> {{ __('sales.add_product') }}
            </button>

            <!-- أزرار الحفظ والإلغاء -->
            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> {{ __('sales.save') }}
                </button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ __('sales.cancel') }}
                </a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let productCount = {{ $sale->saleItems->count() }};

            // تحديث قائمة المنتجات عند اختيار المخزن
            document.querySelector('#products-container').addEventListener('change', function (e) {
                if (e.target.classList.contains('warehouse-select')) {
                    const index = e.target.getAttribute('data-index');
                    const warehouseId = e.target.value;

                    fetch(`/warehouses/${warehouseId}/products`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const productSelect = document.querySelector(`.product-select[data-index="${index}"]`);
                            productSelect.innerHTML = '<option value="">{{ __('sales.select_product') }}</option>';
                            data.forEach(product => {
                                productSelect.innerHTML += `
                            <option value="${product.id}" data-stock="${product.stock}">
                                ${product.name} - {{ __('sales.stock') }}: ${product.stock}
                            </option>`;
                            });
                        })
                        .catch(err => console.error('Fetch error: ', err));
                }
            });

            // إضافة منتج جديد
            document.querySelector('#add-product-btn').addEventListener('click', function () {
                const index = productCount;
                const newItem = `
        <div class="row product-item mb-3">
            <div class="col-md-4">
                <label for="warehouse_id_${index}" class="form-label">{{ __('sales.warehouse') }}</label>
                <select name="products[${index}][warehouse_id]" class="form-select warehouse-select" data-index="${index}" required>
                    <option value="">{{ __('sales.select_warehouse') }}</option>
                    @foreach($warehouses as $warehouse)
                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="product_id_${index}" class="form-label">{{ __('sales.product') }}</label>
                <select name="products[${index}][product_id]" class="form-select product-select" data-index="${index}" required>
                    <option value="">{{ __('sales.select_product') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="quantity_${index}" class="form-label">{{ __('sales.quantity') }}</label>
                <input type="number" name="products[${index}][quantity]" class="form-control" min="1" required>
            </div>
            <div class="col-md-2">
                <label for="price_${index}" class="form-label">{{ __('sales.price') }}</label>
                <input type="number" name="products[${index}][price]" class="form-control" min="0" step="0.01" required>
            </div>
        </div>
        `;
                document.querySelector('#products-container').insertAdjacentHTML('beforeend', newItem);
                productCount++;
            });
        });
    </script>
@endsection
