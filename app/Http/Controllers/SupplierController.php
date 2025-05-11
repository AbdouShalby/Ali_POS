<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Product;
use App\Models\Payment;

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
        
        // Get products purchased from this supplier with pagination
        $products = Product::where('supplier_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get debts for this supplier with pagination
        $debts = Debt::where('supplier_id', $id)
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get payment history for this supplier
        $payments = Payment::where('supplier_id', $id)
            ->with(['debt', 'debt.product'])
            ->orderBy('payment_date', 'desc')
            ->paginate(10);
            
        // Calculate total debt, total paid, and total remaining
        $totalDebt = Debt::where('supplier_id', $id)->sum('amount');
        $totalPaid = Debt::where('supplier_id', $id)->sum('paid');
        $totalRemaining = $totalDebt - $totalPaid;
        
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
        
        return view('suppliers.show', compact(
            'supplier', 
            'purchases', 
            'products',
            'debts',
            'payments',
            'statistics', 
            'totalDebt', 
            'totalPaid', 
            'totalRemaining'
        ));
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
            'supplier_id' => $debt->supplier_id
        ]);

        $debt->paid += $request->amount;
        $debt->save();

        if ($debt->remaining <= 0) {
            $debt->status = 'paid';
            $debt->save();
        }

        // تحديث رصيد الخزنة
        \App\Models\CashRegister::updateBalance(
            'payment_to_supplier',
            -1 * $request->amount,
            'دفعة للمورد: ' . $debt->supplier->name . ' - للمنتج: ' . ($debt->product->name ?? 'غير محدد')
        );

        return redirect()->route('suppliers.show', $debt->supplier_id)
            ->with('success', 'تم تسجيل الدفعة بنجاح.');
    }

    // إضافة دالة تسجيل دفعة مجمعة للمورد (تنقسم على الديون المستحقة)
    public function recordBulkPayment(Request $request, $supplierId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
        ]);

        $supplier = Supplier::findOrFail($supplierId);
        
        // الحصول على الديون غير المدفوعة بالكامل
        $unpaidDebts = Debt::where('supplier_id', $supplierId)
            ->where('status', '!=', 'paid')
            ->orderBy('created_at', 'asc')
            ->get();
            
        if ($unpaidDebts->isEmpty()) {
            return redirect()->route('suppliers.show', $supplierId)
                ->with('error', 'لا توجد ديون مستحقة لهذا المورد.');
        }
        
        $remainingPayment = $request->amount;
        $successMessage = 'تم تسجيل الدفعة بنجاح.';
        
        foreach ($unpaidDebts as $debt) {
            if ($remainingPayment <= 0) {
                break;
            }
            
            $debtRemaining = $debt->amount - $debt->paid;
            $paymentForDebt = min($remainingPayment, $debtRemaining);
            
            if ($paymentForDebt > 0) {
                $payment = $debt->payments()->create([
                    'amount' => $paymentForDebt,
                    'payment_date' => $request->payment_date,
                    'note' => $request->note ?? 'دفعة جزئية من المبلغ الإجمالي: ' . $request->amount,
                    'payment_type' => 'supplier',
                    'supplier_id' => $supplierId
                ]);
                
                $debt->paid += $paymentForDebt;
                $remainingPayment -= $paymentForDebt;
                
                if ($debt->remaining <= 0) {
                    $debt->status = 'paid';
                    $successMessage = 'تم تسجيل الدفعة وسداد بعض الديون بالكامل.';
                }
                
                $debt->save();
            }
        }
        
        // تحديث رصيد الخزنة
        \App\Models\CashRegister::updateBalance(
            'payment_to_supplier',
            -1 * $request->amount,
            'دفعة للمورد: ' . $supplier->name . ' - مبلغ: ' . $request->amount
        );
        
        return redirect()->route('suppliers.show', $supplierId)
            ->with('success', $successMessage);
    }

    public function paymentHistory(Debt $debt)
    {
        $payments = $debt->payments()->orderBy('payment_date', 'desc')->get();

        return view('suppliers.payment_history', compact('debt', 'payments'));
    }

}
