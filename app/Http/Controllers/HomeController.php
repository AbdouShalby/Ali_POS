<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ExternalPurchase;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Maintenance;
use App\Models\CryptoGateway;
use App\Models\CryptoTransaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalSales = Sale::sum('total_amount');
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalPurchases = Purchase::sum('total_amount');
        $phonesInMaintenance = Maintenance::count();
        $totalCryptoBalance = CryptoGateway::sum('balance');
        $totalExternalPurchases = ExternalPurchase::sum('amount');
        $cashBalance = $totalSales + $totalCryptoBalance - $totalPurchases - $totalExternalPurchases;
//        $lowStockProducts = Product::where('quantity', '<', 10)->get();
//        $veryLowStockProducts = Product::where('quantity', '<', 5)->get();
        $topSellingProducts = SaleItem::select('product_id')
            ->with('product')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();
        $latestMaintenances = Maintenance::latest()->take(10)->get();
        $latestSales = Sale::latest()->take(10)->get();
        $latestPurchases = Purchase::latest()->take(10)->get();
        $latestCategories = Category::latest()->take(5)->get();
        $latestCustomers = Customer::latest()->take(5)->get();
        $latestSuppliers = Supplier::latest()->take(5)->get();
        $latestCryptoBuys = CryptoTransaction::where('type', 'buy')->latest()->take(10)->get();
        $latestCryptoSells = CryptoTransaction::where('type', 'sell')->latest()->take(10)->get();
        return view('admin.dashboard', compact(
            'totalSales',
            'totalCustomers',
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalPurchases',
            'phonesInMaintenance',
            'cashBalance',
            'totalCryptoBalance',
            'topSellingProducts',
            'latestMaintenances',
            'latestSales',
            'latestPurchases',
            'latestCategories',
            'latestCustomers',
            'latestSuppliers',
            'latestCryptoBuys',
            'latestCryptoSells',
            'totalExternalPurchases',
        ))->with('activePage', 'dashboard');
    }
}
