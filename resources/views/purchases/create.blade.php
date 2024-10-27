@extends('layouts.app')

@section('title', 'إضافة عملية شراء جديدة')

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة عملية شراء جديدة</h1>

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

        <form action="{{ route('purchases.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="invoice_number" class="form-label">رقم الفاتورة</label>
                <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" required>
            </div>
            <div class="mb-3">
                <label for="supplier_id" class="form-label">المورد</label>
                <div class="input-group">
                    <select class="form-select" id="supplier_id" name="supplier_id" required>
                        <option value="">اختر المورد</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                        إضافة
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label for="purchase_date" class="form-label">تاريخ الشراء</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') ?? date('Y-m-d') }}" required>
            </div>
            <div id="product-container" class="mb-3">
                <label for="products" class="form-label">المنتجات (اختياري)</label>
                <div class="product-row">
                    <select class="form-select mt-2" name="products[0][product_id]">
                        <option value="">اختر المنتج</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" class="form-control mt-2" name="products[0][quantity]" placeholder="الكمية" min="1">
                    <input type="number" class="form-control mt-2" name="products[0][price]" placeholder="السعر" step="0.01">
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-2" onclick="addProductRow()">إضافة منتج آخر</button>
            <div class="mb-3">
                <label for="invoice_file" class="form-label">ملف الفاتورة</label>
                <input type="file" class="form-control" id="invoice_file" name="invoice_file" accept=".pdf,.jpeg,.jpg,.png">
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> حفظ
            </button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
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

    @section('scripts')
        <script>
            document.getElementById('addSupplierForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = {
                    name: document.getElementById('supplier_name').value,
                    email: document.getElementById('supplier_email').value,
                    phone: document.getElementById('supplier_phone').value,
                    address: document.getElementById('supplier_address').value,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };

                fetch('/suppliers', {
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
                            alert('تم إضافة المورد بنجاح!');

                            // إعادة تحميل القائمة بعد إضافة المورد الجديد
                            let supplierSelect = document.getElementById('supplier_id');
                            let newOption = new Option(formData.name, data.supplier_id, true, true);
                            supplierSelect.add(newOption);

                            // إعادة تعيين النموذج وإغلاق الـ Modal
                            document.getElementById('addSupplierForm').reset();
                            let modalElement = document.getElementById('addSupplierModal');
                            let modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide();
                        } else {
                            alert('حدث خطأ أثناء إضافة المورد.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء معالجة الطلب.');
                    });
            });

            function addProductRow() {
                const container = document.getElementById('product-container');
                const index = Date.now();

                const productRow = document.createElement('div');
                productRow.className = 'product-row mt-2';

                productRow.innerHTML = `
            <select class="form-select mt-2" name="products[${index}][product_id]">
                <option value="">اختر المنتج</option>
                @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
                </select>
                <input type="number" class="form-control mt-2" name="products[${index}][quantity]" placeholder="الكمية" min="1">
            <input type="number" class="form-control mt-2" name="products[${index}][price]" placeholder="السعر" step="0.01">
        `;

                container.appendChild(productRow);
            }
        </script>
    @endsection
@endsection
