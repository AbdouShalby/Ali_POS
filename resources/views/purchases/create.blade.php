@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>إضافة فاتورة شراء جديدة</h1>
        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>رقم الفاتورة</label>
                <input type="text" name="invoice_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label>المورد</label>
                <select name="supplier_id" class="form-control" required>
                    <option value="">اختر المورد</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>تاريخ الشراء</label>
                <input type="date" name="purchase_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>المنتجات</label>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody id="products_table">
                    <tr>
                        <td>
                            <select name="products[0][product_id]" class="form-control" required>
                                <option value="">اختر المنتج</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="products[0][quantity]" class="form-control" min="1" required>
                        </td>
                        <td>
                            <input type="number" name="products[0][price]" class="form-control" min="0" step="0.01" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-product">حذف</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary" id="add_product">إضافة منتج آخر</button>
            </div>
            <div class="form-group">
                <label>ملاحظات</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">حفظ</button>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        let productIndex = 1;
        document.getElementById('add_product').addEventListener('click', function() {
            let newRow = `
            <tr>
                <td>
                    <select name="products[${productIndex}][product_id]" class="form-control" required>
                        <option value="">اختر المنتج</option>
                        @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="products[${productIndex}][quantity]" class="form-control" min="1" required>
                </td>
                <td>
                    <input type="number" name="products[${productIndex}][price]" class="form-control" min="0" step="0.01" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-product">حذف</button>
                </td>
            </tr>
        `;
            document.getElementById('products_table').insertAdjacentHTML('beforeend', newRow);
            productIndex++;
        });

        document.getElementById('products_table').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-product')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
@endsection
