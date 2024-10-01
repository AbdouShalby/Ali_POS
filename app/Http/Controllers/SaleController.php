<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('customer')->get();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:sales,invoice_number',
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $sale = Sale::create([
            'invoice_number' => $request->invoice_number,
            'customer_id' => $request->customer_id,
            'sale_date' => $request->sale_date,
            'total_amount' => 0, // سنحسبها لاحقًا
            'notes' => $request->notes,
        ]);

        $totalAmount = 0;

        foreach ($request->products as $item) {
            $product = Product::find($item['product_id']);
            $quantity = $item['quantity'];
            $price = $item['price'];
            $totalAmount += $price * $quantity;

            if ($product->quantity < $quantity) {
                return redirect()->back()->withErrors(['message' => 'الكمية المطلوبة للمنتج ' . $product->name . ' غير متوفرة.']);
            }

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);

            // تحديث كمية المنتج في المخزون
            $product->quantity -= $quantity;
            $product->save();
        }

        $sale->total_amount = $totalAmount;
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'تم إضافة فاتورة البيع بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = Sale::with(['customer', 'saleItems.product'])->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        foreach ($sale->saleItems as $item) {
            $product = $item->product;
            $product->quantity += $item->quantity;
            $product->save();
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'تم حذف فاتورة البيع بنجاح');
    }
}
