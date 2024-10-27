@extends('layouts.app')

@section('title', 'تعديل عملية شراء')

@section('content')
    <div class="container">
        <h1 class="mb-4">تعديل عملية الشراء رقم {{ $purchase->id }}</h1>

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

        <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <input type="text" class="form-control" id="invoice_number" name="invoice_number"
                       value="{{ old('invoice_number', $purchase->invoice_number) }}" hidden="" required>
            </div>

            <!-- المورد -->
            <div class="mb-3">
                <label for="supplier_id" class="form-label">المورد</label>
                <select class="form-select" id="supplier_id" name="supplier_id" required>
                    <option value="">اختر المورد</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- المنتجات المشتراة -->
            <div id="products-container">
                @foreach ($purchase->purchaseItems as $index => $item)
                    <div class="product-item border p-3 mb-3">
                        <h5 class="mb-3">المنتج {{ $index + 1 }}</h5>

                        <div class="mb-3">
                            <label for="product_id_{{ $index }}" class="form-label">المنتج</label>
                            <select class="form-select" id="product_id_{{ $index }}" name="products[{{ $index }}][product_id]" required>
                                <option value="">اختر المنتج</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantity_{{ $index }}" class="form-label">الكمية</label>
                            <input type="number" class="form-control" id="quantity_{{ $index }}" name="products[{{ $index }}][quantity]"
                                   value="{{ old('products.' . $index . '.quantity', $item->quantity) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="price_{{ $index }}" class="form-label">السعر (لكل وحدة)</label>
                            <input type="number" class="form-control" id="price_{{ $index }}" name="products[{{ $index }}][price]"
                                   value="{{ old('products.' . $index . '.price', $item->price) }}" step="0.01" required>
                        </div>

                        <!-- زر حذف المنتج -->
                        <button type="button" class="btn btn-danger remove-product" data-index="{{ $index }}">حذف المنتج</button>
                    </div>
                @endforeach
            </div>

            <!-- زر إضافة منتج جديد -->
            <button type="button" class="btn btn-primary mb-3" id="add-product-btn">إضافة منتج آخر</button>

            <!-- تاريخ الشراء -->
            <div class="mb-3">
                <label for="purchase_date" class="form-label">تاريخ الشراء</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date"
                       value="{{ old('purchase_date', \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d')) }}" required>
            </div>

            <!-- ملف الفاتورة -->
            <div class="mb-3">
                <label for="invoice_file" class="form-label">ملف الفاتورة</label>
                @if($purchase->invoice_file)
                    <p>الملف الحالي: <a href="{{ asset('/invoices/' . $purchase->invoice_file) }}" target="_blank">عرض الملف</a></p>
                @endif
                <input type="file" class="form-control" id="invoice_file" name="invoice_file" accept=".pdf,.jpeg,.jpg,.png">
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> تحديث
            </button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
    </div>

    <!-- سكريبت لإضافة وحذف المنتجات -->
    <script>
        document.getElementById('add-product-btn').addEventListener('click', function() {
            const index = document.querySelectorAll('.product-item').length;
            const container = document.getElementById('products-container');
            const productItem = `
                <div class="product-item border p-3 mb-3">
                    <h5 class="mb-3">المنتج ${index + 1}</h5>

                    <div class="mb-3">
                        <label for="product_id_${index}" class="form-label">المنتج</label>
                        <select class="form-select" id="product_id_${index}" name="products[${index}][product_id]" required>
                            <option value="">اختر المنتج</option>
                            @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity_${index}" class="form-label">الكمية</label>
                        <input type="number" class="form-control" id="quantity_${index}" name="products[${index}][quantity]" required>
                    </div>

                    <div class="mb-3">
                        <label for="price_${index}" class="form-label">السعر (لكل وحدة)</label>
                        <input type="number" class="form-control" id="price_${index}" name="products[${index}][price]" step="0.01" required>
                    </div>

                    <button type="button" class="btn btn-danger remove-product" data-index="${index}">حذف المنتج</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', productItem);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-item').remove();
            }
        });
    </script>
@endsection
