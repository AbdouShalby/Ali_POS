<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\CashTransaction;
use App\Models\Customer;
use App\Models\Debt;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalSales = Sale::sum('total_amount');
        $totalPurchases = Purchase::sum('total_amount');
        $totalExternalPurchases = ExternalPurchase::sum('amount');
        $totalMaintenance = Maintenance::sum('cost');
        $totalDebt = Debt::where('status', 'unpaid')->sum('amount');
        $cashBalance = CashRegister::sum('balance');
        $totalProducts = Product::count();
        $totalProductsStock = DB::table('product_warehouse')->sum('stock');
        $totalCustomers = Customer::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $phonesInMaintenance = Maintenance::count();
        $maintenancePending = Maintenance::where('status', 'pending')->count();
        $maintenanceCompleted = Maintenance::where('status', 'completed')->count();
        $maintenanceInProgress = Maintenance::where('status', 'in_progress')->count();
        $totalCryptoBalance = CryptoGateway::sum('balance');
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
        $latestCryptoBuys = CryptoTransaction::orderBy('created_at', 'desc')->limit(10)->get();
        $latestCryptoSells = CryptoTransaction::orderBy('created_at', 'desc')->limit(10)->get();
        $last7Days = Carbon::now()->subDays(7);
        $incomeLast7Days = CashTransaction::where('transaction_type', 'sale')
            ->where('created_at', '>=', $last7Days)
            ->sum('amount');

        $expensesLast7Days = CashTransaction::where('transaction_type', 'purchase')
            ->where('created_at', '>=', $last7Days)
            ->sum('amount');
        return view('admin.dashboard', compact(
            'totalSales',
            'totalCustomers',
            'totalProducts',
            'totalProductsStock',
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
            'totalMaintenance',
            'totalDebt',
            'maintenancePending',
            'maintenanceCompleted',
            'maintenanceInProgress',
            'incomeLast7Days',
            'expensesLast7Days'
        ))->with('activePage', 'dashboard');
    }
}
