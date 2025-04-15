@extends('layouts.app')

@section('title', ' - ' . __('pos.point_of_sale'))

@section('styles')
<!-- إضافة CSRF token للاستخدام في طلبات AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!-- إضافة مكتبة Lottie للرسوم المتحركة -->
<script src="https://unpkg.com/@lottiefiles/lottie-player@1.5.7/dist/lottie-player.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js"></script>
<style>
    .product-card {
        cursor: pointer;
        transition: all 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.08);
    }
    .cart-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
    .cart-controls .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
    }
    #pos-container {
        height: calc(100vh - 150px);
    }
    #products-container {
        height: 100%;
        overflow-y: auto;
    }
    #cart-container {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    #cart-items {
        flex: 1;
        overflow-y: auto;
    }
    .category-filter, .brand-filter {
        cursor: pointer;
    }
    .category-filter.active, .brand-filter.active {
        background-color: #009ef7;
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="card" id="pos-container">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="card-label">{{ __('pos.point_of_sale') }}</h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row g-5">
            <!-- القسم الأيسر: المنتجات والفلاتر -->
            <div class="col-xl-8">
                <div class="mb-5">
                    <!-- شريط البحث والفلترة -->
                    <div class="d-flex flex-wrap mb-5">
                        <div class="d-flex align-items-center position-relative me-4 mb-3">
                            <span class="svg-icon svg-icon-3 position-absolute ms-3">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="search-products" class="form-control form-control-solid ps-10" placeholder="{{ __('pos.search_products') }}">
                        </div>

                        <div class="d-flex align-items-center position-relative me-4 mb-3">
                            <input type="text" id="barcode-input" class="form-control form-control-solid" placeholder="{{ __('pos.scan_barcode') }}">
                        </div>

                        <div class="d-flex align-items-center position-relative mb-3">
                            <select id="warehouse-select" class="form-select form-select-solid">
                                @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ $warehouse->id == $defaultWarehouse?->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- فلترة حسب الفئات -->
                    <div class="d-flex flex-wrap mb-5">
                        <div class="category-filter me-2 mb-2 badge badge-light-primary fs-7 fw-bold py-2 px-3 active" data-category="null">{{ __('pos.all') }}</div>
                        @foreach($categories as $category)
                        <div class="category-filter me-2 mb-2 badge badge-light fs-7 fw-bold py-2 px-3" data-category="{{ $category->id }}">{{ $category->name }}</div>
                        @endforeach
                    </div>

                    <!-- فلترة حسب العلامات التجارية -->
                    <div class="d-flex flex-wrap mb-5">
                        <div class="brand-filter me-2 mb-2 badge badge-light-success fs-7 fw-bold py-2 px-3 active" data-brand="null">{{ __('pos.all') }}</div>
                        @foreach($brands as $brand)
                        <div class="brand-filter me-2 mb-2 badge badge-light fs-7 fw-bold py-2 px-3" data-brand="{{ $brand->id }}">{{ $brand->name }}</div>
                        @endforeach
                    </div>
                </div>

                <!-- عرض المنتجات -->
                <div id="products-container">
                    <div class="row g-3" id="products-grid">
                        @foreach($products as $product)
                        <div class="col-md-4 col-lg-3">
                            <div class="card product-card h-100" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}" data-product-stock="{{ $product->pivot->stock }}">
                                <div class="card-body p-3 text-center">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100px object-fit-contain mb-3" alt="{{ $product->name }}">
                                    @else
                                    <div class="symbol symbol-100px mb-3">
                                        <span class="symbol-label bg-light-primary">
                                            <i class="bi bi-box fs-1 text-primary"></i>
                                        </span>
                                    </div>
                                    @endif
                                    <h5 class="card-title fs-6 text-truncate mb-1">{{ $product->name }}</h5>
                                    <p class="card-text text-primary fw-bold mb-0">{{ number_format($product->price, 2) }}</p>
                                    <small class="text-muted">{{ __('pos.stock') }}: {{ $product->pivot->stock }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- القسم الأيمن: سلة المشتريات -->
            <div class="col-xl-4">
                <div class="card h-100" id="cart-container">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('pos.cart') }}</h3>
                        <div class="card-toolbar d-flex">
                            <button type="button" id="clear-cart" class="btn btn-sm btn-light-danger">
                                <i class="bi bi-trash"></i> {{ __('pos.clear_cart') }}
                            </button>
                        </div>
                    </div>

                    <div id="cart-items" class="p-3">
                        <div class="text-center py-10 text-muted">
                            <i class="bi bi-cart fs-3x mb-3 d-block"></i>
                            <span>{{ __('pos.empty_cart') }}</span>
                        </div>
                    </div>

                    <div class="card-footer p-3">
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ __('pos.subtotal') }}:</span>
                                <span id="cart-subtotal">0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ __('pos.discount') }}:</span>
                                <div class="w-50">
                                    <input type="number" id="cart-discount" class="form-control form-control-sm" value="0" min="0">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>{{ __('pos.tax_percent') }}:</span>
                                <div class="w-50 d-flex align-items-center">
                                    <input type="number" id="cart-tax" class="form-control form-control-sm" value="0" min="0" style="width: 70px;">
                                    <span class="ms-2">=</span>
                                    <span id="cart-tax-amount" class="ms-2">0.00</span>
                                    <input type="hidden" id="cart-tax-amount-input" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                            <span>{{ __('pos.total') }}:</span>
                            <span id="cart-total">0.00</span>
                        </div>

                        <div class="mb-3">
                            <select id="customer-select" class="form-select">
                                <option value="">{{ __('pos.no_customer') }}</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <select id="payment-method" class="form-select">
                                <option value="cash">{{ __('pos.cash') }}</option>
                                <option value="card">{{ __('pos.card') }}</option>
                                <option value="bank_transfer">{{ __('pos.bank_transfer') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <textarea id="sale-notes" class="form-control" placeholder="{{ __('pos.notes') }}" rows="2"></textarea>
                        </div>

                        <button type="button" id="checkout-btn" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-1"></i> {{ __('pos.checkout') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نموذج تأكيد البيع -->
<div class="modal fade" id="checkout-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('pos.sale_confirmation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-5">
                    <i class="bi bi-check-circle-fill text-success fs-3x"></i>
                    <h3 class="mt-3">{{ __('pos.sale_completed') }}</h3>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('pos.invoice_number') }}:</span>
                    <span id="receipt-id"></span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('pos.date') }}:</span>
                    <span id="receipt-date"></span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('pos.customer') }}:</span>
                    <span id="receipt-customer"></span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('pos.payment_method') }}:</span>
                    <span id="receipt-payment"></span>
                </div>

                <div class="d-flex justify-content-between mb-2 fw-bold">
                    <span>{{ __('pos.total') }}:</span>
                    <span id="receipt-total"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('pos.close') }}</button>
                <a href="#" id="print-receipt" class="btn btn-primary" target="_blank">
                    <i class="bi bi-printer me-1"></i> {{ __('pos.print_receipt') }}
                </a>
                <button type="button" id="new-sale-btn" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="bi bi-plus-circle me-1"></i> {{ __('pos.new_sale') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    // سيتم إضافة كود جافاسكريبت هنا
    document.addEventListener('DOMContentLoaded', function() {
        // المتغيرات العامة
        let cart = [];
        const warehouseSelect = document.getElementById('warehouse-select');
        const searchInput = document.getElementById('search-products');
        const barcodeInput = document.getElementById('barcode-input');
        const productsGrid = document.getElementById('products-grid');
        const cartItems = document.getElementById('cart-items');
        const cartSubtotal = document.getElementById('cart-subtotal');
        const cartDiscount = document.getElementById('cart-discount');
        const cartTax = document.getElementById('cart-tax');
        const cartTotal = document.getElementById('cart-total');
        const customerSelect = document.getElementById('customer-select');
        const paymentMethod = document.getElementById('payment-method');
        const saleNotes = document.getElementById('sale-notes');
        const checkoutBtn = document.getElementById('checkout-btn');
        const clearCartBtn = document.getElementById('clear-cart');
        const categoryFilters = document.querySelectorAll('.category-filter');
        const brandFilters = document.querySelectorAll('.brand-filter');

        let activeCategory = '';
        let activeBrand = '';

        // إضافة منتج إلى السلة
        function addToCart(product) {
            const existingItem = cart.find(item => item.id === product.id);

            if (existingItem) {
                if (existingItem.quantity < product.stock) {
                    existingItem.quantity += 1;
                } else {
                    toastr.warning('لا يمكن إضافة المزيد من هذا المنتج. الكمية المتوفرة: ' + product.stock);
                    return;
                }
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                    stock: product.stock
                });
            }

            updateCart();
        }

        // تحديث عرض السلة
        function updateCart() {
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="text-center py-10 text-muted">
                        <i class="bi bi-cart fs-3x mb-3 d-block"></i>
                        <span>{{ __('pos.cart_empty') }}</span>
                    </div>
                `;
            } else {
                let cartHtml = '';

                cart.forEach((item, index) => {
                    cartHtml += `
                        <div class="cart-item">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 text-truncate" style="max-width: 150px;">${item.name}</h6>
                                <div class="cart-controls">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger delete-item" data-index="${index}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    <button type="button" class="btn btn-light-primary decrease-qty" data-index="${index}">-</button>
                                    <input type="text" class="form-control text-center item-qty" value="${item.quantity}" data-index="${index}" min="1" max="${item.stock}">
                                    <button type="button" class="btn btn-light-primary increase-qty" data-index="${index}">+</button>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">${(item.price * item.quantity).toFixed(2)}</div>
                                    <small class="text-muted">${item.quantity} × ${item.price.toFixed(2)}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });

                cartItems.innerHTML = cartHtml;

                // إضافة مستمعي الأحداث لأزرار السلة
                document.querySelectorAll('.delete-item').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        cart.splice(index, 1);
                        updateCart();
                    });
                });

                document.querySelectorAll('.decrease-qty').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        if (cart[index].quantity > 1) {
                            cart[index].quantity -= 1;
                            updateCart();
                        }
                    });
                });

                document.querySelectorAll('.increase-qty').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        if (cart[index].quantity < cart[index].stock) {
                            cart[index].quantity += 1;
                            updateCart();
                        } else {
                            toastr.warning('لا يمكن إضافة المزيد من هذا المنتج. الكمية المتوفرة: ' + cart[index].stock);
                        }
                    });
                });

                document.querySelectorAll('.item-qty').forEach(input => {
                    input.addEventListener('change', function() {
                        const index = parseInt(this.dataset.index);
                        let qty = parseInt(this.value);

                        if (isNaN(qty) || qty < 1) {
                            qty = 1;
                        } else if (qty > cart[index].stock) {
                            qty = cart[index].stock;
                            toastr.warning('لا يمكن إضافة المزيد من هذا المنتج. الكمية المتوفرة: ' + cart[index].stock);
                        }

                        cart[index].quantity = qty;
                        updateCart();
                    });
                });
            }

            // تحديث المجاميع
            updateTotals();
        }

        // تحديث المجاميع
        function updateTotals() {
            const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            const discount = parseFloat(cartDiscount.value) || 0;

            // حساب الضريبة كنسبة مئوية من المجموع الفرعي
            const taxPercent = parseFloat(cartTax.value) || 0;
            const taxAmount = (subtotal - discount) * (taxPercent / 100);

            const total = subtotal - discount + taxAmount;

            // عرض القيم المحسوبة
            cartSubtotal.textContent = subtotal.toFixed(2);
            document.getElementById('cart-tax-amount').textContent = taxAmount.toFixed(2);
            cartTotal.textContent = total.toFixed(2);

            // تخزين قيمة الضريبة المحسوبة لاستخدامها عند الدفع
            document.getElementById('cart-tax-amount-input').value = taxAmount.toFixed(2);
        }

        // تحميل المنتجات من المخزن المحدد
        function loadWarehouseProducts() {
            const warehouseId = warehouseSelect.value;

            // إظهار رسالة تحميل
            productsGrid.innerHTML = `
                <div class="col-12">
                    <div class="text-center py-10">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                        <p class="mt-3">جاري تحميل المنتجات...</p>
                    </div>
                </div>
            `;

            // استخدام المسار الكامل للتأكد من عدم وجود مشاكل في الروابط
            const baseUrl = window.location.origin;
            const url = `${baseUrl}/pos/warehouse-products?warehouse_id=${warehouseId}`;

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`خطأ في الاستجابة: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (Array.isArray(data)) {
                    renderProducts(data);
                } else {
                    console.error('تنسيق البيانات غير صحيح:', data);
                    toastr.error('تنسيق البيانات المستلمة غير صحيح');
                    renderProducts([]);
                }
            })
            .catch(error => {
                console.error('Error loading products:', error);
                toastr.error(`حدث خطأ أثناء تحميل المنتجات: ${error.message}`);
                renderProducts([]);
            });
        }

        // عرض المنتجات في الشبكة
        function renderProducts(products) {
            let html = '';

            if (products.length === 0) {
                html = `
                    <div class="col-12">
                        <div class="text-center py-10 text-muted">
                            <i class="bi bi-box fs-3x mb-3 d-block"></i>
                            <span>لا توجد منتجات متوفرة</span>
                        </div>
                    </div>
                `;
            } else {
                products.forEach(product => {
                    // التأكد من أن السعر رقم قبل استخدام toFixed
                    const price = parseFloat(product.price) || 0;

                    // التعامل مع المخزون بشكل آمن
                    let stock = 0;

                    // التحقق من وجود stock مباشرة في المنتج (من التحسين السابق)
                    if (product.stock !== undefined) {
                        stock = product.stock;
                    }
                    // التحقق من وجود pivot و stock في pivot
                    else if (product.pivot && product.pivot.stock !== undefined) {
                        stock = product.pivot.stock;
                    }
                    // التحقق من وجود warehouses والوصول إلى المخزون من خلالها
                    else if (product.warehouses && product.warehouses.length > 0 &&
                             product.warehouses[0].pivot && product.warehouses[0].pivot.stock !== undefined) {
                        stock = product.warehouses[0].pivot.stock;
                    }

                    // طباعة معلومات التشخيص
                    console.log(`Product ${product.id} - ${product.name} - Stock: ${stock}`);

                    html += `
                        <div class="col-md-4 col-lg-3">
                            <div class="card product-card h-100" data-product-id="${product.id}" data-product-name="${product.name}" data-product-price="${price}" data-product-stock="${stock}">
                                <div class="card-body p-3 text-center">
                                    ${product.image
                                        ? `<img src="/storage/${product.image}" class="w-100 h-100px object-fit-contain mb-3" alt="${product.name}" onerror="this.onerror=null; this.style.display='none'; document.getElementById('lottie-frame-'+product.id).style.display='block';">`
                                        : `<iframe id="lottie-frame-${product.id}" src="/lottie-placeholder.html" class="w-100 h-100px border-0 mb-3" frameborder="0"></iframe>`
                                    }
                                    ${product.image ? `<iframe id="lottie-frame-${product.id}" src="/lottie-placeholder.html" class="w-100 h-100px border-0 mb-3" frameborder="0" style="display:none;"></iframe>` : ''}
                                    <h5 class="card-title fs-6 text-truncate mb-1">${product.name}</h5>
                                    <p class="card-text text-primary fw-bold mb-0">${price.toFixed(2)}</p>
                                    <small class="text-muted">{{ __('pos.stock') }}: ${stock}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            productsGrid.innerHTML = html;

            // إضافة مستمعي الأحداث لبطاقات المنتجات
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function() {
                    const product = {
                        id: parseInt(this.dataset.productId),
                        name: this.dataset.productName,
                        price: parseFloat(this.dataset.productPrice),
                        stock: parseInt(this.dataset.productStock)
                    };

                    addToCart(product);
                });
            });
        }

        // البحث عن المنتجات
        function searchProducts() {
            const searchTerm = searchInput.value.trim();
            const warehouseId = warehouseSelect.value;

            // إظهار رسالة تحميل
            productsGrid.innerHTML = `
                <div class="col-12">
                    <div class="text-center py-10">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                        <p class="mt-3">جاري البحث عن المنتجات...</p>
                    </div>
                </div>
            `;

            // بناء المسار الكامل
            const baseUrl = window.location.origin;
            let url = new URL(`${baseUrl}/pos/search-products`);

            // إضافة معلمات الاستعلام (query parameters)
            const params = new URLSearchParams();
            params.append('warehouse_id', warehouseId);

            if (searchTerm) {
                params.append('search', searchTerm);
            }

            if (activeCategory) {
                params.append('category_id', activeCategory);
            }

            if (activeBrand) {
                params.append('brand_id', activeBrand);
            }

            url.search = params.toString();

            // طباعة معلومات التشخيص
            console.log('Search URL:', url.toString());
            console.log('Search Parameters:', {
                warehouse_id: warehouseId,
                search: searchTerm || null,
                category_id: activeCategory || null,
                brand_id: activeBrand || null
            });

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.error || `خطأ في الاستجابة: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Search results:', data);
                if (Array.isArray(data)) {
                    renderProducts(data);
                } else if (data.error) {
                    toastr.error(data.error);
                    renderProducts([]);
                } else {
                    console.error('تنسيق البيانات غير صحيح:', data);
                    toastr.error('تنسيق البيانات المستلمة غير صحيح');
                    renderProducts([]);
                }
            })
            .catch(error => {
                console.error('Error searching products:', error);
                toastr.error(`حدث خطأ أثناء البحث عن المنتجات: ${error.message}`);
                renderProducts([]);
            });
        }

        // البحث بالباركود
        function searchByBarcode() {
            const barcode = barcodeInput.value.trim();

            if (!barcode) return;

            const warehouseId = warehouseSelect.value;

            fetch(`/pos/search-barcode?barcode=${barcode}&warehouse_id=${warehouseId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('المنتج غير موجود');
                    }
                    return response.json();
                })
                .then(product => {
                    // التعامل مع المخزون بشكل آمن
                    let stock = 0;

                    // التحقق من وجود stock مباشرة في المنتج
                    if (product.stock !== undefined) {
                        stock = product.stock;
                    }
                    // التحقق من وجود warehouses والوصول إلى المخزون من خلالها
                    else if (product.warehouses && product.warehouses.length > 0 &&
                             product.warehouses[0].pivot && product.warehouses[0].pivot.stock !== undefined) {
                        stock = product.warehouses[0].pivot.stock;
                    }

                    console.log(`Barcode Product ${product.id} - ${product.name} - Stock: ${stock}`);

                    addToCart({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        stock: stock
                    });

                    barcodeInput.value = '';
                    barcodeInput.focus();
                })
                .catch(error => {
                    console.error('Error searching by barcode:', error);
                    toastr.error('المنتج غير موجود أو غير متوفر في المخزن');
                    barcodeInput.value = '';
                    barcodeInput.focus();
                });
        }

        // إتمام عملية البيع
        function checkout() {
            if (cart.length === 0) {
                toastr.warning('{{ __('pos.cart_empty') }}');
                return;
            }

            const data = {
                customer_id: customerSelect.value || null,
                warehouse_id: warehouseSelect.value,
                payment_method: paymentMethod.value,
                discount: parseFloat(cartDiscount.value) || 0,
                tax_percent: parseFloat(cartTax.value) || 0,
                tax_amount: parseFloat(document.getElementById('cart-tax-amount-input').value) || 0,
                notes: saleNotes.value,
                items: cart.map(item => ({
                    product_id: item.id,
                    quantity: item.quantity,
                    price: item.price
                }))
            };

            console.log('Checkout data:', data);

            fetch('/pos/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.error || 'حدث خطأ أثناء إتمام عملية البيع');
                    });
                }
                return response.json();
            })
            .then(data => {
                // عرض نموذج تأكيد البيع
                document.getElementById('receipt-id').textContent = data.sale_id;
                document.getElementById('receipt-date').textContent = new Date().toLocaleDateString();
                document.getElementById('receipt-customer').textContent = customerSelect.options[customerSelect.selectedIndex].text;
                document.getElementById('receipt-payment').textContent = paymentMethod.options[paymentMethod.selectedIndex].text;
                document.getElementById('receipt-total').textContent = cartTotal.textContent;

                document.getElementById('print-receipt').href = `/pos/receipt/${data.sale_id}`;

                const checkoutModal = new bootstrap.Modal(document.getElementById('checkout-modal'));
                checkoutModal.show();

                // تفريغ السلة
                clearCart();
            })
            .catch(error => {
                console.error('Error during checkout:', error);
                toastr.error(error.message || 'حدث خطأ أثناء إتمام عملية البيع');
            });
        }

        // تفريغ السلة
        function clearCart() {
            cart = [];
            updateCart();
        }

        // مستمعي الأحداث
        warehouseSelect.addEventListener('change', loadWarehouseProducts);

        searchInput.addEventListener('input', searchProducts);

        barcodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchByBarcode();
            }
        });

        cartDiscount.addEventListener('input', updateTotals);
        cartTax.addEventListener('input', updateTotals);

        checkoutBtn.addEventListener('click', checkout);

        clearCartBtn.addEventListener('click', clearCart);

        document.getElementById('new-sale-btn').addEventListener('click', function() {
            loadWarehouseProducts();
        });

        // فلترة حسب الفئات
        categoryFilters.forEach(filter => {
            filter.addEventListener('click', function() {
                categoryFilters.forEach(f => f.classList.remove('active'));
                this.classList.add('active');

                // التعامل مع القيم بشكل صحيح
                activeCategory = this.dataset.category;
                // إذا كانت القيمة فارغة أو "null" نضعها null
                if (activeCategory === '' || activeCategory === 'null' || activeCategory === undefined) {
                    activeCategory = null;
                }

                console.log('Category filter clicked:', activeCategory);
                searchProducts();
            });
        });

        // فلترة حسب العلامات التجارية
        brandFilters.forEach(filter => {
            filter.addEventListener('click', function() {
                brandFilters.forEach(f => f.classList.remove('active'));
                this.classList.add('active');

                // التعامل مع القيم بشكل صحيح
                activeBrand = this.dataset.brand;
                // إذا كانت القيمة فارغة أو "null" نضعها null
                if (activeBrand === '' || activeBrand === 'null' || activeBrand === undefined) {
                    activeBrand = null;
                }

                console.log('Brand filter clicked:', activeBrand);
                searchProducts();
            });
        });

        // تحميل المنتجات عند تحميل الصفحة
        loadWarehouseProducts();
    });
</script>
@endsection
