<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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

    public function show($id)
    {
        $supplier = Supplier::with(['purchases.purchaseItems.product'])->findOrFail($id);
        
        // Get supplier's purchases with pagination
        $purchases = $supplier->purchases()
            ->with('purchaseItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Calculate statistics
        $totalPurchases = 0;
        $purchasesCount = 0;
        $lastPurchase = null;
        
        foreach ($supplier->purchases as $purchase) {
            $purchaseTotal = 0;
            foreach ($purchase->purchaseItems as $item) {
                $purchaseTotal += $item->quantity * $item->price;
            }
            
            $totalPurchases += $purchaseTotal;
            $purchasesCount++;
            
            if (!$lastPurchase || $purchase->created_at > $lastPurchase->created_at) {
                $lastPurchase = $purchase;
            }
        }
        
        $statistics = [
            'total_purchases' => $totalPurchases,
            'purchases_count' => $purchasesCount,
            'last_purchase' => $lastPurchase,
            'average_purchase' => $purchasesCount > 0 ? $totalPurchases / $purchasesCount : 0,
        ];
        
        return view('suppliers.show', compact('supplier', 'purchases', 'statistics'));
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
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
        ]);

        $payment = $debt->payments()->create([
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'note' => $request->note ?? null,
            'payment_type' => 'supplier',
        ]);

        $debt->paid += $request->amount;
        $debt->save();

        if ($debt->remaining <= 0) {
            $debt->status = 'paid';
            $debt->save();
        }

        return redirect()->route('suppliers.show', $debt->supplier_id)
            ->with('success', 'Payment recorded successfully.');
    }

    public function paymentHistory(Debt $debt)
    {
        $payments = $debt->payments()->orderBy('payment_date', 'desc')->get();

        return view('suppliers.payment_history', compact('debt', 'payments'));
    }

}
