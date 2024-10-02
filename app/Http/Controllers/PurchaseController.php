<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseItem;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage purchases');
    }

    public function index()
    {
        $purchases = Purchase::with('supplier')->get();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:purchases,invoice_number',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $purchase = Purchase::create([
            'invoice_number' => $request->invoice_number,
            'supplier_id' => $request->supplier_id,
            'purchase_date' => $request->purchase_date,
            'total_amount' => 0,
            'notes' => $request->notes,
        ]);

        $totalAmount = 0;

        foreach ($request->products as $item) {
            $product = Product::find($item['product_id']);
            $quantity = $item['quantity'];
            $price = $item['price'];
            $totalAmount += $price * $quantity;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $product->quantity += $quantity;
            $product->save();
        }

        $purchase->total_amount = $totalAmount;
        $purchase->save();

        return redirect()->route('purchases.index')->with('success', 'تم إضافة فاتورة الشراء بنجاح');
    }

    public function show($id)
    {
        $purchase = Purchase::with(['supplier', 'purchaseItems.product'])->findOrFail($id);
        return view('purchases.show', compact('purchase'));
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);

        foreach ($purchase->purchaseItems as $item) {
            $product = $item->product;
            $product->quantity -= $item->quantity;
            $product->save();
        }

        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'تم حذف فاتورة الشراء بنجاح');
    }
}
