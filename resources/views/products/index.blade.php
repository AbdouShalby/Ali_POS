@extends('layouts.app')

@section('title', 'قائمة المنتجات')

@section('content')
    <div class="container">
        <h1 class="mb-4">قائمة المنتجات</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <!-- نموذج البحث والفلاتر -->
        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
            <div class="row">
                <!-- البحث بالاسم -->
                <div class="col-md-3 mb-3">
                    <input type="text" name="search" class="form-control" placeholder="ابحث بالاسم" value="{{ request('search') }}">
                </div>

                <!-- الفلتر حسب التصنيف -->
                <div class="col-md-3 mb-3">
                    <select name="category" class="form-select">
                        <option value="">كل الأقسام</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- الفلتر حسب العلامة التجارية -->
                <div class="col-md-3 mb-3">
                    <select name="brand" class="form-select">
                        <option value="">كل العلامات التجارية</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- زر البحث -->
                <div class="col-md-1 mb-3">
                    <button type="submit" class="btn btn-primary w-100">بحث</button>
                </div>
            </div>
        </form>

        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> إضافة منتج جديد
        </a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>اسم المنتج</th>
                    <th>كود المنتج</th>
                    <th>القسم</th>
                    <th>العلامة التجارية</th>
                    <th>الكمية</th>
                    <th>التكلفة</th>
                    <th>سعر البيع</th>
                    <th>سعر الجملة</th>
                    <th>أقل سعر للبيع</th>
                    <th>موبايل؟</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->category->name ?? 'غير محدد' }}</td>
                        <td>{{ $product->brand->name ?? 'غير محدد' }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ number_format($product->cost, 2) }} جنيه</td>
                        <td>{{ number_format($product->price, 2) }} جنيه</td>
                        <td>{{ number_format($product->wholesale_price, 2) }} جنيه</td>
                        <td>{{ number_format($product->min_sale_price, 2) }} جنيه</td>
                        <td>{{ $product->mobileDetail ? 'نعم' : 'لا' }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> عرض
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> تعديل
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>

                    @if($product->mobileDetail)
                        <tr>
                            <td colspan="11">
                                <strong>تفاصيل الموبايل:</strong><br>
                                <ul>
                                    <li><strong>اللون:</strong> {{ $product->mobileDetail->color }}</li>
                                    <li><strong>المساحة:</strong> {{ $product->mobileDetail->storage }}</li>
                                    <li><strong>صحة البطارية:</strong> {{ $product->mobileDetail->battery_health }}%</li>
                                    <li><strong>الرام:</strong> {{ $product->mobileDetail->ram }}</li>
                                    <li><strong>معالج الرسوم:</strong> {{ $product->mobileDetail->gpu }}</li>
                                    <li><strong>المعالج:</strong> {{ $product->mobileDetail->cpu }}</li>
                                    <li><strong>حالة الجهاز:</strong> {{ $product->mobileDetail->condition }}</li>
                                    <li><strong>وصف الجهاز:</strong> {{ $product->mobileDetail->device_description }}</li>
                                    <li><strong>هل توجد علبة:</strong> {{ $product->mobileDetail->has_box ? 'نعم' : 'لا' }}</li>
                                </ul>
                            </td>
                        </tr>
                    @endif

                @empty
                    <tr>
                        <td colspan="11" class="text-center">لا توجد منتجات.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- روابط الصفحات -->
        {{ $products->links() }}
    </div>
@endsection
