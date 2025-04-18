<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerSalesController extends Controller
{
    public function index(Request $request, Customer $customer)
    {
        $query = Sale::where('customer_id', $customer->id);

        // Apply filters
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Get sales with pagination
        $sales = $query->latest()->paginate(10);

        // Calculate totals
        $totals = $query->select([
            DB::raw('COUNT(*) as total_sales'),
            DB::raw('SUM(total_amount) as total_amount'),
            DB::raw('SUM(tax) as total_tax'),
            DB::raw('SUM(discount) as total_discount')
        ])->first();

        // Get daily sales data for chart
        $dailySales = Sale::where('customer_id', $customer->id)
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as total_amount')
            ])
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return view('customers.sales', [
            'customer' => $customer,
            'sales' => $sales,
            'totalSales' => $totals->total_sales,
            'totalAmount' => $totals->total_amount,
            'totalTax' => $totals->total_tax,
            'totalDiscount' => $totals->total_discount,
            'dailySales' => $dailySales
        ]);
    }

    public function exportPdf(Customer $customer)
    {
        // TODO: Implement PDF export
        return back()->with('error', 'PDF export not implemented yet');
    }

    public function exportExcel(Customer $customer)
    {
        // TODO: Implement Excel export
        return back()->with('error', 'Excel export not implemented yet');
    }
} 