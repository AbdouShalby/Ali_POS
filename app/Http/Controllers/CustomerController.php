<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage customers');
    }

    public function index(Request $request)
    {
        $query = Customer::query();

        // البحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // الترتيب
        if ($request->has('order')) {
            $orderBy = $request->order;
            $query->orderBy($orderBy);
        } else {
            $query->latest();
        }

        // إحصائيات العملاء
        $totalSales = \App\Models\Sale::sum('total_amount');
        $averagePurchase = \App\Models\Sale::avg('total_amount') ?? 0;

        $customers = $query->paginate(10);

        return view('customers.index', compact('customers', 'totalSales', 'averagePurchase'));
    }

    public function create()
    {
        return view('customers.create')->with('activePage', 'customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:20|unique:customers,phone',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('customers.customer_added_successfully'),
                'customer' => $customer,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        return redirect()->route('customers.index')->with('success', __('customers.customer_added_successfully'));
    }

    public function show(Customer $customer)
    {
        // Get recent purchases with pagination
        $purchases = $customer->sales()->latest()->take(10)->get();

        // Calculate totals and statistics
        $totals = $customer->sales()
            ->select([
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM(total_amount) as total_amount'),
                DB::raw('AVG(total_amount) as average_purchase'),
                DB::raw('MAX(created_at) as last_purchase_date')
            ])
            ->first();

        // Format the statistics
        $total_purchases = $totals->total_sales ?? 0;
        $average_purchase = number_format($totals->average_purchase ?? 0, 2);
        $last_purchase = $totals->last_purchase_date;

        return view('customers.show', compact(
            'customer',
            'purchases',
            'total_purchases',
            'average_purchase',
            'last_purchase'
        ));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'))->with('activePage', 'customers');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20|unique:customers,phone,' . $id,
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('customers.customer_updated_successfully'),
                'customer' => $customer,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        return redirect()->route('customers.index')->with('success', __('customers.customer_updated_successfully'));
    }

    public function destroy(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('customers.customer_deleted_successfully'),
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        return redirect()->route('customers.index')->with('success', __('customers.customer_deleted_successfully'));
    }
}
