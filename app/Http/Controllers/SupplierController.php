<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage suppliers');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $suppliers = Supplier::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%");
        })->paginate(10);

        return view('suppliers.index', compact('suppliers', 'search'))->with('activePage', 'suppliers');
    }

    public function create()
    {
        return view('suppliers.create')->with('activePage', 'suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email',
            'phone' => 'nullable|string|max:20|unique:suppliers,phone',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $supplier = Supplier::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('suppliers.supplier_added_successfully'),
                'supplier' => $supplier,
            ], 200);
        }

        return redirect()->route('suppliers.index')->with('success', __('suppliers.supplier_added_successfully'));
    }

    public function show(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $query = $supplier->purchases()->with('product');

        if ($request->filled('search')) {
            $query->whereHas('product', function ($productQuery) use ($request) {
                $productQuery->where('name', 'LIKE', "%{$request->search}%");
            });
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $purchases = $query->paginate(10);

        $products = $purchases->map(function ($purchase) {
            return $purchase->product;
        });

        $debts = $supplier->debts()->with('product')->latest()->get();

        return view('suppliers.show', compact('supplier', 'products', 'purchases', 'debts'));
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'))->with('activePage', 'suppliers');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email,' . $id,
            'phone' => 'nullable|string|max:20|unique:suppliers,phone,' . $id,
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('suppliers.supplier_updated_successfully'),
                'supplier' => $supplier,
            ], 200);
        }

        return redirect()->route('suppliers.index')->with('success', __('suppliers.supplier_updated_successfully'));
    }

    public function destroy(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('suppliers.supplier_deleted_successfully'),
            ], 200);
        }

        return redirect()->route('suppliers.index')->with('success', __('suppliers.supplier_deleted_successfully'));
    }

    public function debts(Supplier $supplier)
    {
        $debts = $supplier->debts;

        return view('suppliers.debts', compact('supplier', 'debts'));
    }

    public function showPaymentsForm(Debt $debt)
    {
        return view('suppliers.payments', compact('debt'));
    }

    public function recordPayment(Request $request, Debt $debt)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $debt->remainingAmount(),
            'note' => 'nullable|string|max:255',
        ]);

        $debt->payments()->create([
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        return redirect()->route('suppliers.show', $debt->supplier_id)
            ->with('success', 'Payment recorded successfully.');
    }

}
