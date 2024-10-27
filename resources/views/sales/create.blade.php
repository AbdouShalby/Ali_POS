@extends('layouts.app')

@section('title', 'إضافة عملية بيع جديدة')

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة عملية بيع جديدة</h1>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>خطأ!</strong> يرجى تصحيح الأخطاء التالية:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <!-- حقل العميل -->
            <div class="mb-3">
                <label for="customer_id" class="form-label">العميل</label>
                <div class="input-group">
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="">اختر العميل</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        + إضافة عميل
                    </button>
                </div>
            </div>

            <!-- حقل المنتج -->
            <div class="product-item mb-3">
                <label for="product_id">المنتج</label>
                <div class="input-group">
                    <select name="products[0][product_id]" class="form-select" required>
                        <option value="">اختر المنتج</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        + إضافة منتج
                    </button>
                </div>

                <label for="quantity">الكمية</label>
                <input type="number" name="products[0][quantity]" class="form-control" min="1" required>

                <label for="price">السعر</label>
                <input type="number" name="products[0][price]" class="form-control" min="0" step="0.01" required>
            </div>

            <button type="button" class="btn btn-primary mt-3" id="addProductButton">إضافة منتج آخر</button>

            <!-- حقل الملاحظة -->
            <div class="mb-3 mt-3">
                <label for="notes" class="form-label">ملاحظة</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            </div>

            <!-- حقل تاريخ البيع -->
            <div class="mb-3">
                <label for="sale_date" class="form-label">تاريخ البيع</label>
                <input type="date" class="form-control" id="sale_date" name="sale_date" value="{{ old('sale_date', now()->format('Y-m-d')) }}" required>
            </div>

            <!-- زر الحفظ والإلغاء -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> حفظ
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
    </div>

    <!-- Modal لإضافة عميل جديد -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">إضافة عميل جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">اسم العميل</label>
                            <input type="text" class="form-control" id="customer_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" id="customer_phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="customer_email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="customer_address" name="address" required>
                        </div>
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal لإضافة منتج جديد -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">إضافة منتج جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        @csrf
                        <div class="mb-3">
                            <label for="product_name" class="form-label">اسم المنتج</label>
                            <input type="text" class="form-control" id="product_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_code" class="form-label">كود المنتج</label>
                            <input type="text" class="form-control" id="product_code" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_category" class="form-label">القسم</label>
                            <select class="form-select" id="product_category" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_brand" class="form-label">العلامة التجارية</label>
                            <select class="form-select" id="product_brand" name="brand_id" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_quantity" class="form-label">الكمية</label>
                            <input type="number" class="form-control" id="product_quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_cost" class="form-label">التكلفة</label>
                            <input type="number" class="form-control" id="product_cost" name="cost" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label">السعر</label>
                            <input type="number" class="form-control" id="product_price" name="price" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="wholesale_price" class="form-label">سعر الجملة</label>
                            <input type="number" class="form-control" id="wholesale_price" name="wholesale_price" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="min_sale_price" class="form-label">أقل سعر بيع</label>
                            <input type="number" class="form-control" id="min_sale_price" name="min_sale_price" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_image" class="form-label">صورة المنتج</label>
                            <input type="file" class="form-control" id="product_image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let productCount = 1;

            // إضافة منتج جديد
            $('#addProductButton').on('click', function() {
                var productItem = `
                <div class="product-item mb-3">
                    <label for="product_id">المنتج</label>
                    <select name="products[` + productCount + `][product_id]" class="form-select" required>
                        <option value="">اختر المنتج</option>
                        @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                </select>

                <label for="quantity">الكمية</label>
                <input type="number" name="products[` + productCount + `][quantity]" class="form-control" min="1" required>

                    <label for="price">السعر</label>
                    <input type="number" name="products[` + productCount + `][price]" class="form-control" min="0" step="0.01" required>
                </div>
            `;
                $('.product-item:last').after(productItem);
                productCount++;
            });

            // إضافة العميل
            $('#addCustomerForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('customers.store') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#addCustomerModal').modal('hide');
                            $('#customer_id').append(new Option(response.name, response.id, true, true)).trigger('change');
                            alert('تم إضافة العميل بنجاح');
                        } else {
                            alert('فشل في إضافة العميل');
                        }
                    },
                    error: function(response) {
                        alert('فشل في إضافة العميل');
                    }
                });
            });

            // إضافة المنتج
            $('#addProductForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('products.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#addProductModal').modal('hide');
                            $('#product_id').append(new Option(response.name, response.id, true, true)).trigger('change');
                            alert('تم إضافة المنتج بنجاح');
                        } else {
                            alert('فشل في إضافة المنتج');
                        }
                    },
                    error: function(response) {
                        alert('فشل في إضافة المنتج');
                    }
                });
            });
        });
    </script>
@endsection
