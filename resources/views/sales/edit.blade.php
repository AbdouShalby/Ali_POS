@extends('layouts.app')

@section('title', 'تعديل عملية البيع')

@section('content')
    <div class="container">
        <h1 class="mb-4">تعديل عملية البيع رقم {{ $sale->id }}</h1>

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

        <form action="{{ route('sales.update', $sale->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="customer_id" class="form-label">العميل</label>
                <select class="form-select" id="customer_id" name="customer_id" required>
                    <option value="">اختر العميل</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="products-container">
                @foreach($sale->saleItems as $index => $item)
                    <div class="product-item mb-3">
                        <label for="product_id">المنتج</label>
                        <select name="products[{{ $index }}][product_id]" class="form-select" required>
                            <option value="">اختر المنتج</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>

                        <label for="quantity">الكمية</label>
                        <input type="number" name="products[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" min="1" required>

                        <label for="price">السعر</label>
                        <input type="number" name="products[{{ $index }}][price]" class="form-control" value="{{ $item->price }}" min="0" step="0.01" required>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-primary mt-3" id="addProductButton">إضافة منتج آخر</button>

            <div class="mb-3 mt-3">
                <label for="notes" class="form-label">ملاحظة</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ $sale->notes }}</textarea>
            </div>

            <div class="mb-3">
                <label for="sale_date" class="form-label">تاريخ البيع</label>
                <input type="date" class="form-control" id="sale_date" name="sale_date" value="{{ $sale->sale_date ? \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') : '' }}" required>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> حفظ التعديلات
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> إلغاء
            </a>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            let productCount = {{ $sale->saleItems->count() }};

            $('#addProductButton').click(function() {
                let productItem = `
                    <div class="product-item mb-3">
                        <label for="product_id">المنتج</label>
                        <select name="products[${productCount}][product_id]" class="form-select" required>
                            <option value="">اختر المنتج</option>
                            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                </select>

                <label for="quantity">الكمية</label>
                <input type="number" name="products[${productCount}][quantity]" class="form-control" min="1" required>

                        <label for="price">السعر</label>
                        <input type="number" name="products[${productCount}][price]" class="form-control" min="0" step="0.01" required>
                    </div>
                `;
                $('#products-container').append(productItem);
                productCount++;
            });
        });
    </script>
@endsection
