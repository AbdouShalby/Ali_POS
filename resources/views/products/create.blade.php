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
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">اختر القسم</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- العلامة التجارية -->
            <div class="mb-3">
                <label for="brand_id" class="form-label">العلامة التجارية</label>
                <select class="form-select" id="brand_id" name="brand_id">
                    <option value="">اختر العلامة التجارية</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
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
                <div class="mb-3" id="customer_select" style="display: {{ old('client_type') == 'customer' ? 'block' : 'none' }};">
                    <label for="customer_id" class="form-label">الزبون</label>
                    <select class="form-select" id="customer_id" name="customer_id">
                        <option value="">اختر الزبون</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="supplier_select" style="display: {{ old('client_type') == 'supplier' ? 'block' : 'none' }};">
                    <label for="supplier_id" class="form-label">المورد</label>
                    <select class="form-select" id="supplier_id" name="supplier_id">
                        <option value="">اختر المورد</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- طريقة الدفع -->
                <div class="mb-3">
                    <label for="payment_method" class="form-label">طريقة الدفع</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>كاش</option>
                        <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>آجل</option>
                    </select>
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
        </script>
    @endsection

@endsection
