<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalSales = Sale::sum('total_amount');
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('quantity', '<', 10)->get();

        return view('admin.dashboard', compact('totalSales', 'totalCustomers', 'totalProducts', 'lowStockProducts'));
    }
}
