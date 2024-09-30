<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Sale::sum('total_amount');
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('quantity', '<', 10)->get();

        return view('admin.dashboard', compact('totalSales', 'totalCustomers', 'totalProducts', 'lowStockProducts'));
    }
}
