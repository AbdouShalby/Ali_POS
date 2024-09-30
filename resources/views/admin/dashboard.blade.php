@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>لوحة التحكم</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">إجمالي المبيعات</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalSales }} جنيه</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">عدد المنتجات</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalProducts }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">عدد العملاء</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalCustomers }}</h5>
                    </div>
                </div>
            </div>
            <!-- يمكنك إضافة المزيد من البطاقات هنا -->
        </div>

        <!-- عرض المنتجات منخفضة المخزون -->
        <div class="row">
            <div class="col-md-12">
                <h3>المنتجات منخفضة المخزون</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>اسم المنتج</th>
                        <th>الكمية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->quantity }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
