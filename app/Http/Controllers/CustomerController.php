<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage customers');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $customers = Customer::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%");
        })->paginate(10);

        return view('customers.index', compact('customers', 'search'))->with('activePage', 'customers');
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

    public function show(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $salesQuery = $customer->sales();

        if ($request->filled('search')) {
            $salesQuery->where('product_name', 'LIKE', "%{$request->search}%");
        }

        if ($request->filled('from') && $request->filled('to')) {
            $salesQuery->whereBetween('created_at', [$request->from, $request->to]);
        }

        $sales = $salesQuery->paginate(10);

        return view('customers.show', compact('customer', 'sales'))->with('activePage', 'customers');
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
