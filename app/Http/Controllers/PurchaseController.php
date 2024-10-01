<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('supplier')->get();
        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:purchases,invoice_number',
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $purchase = Purchase::create([
            'invoice_number' => $request->invoice_number,
            'supplier_id' => $request->supplier_id,
            'purchase_date' => $request->purchase_date,
            'total_amount' => 0, // سنحسبها لاحقًا
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

            // تحديث كمية المنتج في المخزون
            $product->quantity += $quantity;
            $product->save();
        }

        $purchase->total_amount = $totalAmount;
        $purchase->save();

        return redirect()->route('purchases.index')->with('success', 'تم إضافة فاتورة الشراء بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $purchase = Purchase::with(['supplier', 'purchaseItems.product'])->findOrFail($id);
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
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
