@extends('layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة منتج جديد</h1>

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

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- الاسم -->
            <div class="mb-3">
                <label for="name" class="form-label">اسم المنتج</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <!-- الكود (الباركود) -->
            <div class="mb-3">
                <label for="code" class="form-label">كود المنتج (الباركود)</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
            </div>

            <!-- القسم -->
            <div class="mb-3">
                <label for="category_id" class="form-label">القسم</label>
                <div class="input-group">
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">اختر القسم</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        إضافة
                    </button>
                </div>
            </div>

            <!-- العلامة التجارية -->
            <div class="mb-3">
                <label for="brand_id" class="form-label">العلامة التجارية</label>
                <div class="input-group">
                    <select class="form-select" id="brand_id" name="brand_id">
                        <option value="">اختر العلامة التجارية</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                        إضافة
                    </button>
                </div>
            </div>

            <!-- الكمية -->
            <div class="mb-3">
                <label for="quantity" class="form-label">الكمية</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
            </div>

            <!-- تنبيه المخزون -->
            <div class="mb-3">
                <label for="stock_alert" class="form-label">تنبيه المخزون</label>
                <input type="number" class="form-control" id="stock_alert" name="stock_alert" value="{{ old('stock_alert') }}" required>
            </div>

            <!-- التكلفة -->
            <div class="mb-3">
                <label for="cost" class="form-label">التكلفة</label>
                <input type="number" class="form-control" id="cost" name="cost" value="{{ old('cost') }}" step="0.01" required>
            </div>

            <!-- سعر البيع -->
            <div class="mb-3">
                <label for="price" class="form-label">سعر البيع</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" step="0.01" required>
            </div>

            <!-- سعر الجملة -->
            <div class="mb-3">
                <label for="wholesale_price" class="form-label">سعر الجملة</label>
                <input type="number" class="form-control" id="wholesale_price" name="wholesale_price" value="{{ old('wholesale_price') }}" step="0.01" required>
            </div>

            <!-- أقل سعر للبيع -->
            <div class="mb-3">
                <label for="min_sale_price" class="form-label">أقل سعر للبيع</label>
                <input type="number" class="form-control" id="min_sale_price" name="min_sale_price" value="{{ old('min_sale_price') }}" step="0.01" required>
            </div>

            <!-- الصورة -->
            <div class="mb-3">
                <label for="image" class="form-label">صورة المنتج</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <!-- هل هذا موبايل؟ -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_mobile" name="is_mobile" {{ old('is_mobile') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_mobile">هل هذا موبايل؟</label>
            </div>

            <!-- تفاصيل الموبايل (تظهر إذا كان المنتج موبايلًا) -->
            <div id="mobile_details" style="display: {{ old('is_mobile') ? 'block' : 'none' }};">
                <hr>
                <h4>تفاصيل الموبايل</h4>

                <!-- اللون -->
                <div class="mb-3">
                    <label for="color" class="form-label">اللون</label>
                    <input type="text" class="form-control" id="color" name="color" value="{{ old('color') }}">
                </div>

                <!-- المساحة -->
                <div class="mb-3">
                    <label for="storage" class="form-label">المساحة (جيجابايت/تيرابايت)</label>
                    <input type="text" class="form-control" id="storage" name="storage" value="{{ old('storage') }}">
                </div>

                <!-- صحة البطارية -->
                <div class="mb-3">
                    <label for="battery_health" class="form-label">صحة البطارية (%)</label>
                    <input type="number" class="form-control" id="battery_health" name="battery_health" value="{{ old('battery_health') }}" step="0.01">
                </div>

                <!-- الرام -->
                <div class="mb-3">
                    <label for="ram" class="form-label">الرام (جيجابايت/تيرابايت)</label>
                    <input type="text" class="form-control" id="ram" name="ram" value="{{ old('ram') }}">
                </div>

                <!-- معالج الرسوم -->
                <div class="mb-3">
                    <label for="gpu" class="form-label">معالج الرسوم</label>
                    <input type="text" class="form-control" id="gpu" name="gpu" value="{{ old('gpu') }}">
                </div>

                <!-- المعالج -->
                <div class="mb-3">
                    <label for="cpu" class="form-label">المعالج</label>
                    <input type="text" class="form-control" id="cpu" name="cpu" value="{{ old('cpu') }}">
                </div>

                <!-- حالة الجهاز -->
                <div class="mb-3">
                    <label for="condition" class="form-label">حالة الجهاز</label>
                    <input type="text" class="form-control" id="condition" name="condition" value="{{ old('condition') }}">
                </div>

                <!-- وصف الجهاز -->
                <div class="mb-3">
                    <label for="device_description" class="form-label">وصف الجهاز</label>
                    <textarea class="form-control" id="device_description" name="device_description" rows="3">{{ old('device_description') }}</textarea>
                </div>

                <!-- هل توجد علبة الجهاز؟ -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="has_box" name="has_box" {{ old('has_box') ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_box">هل توجد علبة الجهاز؟</label>
                </div>
                <!-- نوع العميل -->
                <div class="mb-3">
                    <label for="client_type" class="form-label">نوع العميل</label>
                    <select class="form-select" id="client_type" name="client_type">
                        <option value="">اختر النوع</option>
                        <option value="customer" {{ old('client_type') == 'customer' ? 'selected' : '' }}>زبون</option>
                        <option value="supplier" {{ old('client_type') == 'supplier' ? 'selected' : '' }}>مورد</option>
                    </select>
                </div>

                <!-- اختيار العميل (زبون أو مورد) -->
                <div class="mb-3" id="customer_select" style="display: none;">
                    <label for="customer_id" class="form-label">الزبون</label>
                    <div class="input-group">
                        <select class="form-select" id="customer_id" name="customer_id">
                            <option value="">اختر الزبون</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                            إضافة
                        </button>
                    </div>
                </div>

                <div class="mb-3" id="supplier_select" style="display: none;">
                    <label for="supplier_id" class="form-label">المورد</label>
                    <div class="input-group">
                        <select class="form-select" id="supplier_id" name="supplier_id">
                            <option value="">اختر المورد</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                            إضافة
                        </button>
                    </div>
                </div>

                <!-- طريقة الدفع -->
                <div class="mb-3">
                    <label for="payment_method" class="form-label">طريقة الدفع</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>كاش</option>
                        <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>آجل</option>
                    </select>
                </div>

                <!-- Scan ID File -->
                <div class="mb-3">
                    <label for="scan_id" class="form-label">ملف Scan ID</label>
                    <input type="file" class="form-control" id="scan_id" name="scan_id" accept=".pdf,.jpeg,.jpg,.png">
                </div>

                <!-- Scan Document File -->
                <div class="mb-3">
                    <label for="scan_documents" class="form-label">ملف Scan Document</label>
                    <input type="file" class="form-control" id="scan_documents" name="scan_documents" accept=".pdf,.jpeg,.jpg,.png">
                </div>
            </div>

            <!-- زر الحفظ -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> حفظ
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
    </div>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">إضافة قسم جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="category_name" class="form-label">اسم القسم</label>
                            <input type="text" class="form-control" id="category_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">إضافة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">إضافة علامة تجارية جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="addBrandForm">
                        @csrf
                        <div class="mb-3">
                            <label for="brand_name" class="form-label">اسم العلامة التجارية</label>
                            <input type="text" class="form-control" id="brand_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">إضافة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">إضافة زبون جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">اسم الزبون</label>
                            <input type="text" class="form-control" id="customer_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="customer_email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" id="customer_phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="customer_address" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="customer_notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control" id="customer_notes" name="notes" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">إضافة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">إضافة مورد جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        @csrf
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">اسم المورد</label>
                            <input type="text" class="form-control" id="supplier_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="supplier_email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="supplier_phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" id="supplier_phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="supplier_address" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="supplier_address" name="address">
                        </div>
                        <button type="submit" class="btn btn-primary">إضافة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript لإظهار وإخفاء تفاصيل الموبايل واختيار العميل -->
    @section('scripts')
        <script>
            document.getElementById('is_mobile').addEventListener('change', function() {
                var mobileDetails = document.getElementById('mobile_details');
                mobileDetails.style.display = this.checked ? 'block' : 'none';
            });

            document.getElementById('client_type').addEventListener('change', function() {
                var clientType = this.value;
                document.getElementById('customer_select').style.display = clientType === 'customer' ? 'block' : 'none';
                document.getElementById('supplier_select').style.display = clientType === 'supplier' ? 'block' : 'none';
            });

            document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = {
                    name: document.getElementById('category_name').value,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };

                fetch('/categories', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': formData._token
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('تم إضافة القسم بنجاح!');

                            // تحديث القائمة بعد إضافة القسم الجديد
                            let categorySelect = document.getElementById('category_id');
                            let newOption = new Option(formData.name, data.category_id, true, true);
                            categorySelect.add(newOption);

                            // إعادة تعيين النموذج وإغلاق الـ Modal
                            document.getElementById('addCategoryForm').reset();
                            let modalElement = document.getElementById('addCategoryModal');
                            let modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide();
                        } else {
                            alert('حدث خطأ أثناء إضافة القسم.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء معالجة الطلب.');
                    });
            });

            document.getElementById('addBrandForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = {
                    name: document.getElementById('brand_name').value,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };

                fetch('/brands', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': formData._token
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('تم إضافة العلامة التجارية بنجاح!');

                            // تحديث القائمة بعد إضافة العلامة التجارية الجديدة
                            let brandSelect = document.getElementById('brand_id');
                            let newOption = new Option(formData.name, data.brand_id, true, true);
                            brandSelect.add(newOption);

                            // إعادة تعيين النموذج وإغلاق الـ Modal
                            document.getElementById('addBrandForm').reset();
                            let modalElement = document.getElementById('addBrandModal');
                            let modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide();
                        } else {
                            alert('حدث خطأ أثناء إضافة العلامة التجارية.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء معالجة الطلب.');
                    });
            });

            document.getElementById('addCustomerForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    alert('CSRF token غير موجود في الصفحة.');
                    return;
                }

                let formData = {
                    name: document.getElementById('customer_name').value,
                    email: document.getElementById('customer_email').value,
                    phone: document.getElementById('customer_phone').value,
                    address: document.getElementById('customer_address').value,
                    notes: document.getElementById('customer_notes').value,
                };

                fetch('/customers', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('حدث خطأ في الاستجابة من السيرفر.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert(data.message);

                            document.getElementById('addCustomerForm').reset();

                            let modalElement = document.getElementById('addCustomerModal');
                            let modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide();

                            let customerSelect = document.getElementById('customer_id');
                            if (customerSelect) {
                                let newOption = new Option(formData.name, data.customer_id, true, true);
                                customerSelect.add(newOption);
                            }
                        } else {
                            alert('حدث خطأ أثناء إضافة العميل.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء إرسال البيانات.');
                    });
            });

            document.getElementById('addSupplierForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    alert('CSRF token غير موجود في الصفحة.');
                    return;
                }

                let formData = {
                    name: document.getElementById('supplier_name').value,
                    email: document.getElementById('supplier_email').value,
                    phone: document.getElementById('supplier_phone').value,
                    address: document.getElementById('supplier_address').value,
                };

                fetch('/suppliers', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('حدث خطأ في الاستجابة من السيرفر.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert(data.message);

                            document.getElementById('addSupplierForm').reset();

                            let modalElement = document.getElementById('addSupplierModal');
                            let modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide();

                            let customerSelect = document.getElementById('supplier_id');
                            if (customerSelect) {
                                let newOption = new Option(formData.name, data.customer_id, true, true);
                                customerSelect.add(newOption);
                            }
                        } else {
                            alert('حدث خطأ أثناء إضافة العميل.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء إرسال البيانات.');
                    });
            });
        </script>
    @endsection

@endsection
