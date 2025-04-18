<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <title>{{ config('app.name') }} - {{ __('pos.point_of_sale') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    @if(app()->getLocale() == 'ar')
    <link href="{{ asset('css/rtl-new.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo:300,400,500,600,700" />
    @endif
    <style>
        :root {
            --primary-color: #009ef7;
            --primary-light: #f1faff;
            --secondary-color: #7e8299;
            --border-radius: 0.475rem;
            --transition: all 0.2s ease;
            --shadow-sm: 0 0.1rem 1rem 0.25rem rgba(0, 0, 0, 0.05);
            --shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075);
            --card-bg: #ffffff;
            --body-bg: #f5f8fa;
        }

        body {
            overflow: hidden;
            background-color: var(--body-bg);
            font-size: 13px;
            line-height: 1.5;
        }

        #pos-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #pos-header {
            background-color: var(--card-bg);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        #pos-content {
            flex: 1;
            overflow: hidden;
            display: flex;
            padding: 1.5rem;
            gap: 1.5rem;
        }

        #products-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            min-width: 0;
        }

        .search-box {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.25rem;
            box-shadow: var(--shadow-sm);
        }

        .search-input-wrapper {
            position: relative;
        }

        .search-input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
            font-size: 1.1rem;
        }

        .search-input {
            padding-left: 2.5rem !important;
            height: 2.5rem;
            font-size: 0.925rem;
        }

        .filters-box {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.25rem;
            box-shadow: var(--shadow-sm);
        }

        .filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .filter-chip {
            padding: 0.4rem 0.85rem;
            border-radius: 2rem;
            background-color: var(--body-bg);
            color: var(--secondary-color);
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .filter-chip:hover, .filter-chip.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            overflow-y: auto;
            padding: 0.5rem;
            margin: -0.5rem;
        }

        .product-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            cursor: pointer;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            border-color: var(--primary-color);
        }

        .product-image-wrapper {
            position: relative;
            padding-top: 65%;
            overflow: hidden;
            background-color: var(--body-bg);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-details {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            color: #181c32;
            margin-bottom: 0.25rem;
            font-size: 0.925rem;
            line-height: 1.4;
        }

        .product-meta {
            display: flex;
            gap: 0.35rem;
            flex-wrap: wrap;
        }

        .product-badge {
            padding: 0.15rem 0.5rem;
            border-radius: 0.475rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid var(--body-bg);
            margin-top: auto;
        }

        .product-price {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1rem;
        }

        .stock-badge {
            padding: 0.15rem 0.5rem;
            border-radius: 0.475rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        #cart-container {
            width: 400px;
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .cart-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--body-bg);
        }

        #cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .cart-item {
            background-color: var(--body-bg);
            border-radius: var(--border-radius);
            padding: 1rem;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .cart-item:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-color);
        }

        .cart-footer {
            padding: 1.25rem;
            background-color: var(--body-bg);
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .cart-summary {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .cart-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-control, .form-select {
            height: 2.3rem;
            padding: 0.4rem 1rem;
            border-radius: 0.475rem;
            border: 1px solid #e4e6ef;
            background-color: #ffffff;
            transition: var(--transition);
            font-size: 0.925rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 158, 247, 0.25);
        }

        .btn-checkout {
            height: 3.25rem;
            font-size: 1rem;
            font-weight: 600;
        }

        .warehouse-selector {
            background-color: var(--primary-light);
            padding: 0.65rem 1.15rem;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: var(--transition);
            border: 1px solid var(--primary-color);
        }

        .warehouse-selector:hover {
            background-color: #e1f0ff;
        }

        .warehouse-selector select {
            background: transparent;
            border: none;
            color: var(--primary-color);
            font-weight: 500;
            cursor: pointer;
            min-width: 200px;
            font-size: 0.925rem;
        }

        .warehouse-selector select:focus {
            box-shadow: none;
        }

        @media (max-width: 1199.98px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            #pos-content {
                flex-direction: column;
                padding: 1rem;
            }

            #cart-container {
                width: 100%;
                height: 400px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            #pos-header {
                padding: 0.75rem;
            }

            .search-box, .filters-box {
                padding: 1rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 0.75rem;
            }

            .product-details {
                padding: 0.75rem;
            }

            .product-name {
                font-size: 0.85rem;
            }

            .product-price {
                font-size: 0.925rem;
            }
        }

        .product-placeholder {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            color: var(--primary-color);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .placeholder-content {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
        }

        .placeholder-icon {
            font-size: 1.5rem;
            opacity: 0.7;
            color: var(--primary-color);
        }

        .placeholder-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            text-transform: uppercase;
            line-height: 1;
        }
    </style>
</head>
<body>
    <div id="pos-container">
        <div id="pos-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-4">
                    <h3 class="mb-0 fw-bold">{{ __('pos.point_of_sale') }}</h3>
                    <div class="warehouse-selector">
                        <i class="bi bi-building fs-5 text-primary"></i>
                        <select id="warehouse-select" class="form-select-solid">
                            @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ $warehouse->id == $defaultWarehouse?->id ? 'selected' : '' }}>
                                {{ $warehouse->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-light-primary px-4" onclick="window.close()">
                    <i class="bi bi-x-lg me-2"></i>
                    {{ __('pos.close') }}
                </button>
            </div>
        </div>

        <div id="pos-content">
            <div id="products-container">
                <div class="search-box">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="search-input-wrapper">
                                <i class="bi bi-search"></i>
                                <input type="text" id="search-products" class="form-control search-input" placeholder="{{ __('pos.search_products') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="search-input-wrapper">
                                <i class="bi bi-upc-scan"></i>
                                <input type="text" id="barcode-input" class="form-control search-input" placeholder="{{ __('pos.scan_barcode') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filters-box">
                    <div class="mb-4">
                        <h6 class="text-gray-800 mb-3 fw-bold">{{ __('pos.categories') }}</h6>
                        <div class="filter-chips">
                            <div class="filter-chip active" data-category="">
                                {{ __('pos.all') }}
                            </div>
                            @foreach($categories as $category)
                            <div class="filter-chip" data-category="{{ $category->id }}">
                                {{ $category->name }}
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h6 class="text-gray-800 mb-3 fw-bold">{{ __('pos.brands') }}</h6>
                        <div class="filter-chips">
                            <div class="filter-chip active" data-brand="">
                                {{ __('pos.all') }}
                            </div>
                            @foreach($brands as $brand)
                            <div class="filter-chip" data-brand="{{ $brand->id }}">
                                {{ $brand->name }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="products-grid" id="products-list">
                    @foreach($products as $product)
                    <div class="product-card" 
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}"
                        data-product-price="{{ $product->price }}"
                        data-product-stock="{{ $product->warehouses->first()->pivot->stock }}">
                        <div class="product-image-wrapper">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}">
                            @else
                            <div class="product-placeholder">
                                <div class="placeholder-content">
                                    <i class="bi bi-box-seam placeholder-icon"></i>
                                    <span class="placeholder-text">{{ substr($product->name, 0, 1) }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="product-details">
                            <h5 class="product-name">{{ $product->name }}</h5>
                            <div class="product-meta">
                                <span class="product-badge bg-light-info">{{ $product->category->name }}</span>
                                @if($product->brand)
                                <span class="product-badge bg-light-primary">{{ $product->brand->name }}</span>
                                @endif
                            </div>
                            <div class="product-footer">
                                <div class="product-price" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                    {{ number_format($product->price, 2) }}
                                    <small class="text-muted">{{ config('app.currency') }}</small>
                                </div>
                                <span class="stock-badge bg-light-{{ $product->warehouses->first()->pivot->stock > 0 ? 'success' : 'danger' }}">
                                    {{ $product->warehouses->first()->pivot->stock }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div id="cart-container">
                <div class="cart-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-1">{{ __('pos.cart.title') }}</h4>
                            <span class="text-muted" id="cart-count">0 {{ __('pos.cart.items') }}</span>
                        </div>
                        <button type="button" class="btn btn-icon btn-light-danger" id="clear-cart">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>

                <div id="cart-items">
                    <!-- Cart items will be added here -->
                </div>

                <div class="cart-footer">
                    <div class="cart-summary mb-4">
                        <div class="cart-row">
                            <span class="text-gray-600">{{ __('pos.cart.subtotal') }}</span>
                            <span class="fw-bold" id="cart-subtotal">0.00</span>
                        </div>
                        <div class="cart-row">
                            <span class="text-gray-600">{{ __('pos.cart.discount_amount') }}</span>
                            <div class="w-100px">
                                <input type="number" id="cart-discount" class="form-control form-control-sm text-end" value="0" min="0">
                            </div>
                        </div>
                        <div class="cart-row">
                            <span class="text-gray-600">{{ __('pos.cart.tax_percent') }}</span>
                            <div class="input-group input-group-sm w-100px">
                                <input type="number" id="cart-tax" class="form-control text-end" value="0" min="0" max="100" step="0.01">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="cart-row">
                            <span class="text-gray-600">{{ __('pos.cart.tax_amount') }}</span>
                            <span class="fw-bold" id="cart-tax-amount">0.00</span>
                        </div>
                        <div class="cart-row border-top pt-3 mt-2">
                            <span class="fw-bold fs-5">{{ __('pos.cart.total') }}</span>
                            <span class="fw-bold fs-5 text-primary" id="cart-total">0.00</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <select id="customer-select" class="form-select mb-3">
                            <option value="">{{ __('pos.no_customer') }}</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>

                        <select id="payment-method" class="form-select mb-3">
                            <option value="cash">{{ __('pos.cash') }}</option>
                            <option value="card">{{ __('pos.card') }}</option>
                            <option value="bank_transfer">{{ __('pos.bank_transfer') }}</option>
                        </select>

                        <textarea id="sale-notes" class="form-control" placeholder="{{ __('pos.notes') }}" rows="2"></textarea>
                    </div>

                    <button type="button" id="checkout-btn" class="btn btn-primary w-100 btn-checkout">
                        <i class="bi bi-check2-circle me-2"></i>
                        {{ __('pos.cart.checkout') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkout-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">{{ __('pos.sale_confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-5">
                        <div class="icon-success mb-3">
                            <i class="bi bi-check-circle-fill text-success fs-1"></i>
                        </div>
                        <h3 class="mb-1">{{ __('pos.sale_completed') }}</h3>
                        <p class="text-muted">{{ __('pos.sale_completed_successfully') }}</p>
                    </div>

                    <div class="receipt-details bg-light p-4 rounded mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('pos.invoice_number') }}</span>
                            <span class="fw-bold" id="receipt-id"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('pos.date') }}</span>
                            <span class="fw-bold" id="receipt-date"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('pos.customer') }}</span>
                            <span class="fw-bold" id="receipt-customer"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('pos.payment_method') }}</span>
                            <span class="fw-bold" id="receipt-payment"></span>
                        </div>
                        <div class="d-flex justify-content-between pt-2 mt-2 border-top">
                            <span class="fw-bold">{{ __('pos.total') }}</span>
                            <span class="fw-bold text-primary" id="receipt-total"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        {{ __('pos.close') }}
                    </button>
                    <a href="#" id="print-receipt" class="btn btn-primary" target="_blank">
                        <i class="bi bi-printer me-2"></i>
                        {{ __('pos.print_receipt') }}
                    </a>
                    <button type="button" id="new-sale-btn" class="btn btn-success" data-bs-dismiss="modal">
                        <i class="bi bi-plus-lg me-2"></i>
                        {{ __('pos.new_sale') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Global variables
        let cart = [];
        let selectedCategory = '';
        let selectedBrand = '';
        let currentWarehouse = $('#warehouse-select').val();

        // Initialize CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize toastr
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "{{ app()->getLocale() == 'ar' ? 'toast-top-left' : 'toast-top-right' }}",
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };

        // Format currency
        function formatCurrency(amount) {
            const locale = '{{ app()->getLocale() }}';
            const options = {
                style: 'currency',
                currency: '{{ config('app.currency', 'SAR') }}',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
                numberingSystem: locale === 'ar' ? 'arab' : 'latn'
            };
            
            return new Intl.NumberFormat(locale === 'ar' ? 'ar-SA' : 'en-US', options).format(amount);
        }

        // Add product to cart
        function addToCart(product) {
            const existingItem = cart.find(item => item.id === product.id);
            
            if (existingItem) {
                if (existingItem.quantity + 1 > product.stock) {
                    toastr.error('{{ __("pos.insufficient_stock") }}');
                    return;
                }
                existingItem.quantity++;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    quantity: 1,
                    stock: product.stock
                });
            }
            
            updateCartDisplay();
            toastr.success('{{ __("pos.cart.product_added") }}');
        }

        // Update cart display
        function updateCartDisplay() {
            const cartItemsContainer = $('#cart-items');
            const cartCountElement = $('#cart-count');
            cartItemsContainer.empty();
            
            if (cart.length === 0) {
                cartItemsContainer.html(`
                    <div class="text-center py-5">
                        <i class="bi bi-cart fs-1 text-muted mb-3"></i>
                        <p class="text-muted">{{ __('pos.cart.empty') }}</p>
                    </div>
                `);
            } else {
                cart.forEach((item, index) => {
                    const itemTotal = item.price * item.quantity;
                    cartItemsContainer.append(`
                        <div class="cart-item">
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <h6 class="mb-0">${item.name}</h6>
                                    <small class="text-muted">${formatCurrency(item.price)} × ${item.quantity}</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-light-primary" onclick="updateQuantity(${index}, -1)">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <button class="btn btn-light-primary" onclick="updateQuantity(${index}, 1)">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    <button class="btn btn-sm btn-light-danger" onclick="removeFromCart(${index})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">{{ __('pos.cart.total') }}</small>
                                <span class="fw-bold">${formatCurrency(itemTotal)}</span>
                            </div>
                        </div>
                    `);
                });
            }

            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discount = parseFloat($('#cart-discount').val()) || 0;
            const taxRate = parseFloat($('#cart-tax').val()) || 0;
            const afterDiscount = subtotal - discount;
            const taxAmount = (afterDiscount * taxRate) / 100;
            const total = afterDiscount + taxAmount;

            cartCountElement.text(`${cart.length} {{ __('pos.cart.items') }}`);
            $('#cart-subtotal').text(formatCurrency(subtotal));
            $('#cart-tax-amount').text(formatCurrency(taxAmount));
            $('#cart-total').text(formatCurrency(total));

            // Enable/disable checkout button
            $('#checkout-btn').prop('disabled', cart.length === 0);
        }

        // Update quantity
        function updateQuantity(index, change) {
            const item = cart[index];
            const newQuantity = item.quantity + change;
            
            if (newQuantity > 0 && newQuantity <= item.stock) {
                item.quantity = newQuantity;
                updateCartDisplay();
            } else if (newQuantity > item.stock) {
                toastr.error('{{ __("pos.insufficient_stock") }}');
            }
        }

        // Remove from cart
        function removeFromCart(index) {
            if (index >= 0 && index < cart.length) {
                cart.splice(index, 1);
                updateCartDisplay();
                toastr.success('{{ __("pos.cart.product_removed") }}');
            }
        }

        // Update products list
        function updateProducts() {
            const loadingHtml = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">{{ __('pos.loading') }}</span>
                    </div>
                    <p class="text-muted">{{ __('pos.loading_products') }}</p>
                </div>
            `;
            
            $('#products-list').html(loadingHtml);
            
            $.get('/pos/search-products', {
                search: $('#search-products').val(),
                warehouse_id: currentWarehouse,
                category_id: selectedCategory,
                brand_id: selectedBrand
            })
            .done(function(products) {
                let productsHtml = '';
                
                if (products.length === 0) {
                    productsHtml = `
                        <div class="text-center py-5">
                            <i class="bi bi-search fs-1 text-muted mb-3"></i>
                            <p class="text-muted">{{ __('pos.no_products_found') }}</p>
                        </div>
                    `;
                } else {
                    products.forEach(product => {
                        productsHtml += `
                            <div class="product-card" 
                                data-product-id="${product.id}"
                                data-product-name="${product.name}"
                                data-product-price="${product.price}"
                                data-product-stock="${product.stock}">
                                <div class="product-image-wrapper">
                                    ${product.image 
                                        ? `<img src="/storage/${product.image}" class="product-image" alt="${product.name}">`
                                        : `<div class="product-placeholder">
                                            <div class="placeholder-content">
                                                <i class="bi bi-box-seam placeholder-icon"></i>
                                                <span class="placeholder-text">${product.name.charAt(0)}</span>
                                            </div>
                                        </div>`
                                    }
                                </div>
                                <div class="product-details">
                                    <h5 class="product-name">${product.name}</h5>
                                    <div class="product-meta">
                                        <span class="product-badge bg-light-info">${product.category ? product.category.name : ''}</span>
                                        ${product.brand ? `<span class="product-badge bg-light-primary">${product.brand.name}</span>` : ''}
                                    </div>
                                    <div class="product-footer">
                                        <div class="product-price" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                            ${formatCurrency(product.price)}
                                        </div>
                                        <span class="stock-badge bg-light-${product.stock > 0 ? 'success' : 'danger'}">
                                            ${product.stock}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }
                
                $('#products-list').html(productsHtml);
            })
            .fail(function(error) {
                toastr.error('{{ __("pos.error_loading_products") }}');
                console.error(error);
            });
        }

        // Event Listeners
        $(document).ready(function() {
            // Initialize
            updateCartDisplay();
            updateProducts();

            // Warehouse change
            $('#warehouse-select').change(function() {
                currentWarehouse = $(this).val();
                updateProducts();
            });

            // Product search
            let searchTimeout;
            $('#search-products').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(updateProducts, 300);
            });

            // Barcode search
            $('#barcode-input').on('keypress', function(e) {
                if (e.which === 13) {
                    const barcode = $(this).val();
                    if (!barcode) return;

                    $.get('/pos/search-barcode', {
                        barcode: barcode,
                        warehouse_id: currentWarehouse
                    })
                    .done(function(product) {
                        if (product) {
                            addToCart(product);
                            $('#barcode-input').val('');
                        } else {
                            toastr.error('{{ __("pos.product_not_found") }}');
                        }
                    })
                    .fail(function() {
                        toastr.error('{{ __("pos.error_searching") }}');
                    });
                }
            });

            // Category filter
            $('.filter-chip[data-category]').click(function() {
                $('.filter-chip[data-category]').removeClass('active');
                $(this).addClass('active');
                selectedCategory = $(this).data('category');
                updateProducts();
            });

            // Brand filter
            $('.filter-chip[data-brand]').click(function() {
                $('.filter-chip[data-brand]').removeClass('active');
                $(this).addClass('active');
                selectedBrand = $(this).data('brand');
                updateProducts();
            });

            // Clear cart
            $('#clear-cart').click(function() {
                if (cart.length === 0) return;
                
                if (confirm('{{ __("pos.cart.clear_confirm") }}')) {
                    cart = [];
                    updateCartDisplay();
                    toastr.success('{{ __("pos.cart.cleared") }}');
                }
            });

            // Add to cart
            $(document).on('click', '.product-card', function() {
                const $card = $(this);
                const product = {
                    id: $card.data('product-id'),
                    name: $card.data('product-name'),
                    price: parseFloat($card.data('product-price')),
                    stock: parseInt($card.data('product-stock'))
                };
                
                addToCart(product);
            });

            // Update totals on discount/tax change
            $('#cart-discount, #cart-tax').on('input', function() {
                updateCartDisplay();
            });

            // Checkout
            $('#checkout-btn').click(function() {
                if (cart.length === 0) {
                    toastr.error('{{ __("pos.cart.empty") }}');
                    return;
                }

                const saleData = {
                    customer_id: $('#customer-select').val(),
                    warehouse_id: currentWarehouse,
                    payment_method: $('#payment-method').val(),
                    items: cart.map(item => ({
                        product_id: item.id,
                        quantity: item.quantity,
                        price: item.price
                    })),
                    discount: parseFloat($('#cart-discount').val()) || 0,
                    tax: parseFloat($('#cart-tax').val()) || 0,
                    notes: $('#sale-notes').val()
                };

                $(this).prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{ __('pos.processing') }}
                `);

                $.post('/pos/checkout', saleData)
                    .done(function(response) {
                        if (response.success) {
                            $('#receipt-id').text(response.sale_id);
                            $('#receipt-date').text(new Date().toLocaleString());
                            $('#receipt-customer').text($('#customer-select option:selected').text());
                            $('#receipt-payment').text($('#payment-method option:selected').text());
                            $('#receipt-total').text($('#cart-total').text());
                            $('#print-receipt').attr('href', `/pos/receipt/${response.sale_id}`);
                            $('#checkout-modal').modal('show');
                            
                            cart = [];
                            updateCartDisplay();
                            
                            toastr.success('{{ __("pos.sale_completed_successfully") }}');
                        }
                    })
                    .fail(function(error) {
                        toastr.error(error.responseJSON?.error || '{{ __("pos.error_checkout") }}');
                    })
                    .always(function() {
                        $('#checkout-btn').prop('disabled', false).html(`
                            <i class="bi bi-check2-circle me-2"></i>
                            {{ __('pos.cart.checkout') }}
                        `);
                    });
            });

            // New sale
            $('#new-sale-btn').click(function() {
                cart = [];
                updateCartDisplay();
                $('#customer-select').val('');
                $('#payment-method').val('cash');
                $('#sale-notes').val('');
                $('#cart-discount').val('0');
                $('#cart-tax').val('0');
                updateProducts();
            });
        });
    </script>
</body>
</html>